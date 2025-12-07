<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events'; // sesuaikan nama tabel
    protected $primaryKey = 'id_event'; // jika menggunakan id custom

    protected $fillable = [
        'nama_event',
        'tempat_event',
        'tgl_event',
        'htm',
        'kontak_panitia',
        'gambar', // jika ada kolom untuk foto
    ];

    protected $dates = [
        'tgl_event' => 'datetime',
    ];
}
