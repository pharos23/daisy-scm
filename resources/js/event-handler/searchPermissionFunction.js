export function setupSearchPermission() {
    const searchInput = document.getElementById('permissionSearch');
    const table = document.getElementById('permissionsTable');
    const paginationContainer = document.querySelector('.pagination')?.parentElement;

    let searchTerm = '';

    function buildQuery(url = '/permissions') {
        const fullUrl = new URL(url, window.location.origin);
        fullUrl.searchParams.set('search', searchTerm);
        return fullUrl.toString();
    }

    function loadPermissions(url = '/permissions') {
        fetch(buildQuery(url))
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                const newTbody = doc.querySelector('#permissionsTable tbody');
                const newPagination = doc.querySelector('.pagination')?.parentElement;

                if (newTbody) {
                    table.querySelector('tbody').innerHTML = newTbody.innerHTML;
                }

                if (newPagination && paginationContainer) {
                    paginationContainer.innerHTML = newPagination.innerHTML;
                }
            })
            .catch(err => console.error('Error loading permissions:', err));
    }

    function applyFilters() {
        searchTerm = searchInput.value;
        loadPermissions();
    }

    searchInput.addEventListener('input', applyFilters);

    document.addEventListener('click', (e) => {
        const link = e.target.closest('.pagination a');
        if (link) {
            e.preventDefault();
            loadPermissions(link.href);
        }
    });
}
