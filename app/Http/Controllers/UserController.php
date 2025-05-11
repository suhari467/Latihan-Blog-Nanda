<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role')->get();

        $data = [
            'title' => 'Data Pengguna',
            'slug' => 'home',
            'users' => $users
        ];

        // dd($data);

        return view('admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();

        $data = [
            'title' => 'Tambah Data Pengguna',
            'slug' => 'home',
            'roles' => $roles,
        ];

        // dd($data);

        return view('admin.user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:users,email',
            'role_id' => 'required|max:255',
            'password' => 'required|max:255|min:8',
            'password_confirmation' => 'required|max:255|same:password',
        ], [
            'password.min' => 'Harap mengisi minimal 8 karakter',
        ]);

        $validated['password'] = Hash::make($request->password);

        // dd($validated);

        $create = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'password' => $validated['password'],
        ]);

        if ($create) {
            return redirect('/admin/user')->with('success', 'Data Pengguna berhasil ditambahkan');
        } else {
            return redirect('/admin/user')->with('error', 'Data Pengguna gagal ditambahkan');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        $data = [
            'title' => 'Edit Data Pengguna',
            'slug' => 'home',
            'roles' => $roles,
            'user' => $user,
        ];

        // dd($data);

        return view('admin.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|max:255',
            'role_id' => 'required|max:255',
        ];

        if ($request->email == $user->email) {
            $rules['email'] = 'required|max:255|email';
        } else {
            $rules['email'] = 'required|max:255|email|unique:users,email';
        }

        $validated = $request->validate($rules);

        // dd($validated);

        $update = User::where('id', $user->id)->update($validated);

        if ($update) {
            return redirect('/admin/user')->with('success', 'Data Pengguna berhasil diedit');
        } else {
            return redirect('/admin/user')->with('error', 'Data Pengguna gagal diedit');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // dd($user);
        $delete = User::destroy($user->id);
        if ($delete) {
            return redirect('/admin/user')->with('success', 'Data Pengguna berhasil dihapus');
        } else {
            return redirect('/admin/user')->with('error', 'Data Pengguna gagal dihapus');
        }
    }

    public function resetPassword(User $user)
    {
        $data = [
            'title' => 'Reset Password Pengguna',
            'user' => $user,
            'slug' => 'home'
        ];

        // dd($data);

        return view('admin.user.reset-password', $data);
    }

    public function updatePassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => 'required|max:255|min:8',
            'password_confirmation' => 'required|max:255|same:password',
        ], [
            'password.min' => 'Harap mengisi minimal 8 karakter',
        ]);

        $validated['password'] = Hash::make($request->password);

        // dd($validated);

        $reset = User::where('id', $user->id)->update([
            'password' => $validated['password'],
        ]);

        if ($reset) {
            return redirect('/admin/user')->with('success', 'Password Pengguna berhasil direset');
        } else {
            return redirect('/admin/user')->with('error', 'Password Pengguna gagal direset');
        }
    }
}
