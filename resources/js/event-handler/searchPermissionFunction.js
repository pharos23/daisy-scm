export function setupSearchPermission() {

    // Get reference to the search input and the permissions table and pagination container
    const searchInput = document.getElementById('permissionSearch');
    const table = document.getElementById('permissionsTable');
    const paginationContainer = document.querySelector('.pagination')?.parentElement;

    // Store the current search term
    let searchTerm = '';

    // Build the URL with current search term as query parameter
    function buildQuery(url = '/permissions') {
        const fullUrl = new URL(url, window.location.origin);
        fullUrl.searchParams.set('search', searchTerm);
        return fullUrl.toString();
    }

    // Fetch filtered permissions data from the server and update the table and pagination
    function loadPermissions(url = '/permissions') {
        fetch(buildQuery(url))
            .then(res => res.text())
            .then(html => {
                // Parse the returned HTML string into a document
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Extract the new tbody content from the fetched page
                const newTbody = doc.querySelector('#permissionsTable tbody');
                // Extract the new pagination container
                const newPagination = doc.querySelector('.pagination')?.parentElement;

                // Replace current table body with new filtered results
                if (newTbody) {
                    table.querySelector('tbody').innerHTML = newTbody.innerHTML;
                }

                // Replace current pagination with new pagination controls
                if (newPagination && paginationContainer) {
                    paginationContainer.innerHTML = newPagination.innerHTML;
                }
            })
            .catch(err => console.error('Error loading permissions:', err));
    }

    // Update search term and reload permissions whenever the user types in the search input
    function applyFilters() {
        searchTerm = searchInput.value;
        loadPermissions();
    }

    // Listen for input events on the search box to apply filters
    searchInput.addEventListener('input', applyFilters);

    // Handle pagination link clicks: prevent default navigation and load filtered results dynamically
    document.addEventListener('click', (e) => {
        const link = e.target.closest('.pagination a');
        if (link) {
            e.preventDefault();
            loadPermissions(link.href);
        }
    });
}
