<?php

namespace App\Http\Controllers\Eligibility;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPostToCalculateRequest;
use App\Http\Requests\RemovePostToCalculateRequest;
use App\Http\Requests\StoreCalculateRequest;
use App\Http\Requests\UpdateCalculateRequest;
use App\Models\Alternative;
use App\Models\Calculation;
use App\Models\Category;
use App\Models\Criteria;
use App\Models\Post;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class CalculateController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Calculation::query()->oldest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $link = '';

                    $link .= '<a href="' . route('eligibility.calculate.process', ['id' => $data->id]) . '" class="btn btn-sm mr-2 btn-success">Proses</a>' .
                        '<a href="' . route('eligibility.calculate.edit', ['id' => $data->id]) . '" class="btn btn-sm mr-2 btn-warning">Edit</a>' .
                        '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="' . $data->id . '">Hapus</a>';
                    return $link;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('eligibility.calculate_lists');
    }

    public function show($id)
    {
        $data = Calculation::findOrFail($id);

        return $this->res(200, 'Berhasil', $data);
    }

    public function createPage()
    {
        $categories = Category::all();

        return view('eligibility.calculate_create', compact('categories'));
    }

    public function updatePage($id)
    {
        $categories = Category::all();
        $data = Calculation::query()->find($id);

        return view('eligibility.calculate_edit', compact('data', 'categories'));
    }

    public function store(StoreCalculateRequest $request)
    {
        try {
            $data = Calculation::create($request->validated());

            return redirect(route('eligibility.calculate'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('data', $e->getMessage());
        }
    }

    public function edit($id, UpdateCalculateRequest $request)
    {
        try {
            $data = Calculation::query()->updateOrCreate(
                [
                    'id' => $id
                ],
                $request->validated()
            );

            return redirect(route('eligibility.calculate'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('data', $e->getMessage());
        }
    }

    public function processPage($id, Request $request)
    {
        $current = Calculation::query()->with(['posts'])->find($id);

        if ($request->ajax()) {
            $data = Post::query()->select('id', 'title', 'category_id')->with(['alternative'])->whereHas('alternative')->whereCategoryId($current->category_id)->get();
            $posts = $current->posts->pluck('id')->toArray();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) use ($posts) {
                    $link = '';

                    if (in_array($data->id, $posts)) {
                        $link .= '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 remove" data-id="' . $data->id . '">Hapus</a>';
                    } else {
                        $link .= '<a href="#" class="btn btn-sm mr-2 btn-success add" data-id="' . $data->id . '">Tambah</a>';
                    }

                    return $link;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('eligibility.calculate_article');
    }

    public function addPostToCalculate($id, AddPostToCalculateRequest $request)
    {
        $validated = $request->validated();

        try {
            $data = Calculation::findOrFail($id);
            $post = Post::findOrFail($validated['post']);

            $data->posts()->attach($post);

            return $this->res(200, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function removePostToCalculate($id, RemovePostToCalculateRequest $request)
    {
        $validated = $request->validated();

        try {
            $data = Calculation::findOrFail($id);
            $post = Post::findOrFail($validated['post']);

            $data->posts()->detach($post);

            return $this->res(200, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function process($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $calculation = Calculation::with(['posts', 'posts.alternative'])->findOrFail($id);

            $calculation->results()->delete();

            // Matrix Keputusan (X)
            $matrix_x = array();
            $criterias = Criteria::query()->get();
            $alternatives = Alternative::query()->with(['scores', 'scores.criteria', 'post'])->whereIn('post_id', $calculation->posts->pluck('id'))->get(['id', 'post_id']);

            foreach ($alternatives as $alternative) {
                foreach ($alternative->scores as $score) {
                    $value = $score->value;

                    // save value to matrix keputusan
                    $matrix_x[$score->criteria_id][$alternative->id] = $value;
                }
            }

            // Matrix Normalisasi (X)
            $value_x = array();
            foreach ($alternatives as $alternative) {
                foreach ($alternative->scores as $score) {
                    $current_value = $matrix_x[$score->criteria_id][$alternative->id];

                    $max_value = @(max($matrix_x[$score->criteria_id]));
                    $min_value = @(min($matrix_x[$score->criteria_id]));

                    try {
                        $result = ($max_value - $current_value) / ($max_value - $min_value);
                    } catch (\Throwable $th) {
                        $result = 0.0;
                    }

                    // save result to matrix normalisasi
                    $value_x[$score->criteria_id][$alternative->id] = round($result, 3);
                }
            }

            // Matrix Normalisasi (R)
            $matrix_r = array();
            // Nilai S
            $value_s = array();
            foreach ($alternatives as $alternative) {
                $total_r = 0;
                foreach ($criterias as $criteria) {
                    $weight = $criteria->weight;
                    $current_value = $value_x[$criteria->id][$alternative->id];

                    $r = $current_value * $weight;

                    $matrix_r[$criteria->id][$alternative->id] = round($r, 3);
                    $total_r += round($r, 3);
                }
                $value_s[$alternative->id] = floatval($total_r);
            }

            // Nilai R
            $value_r = array();
            foreach ($alternatives as $alternative) {
                $max_value = @(max($matrix_r[$alternative->id]));

                $value_r[$alternative->id] = floatval($max_value);
            }

            // Nilai Qi
            $value_q = array();
            foreach ($alternatives as $alternative) {
                $current_s = $value_s[$alternative->id];
                $current_r = $value_r[$alternative->id];
                $max_s = floatval(max($value_s));
                $min_s = floatval(min($value_s));
                $max_r = floatval(max($value_r));
                $min_r = floatval(min($value_r));

                $v = 0.5;
                $v1 = $current_s - $min_s;
                $v2 = $max_s - $min_s;
                $v3 = $current_r - $min_r;
                $v4 = $max_r - $min_r;

                $div1 = $v1 / $v2;
                $div2 = $v3 / $v4;

                $result1 = $div1 * $v;
                $result2 = $div2 * (1 - $v);
                $q = $result1 + $result2;
                $value_q[$alternative->id] = round($q, 4);
            }

            foreach ($alternatives as $alternative) {
                $result = Result::query()->create([
                    'alternative_id' => $alternative->id,
                    'value' => $value_q[$alternative->id]
                ]);

                $calculation->results()->attach($result);
            }

            DB::commit();

            $data = [
                [
                    'title' => "Matrix Keputusan (X)",
                    'type' => 0,
                    'show' => 'vertical',
                    'value' => $matrix_x
                ],
                [
                    'title' => 'Normalisasi Matrix (X)',
                    'type' => 0,
                    'show' => 'vertical',
                    'value' => $value_x
                ],
                [
                    'title' => 'Bobot Kriteria (W)',
                    'type' => 0,
                    'hide_name' => true,
                    'show' => 'horizontal',
                    'value' => $criterias->pluck('weight')
                ],
                [
                    'title' => 'Matrix Normalisasi (R)',
                    'type' => 0,
                    'show' => 'vertical',
                    'value' => $matrix_r
                ],
                [
                    'header' => 'R',
                    'title' => 'Nilai R',
                    'hide_name' => true,
                    'type' => 1,
                    'show' => 'horizontal',
                    'value' => $value_r
                ],
                [
                    'header' => 'S',
                    'title' => 'Nilai S',
                    'hide_name' => true,
                    'type' => 1,
                    'show' => 'horizontal',
                    'value' => $value_s
                ],
                [
                    'header' => [
                        'S<sup>+</sup>',
                        'S<sup>-</sup>',
                        'R<sup>+</sup>',
                        'R<sup>-</sup>'
                    ],
                    'title' => 'Nilai S dan R',
                    'hide_name' => true,
                    'type' => 0,
                    'show' => 'horizontal',
                    'value' => [
                        floatval(max($value_s)),
                        floatval(min($value_s)),
                        floatval(max($value_r)),
                        floatval(min($value_r))
                    ]
                ],
                [
                    'header' => [
                        'No', 'Alternatif', 'Nilai Q'
                    ],
                    'title' => 'Nilai Qi',
                    'hide_name' => true,
                    'type' => 1,
                    'show' => 'vertical',
                    'value' => $value_q
                ]
            ];

            return view('eligibility.calculate_process', compact(
                'alternatives',
                'criterias',
                'data'
            ));
        } catch (\PDOException $th) {
            DB::rollBack();
            throw $th;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $data = Calculation::findOrFail($id);

            $data->delete();

            return $this->res(200, 'Berhasil', $data);
        } catch (\Illuminate\Database\QueryException $ex) {
            if ($ex->getCode() === '23000')
                return $this->errorFk();
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }
}
