<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'delivery_method' // ⬅️ WAJIB
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function sewas()
    {
        return $this->hasMany(Sewa::class, 'cart_id');
    }
}
