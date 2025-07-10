export function setupSearchContact() {

    // Get references to search/filter inputs and table/pagination containers
    const searchInput = document.getElementById('searchInput');
    const filterLocal = document.getElementById('filterLocal');
    const filterGroup = document.getElementById('filterGroup');
    const filterDeleted = document.getElementById('filterDeleted');
    const table = document.getElementById('contactsTable');
    const paginationContainer = document.querySelector('.pagination')?.parentElement;

    // Build the URL query string with current filter values
    function buildQuery(url = '/contacts') {
        const fullUrl = new URL(url, window.location.origin);
        fullUrl.searchParams.set('search', searchInput?.value || '');
        fullUrl.searchParams.set('local', filterLocal?.value || '');
        fullUrl.searchParams.set('group', filterGroup?.value || '');
        fullUrl.searchParams.set('deleted', filterDeleted?.value || 'active');
        return fullUrl.toString();
    }

    // Update the browser's URL bar without reloading the page
    function updateBrowserURL(url) {
        window.history.pushState({}, '', url);
    }

    // Fetch filtered contacts and update the table and pagination dynamically
    function loadContacts(url = '/contacts') {
        const fullUrl = buildQuery(url);
        fetch(fullUrl)
            .then(response => response.text())
            .then(html => {
                // Parse the fetched HTML string into a document object
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Extract the new tbody content from the fetched page
                const newTbody = doc.querySelector('#contactsTable tbody');
                // Extract the new pagination container from the fetched page
                const newPagination = doc.querySelector('.pagination')?.parentElement;

                // Replace current table body with the new filtered results
                if (newTbody) {
                    table.querySelector('tbody').innerHTML = newTbody.innerHTML;
                }
                // Replace current pagination with new pagination controls
                if (newPagination && paginationContainer) {
                    paginationContainer.innerHTML = newPagination.innerHTML;
                }

                // Update the browser URL to reflect current filters and page
                updateBrowserURL(fullUrl);
            })
            .catch(error => console.error('Error loading contacts:', error));
    }

    // Set the filters inputs based on the current URL query parameters
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

        // Load contacts immediately after restoring filters
        loadContacts();
    }

    // Attach event listeners to inputs to reload filtered contacts on change/input
    searchInput?.addEventListener('input', () => loadContacts());
    filterLocal?.addEventListener('change', () => loadContacts());
    filterGroup?.addEventListener('change', () => loadContacts());
    filterDeleted?.addEventListener('change', () => loadContacts());

    // Listen for pagination link clicks and load contacts with current filters + selected page
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

    // On page load and when user navigates back/forward, restore filters and reload contacts
    document.addEventListener('DOMContentLoaded', () => {
        restoreFiltersFromURL();
    });

    window.addEventListener('popstate', () => {
        restoreFiltersFromURL();
    });
}
