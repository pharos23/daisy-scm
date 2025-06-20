export function setupDynamicPermissionPagination() {
    const searchInput = document.getElementById('searchInput');
    const perPageSelect = document.getElementById('perPageSelect');
    const wrapper = document.getElementById('permissionsTableWrapper');

    function fetchPermissions(page = 1) {
        const search = searchInput.value;
        const perPage = perPageSelect.value;

        fetch(`{{ route('permissions.index') }}?search=${search}&perPage=${perPage}&page=${page}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(res => res.json())
            .then(data => {
                wrapper.innerHTML = data.html;

                // Re-bind pagination links
                wrapper.querySelectorAll('.pagination a').forEach(link => {
                    link.addEventListener('click', e => {
                        e.preventDefault();
                        const url = new URL(link.href);
                        fetchPermissions(url.searchParams.get('page'));
                    });
                });
            });
    }

    // Bind inputs
    searchInput.addEventListener('input', () => fetchPermissions());
    perPageSelect.addEventListener('change', () => fetchPermissions());

    // Initial bind of pagination
    document.querySelectorAll('.pagination a').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const url = new URL(link.href);
            fetchPermissions(url.searchParams.get('page'));
        });
    });
}
