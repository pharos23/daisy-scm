export function setupSearchUser() {
    const searchInput = document.getElementById('userSearch');
    const roleFilter = document.getElementById('roleFilter');
    const rows = document.querySelectorAll('#usersTable tbody tr');

    function filterTable() {
        const search = searchInput.value.toLowerCase();
        const role = roleFilter.value.toLowerCase();

        rows.forEach(row => {
            const name = row.querySelector('.name')?.textContent.toLowerCase() ?? '';
            const email = row.querySelector('.email')?.textContent.toLowerCase() ?? '';
            const roles = row.querySelector('.roles')?.textContent.toLowerCase() ?? '';

            const matchesSearch = name.includes(search) || email.includes(search);
            const matchesRole = !role || roles.includes(role);

            row.style.display = matchesSearch && matchesRole ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    roleFilter.addEventListener('change', filterTable);
}
