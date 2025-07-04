export function setupSearchContact() {
    const searchInput = document.getElementById('searchInput');
    const filterLocal = document.getElementById('filterLocal');
    const filterGroup = document.getElementById('filterGroup');
    const filterTrashed = document.getElementById('filterTrashed');
    const table = document.getElementById('contactsTable');
    const paginationContainer = document.querySelector('.pagination')?.parentElement;

    let searchTerm = '';
    let localFilter = '';
    let groupFilter = '';
    let withTrashed = false;

    function buildQuery(url = '/contacts') {
        const fullUrl = new URL(url, window.location.origin);
        fullUrl.searchParams.set('search', searchTerm);
        fullUrl.searchParams.set('local', localFilter);
        fullUrl.searchParams.set('group', groupFilter);
        if (withTrashed) {
            fullUrl.searchParams.set('with_trashed', '1');
        }
        return fullUrl.toString();
    }

    function loadContacts(url = '/contacts') {
        fetch(buildQuery(url))
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                const newTbody = doc.querySelector('#contactsTable tbody');
                const newPagination = doc.querySelector('.pagination')?.parentElement;

                if (newTbody) {
                    table.querySelector('tbody').innerHTML = newTbody.innerHTML;
                }
                if (newPagination && paginationContainer) {
                    paginationContainer.innerHTML = newPagination.innerHTML;
                }
            })
            .catch(error => console.error('Error loading contacts:', error));
    }

    function applyFilters() {
        withTrashed = filterTrashed ? filterTrashed.checked : false;
        searchTerm = searchInput.value;
        localFilter = filterLocal.value;
        groupFilter = filterGroup.value;
        loadContacts();
    }

    searchInput.addEventListener('input', applyFilters);
    filterLocal.addEventListener('change', applyFilters);
    filterGroup.addEventListener('change', applyFilters);

    if (filterTrashed) {
        filterTrashed.addEventListener('change', applyFilters);
    }

    document.addEventListener('click', function (e) {
        const link = e.target.closest('.pagination a');
        if (link) {
            e.preventDefault();
            withTrashed = filterTrashed ? filterTrashed.checked : false;
            loadContacts(link.getAttribute('href'));
        }
    });
}
