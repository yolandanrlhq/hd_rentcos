<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukFoto extends Model
{
    use HasFactory;

    protected $table = 'produk_fotos';
    protected $fillable = ['id_produk', 'foto_path'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
