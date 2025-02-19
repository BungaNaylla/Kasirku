<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'total', 'nominal_uang', 'kembalian'];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
