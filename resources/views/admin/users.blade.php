@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/produkAdmin.css') }}">
@endsection

@section('content')
<div class="dashboard-container">
    @include('admin.sections.sidebar')

    <main class="main-content">
        <header class="main-header">
            <h2>Semua User</h2>

            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Cari user...">
            </div>
        </header>

        <section class="data-table-section">
            <div class="table-info">
                <span class="status">semua user</span>
            </div>

            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAMA</th>
                            <th>EMAIL</th>
                            <th>NO HP</th>
                            <th>ALAMAT</th>
                            <th>ROLE</th>
                            <th>FOTO</th>
                            <th>TERDAFTAR</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>

                            <td>{{ $user->name }}</td>

                            <td>{{ $user->email }}</td>

                            <td>{{ $user->phone ?? '-' }}</td>

                            <td style="max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $user->address ?? '-' }}
                            </td>

                            <td>
                                <span class="badge-ukuran">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>

                            <td>
                                @if($user->foto)
                                    <img src="{{ asset('storage/'.$user->foto) }}" width="40">
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                {{ $user->created_at
                                    ? $user->created_at->format('d-m-Y')
                                    : '-' }}
                            </td>

                            <td class="aksi">
                                <a href="#" class="btn-edit">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form action="#" method="POST" class="hapus-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete"
                                        onclick="return confirm('Yakin hapus user ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
@endsection
