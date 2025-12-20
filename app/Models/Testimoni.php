<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $fillable = [
        'sewa_id',
        'produk_id',
        'isi',
        'rating',
        'foto'
    ];

    public function sewa()
    {
        return $this->belongsTo(Sewa::class, 'sewa_id');
    }
}
