<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'barang_id',
        'jenis',
        'jumlah',
        'total_harga',
        'status',
        'cancel_jumlah'

    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
