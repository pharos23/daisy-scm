export function setupSearchPermission() {
    const searchInput = document.getElementById('permissionSearch');
    const rows = document.querySelectorAll('#permissionsTable tbody tr');

    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();

        rows.forEach(row => {
            const permissionName = row.querySelector('.permission-name')?.textContent.toLowerCase() ?? '';
            const matches = permissionName.includes(query);
            row.style.display = matches ? '' : 'none';
        });
    });
}
