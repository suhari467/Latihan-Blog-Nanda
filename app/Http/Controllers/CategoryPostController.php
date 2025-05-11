<?php

namespace App\Http\Controllers;

use App\Models\CategoryPost;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category_posts = CategoryPost::all();

        $data = [
            'title' => 'Data Kategori Postingan',
            'slug' => 'category_post',
            'category_posts' => $category_posts
        ];

        // dd($data);

        return view('admin.category_post.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori Postingan',
            'slug' => 'category_post',
        ];

        // dd($data);

        return view('admin.category_post.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
            'keterangan' => 'nullable|max:255',
            'image' => 'required|image',
        ]);

        // dd($validated);

        if ($request->file('image')) {
            $namaberkas = $validated['slug'];
            $ext = $request->file('image')->getClientOriginalExtension();
            $filename = $namaberkas.'.'.$ext;
            $upload = $request->file('image')->move('storage/category_post', $filename);

            $validated['image'] = $upload->getFilename();
        }

        $create = CategoryPost::create($validated);
        if ($create) {
            return redirect('/admin/category_post')->with('success', 'Data Kategori berhasil ditambahkan');
        } else {
            return redirect('/admin/category_post')->with('error', 'Data Kategori gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryPost $categoryPost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryPost $categoryPost)
    {
        $data = [
            'title' => 'Edit Kategori Postingan',
            'slug' => 'category_post',
            'category_post' => $categoryPost,
        ];

        // dd($data);

        return view('admin.category_post.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryPost $categoryPost)
    {
        $rules = [
            'name' => 'required|max:255',
            'keterangan' => 'nullable|max:255',
            'image' => 'nullable|image',
        ];

        if($request->slug != $categoryPost->slug) {
            $rules['slug'] = 'required|max:255|unique:category_posts,slug';
        } else {
            $rules['slug'] = 'required|max:255';
        }
        $validated = $request->validate($rules);

        // dd($validated);

        if ($request->file('image')) {
            if($request->old_image) {
                $delete = Storage::disk('public')->delete('category_post/'.$categoryPost->image);
                if(!$delete){
                    return redirect('/admin/category_post')->with('error', 'Gambar tidak bisa dihapus');
                }
            }
            $namaberkas = $validated['slug'];
            $ext = $request->file('image')->getClientOriginalExtension();
            $filename = $namaberkas.'.'.$ext;
            $upload = $request->file('image')->move('storage/category_post', $filename);

            $validated['image'] = $upload->getFilename();
        }

        $update = CategoryPost::where('id', $categoryPost->id)->update($validated);
        if ($update) {
            return redirect('/admin/category_post')->with('success', 'Data Kategori berhasil diubah');
        } else {
            return redirect('/admin/category_post')->with('error', 'Data Kategori gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryPost $categoryPost)
    {
        if($categoryPost->image) {
            $delete = Storage::disk('public')->delete('category_post/'.$categoryPost->image);
            if(!$delete){
                return redirect('/admin/category_post')->with('error', 'Gambar tidak bisa dihapus');
            }
        }

        $destroy = CategoryPost::destroy($categoryPost->id);
        if ($destroy) {
            return redirect('/admin/category_post')->with('success', 'Data Kategori berhasil dihapus');
        } else {
            return redirect('/admin/category_post')->with('error', 'Data Kategori gagal dihapus');
        }
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(CategoryPost::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
