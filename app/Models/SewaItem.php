<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SewaItem extends Model
{
    use HasFactory;

    protected $table = 'sewa_items';
    protected $fillable = [
        'sewa_id',
        'produk_id',
        'ukuran',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    public function sewa()
    {
        return $this->belongsTo(Sewa::class, 'sewa_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id_produk');
    }
}
