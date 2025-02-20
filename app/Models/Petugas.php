<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'email', 'password'];
}
Petugas::create([
    'nama_lengkap' => 'Bunga',
    'username' => 'Kasir',
    'password' => bcrypt('password123'), // Pastikan password di-hash
    'hak_akses' => 'Kasir',
]);