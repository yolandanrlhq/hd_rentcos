<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Notification;


class EventAdminController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('tgl_event', 'asc')->paginate(10);
        return view('admin.jadwalEvent', compact('events'));
    }

    public function create()
    {
        return view('admin.createEvent');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nama_event' => 'required|string|max:255',
        'tempat_event' => 'required|string|max:255',
        'tgl_event' => 'required|date',
        'htm' => 'required|numeric|min:0',
        'kontak_panitia' => 'required|string|max:50',
        'gambar' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('gambar')) {
        $validated['gambar'] = $request->file('gambar')->store('events', 'public');
    }

    // ================= SIMPAN EVENT =================
    $event = Event::create($validated);

    // ================= NOTIFIKASI KE USER =================
    $users = User::where('role', 'user')->get();

    foreach ($users as $user) {
        Notification::create([
            'user_id' => $user->id,
            'judul'   => 'Event Baru',
            'pesan'   => "Event {$event->nama_event} akan dilaksanakan pada {$event->tgl_event}.",
            'ikon'    => 'calendar-event',
            'is_read' => false,
        ]);
    }
    // =====================================================

    return redirect()
        ->route('admin.event.index')
        ->with('success', 'Event berhasil ditambahkan & notifikasi terkirim!');
}


    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.editEvent', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // validasi input
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'tempat_event' => 'required|string|max:255',
            'tgl_event' => 'required|date',
            'htm' => 'required|numeric',
            'kontak_panitia' => 'required|string|max:100',
            'gambar' => 'nullable|image|max:2048',
        ]);

        // update data
        $event->nama_event = $request->nama_event;
        $event->tempat_event = $request->tempat_event;
        $event->tgl_event = $request->tgl_event;
        $event->htm = $request->htm;
        $event->kontak_panitia = $request->kontak_panitia;

        // jika ada gambar baru
        if ($request->hasFile('gambar')) {
            if ($event->gambar) {
                Storage::delete($event->gambar); // hapus gambar lama
            }
            $event->gambar = $request->file('gambar')->store('events');
        }

        $event->save();

        return redirect()->route('admin.event.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        if ($event->gambar && \Storage::disk('public')->exists($event->gambar)) {
            \Storage::disk('public')->delete($event->gambar);
        }
        $event->delete();

        return redirect()->route('admin.event.index')->with('success', 'Event berhasil dihapus');
    }
}
