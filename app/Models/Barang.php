<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
   protected $fillable = [
    'nama',
    'kode_barang',
    'stok',
    'harga_beli',
    'harga_jual',
    'gambar'
];
public function transaksis()
{
    return $this->hasMany(Transaksi::class);
}
}
