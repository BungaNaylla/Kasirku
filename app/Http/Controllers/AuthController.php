<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        // Ambil user dari database berdasarkan Username
        $user = DB::table('user')->where('Username', $credentials['username'])->first();

        // Cek apakah user ditemukan dan password cocok
        if ($user && Hash::check($credentials['password'], $user->Password)) {
            // Simpan sesi login
            Session::put('user', $user);
            return redirect()->route('beranda');
        }

        return back()->with('error', 'Username atau password salah!');
    }

    public function logout()
    {
        Session::forget('user');
        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}
