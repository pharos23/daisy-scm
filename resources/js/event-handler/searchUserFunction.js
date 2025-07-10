export function setupSearchUser() {

    // Get references to relevant elements: search input, role filter dropdown, deleted filter dropdown, users table, and pagination container
    const searchInput = document.getElementById('userSearch');
    const roleFilter = document.getElementById('roleFilter');
    const filterDeleted = document.getElementById('filterDeleted');
    const table = document.getElementById('usersTable');
    const paginationContainer = document.querySelector('.pagination')?.parentElement;

    // Variables to hold the current filter values
    let searchTerm = '';
    let role = '';

    // Builds the URL for fetching user data, adding current filters as query parameters
    function buildQuery(url = '/users') {
        const fullUrl = new URL(url, window.location.origin);
        fullUrl.searchParams.set('search', searchTerm);
        fullUrl.searchParams.set('role', role);
        return fullUrl.toString();
    }

    // Fetches the user data page with applied filters and updates the table and pagination
    function loadUsers(url = '/users') {
        fetch(buildQuery(url))
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Extract updated table body and pagination container from fetched HTML
                const newTbody = doc.querySelector('#usersTable tbody');
                const newPagination = doc.querySelector('.pagination')?.parentElement;

                // Replace the current table body with new results
                if (newTbody) {
                    table.querySelector('tbody').innerHTML = newTbody.innerHTML;
                }

                // Replace the current pagination controls
                if (newPagination && paginationContainer) {
                    paginationContainer.innerHTML = newPagination.innerHTML;
                }
            })
            .catch(err => console.error('Error loading users:', err));
    }

    // For search input and deleted filter dropdown:
    // On change, update the URL query parameters and reload the page with the new parameters.
    [searchInput, filterDeleted].forEach(el => {
        if (el) {
            el.addEventListener('change', () => {
                const search = searchInput.value;
                const deleted = filterDeleted?.value || '';

                const params = new URLSearchParams(window.location.search);
                params.set('search', search);
                if (deleted) {
                    params.set('deleted', deleted);
                } else {
                    params.delete('deleted');
                }

                // Navigate to updated URL - reloads the page with new filters
                window.location.href = `${window.location.pathname}?${params.toString()}`;
            });
        }
    });

    // Apply filters by updating local variables and loading filtered user data asynchronously
    function applyFilters() {
        searchTerm = searchInput.value;
        role = roleFilter.value;
        loadUsers();
    }

    // Bind event listeners for user search input and role filter dropdown changes
    searchInput.addEventListener('input', applyFilters);
    roleFilter.addEventListener('change', applyFilters);

    // Delegate click events on pagination links to load paginated user data without full page reload
    document.addEventListener('click', (e) => {
        const link = e.target.closest('.pagination a');
        if (link) {
            e.preventDefault();
            loadUsers(link.href);
        }
    });
}
