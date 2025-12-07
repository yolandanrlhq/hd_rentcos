@extends('layouts.admin')

@section('title', 'Tambah Event - HD RENTCOS')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<div class="dashboard-container">
    @include('admin.sections.sidebar')
    <div class="main-content">
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

        <div class="form-container">
            <h2>Tambah Event Baru</h2>

            <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nama_event">Nama Event</label>
                    <input type="text" name="nama_event" id="nama_event" required>
                </div>

                <div class="form-group">
                    <label for="tempat_event">Tempat Event</label>
                    <input type="text" name="tempat_event" id="tempat_event" required>
                </div>

                <div class="form-group">
                    <label for="tgl_event">Tanggal Event</label>
                    <input type="date" name="tgl_event" id="tgl_event" required>
                </div>

                <div class="form-group">
                    <label for="htm">Harga Tiket (HTM)</label>
                    <input type="number" name="htm" id="htm" required>
                </div>

                <div class="form-group">
                    <label for="kontak_panitia">Kontak Panitia</label>
                    <input type="text" name="kontak_panitia" id="kontak_panitia" required>
                </div>

                <div class="form-group">
                    <label for="gambar">Foto Event</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Simpan</button>
                    <a href="{{ route('admin.event.index') }}" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
