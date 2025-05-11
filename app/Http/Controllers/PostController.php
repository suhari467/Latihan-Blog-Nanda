<?php

namespace App\Http\Controllers;

use App\Models\CategoryPost;
use App\Models\Post;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())->latest()->get();

        $data = [
            'title' => 'Data Postingan',
            'slug' => 'posts',
            'posts' => $posts
        ];

        // dd($data);

        return view('user.post.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category_post = CategoryPost::all();
        $data = [
            'title' => 'Tambah Postingan',
            'slug' => 'posts',
            'category_post' => $category_post,
        ];

        // dd($data);

        return view('user.post.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_post_id' => 'required|exists:category_posts,id',
            'slug' => 'required|max:255',
            'body' => 'required',
            'image' => 'required|image',
        ]);

        // dd($validated);

        if ($request->file('image')) {
            $namaberkas = $validated['slug'];
            $ext = $request->file('image')->getClientOriginalExtension();
            $filename = $namaberkas.'.'.$ext;
            $upload = $request->file('image')->move('storage/post', $filename);

            $validated['image'] = $upload->getFilename();
        }

        $validated['user_id'] = Auth::id();

        $create = Post::create($validated);
        if ($create) {
            return redirect('/user/posts')->with('success', 'Data Postingan berhasil ditambahkan');
        } else {
            return redirect('/user/posts')->with('error', 'Data Postingan gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $category_post = CategoryPost::all();
        $data = [
            'title' => 'Edit Postingan',
            'slug' => 'posts',
            'category_post' => $category_post,
            'post' => $post,
        ];

        // dd($data);

        return view('user.post.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $rules = [
            'title' => 'required|max:255',
            'category_post_id' => 'required|exists:category_posts,id',
            'body' => 'required',
            'image' => 'nullable|image',
        ];

        if($request->slug != $post->slug) {
            $rules['slug'] = 'required|unique:posts,slug|max:255';
        }else{
            $rules['slug'] = 'required|max:255';
        }

        $validated = $request->validate($rules);

        // dd($validated);

        if ($request->file('image')) {
            if($request->old_image) {
                $delete = Storage::disk('public')->delete('post/'.$post->image);
                if(!$delete){
                    return redirect('/user/posts')->with('error', 'Gambar tidak bisa dihapus');
                }
            }
            $namaberkas = $validated['slug'];
            $ext = $request->file('image')->getClientOriginalExtension();
            $filename = $namaberkas.'.'.$ext;
            $upload = $request->file('image')->move('storage/post', $filename);

            $validated['image'] = $upload->getFilename();
        }

        $update = Post::where('id', $post->id)->update($validated);
        if ($update) {
            return redirect('/user/posts')->with('success', 'Data Postingan berhasil diedit');
        } else {
            return redirect('/user/posts')->with('error', 'Data Postingan gagal diedit');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if($post->image) {
            $delete = Storage::disk('public')->delete('post/'.$post->image);
            if(!$delete){
                return redirect('/user/posts')->with('error', 'Gambar tidak bisa dihapus');
            }
        }

        $destroy = Post::destroy($post->id);
        if ($destroy) {
            return redirect('/user/posts')->with('success', 'Data Postingan berhasil dihapus');
        } else {
            return redirect('/user/posts')->with('error', 'Data Postingan gagal dihapus');
        }
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }
}