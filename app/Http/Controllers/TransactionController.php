<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\TransactionDetail;


Route::get('/transaksi', [TransactionController::class, 'index']);
Route::post('/transaksi/store', [TransactionController::class, 'store']);

// Transaction Controller
class TransactionController extends Controller
{
    public function index()
    {
        
        $products = Product::all(); // Ambil semua produk dari database
        $members = Member::all();
         // Ambil semua member dari database
        return view('transaction', compact('products', 'members'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:member,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'total' => 'required|integer|min:0',
            'nominal_uang' => 'required|integer|min:0',
            'kembalian' => 'required|integer|min:0',
        ]);

        $transaction = Transaction::create([
            'member_id' => $request->member_id,
            'total' => $request->total,
            'nominal_uang' => $request->nominal_uang,
            'kembalian' => $request->kembalian,
        ]);

        foreach ($request->items as $item) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item['product_id'],
                'jumlah' => $item['jumlah'],
                'subtotal' => $item['subtotal'],
            ]);

            $product = Product::find($item['product_id']);
            $product->stok -= $item['jumlah'];
            $product->save();
        }

        return response()->json(['message' => 'Transaksi berhasil disimpan']);
    }
}
