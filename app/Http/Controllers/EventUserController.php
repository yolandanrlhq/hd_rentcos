<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventUserController extends Controller
{
    public function index()
    {
        // Ambil semua event (bisa urut tanggal terbaru)
        $events = Event::orderBy('tgl_event', 'desc')->get();

        return view('user.jadwalEvent', compact('events'));
    }
}
