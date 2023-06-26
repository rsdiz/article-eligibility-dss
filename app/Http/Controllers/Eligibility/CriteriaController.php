<?php

namespace App\Http\Controllers\Eligibility;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCriteriaRequest;
use App\Http\Requests\UpdateCriteriaRequest;
use App\Models\Criteria;
use Illuminate\Http\Request;
use DataTables;

class CriteriaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Criteria::query()->oldest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $link = '';

                    if ($data->has_option) {
                        $link .= '<a href="' . route('eligibility.criterias.sub', $data->id) . '" class="btn btn-sm mr-2 btn-success">Sub</a>';
                    }

                    $link .= '<a href="#" class="btn btn-sm mr-2 btn-warning edit" data-id="' . $data->id . '" data-toggle="modal" data-target="#modal-edit">Edit</a>' .
                        '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="' . $data->id . '">Hapus</a>';
                    return $link;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('eligibility.criterias');
    }

    public function show($id)
    {
        $data = Criteria::findOrFail($id);

        return $this->res(200, 'Berhasil', $data);
    }

    public function store(StoreCriteriaRequest $request)
    {
        try {
            $data = Criteria::create($request->validated());

            return $this->res(201, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function edit($id, UpdateCriteriaRequest $request)
    {
        try {
            $data = Criteria::findOrFail($id);

            $data->update($request->validated());

            return $this->res(200, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $data = Criteria::findOrFail($id);

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
