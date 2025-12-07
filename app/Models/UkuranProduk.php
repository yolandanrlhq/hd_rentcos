<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sewa;
use App\Models\Produk;

class UkuranProduk extends Model
{
    use HasFactory;

    protected $table = 'ukuran_produk';
    protected $fillable = ['id_produk', 'nama_ukuran', 'stok'];

    /**
     * Relasi ke Produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    /**
     * Hitung jumlah unit yang sedang disewa (status menunggu_konfirmasi atau disewa)
     */
    public function jumlahDisewa()
    {
        return Sewa::where('produk_id', $this->id_produk)
            ->where('ukuran', $this->nama_ukuran)
            ->whereIn('status', ['menunggu_konfirmasi', 'disewa'])
            ->sum('jumlah');
    }

    /**
     * Hitung stok tersisa untuk ukuran ini
     */
    public function stokTersisa()
    {
        $sisa = $this->stok - $this->jumlahDisewa();
        return max($sisa, 0);
    }

    /**
     * Cek apakah ukuran ini habis disewa
     */
    public function isRented()
    {
        return $this->stokTersisa() <= 0;
    }

    /**
     * Event otomatis update stok total di Produk
     */
    protected static function booted()
    {
        static::created(function ($ukuran) {
            $ukuran->produk->updateStokTotal();
        });

        static::updated(function ($ukuran) {
            $ukuran->produk->updateStokTotal();
        });

        static::deleted(function ($ukuran) {
            $ukuran->produk->updateStokTotal();
        });
    }
}
