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
                            <th class="sortable" data-sort="number">ID <span class="sort-icon"></span></th>
                            <th class="sortable" data-sort="text">NAMA <span class="sort-icon"></span></th>
                            <th class="sortable" data-sort="text">EMAIL <span class="sort-icon"></span></th>
                            <th class="sortable" data-sort="number">NO. HP <span class="sort-icon"></span></th>
                            <th class="sortable" data-sort="text">ALAMAT <span class="sort-icon"></span></th>
                            <th class="sortable" data-sort="text">ROLE <span class="sort-icon"></span></th>
                            <th>FOTO</th>
                            <th class="sortable" data-sort="text">TERDAFTAR <span class="sort-icon"></span></th>
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-bar input');
    const tableRows = document.querySelectorAll('.data-table tbody tr');

    searchInput.addEventListener('keyup', function() {
        const query = this.value.toLowerCase().trim();

        tableRows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(query) ? '' : 'none';
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

