<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

/**
 * Routes tanpa middleware
 */
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('username', 'password');
    
    $user = DB::table('user')->where('Username', $credentials['username'])->first();
    
    if ($user && Hash::check($credentials['password'], $user->Password)) {
        Session::put('user', $user);
        return redirect()->route('beranda');
    }
    
    return back()->with('error', 'Username atau password salah!');
})->name('login.process');

Route::get('/logout', function () {
    Session::forget('user');
    return redirect()->route('login');
})->name('logout');

/**
 * Routes dengan middleware auth.session
 */
Route::middleware(['auth.session'])->group(function () {
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
});

/**
 * Routes untuk Product (Harus login)
 */
Route::middleware(['auth'])->group(function () {
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
        Route::get('/export', [ProductController::class, 'export'])->name('export');
    });
});

/**
 * Routes untuk Barang
 */
Route::get('/databarang', [ProductController::class, 'index'])->name('databarang.index');
Route::get('/barang/{id}/edit', [ProductController::class, 'edit'])->name('barang.edit');
Route::get('/cari-barang', function (Request $request) {
    $cari = $request->query('cari');
    
    if (!$cari) {
        return response()->json(['error' => 'Nama barang tidak boleh kosong'], 400);
    }

    $barang = Product::where('NamaProduk', 'LIKE', "%$cari%")->first();

    if (!$barang) {
        return response()->json(['error' => 'Barang tidak ditemukan'], 404);
    }

    return response()->json([
        'kode_barang' => $barang->id,
        'NamaProduk' => $barang->NamaProduk,
        'harga' => $barang->harga,
        'satuan' => $barang->satuan,
    ]);
});

Route::post('/products', [ProductController::class, 'store'])->name('products.store');

Route::get('/member', function () {
    $members = Member::paginate(10);
    return view('member', compact('members'));
})->name('members.index');

Route::post('/members/store', function (Request $request) {
    Member::create($request->all());
    return redirect()->route('members.index')->with('success', 'Member berhasil ditambahkan!');
})->name('members.store');


Route::get('/datapetugas', [UserController::class, 'index'])->name('datapetugas.index');
Route::post('/datapetugas', [UserController::class, 'store'])->name('datapetugas.store');
Route::get('/datapetugas/{id}/edit', [UserController::class, 'edit'])->name('datapetugas.edit');
Route::put('/datapetugas/{id}', [UserController::class, 'update'])->name('datapetugas.update');
Route::delete('/datapetugas/{id}', [UserController::class, 'destroy'])->name('datapetugas.destroy');


Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
Route::post('/transaction/store', [TransactionController::class, 'store'])->name('transaction.store');
Route::get('/transaction/struk/{id}', [TransactionController::class, 'struk'])->name('transaction.struk');

Route::get('/members/search', [MemberController::class, 'search']);
Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/transaksi', [TransactionController::class, 'index']);
Route::post('/transaksi/store', [TransactionController::class, 'store']);

Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

