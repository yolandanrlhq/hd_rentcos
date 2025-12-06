
@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="dashboard-container">
    @include('admin.sections.sidebar')
    <main class="main-content">
            <section class="stat-cards-container">
                <div class="stat-card total-pelanggan">
                    <div class="card-icon"><i class="fas fa-users"></i></div>
                    <div class="card-info">
                        <span class="card-title">Total Pelanggan</span>
                        <span class="card-value">250</span>
                    </div>
                    <button class="card-options"><i class="fas fa-ellipsis-v"></i></button>
                </div>

                <div class="stat-card pendapatan">
                    <div class="card-icon"><i class="fas fa-wallet"></i></div>
                    <div class="card-info">
                        <span class="card-title">Pendapatan</span>
                        <span class="card-value">15</span>
                    </div>
                    <button class="card-options"><i class="fas fa-ellipsis-v"></i></button>
                </div>

                <div class="stat-card total-kostum">
                    <div class="card-icon"><i class="fas fa-gem"></i></div>
                    <div class="card-info">
                        <span class="card-title">Total Kostm</span>
                        <span class="card-value">200</span>
                    </div>
                    <button class="card-options"><i class="fas fa-ellipsis-v"></i></button>
                </div>

                <div class="stat-card total-pesanan">
                    <div class="card-icon"><i class="fas fa-shopping-cart"></i></div>
                    <div class="card-info">
                        <span class="card-title">Total Pesanan</span>
                        <span class="card-value">35</span>
                    </div>
                    <button class="card-options"><i class="fas fa-ellipsis-v"></i></button>
                </div>
            </section>

            <section class="chart-section">
                <div class="chart-header">
                    <span class="chart-title">Item approvals in</span>
                    <div class="dropdown">
                        This werk <i class="fas fa-chevron-down"></i>
                    </div>
                </div>

                <div class="chart-body">
                    <div class="chart-y-axis">
                        <span>Sat</span>
                        <span>Fir</span>
                        <span>Thu</span>
                        <span>Wed</span>
                        <span>Tue</span>
                        <span>Mon</span>
                        <span>Sun</span>
                    </div>
                    <div class="bar-chart-area">
                        <div class="chart-x-axis">
                            <span>10</span>
                            <span>20</span>
                            <span>30</span>
                            <span>40</span>
                            <span>50</span>
                            <span>60</span>
                            <span>70</span>
                            <span>80</span>
                            <span>90</span>
                            <span>100</span>
                            <span>110</span>
                            <span>120</span>
                        </div>

                        <div class="bars-container">
                            <div class="bar" style="--bar-width: 50;"></div> <div class="bar" style="--bar-width: 75;"></div> <div class="bar" style="--bar-width: 65;"></div> <div class="bar highlight-bar" style="--bar-width: 115;">
                                <span class="percentage">95%</span>
                            </div> <div class="bar" style="--bar-width: 95;"></div> <div class="bar" style="--bar-width: 85;"></div> <div class="bar" style="--bar-width: 70;"></div> </div>
                    </div>
                </div>
            </section>
        </main>
</div>
@endsection
