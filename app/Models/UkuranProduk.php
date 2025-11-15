<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UkuranProduk extends Model
{
    use HasFactory;

    protected $table = 'ukuran_produk';
    protected $fillable = ['id_produk', 'nama_ukuran', 'stok'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
