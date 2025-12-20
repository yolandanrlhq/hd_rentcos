@extends('layouts.admin')

@section('title', 'Pengembalian Kostum')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/pengembalian.css') }}">
@endsection

@section('content')
<div class="dashboard-container">
    @include('admin.sections.sidebar')
    <main class="main-content">
        <div class="main-header">
            <h2>Daftar Pengembalian</h2>
            <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search for...">
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="data-table-section">
            {{-- <div class="table-info">
                <span class="status">Data Pengembalian</span>
            </div> --}}

            <table class="data-table">
                <thead>
                    <tr>
                        <th class="sortable" data-sort="number">ID Sewa <span class="sort-icon"></span></th>
                        <th class="sortable" data-sort="text">User <span class="sort-icon"></span></th>
                        <th class="sortable" data-sort="date">Tanggal Sewa<span class="sort-icon"></span></th>
                        <th class="sortable" data-sort="date">Tanggal Kembali<span class="sort-icon"></span></th>
                        <th class="sortable" data-sort="text">Status <span class="sort-icon"></span></th>
                        <th class="sortable" data-sort="number">Denda <span class="sort-icon"></span></th>
                        <th class="sortable" data-sort="text">Aksi <span class="sort-icon"></span></th>
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
                        <td class="aksi">
                            <a href="{{ route('admin.pengembalian.edit', $p->id) }}" class="btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;">Belum ada pengembalian</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $pengembalians->links() }}
    </main>
</div>
@endsection
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-bar input');
    const tableRows = document.querySelectorAll('.data-table tbody tr');

    searchInput.addEventListener('keyup', function() {
        const query = this.value.toLowerCase().trim();

        tableRows.forEach(row => {
            // Ambil semua teks di row
            const rowText = row.textContent.toLowerCase();
            // Tampilkan row jika mengandung query, sembunyikan jika tidak
            if(rowText.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});

document.querySelectorAll('.data-table th.sortable').forEach((th, index) => {
    let asc = true;

    th.addEventListener('click', () => {
        const tbody = th.closest('table').querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const type = th.dataset.sort;

        rows.sort((a, b) => {
            let aText = a.cells[index].textContent.trim();
            let bText = b.cells[index].textContent.trim();

            if (type === 'number') {
                aText = parseInt(aText.replace(/\D/g,'')) || 0;
                bText = parseInt(bText.replace(/\D/g,'')) || 0;
                return asc ? aText - bText : bText - aText;
            }

            if (type === 'date') {
                return asc
                    ? new Date(aText) - new Date(bText)
                    : new Date(bText) - new Date(aText);
            }

            return asc
                ? aText.localeCompare(bText, 'id')
                : bText.localeCompare(aText, 'id');
        });

        // reset icon semua header
        th.parentElement.querySelectorAll('th.sortable')
            .forEach(h => h.classList.remove('asc','desc'));

        th.classList.add(asc ? 'asc' : 'desc');
        asc = !asc;

        rows.forEach(row => tbody.appendChild(row));
    });
});
</script>
@endsection

