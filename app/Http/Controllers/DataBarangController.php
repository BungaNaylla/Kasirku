<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Gunakan model Product

class DataBarangController extends Controller
{
    public function index()
    {
        // Ambil semua data dari tabel products
        $items = Product::all(); 
        dd($items);
        return view('databarang', compact('items'));
    }
}


