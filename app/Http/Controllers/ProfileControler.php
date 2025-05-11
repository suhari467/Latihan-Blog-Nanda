<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileControler extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Profile Account',
            'slug' => 'home',
            'user' => Auth::user(),
        ];

        return view('profile.index', $data);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|max:255',
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
            return redirect('/account')->with('success', 'Profile Pengguna berhasil diedit');
        } else {
            return redirect('/account')->with('error', 'Profile Pengguna gagal diedit');
        }
    }

    public function password()
    {
        $data = [
            'title' => 'Reset Password',
            'slug' => 'home',
            'user' => Auth::user(),
        ];

        return view('profile.reset-password', $data);
    }

    public function resetPassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'old_password' => 'required|max:255|min:8',
            'password' => 'required|max:255|min:8',
            'password_confirmation' => 'required|max:255|same:password',
        ], [
            'password.min' => 'Harap mengisi minimal 8 karakter',
        ]);

        $validated['password'] = Hash::make($request->password);
        
        $check_password = Hash::check($request->old_password, $user->password);

        if(!$check_password){
            return redirect('/account')->with('error', 'Password Pengguna gagal direset! Password lama salah');
        }

        // dd($validated);

        $reset = User::where('id', $user->id)->update([
            'password' => $validated['password'],
        ]);

        if ($reset) {
            return redirect('/account')->with('success', 'Password Pengguna berhasil direset');
        } else {
            return redirect('/account')->with('error', 'Password Pengguna gagal direset');
        }
    }
}
