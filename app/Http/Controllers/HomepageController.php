<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index() 
    {
        $title = 'Home Page';
        $posts = Post::limit(5)->latest()->get();

        return view('home', [
            'title' => $title,
            'slug' => 'home',
            'posts' => $posts,
        ]);
    }

    public function post() 
    {
        $title = 'Detail Page';

        return view('post', [
            'title' => $title,
        ]);
    }
}
