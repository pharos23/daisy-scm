export function setupSearchContact() {
    const searchInput = document.getElementById('searchInput');
    const filterLocal = document.getElementById('filterLocal');
    const filterGroup = document.getElementById('filterGroup');
    const table = document.getElementById('contactsTable');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const localFilter = filterLocal.value;
        const groupFilter = filterGroup.value;

        rows.forEach(row => {
            const local = row.querySelector('.local').textContent.toLowerCase();
            const group = row.querySelector('.group').textContent.toLowerCase();
            const name = row.querySelector('.name').textContent.toLowerCase();
            const phone = row.querySelector('.phone').textContent.toLowerCase();

            // Check search text matches any column (name, phone, local, group)
            const matchesSearch =
                name.includes(searchTerm) ||
                phone.includes(searchTerm) ||
                local.includes(searchTerm) ||
                group.includes(searchTerm);

            // Check filters
            const matchesLocal = !localFilter || local === localFilter.toLowerCase();
            const matchesGroup = !groupFilter || group === groupFilter.toLowerCase();

            if (matchesSearch && matchesLocal && matchesGroup) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Event listeners
    searchInput.addEventListener('input', filterTable);
    filterLocal.addEventListener('change', filterTable);
    filterGroup.addEventListener('change', filterTable);
}
