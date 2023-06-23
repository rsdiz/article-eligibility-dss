<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use DataTables;
use Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = Category::latest();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data) {
                    return '<a href="#" class="btn btn-sm mr-2 btn-warning edit" data-id="'. $data->id .'" data-toggle="modal" data-target="#modal-edit">Edit</a>' .
                        '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="'. $data->id .'">Hapus</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('category.category');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);

        try {
            $data = Category::create([
                'name' => ucfirst($request->name),
                'user_id' => Auth::user()->id
            ]);

            return $this->res(201, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data = Category::findOrFail($id);

        return $this->res(200, 'Berhasil', $data);
    }

    public function edit($id, Request $request)
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);

        $data = Category::findOrFail($id);
        try {
            $data->update([
                'name' => ucfirst($request->name),
                'user_id' => Auth::user()->id
            ]);

            return $this->res(200, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function delete($id)
    {
        $data = Category::findOrFail($id);
        try {
            $data->delete();

            return $this->res(200, 'Berhasil', $data);
        } catch (\Illuminate\Database\QueryException $ex) {
            if($ex->getCode() === '23000') 
                return $this->errorFk();
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }
}
