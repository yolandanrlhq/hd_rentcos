@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/pesanan.css') }}">
@endsection

@section('content')
<div class="dashboard-container">
    @include('admin.sections.sidebar')
    <main class="main-content">
            <section class="stat-cards-container">
                <div class="stat-card total">
                    <div class="card-icon"><i class="fas fa-receipt"></i></div>
                    <div class="card-info">
                        <span class="card-title">Total Pesanan</span>
                        <span class="card-value">250</span>
                    </div>
                    <button class="card-options"><i class="fas fa-ellipsis-v"></i></button>
                </div>

                <div class="stat-card success">
                    <div class="card-icon"><i class="fas fa-user-check"></i></div>
                    <div class="card-info">
                        <span class="card-title">Berhasil</span>
                        <span class="card-value">15</span>
                    </div>
                    <button class="card-options"><i class="fas fa-ellipsis-v"></i></button>
                </div>

                <div class="stat-card failed">
                    <div class="card-icon"><i class="fas fa-heart-broken"></i></div>
                    <div class="card-info">
                        <span class="card-title">Gagal</span>
                        <span class="card-value">200</span>
                    </div>
                    <button class="card-options"><i class="fas fa-ellipsis-v"></i></button>
                </div>

                <div class="stat-card pending">
                    <div class="card-icon"><i class="fas fa-clipboard-list"></i></div>
                    <div class="card-info">
                        <span class="card-title">Dalam Proses</span>
                        <span class="card-value">35</span>
                    </div>
                    <button class="card-options"><i class="fas fa-ellipsis-v"></i></button>
                </div>
            </section>

            <section class="data-table-section">
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>id_sewa</th>
                                <th>id_pelanggan</th>
                                <th>id_kostum</th>
                                <th>harga</th>
                                <th>tgl_sewa</th>
                                <th>tgl_kembali</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>SW-1001</td>
                                <td>PLG-001</td>
                                <td>KST-005</td>
                                <td>150.000</td>
                                <td>2025-11-01</td>
                                <td>2025-11-03</td>
                                <td>status</td>
                            </tr>
                            <tr>
                                <td>SW-1002</td>
                                <td>PLG-002</td>
                                <td>KST-010</td>
                                <td>200.000</td>
                                <td>2025-11-02</td>
                                <td>2025-11-04</td>
                                <td>status</td>
                            </tr>
                            <tr>
                                <td>SW-1003</td>
                                <td>PLG-003</td>
                                <td>KST-001</td>
                                <td>125.000</td>
                                <td>2025-11-03</td>
                                <td>2025-11-05</td>
                                <td>status</td>
                            </tr>
                            <tr>
                                <td>SW-1004</td>
                                <td>PLG-004</td>
                                <td>KST-007</td>
                                <td>180.000</td>
                                <td>2025-11-04</td>
                                <td>2025-11-06</td>
                                <td>status</td>
                            </tr>
                            <tr>
                                <td>SW-1005</td>
                                <td>PLG-005</td>
                                <td>KST-012</td>
                                <td>190.000</td>
                                <td>2025-11-05</td>
                                <td>2025-11-07</td>
                                <td>status</td>
                            </tr>
                            <tr>
                                <td>SW-1006</td>
                                <td>PLG-006</td>
                                <td>KST-003</td>
                                <td>250.000</td>
                                <td>2025-11-06</td>
                                <td>2025-11-08</td>
                                <td>status</td>
                            </tr>
                            <tr>
                                <td>SW-1007</td>
                                <td>PLG-007</td>
                                <td>KST-009</td>
                                <td>160.000</td>
                                <td>2025-11-07</td>
                                <td>2025-11-09</td>
                                <td>status</td>
                            </tr>
                            <tr>
                                <td>SW-1008</td>
                                <td>PLG-008</td>
                                <td>KST-002</td>
                                <td>175.000</td>
                                <td>2025-11-08</td>
                                <td>2025-11-10</td>
                                <td>status</td>
                            </tr>
                            <tr>
                                <td>SW-1009</td>
                                <td>PLG-009</td>
                                <td>KST-011</td>
                                <td>170.000</td>
                                <td>2025-11-09</td>
                                <td>2025-11-11</td>
                                <td>status</td>
                            </tr>
                            <tr>
                                <td>SW-1010</td>
                                <td>PLG-010</td>
                                <td>KST-008</td>
                                <td>140.000</td>
                                <td>2025-11-10</td>
                                <td>2025-11-12</td>
                                <td>status</td>
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
