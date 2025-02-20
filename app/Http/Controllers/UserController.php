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
    $request->validate([
        'NamaLengkap' => 'required',
        'Username' => 'required|unique:user,Username',
        'password' => 'required|min:6',
        'HakAkses' => 'required',
    ]);

    User::create([
        'NamaLengkap' => $request->NamaLengkap,
        'Username' => $request->Username,
        'password' => bcrypt($request->password), // Hash password sebelum simpan
        'HakAkses' => $request->HakAkses,
    ]);

    return redirect()->route('datapetugas')->with('success', 'Petugas berhasil ditambahkan');
}
}