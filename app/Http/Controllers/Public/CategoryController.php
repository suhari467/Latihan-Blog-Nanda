<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CategoryPost;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category_post = CategoryPost::latest()->get();

        $data = [
            'title' => 'Kategori Postingan',
            'slug' => 'category_post',
            'category_post' => $category_post,
        ];

        // dd($data);

        return view('category_post', $data);
    }

    public function show(CategoryPost $category_post)
    {
        $posts = Post::where('category_post_id', $category_post->id)->paginate(6);
        
        $data = [
            'title' => 'Kategori Postingan: '.$category_post->name,
            'slug' => 'category_post',
            'posts' => $posts,
            'category_post' => $category_post,
            'user' => null,
        ];

        // dd($data);

        return view('posts', $data);
    }
}
