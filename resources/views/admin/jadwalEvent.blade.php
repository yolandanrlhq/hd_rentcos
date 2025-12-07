@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/jadwalEventAdmin.css') }}">
@endsection

@section('content')
<div class="dashboard-container">
    @include('admin.sections.sidebar')
    <main class="main-content">
            <header class="main-header">
                <h2>EVENT</h2>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search for...">
                </div>
                <a href="{{ route('admin.event.create') }}" class="add-button">
                    Tambah Event
                    <i class="fas fa-plus-circle"></i>
                </a>
            </header>

            <section class="data-table-section">
                <div class="table-info">
                    <span class="status">semua event</span>

                </div>
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>nama</th>
                                <th>tempat</th>
                                <th>tgl</th>
                                <th>htm</th>
                                <th>kontak</th>
                                <th>foto</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td>{{ $event->id_event }}</td>
                            <td>{{ $event->nama_event }}</td>
                            <td class="tempat-event">{{ $event->tempat_event }}</td>
                            <td>{{ date('Y-m-d', strtotime($event->tgl_event)) }}</td>
                            <td>{{ $event->htm }}</td>
                            <td>{{ $event->kontak_panitia }}</td>
                            <td>
                                @if($event->gambar)
                                <img src="{{ asset('storage/'.$event->gambar) }}" width="50" alt="{{ $event->gambar }}">
                                @else
                                Tidak ada
                                @endif
                            </td>
                            <td>
                                <!-- Edit -->
                                <a href="{{ route('admin.event.edit', $event->id_event) }}">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('admin.event.destroy', $event->id_event) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('Yakin hapus event ini?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="pagination-wrapper" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                <span class="table-count">
                    {{ $events->firstItem() ?? 0 }}-{{ $events->lastItem() ?? 0 }} of {{ $events->total() }}
                </span>
                <div class="pagination-controls">
                    <span>Rows per page:</span>
                    <span class="row-count">{{ $events->perPage() }}</span>

                    @if($events->onFirstPage())
                        <button class="nav-button disabled"><i class="fas fa-angle-left"></i></button>
                    @else
                        <a href="{{ $events->previousPageUrl() }}" class="nav-button"><i class="fas fa-angle-left"></i></a>
                    @endif

                    @if($events->hasMorePages())
                        <a href="{{ $events->nextPageUrl() }}" class="nav-button"><i class="fas fa-angle-right"></i></a>
                    @else
                        <button class="nav-button disabled"><i class="fas fa-angle-right"></i></button>
                    @endif
                </div>
            </div>
    </main>
</div>
@endsection
