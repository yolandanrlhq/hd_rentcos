<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $fillable = ['sewa_id', 'isi', 'rating'];

    public function sewa()
    {
        return $this->belongsTo(Sewa::class);
    }
}
