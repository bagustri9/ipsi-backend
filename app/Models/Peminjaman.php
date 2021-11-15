<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "total",
        "barang_jaminan",
        "tanggal_rental",
        "rencana_pengembalian",
        "status"
    ];
}
