<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'nama_produk',
        'harga_produk',
        'stok_produk', // stok total (opsional)
        'foto',
        'id_kategori',
        'rating',
        'deskripsi',
    ];

    /**
     * Relasi ke kategori produk.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    /**
     * Relasi ke ukuran produk (misal S, M, L, XL)
     */
    public function ukuran()
    {
        return $this->hasMany(UkuranProduk::class, 'id_produk');
    }

    /**
     * Hitung stok total dari semua ukuran
     */
    public function getTotalStokAttribute()
    {
        return $this->ukuranProduk->sum('stok');
    }
}
