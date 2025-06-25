export function setupSearchUser() {
    const searchInput = document.getElementById('userSearch');
    const roleFilter = document.getElementById('roleFilter');
    const table = document.getElementById('usersTable');
    const paginationContainer = document.querySelector('.pagination')?.parentElement;

    let searchTerm = '';
    let role = '';

    function buildQuery(url = '/users') {
        const fullUrl = new URL(url, window.location.origin);
        fullUrl.searchParams.set('search', searchTerm);
        fullUrl.searchParams.set('role', role);
        return fullUrl.toString();
    }

    function loadUsers(url = '/users') {
        fetch(buildQuery(url))
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Replace table content
                const newTbody = doc.querySelector('#usersTable tbody');
                const newPagination = doc.querySelector('.pagination')?.parentElement;

                if (newTbody) {
                    table.querySelector('tbody').innerHTML = newTbody.innerHTML;
                }

                if (newPagination && paginationContainer) {
                    paginationContainer.innerHTML = newPagination.innerHTML;
                }
            })
            .catch(err => console.error('Error loading users:', err));
    }

    function applyFilters() {
        searchTerm = searchInput.value;
        role = roleFilter.value;
        loadUsers();
    }

    // Bind input events
    searchInput.addEventListener('input', applyFilters);
    roleFilter.addEventListener('change', applyFilters);

    // Delegate pagination clicks
    document.addEventListener('click', (e) => {
        const link = e.target.closest('.pagination a');
        if (link) {
            e.preventDefault();
            loadUsers(link.href);
        }
    });
}
