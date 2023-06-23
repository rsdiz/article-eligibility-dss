<?php

namespace App\Http\Controllers\Saved;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Saved;
use DataTables;
use Auth;

class SavedController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = Saved::where('user_id', Auth::user()->id)->latest();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function($data) {
                    return '<a href="'. route('postShow', $data->post->id) .'">'. $data->post->title .'</a>';
                })
                ->addColumn('thumbnail', function($data) {
                    $url = $data->post->thumbnail;
                    return '<img src="'. asset("storage/$url") .'" style="width: 100px">';
                })
                ->addColumn('action', function($data) {
                    return '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="'. $data->id .'">Hapus</a>';
                })
                ->rawColumns(['title', 'thumbnail', 'action'])
                ->make(true);
        }

        return view('saved.saved');
    }

    public function store(Request $request)
    {
        $data = Saved::create([
            'post_id' => $request->id,
            'user_id' => Auth::user()->id
        ]);

        return back()->with('success', 'Berita berasil disimpan');
    }

    public function delete(Request $request, $id)
    {
        if($request->ajax()) {
            $data = Saved::findOrFail($id);
            $data->delete();
            return $this->res(200, 'Berhasil', $data);
        }else{
            $data = Saved::where('user_id', Auth::user()->id)->where('post_id', $id)->first();
            $data->delete();
            return back()->with('success', 'Berita dihapus dari penyimpanan');
        }
    }
}
