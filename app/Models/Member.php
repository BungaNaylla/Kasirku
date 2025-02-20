<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';
    protected $fillable = ['NamaMember', 'Alamat', 'NomorTelepon'];

    // Mengatasi nama kolom dengan spasi
    public function getNamaMemberAttribute()
    {
        return $this->attributes['NamaMember'] ?? null;
    }
}