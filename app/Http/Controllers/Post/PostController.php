<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Saved;
use App\Models\Post;
use DataTables;
use Auth;
use File;
use Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = Post::latest();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function($data) {
                    return '<a href="'. route('postShow', $data->id) .'">'. $data->title .'</a>';
                })
                ->addColumn('thumbnail', function($data) {
                    $url = $data->thumbnail;
                    return '<img src="'. asset("storage/$url") .'" style="width: 100px">';
                })
                ->addColumn('action', function($data) {
                    return '<a href="'. route('postEdit', $data->id) .'" class="btn btn-sm mr-2 btn-warning">Edit</a>' .
                        '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="'. $data->id .'">Hapus</a>';
                })
                ->rawColumns(['title', 'thumbnail', 'action'])
                ->make(true);
        }

        return view('post.post');
    }

    public function show($id)
    {
        $categories = Category::all();
        $newPosts = Post::latest()->limit(3)->get();
        $data = Post::findOrFail($id);
        $check = false;

        if(!is_null(Auth::user())) {
            if(Auth::user()->role == 'reader') {
                $saved = Saved::where('user_id', Auth::user()->id)->where('post_id', $id)->first();
                if(!is_null($saved)) {
                    $check = true;
                }
            }
        }

        return view('post.postShow', compact('categories', 'newPosts', 'data', 'check'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('post.postCreate', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'body' => 'required',
            'thumbnail' => 'required|mimes:jpeg,jpg,bmp,png|max:4096',
        ]);

        $data = new Post();
        $data->title = $request->title;
        $data->description = $request->description;
        $data->body = $request->body;
        $data->user_id = Auth::user()->id;

        if($request->file('thumbnail') != null) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailNama = Str::random(5) . ucfirst($request->nama) . '.' . $thumbnail->clientExtension();

            $data->thumbnail = 'post/' . $thumbnailNama;
            $request->thumbnail->move(storage_path('app/public/post'), $thumbnailNama);
        }

        $data->save();

        $data->categories()->attach($request->categories);

        return redirect()->route('post')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $categories = Category::all();
        $data = Post::findOrFail($id);
        return view('post.postEdit', compact('categories', 'data', 'id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'body' => 'required',
            'thumbnail' => 'nullable|mimes:jpeg,jpg,bmp,png|max:4096',
        ]);

        $data = Post::findOrFail($id);
        $thumbnailLama = $data->thumbnail;

        $data->title = $request->title;
        $data->description = $request->description;
        $data->body = $request->body;
        $data->user_id = Auth::user()->id;

        if($request->file('thumbnail') != null) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailNama = Str::random(5) . ucfirst($request->nama) . '.' . $thumbnail->clientExtension();

            $data->thumbnail = 'post/' . $thumbnailNama;
            $request->thumbnail->move(storage_path('app/public/post'), $thumbnailNama);

            File::delete('storage/' . $thumbnailLama);
        }

        $data->save();

        $data->categories()->sync($request->categories);

        return redirect()->route('post')->with('success', 'Data berhasil diedit');
    }

    public function delete($id)
    {
        $data = Post::findOrFail($id);
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
