@extends('layouts.admin')

@section('title','Dashboard Admin')

@section('content')
<div class="dashboard-container">
    @include('admin.sections.sidebar')
    <main class="main-content">
        <!-- STAT CARDS -->
        <section class="stat-cards-container">
            <a href="{{ route('admin.users') }}" class="stat-card total-pelanggan">
                <div class="card-icon"><i class="fas fa-users"></i></div>
                <div class="card-info">
                    <span class="card-title">Total User</span>
                    <span class="card-value" id="totalPelanggan">0</span>
                </div>
            </a>

            <a href="#" class="stat-card pendapatan">
                <div class="card-icon"><i class="fas fa-wallet"></i></div>
                <div class="card-info">
                    <span class="card-title">Pendapatan</span>
                    <span class="card-value" id="pendapatan">0</span>
                </div>
            </a>

            <a href="{{ route('admin.produk') }}" class="stat-card total-produk">
                <div class="card-icon"><i class="fas fa-gem"></i></div>
                <div class="card-info">
                    <span class="card-title">Total Produk</span>
                    <span class="card-value" id="totalProduk">0</span>
                </div>
            </a>

            <a href="{{ route('admin.pesanan') }}" class="stat-card total-pesanan">
                <div class="card-icon"><i class="fas fa-shopping-cart"></i></div>
                <div class="card-info">
                    <span class="card-title">Total Pesanan</span>
                    <span class="card-value" id="totalPesanan">0</span>
                </div>
            </a>
        </section>

        <!-- CHART -->
        <section class="chart-section">
            <div class="chart-header">
                <span class="chart-title">Pendapatan</span>
                <div class="dropdown">
                    <button class="period-btn" data-period="day">Hari</button>
                    <button class="period-btn active" data-period="month">Bulan</button>
                    <button class="period-btn" data-period="year">Tahun</button>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="pendapatanChart" height="250"></canvas>
            </div>
        </section>
    </main>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('pendapatanChart').getContext('2d');

let pendapatanChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'Pendapatan',
            data: @json($chartValues),
            backgroundColor: '#4a5496',
            borderRadius: 8,      // bar rounded
            barPercentage: 0.6,   // bar lebih ramping
            categoryPercentage: 0.7
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: { top: 10, right: 20, left: 10, bottom: 10 }
        },
        plugins: {
            legend: { display: false },
            tooltip: {
                yAlign: 'bottom',
                padding: 8,
                cornerRadius: 6
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { padding: 8 },
                grid: { color: '#ddd', borderDash: [3,3] }
            },
            x: {
                offset: true,
                ticks: { padding: 8 },
                grid: { drawOnChartArea: false }
            }
        }
    }
});

// Tombol switch period
document.querySelectorAll('.period-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        fetchDashboard(this.dataset.period);
    });
});

function fetchDashboard(period){
    fetch("{{ route('admin.dashboardData') }}?period=" + period)
    .then(res => res.json())
    .then(data => {
        document.getElementById('totalPelanggan').textContent = data.totalPelanggan;
        document.getElementById('pendapatan').textContent ='Rp' + Number(data.totalPendapatan).toLocaleString('id-ID');
        document.getElementById('totalProduk').textContent = data.totalProduk;
        document.getElementById('totalPesanan').textContent = data.totalPesanan;

        pendapatanChart.data.labels = data.labels;
        pendapatanChart.data.datasets[0].data = data.data;
        pendapatanChart.update();
    });
}

// Init default
fetchDashboard('month');
</script>
@endsection
