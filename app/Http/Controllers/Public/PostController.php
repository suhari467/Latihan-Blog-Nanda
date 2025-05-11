<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $data_filter = [
            'search' => request('search'),
            'category' => request('category'),
        ];

        $posts = Post::latest()->paginate(8);

        if ($data_filter['search'] || $data_filter['category']) {
            $posts = Post::latest()
                        ->filter($data_filter)
                        ->paginate(8)
                        ->withQueryString();
        }


        $data = [
            'title' => 'Postingan',
            'slug' => 'posts',
            'posts' => $posts,
            'category_post' => null,
            'user' => null,
        ];

        // dd($data);

        return view('posts', $data);
    }

    public function show(Post $post)
    {
        $data = [
            'title' => $post->title,
            'slug' => 'posts',
            'post' => $post,
        ];

        // dd($data);

        return view('post', $data);
    }

    public function user(User $user)
    {
        $posts = Post::where('user_id', $user->id)->paginate(6);
        
        $data = [
            'title' => 'Postingan Author: '.$user->name,
            'slug' => 'posts',
            'posts' => $posts,
            'category_post' => null,
            'user' => $user,
        ];

        // dd($data);

        return view('posts', $data);
    }
}
