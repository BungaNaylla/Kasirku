<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

Route::get('/cari-barang', function (Request $request) {
    $barang = Product::where('NamaProduk', 'LIKE', "%{$request->cari}%")->first();
    return response()->json($barang ?: ['error' => 'Barang tidak ditemukan'], $barang ? 200 : 404);
});

Route::get('/api/products', function (Request $request) {
    $query = $request->query('query');
    $products = Product::where('NamaProduk', 'LIKE', "%{$query}%")->limit(5)->get();
    return response()->json($products);
});

Route::post('/transaksi/store', function (Request $request) {
    $transaksi = new Transaction();
    $transaksi->id_member = $request->id_member;
    $transaksi->nominal = $request->nominal;
    $transaksi->total_harga = $request->total_harga;
    $transaksi->save();

    return response()->json(['message' => 'Transaksi berhasil disimpan!']);
});
