export function setupSearchContact() {
    const searchInput = document.getElementById('searchInput');
    const filterLocal = document.getElementById('filterLocal');
    const filterGroup = document.getElementById('filterGroup');
    const table = document.getElementById('contactsTable');

    // Function to trigger search and filter
    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const localFilter = filterLocal.value;
        const groupFilter = filterGroup.value;

        // Create a query string with search term and filters
        let queryString = `?search=${searchTerm}&local=${localFilter}&group=${groupFilter}`;

        // Make the AJAX request
        fetch(`/contacts${queryString}`)
            .then(response => response.text())
            .then(data => {
                // Replace the table content with the new filtered data
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, 'text/html');
                const newTableBody = doc.querySelector('#contactsTable tbody');
                table.querySelector('tbody').innerHTML = newTableBody.innerHTML;

                // Update pagination links (if needed)
                const pagination = doc.querySelector('.pagination');
                document.querySelector('.pagination').innerHTML = pagination.innerHTML;
            })
            .catch(error => console.error('Error fetching filtered contacts:', error));
    }

    // Event listeners to trigger the filter function
    searchInput.addEventListener('input', applyFilters);
    filterLocal.addEventListener('change', applyFilters);
    filterGroup.addEventListener('change', applyFilters);
}
