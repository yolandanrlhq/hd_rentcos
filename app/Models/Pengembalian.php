<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $fillable = [
        'sewa_id',
        'tanggal_dikembalikan',
        'status',
        'denda',
        'catatan_admin',
        'bukti_foto'
    ];

    public function sewa()
    {
        return $this->belongsTo(Sewa::class);
    }
}
