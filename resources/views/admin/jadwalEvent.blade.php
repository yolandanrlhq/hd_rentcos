@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/jadwalEvent.css') }}">
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
                <button class="add-button">
                    Tambah Event
                    <i class="fas fa-plus-circle"></i>
                </button>
            </header>

            <section class="data-table-section">
                <div class="table-info">
                    <span class="status">semua event</span>
                    <span class="pagination-summary">1-25 of 200</span>
                </div>
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>id_event</th>
                                <th>nama_event</th>
                                <th>tempat_event</th>
                                <th>tgl_event</th>
                                <th>htm</th>
                                <th>kontak_panitia</th>
                                <th>edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>EVT-012</td>
                                <td>Big Cosplay Bash</td>
                                <td>Mega Hall</td>
                                <td>2026-06-19</td>
                                <td>Rp 150.000</td>
                                <td>+6281xxxxxx</td>
                                <td><i class="fas fa-pen"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <footer class="main-footer">
                <span class="table-count">1-10 of 460</span>
                <div class="pagination-controls">
                    <span>Rows per page:</span>
                    <span class="row-count">10</span>
                    <button class="nav-button"><i class="fas fa-angle-left"></i></button>
                    <button class="nav-button"><i class="fas fa-angle-right"></i></button>
                </div>
            </footer>
    </main>
</div>
@endsection
