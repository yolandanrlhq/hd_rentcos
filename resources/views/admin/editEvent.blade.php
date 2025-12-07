@extends('layouts.admin')

@section('title', 'Edit Event')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/editProduk.css') }}">
@endsection

@section('content')
<div class="dashboard-container">
    @include('admin.sections.sidebar')
    <div class="main-content">
        <div class="form-container">
            <h2>Edit Event</h2>

            @if ($errors->any())
                <div class="alert alert-danger" style="background-color:#f8d7da; color:#721c24; padding:10px; border-radius:5px; margin-bottom:15px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" style="background-color:#f8d7da; color:#721c24; padding:10px; border-radius:5px; margin-bottom:15px;">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.event.update', $event->id_event) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama_event">Nama Event</label>
                    <input type="text" name="nama_event" id="nama_event" value="{{ old('nama_event', $event->nama_event) }}" required>
                </div>

                <div class="form-group">
                    <label for="tempat_event">Tempat</label>
                    <input type="text" name="tempat_event" id="tempat_event" value="{{ old('tempat_event', $event->tempat_event) }}" required>
                </div>

                <div class="form-group">
                    <label for="tgl_event">Tanggal</label>
                    <input type="date" name="tgl_event" id="tgl_event" value="{{ old('tgl_event', date('Y-m-d', strtotime($event->tgl_event))) }}" required>
                </div>

                <div class="form-group">
                    <label for="htm">HTM</label>
                    <input type="number" name="htm" id="htm" value="{{ old('htm', $event->htm) }}" required>
                </div>

                <div class="form-group">
                    <label for="kontak_panitia">Kontak Panitia</label>
                    <input type="text" name="kontak_panitia" id="kontak_panitia" value="{{ old('kontak_panitia', $event->kontak_panitia) }}" required>
                </div>

                <div class="form-group">
                    <label for="gambar">Foto Event Baru</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*">
                </div>

                <div class="form-group">
                    <label>Foto Event Lama</label>
                    <div class="existing-photos">
                        @if($event->gambar)
                            <img src="{{ asset('storage/' . $event->gambar) }}" alt="Foto Event" style="width:100px; height:100px; object-fit:cover; border-radius:5px;">
                        @else
                            Tidak ada foto
                        @endif
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Perbarui</button>
                    <a href="{{ route('admin.event.index') }}" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
