<?php

namespace App\Http\Controllers\Eligibility;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPostToFeaturedRequest;
use App\Http\Requests\RemovePostToFeaturedRequest;
use App\Models\Calculation;
use App\Models\Post;
use App\Models\Result;
use DataTables;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $data = Calculation::query()->with(['results'])->whereHas('results')->get();

        return view('eligibility.results_list', compact('data'));
    }

    public function show($id, Request $request)
    {
        if ($request->ajax()) {
            $data = Calculation::query()->with(['results'])->whereHas('results')->find($id);
            $data = $data->results->sortBy('value');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function ($data) {
                    return $data->alternative->post->title;
                })
                ->addColumn('action', function ($data) {
                    $link = '';

                    if ($data->alternative->post->featured) {
                        $link .= '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 remove" data-id="' . $data->alternative->post->id . '">Batal</a>';
                    } else {
                        $link .= '<a href="#" class="btn btn-sm mr-2 btn-success add" data-id="' . $data->alternative->post->id . '">Terapkan</a>';
                    }

                    return $link;
                })
                ->rawColumns(['title', 'action'])
                ->make(true);
        }

        return view('eligibility.result');
    }

    public function addPostToFeatured(AddPostToFeaturedRequest $request)
    {
        $validated = $request->validated();

        try {
            $post = Post::findOrFail($validated['post']);

            $post->update([
                'featured' => true
            ]);

            return $this->res(200, 'Berhasil', $post);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function removePostToFeatured(RemovePostToFeaturedRequest $request)
    {
        $validated = $request->validated();

        try {
            $post = Post::findOrFail($validated['post']);

            $post->update([
                'featured' => false
            ]);

            return $this->res(200, 'Berhasil', $post);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

}
