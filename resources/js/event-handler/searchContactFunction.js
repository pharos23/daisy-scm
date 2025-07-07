export function setupSearchContact() {
    const searchInput = document.getElementById('searchInput');
    const filterLocal = document.getElementById('filterLocal');
    const filterGroup = document.getElementById('filterGroup');
    const filterDeleted = document.getElementById('filterDeleted');
    const table = document.getElementById('contactsTable');
    const paginationContainer = document.querySelector('.pagination')?.parentElement;

    function buildQuery(url = '/contacts') {
        const fullUrl = new URL(url, window.location.origin);
        fullUrl.searchParams.set('search', searchInput?.value || '');
        fullUrl.searchParams.set('local', filterLocal?.value || '');
        fullUrl.searchParams.set('group', filterGroup?.value || '');
        fullUrl.searchParams.set('deleted', filterDeleted?.value || 'active');
        return fullUrl.toString();
    }

    function updateBrowserURL(url) {
        window.history.pushState({}, '', url);
    }

    function loadContacts(url = '/contacts') {
        const fullUrl = buildQuery(url);
        fetch(fullUrl)
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

                updateBrowserURL(fullUrl);
            })
            .catch(error => console.error('Error loading contacts:', error));
    }

    function restoreFiltersFromURL() {
        const params = new URLSearchParams(window.location.search);

        if (searchInput) {
            searchInput.value = params.get('search') || '';
        }

        if (filterLocal) {
            filterLocal.value = params.get('local') || '';
        }

        if (filterGroup) {
            filterGroup.value = params.get('group') || '';
        }

        if (filterDeleted) {
            filterDeleted.value = params.get('deleted') || 'active';
        }

        loadContacts();
    }

    // Attach input/change events to trigger filtering
    searchInput?.addEventListener('input', () => loadContacts());
    filterLocal?.addEventListener('change', () => loadContacts());
    filterGroup?.addEventListener('change', () => loadContacts());
    filterDeleted?.addEventListener('change', () => loadContacts());

    // Handle pagination clicks and merge current filters
    document.addEventListener('click', function (e) {
        const link = e.target.closest('.pagination a');
        if (link) {
            e.preventDefault();
            let href = link.getAttribute('href');

            const url = new URL(href, window.location.origin);
            url.searchParams.set('local', filterLocal?.value || '');
            url.searchParams.set('group', filterGroup?.value || '');
            url.searchParams.set('deleted', filterDeleted?.value || 'active');
            url.searchParams.set('search', searchInput?.value || '');

            loadContacts(url.toString());
        }
    });

    // Restore filters on page load and back/forward navigation
    document.addEventListener('DOMContentLoaded', () => {
        restoreFiltersFromURL();
    });

    window.addEventListener('popstate', () => {
        restoreFiltersFromURL();
    });
}
