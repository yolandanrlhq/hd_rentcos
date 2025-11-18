<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'id_produk',
        'ukuran',
        'jumlah',
        'harga_satuan'
    ];

    public function produk()
    {
        // FK: cart_items.id_produk -> produk.id_produk
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
