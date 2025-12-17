@extends('layouts.admin')

@section('title', 'Edit Pengembalian Kostum')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/editPengembalian.css') }}">
@endsection

@section('content')
<div class="dashboard-container">
    @include('admin.sections.sidebar')

    <main class="main-content">
        <h2>Edit Pengembalian #{{ $pengembalian->sewa->id }}</h2>

        {{-- Success message --}}
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.pengembalian.update', $pengembalian->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="select-field" required>
                    @foreach(['belum_dikembalikan','dikembalikan','dicek_admin','selesai'] as $status)
                        <option value="{{ $status }}" {{ old('status', $pengembalian->status) == $status ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_',' ', $status)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Denda (Rp)</label>
                <input type="number" name="denda" class="input-field" value="{{ old('denda', $pengembalian->denda) }}">
            </div>

            <div class="form-group">
                <label>Catatan Admin</label>
                <textarea name="catatan_admin" class="textarea-field">{{ old('catatan_admin', $pengembalian->catatan_admin) }}</textarea>
            </div>

            <div class="form-group">
                <label>Bukti Foto</label>
                <input type="file" name="bukti_foto" class="input-file">
                @if($pengembalian->bukti_foto)
                    <p>Foto Saat Ini: <a href="{{ asset('storage/' . $pengembalian->bukti_foto) }}" target="_blank">Lihat</a></p>
                @endif
            </div>

            <button type="submit" class="btn-primary">Update Pengembalian</button>
        </form>
    </main>
</div>
@endsection
