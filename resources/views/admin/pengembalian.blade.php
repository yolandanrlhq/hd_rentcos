@extends('layouts.admin')

@section('title', 'Pengembalian Kostum')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/pengembalian.css') }}">
@endsection

@section('content')
<div class="dashboard-container">
    @include('admin.sections.sidebar')
    <main class="main-content">
        <h2>Daftar Pengembalian</h2>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>ID Sewa</th>
                    <th>User</th>
                    <th>Tanggal Sewa</th>
                    <th>Tanggal Kembali</th>
                    <th>Status Pengembalian</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengembalians as $p)
                <tr>
                    <td>{{ $p->sewa->id }}</td>
                    <td>{{ $p->sewa->user->name }}</td>
                    <td>{{ $p->sewa->tanggal_sewa }}</td>
                    <td>{{ $p->tanggal_dikembalikan }}</td>
                    <td>
                    <span class="badge-status badge-{{ $p->status }}">
                        {{ ucfirst(str_replace('_',' ', $p->status)) }}
                    </span>
                </td>
                    <td>{{ $p->denda ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.pengembalian.edit', $p->id) }}">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">Belum ada pengembalian</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $pengembalians->links() }}
    </main>
</div>
@endsection
