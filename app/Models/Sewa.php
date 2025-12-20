<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    use HasFactory;

    protected $table = 'sewa';
    protected $fillable = [
        'user_id',
        'cart_id',
        'status',
        'tanggal_sewa',
        'tanggal_kembali',
        'total_harga'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(SewaItem::class, 'sewa_id');
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function getKodePesananAttribute()
    {
        return 'SEWA' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }

    public function testimoni()
    {
        return $this->hasOne(Testimoni::class, 'sewa_id');
    }
}
