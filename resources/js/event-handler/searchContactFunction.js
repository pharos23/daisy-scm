export function setupSearchContact() {
    const searchInput = document.getElementById('searchInput');
    const filterLocal = document.getElementById('filterLocal');
    const filterGroup = document.getElementById('filterGroup');
    const table = document.getElementById('contactsTable');
    const paginationContainer = document.querySelector('.pagination')?.parentElement;

    let searchTerm = '';
    let localFilter = '';
    let groupFilter = '';

    function buildQuery(url = '/contacts') {
        const fullUrl = new URL(url, window.location.origin);
        fullUrl.searchParams.set('search', searchTerm);
        fullUrl.searchParams.set('local', localFilter);
        fullUrl.searchParams.set('group', groupFilter);
        return fullUrl.toString();
    }

    function loadContacts(url = '/contacts') {
        fetch(buildQuery(url))
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Get the new table and pagination
                const newTbody = doc.querySelector('#contactsTable tbody');
                const newPagination = doc.querySelector('.pagination')?.parentElement;

                // Replace the old tbody and pagination
                if (newTbody) {
                    table.querySelector('tbody').innerHTML = newTbody.innerHTML;
                }
                if (newPagination && paginationContainer) {
                    paginationContainer.innerHTML = newPagination.innerHTML;
                }
            })
            .catch(error => console.error('Error loading contacts:', error));
    }

    // Apply filters
    function applyFilters() {
        searchTerm = searchInput.value;
        localFilter = filterLocal.value;
        groupFilter = filterGroup.value;
        loadContacts();
    }

    // Bind input events
    searchInput.addEventListener('input', applyFilters);
    filterLocal.addEventListener('change', applyFilters);
    filterGroup.addEventListener('change', applyFilters);

    // Delegate pagination link clicks
    document.addEventListener('click', function (e) {
        const link = e.target.closest('.pagination a');
        if (link) {
            e.preventDefault();
            loadContacts(link.getAttribute('href'));
        }
    });
}
