<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthSessionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('user')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }

        // Cek jika user adalah petugas dan mencoba akses beranda
        $user = Session::get('user');
        if ($user->role === 'petugas' && $request->route()->getName() === 'beranda') {
            return redirect()->route('transaksi')->with('error', 'Anda tidak memiliki akses ke halaman beranda.');
        }

        return $next($request);
    }
}
