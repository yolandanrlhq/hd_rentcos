<?php

namespace App\Models;

use App\Models\ProdukFoto;
use App\Models\Sewa;
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
        'stok_produk',
        'foto',
        'id_kategori',
        'rating',
        'deskripsi',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function ukuran()
    {
        return $this->hasMany(UkuranProduk::class, 'id_produk');
    }

    public function fotos()
    {
        return $this->hasMany(ProdukFoto::class, 'id_produk');
    }

    public function getTotalStokAttribute()
    {
        return $this->ukuran->sum('stok');
    }

    public function sewa()
    {
        return $this->hasMany(Sewa::class, 'produk_id', 'id_produk');
    }

    public function updateStokTotal()
    {
        // Hitung total stok dari semua ukuran
        $total = $this->ukuran()->sum('stok');
        $this->stok_produk = $total;
        $this->save();
    }

    public function testimonis()
    {
        return $this->hasMany(Testimoni::class, 'produk_id', 'id_produk');
    }
}
