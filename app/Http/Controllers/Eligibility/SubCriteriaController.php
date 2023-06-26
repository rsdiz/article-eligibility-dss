<?php

namespace App\Http\Controllers\Eligibility;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubCriteriaRequest;
use App\Http\Requests\UpdateSubCriteriaRequest;
use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Http\Request;
use DataTables;

class SubCriteriaController extends Controller
{
    public function index($id, Request $request)
    {
        $criteria = Criteria::query()->with(['subCriterias'])->findOrFail($id);

        if (!$criteria->has_option)
            return redirect()->back();

        if ($request->ajax()) {
            $data = $criteria->subCriterias;

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $link = '';

                    $link .= '<a href="#" class="btn btn-sm mr-2 btn-warning edit" data-id="' . $data->id . '" data-toggle="modal" data-target="#modal-edit">Edit</a>' .
                        '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="' . $data->id . '">Hapus</a>';
                    return $link;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('eligibility.sub_criteria', compact('criteria'));
    }

    public function show($id)
    {
        $data = SubCriteria::findOrFail($id);

        return $this->res(200, 'Berhasil', $data);
    }

    public function store(StoreSubCriteriaRequest $request)
    {
        try {
            $data = SubCriteria::create($request->validated());

            return $this->res(201, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function edit($id, UpdateSubCriteriaRequest $request)
    {
        try {
            $data = SubCriteria::findOrFail($id);

            $data->update($request->validated());

            return $this->res(200, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $data = SubCriteria::findOrFail($id);

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
