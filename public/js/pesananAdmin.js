/* ===============================
   UPDATE STATUS (AJAX)
================================ */
document.querySelectorAll('.status-select').forEach(select => {
    select.addEventListener('change', function () {
        const sewaId = this.dataset.id;
        const newStatus = this.value;

        fetch(`/admin/pesanan/${sewaId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const text = newStatus
                    .replace('_', ' ')
                    .replace(/\b\w/g, l => l.toUpperCase());

                this.outerHTML = `<span class="status-text">${text}</span>`;
            } else {
                alert('Gagal memperbarui status.');
            }
        })
        .catch(() => alert('Terjadi kesalahan.'));
    });
});


/* ===============================
   SEARCH & DATE FILTER
================================ */
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const tableRows = document.querySelectorAll('.data-table tbody tr');
    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');
    const filterBtn = document.getElementById('filter-date-btn');

    function filterTable(applyDateFilter = false) {
        const query = searchInput.value.toLowerCase().trim();
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;

        tableRows.forEach(row => {
            const nameCell = row.cells[1].textContent.toLowerCase();
            const produkCell = row.cells[2].textContent.toLowerCase();
            const dateCell = row.cells[4].textContent;

            let show = true;

            // 🔍 Search nama & kostum
            if (query && !nameCell.includes(query) && !produkCell.includes(query)) {
                show = false;
            }

            // 📅 Filter tanggal
            if (applyDateFilter) {
                if (startDate && dateCell < startDate) show = false;
                if (endDate && dateCell > endDate) show = false;
            }

            row.style.display = show ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', () => filterTable(false));
    filterBtn.addEventListener('click', () => filterTable(true));
});


/* ===============================
   SORTING TABLE (FINAL)
================================ */
document.querySelectorAll('.data-table th.sortable').forEach((th, index) => {
    th.addEventListener('click', () => {
        const tbody = th.closest('table').querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const isNumeric = ['id', 'harga'].includes(th.dataset.sort);
        const asc = !th.classList.contains('asc');

        rows.sort((a, b) => {
            let aText = a.cells[index].textContent.trim();
            let bText = b.cells[index].textContent.trim();

            // 🔢 NUMERIC SORT (ID & HARGA)
            if (isNumeric) {
                const aNum = parseInt(aText.replace(/\./g, '')) || 0;
                const bNum = parseInt(bText.replace(/\./g, '')) || 0;
                return asc ? aNum - bNum : bNum - aNum;
            }

            // 🔤 STRING SORT (NAMA, KOSTUM, TANGGAL)
            return asc
                ? aText.localeCompare(bText, 'id')
                : bText.localeCompare(aText, 'id');
        });

        // reset arrow
        th.closest('tr')
            .querySelectorAll('th.sortable')
            .forEach(h => h.classList.remove('asc', 'desc'));

        th.classList.add(asc ? 'asc' : 'desc');

        rows.forEach(row => tbody.appendChild(row));
    });
});
