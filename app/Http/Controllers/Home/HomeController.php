<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $posts = Post::latest()->paginate(5);
        $newPosts = Post::latest()->limit(3)->get();

        return view('home.home', compact('categories', 'posts', 'newPosts'));
    }

    public function search(Request $request)
    {
        $q = trim($request->input('q'));
        $category = trim($request->input('category'));

        $categories = Category::all();

        if($q != '') {
            $posts = Post::orWhere('title', 'LIKE', "%$q%")
                ->orWhere('description', 'LIKE', "%$q%")
                ->latest()->paginate(5);
        }

        if($category != '') {
            $posts = Post::whereHas('categories', function($q) use ($category) {
                    $q->where('category_id', $category);
                })
                ->latest()->paginate(5);
        }

        $newPosts = Post::latest()->limit(3)->get();

        return view('home.home', compact('categories', 'posts', 'newPosts'));
    }
}
