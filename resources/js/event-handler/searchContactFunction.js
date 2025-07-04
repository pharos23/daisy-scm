export function setupSearchContact() {
    const searchInput = document.getElementById('searchInput');
    const filterLocal = document.getElementById('filterLocal');
    const filterGroup = document.getElementById('filterGroup');
    const filterDeleted = document.getElementById('filterDeleted'); // the new select
    const table = document.getElementById('contactsTable');
    const paginationContainer = document.querySelector('.pagination')?.parentElement;

    let searchTerm = '';
    let localFilter = '';
    let groupFilter = '';
    let deletedFilter = 'active';

    function buildQuery(url = '/contacts') {
        const fullUrl = new URL(url, window.location.origin);
        fullUrl.searchParams.set('search', searchTerm);
        fullUrl.searchParams.set('local', localFilter);
        fullUrl.searchParams.set('group', groupFilter);
        if (deletedFilter) {
            fullUrl.searchParams.set('deleted', deletedFilter);
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
        searchTerm = searchInput.value;
        localFilter = filterLocal.value;
        groupFilter = filterGroup.value;
        deletedFilter = filterDeleted ? filterDeleted.value : 'active';
        loadContacts();
    }

    // connect the events
    searchInput.addEventListener('input', applyFilters);
    filterLocal.addEventListener('change', applyFilters);
    filterGroup.addEventListener('change', applyFilters);

    if (filterDeleted) {
        filterDeleted.addEventListener('change', applyFilters);
    }

    document.addEventListener('click', function (e) {
        const link = e.target.closest('.pagination a');
        if (link) {
            e.preventDefault();
            deletedFilter = filterDeleted ? filterDeleted.value : 'active';
            loadContacts(link.getAttribute('href'));
        }
    });
}
