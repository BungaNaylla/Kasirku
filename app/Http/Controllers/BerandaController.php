<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class BerandaController extends Controller
{
    public function index()
    {
        $menus = Menu::all(); // Ambil semua data menu dari database
        return view('beranda', compact('menus'));
    }
}
