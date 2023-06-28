<?php

namespace App\Http\Controllers\Eligibility;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlternativeRequest;
use App\Http\Requests\UpdateAlternativeRequest;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Score;
use Illuminate\Http\Request;
use DataTables;

class AlternativeController extends Controller
{
    public function index(Request $request)
    {
        $criterias = Criteria::with(['subCriterias'])->get();

        if ($request->ajax()) {
            $data = Alternative::query()->oldest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('result_text', function ($data) {
                    $text = '';
                    if ($data->hasScores()) {
                        $text .= '<ul class="list-group">';
                        foreach ($data->scores as $key => $value) {
                            $text .= '<li class="list-group-item">(' . $value->criteria->code . ') ' . $value->criteria->name . ' : ' . $value->value . '</li>';
                        }
                        $text .= '</ul>';
                    } else {
                        $text .= '<ul class="list-group">';
                        $text .= '<li class="list-group-item">-</li>';
                        $text .= '</ul>';
                    }
                    return $text;
                })
                ->addColumn('action', function ($data) {
                    $link = '<a href="#" class="btn btn-sm mr-2 btn-warning edit" data-id="' . $data->id . '" data-toggle="modal" data-target="#modal-edit">Edit</a>' .
                        '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="' . $data->id . '">Hapus</a>';
                    return $link;
                })
                ->rawColumns(['result_text', 'action'])
                ->make(true);
        }

        return view('eligibility.alternative', compact('criterias'));
    }

    public function show($id)
    {
        $data = Alternative::query()->with(['scores'])->where('id', $id)->firstOrFail();

        return $this->res(200, 'Berhasil', $data);
    }

    public function store(StoreAlternativeRequest $request)
    {
        try {
            $alternative = Alternative::create([
                'name' => $request->name
            ]);

            if (!empty($request->criteria)) {
                foreach ($request->criteria as $key => $value) {
                    $criteria = Criteria::query()->where('code', '=', $key)->first();

                    if (empty($criteria)) {
                        continue;
                    }

                    $score = Score::create([
                        'criteria_id' => $criteria->id,
                        'alternative_id' => $alternative->id,
                        'value' => $value
                    ]);
                }
            }

            return $this->res(201, 'Berhasil', $alternative);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function edit($id, UpdateAlternativeRequest $request)
    {
        try {
            $validated = $request->validated();

            $alternative = Alternative::query()->findOrFail($id);

            $alternative->update([
                'name' => $validated['name']
            ]);

            if (array_key_exists('criteria', $validated)) {
                foreach ($validated['criteria'] as $key => $value) {
                    $criteria = Criteria::query()->where('code', '=', $key)->first();

                    if (empty($criteria)) {
                        continue;
                    }

                    Score::query()->updateOrCreate(
                        ['criteria_id' => $criteria->id, 'alternative_id' => $alternative->id],
                        ['value' => $value]
                    );
                }
            }

            return $this->res(201, 'Berhasil', $alternative);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $data = Alternative::findOrFail($id);

            $data->scores()->delete();
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
