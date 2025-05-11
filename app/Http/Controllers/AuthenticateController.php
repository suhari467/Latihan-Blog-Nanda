<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticateController extends Controller
{
    public function login()
    {
        $data = [
            'title' => 'Login Akses',
        ];

        // dd($data);

        return view('auth.login', $data);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('home');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/login');
    }

    public function register()
    {
        $data = [
            'title' => 'Register Account',
        ];

        // dd($data);

        return view('auth.register', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:users,email',
            'password' => 'required|max:255|min:8',
            'password_confirmation' => 'required|max:255|same:password',
        ], [
            'password.min' => 'Harap mengisi minimal 8 karakter',
        ]);

        $validated['password'] = Hash::make($request->password);
        $validated['role_id'] = 2; //Level Pengguna adalah User
        // dd($validated);

        $create = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'password' => $validated['password'],
        ]);

        if ($create) {
            return redirect('/login')->with('success', 'Registrasi berhasil');
        } else {
            return redirect('/login')->with('error', 'Registrasi gagal');
        }
    }
}
