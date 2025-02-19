<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Pastikan ini ada
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $user = user::paginate(200); 
        return view('datapetugas', compact('user')); // Kirim ke view
    }

    public function store(Request $request)
    {
        Log::info('Data yang diterima:', $request->all());
        // Validasi input
        $request->validate([
            'NamaLengkap' => 'required|string|max:255',
            'Username' => 'required|string|max:255|unique:user,Username',
            'Password' => 'required|string|min:6',
            'HakAkses' => 'required|in:Admin,Kasir',
        ]);

        // Simpan data ke database
        User::create([
            'NamaLengkap' => $request->NamaLengkap,
            'Username' => $request->Username,
            'Password' => Hash::make($request->Password), // Hash password sebelum disimpan
            'HakAkses' => $request->HakAkses,
        ]);

        // Redirect kembali ke halaman Data Petugas dengan pesan sukses
        return redirect()->route('datapetugas.index')->with('success', 'Petugas berhasil ditambahkan.');
    }
}
