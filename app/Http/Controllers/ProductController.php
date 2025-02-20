<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        Log::info('Mencari produk dengan query: ' . $query);
        $products = Product::where('nama', 'LIKE', "%{$query}%")->get();
        Log::info('Produk ditemukan: ' . $products->toJson());
        return response()->json($products);
    }

    public function index()
    {
        // Ambil semua data produk
        $products = Product::paginate(200);

        // Kirim data ke view
        return view('databarang', compact('products'));
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'NamaProduk' => $request->NamaProduk,
            'Harga' => $request->Harga,
            'Stok' => $request->Stok,
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
    public function getTotalStock()
    {
        $totalStokBarang = Product::sum('stok');
        return response()->json(['totalStokBarang' => $totalStokBarang]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:products,kode_barang',
            'NamaProduk' => 'required|string|max:255',
            'Harga' => 'required|numeric|min:0',
            'Stok' => 'required|integer|min:0',
        ]);

        Product::create([
            'kode_barang' => $request->kode_barang,
            'NamaProduk' => $request->NamaProduk,
            'Harga' => $request->Harga,
            'Stok' => $request->Stok,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

}
