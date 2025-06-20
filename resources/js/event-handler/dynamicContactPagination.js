export function setupDynamicContactPagination() {
    function calculateItemsPerPage() {
        const itemHeight = 100; // estimated height of each contact item in pixels
        const containerPadding = 200; // account for header, footer, margins, etc.

        const availableHeight = window.innerHeight - containerPadding;
        const perPage = Math.floor(availableHeight / itemHeight);

        const url = new URL(window.location.href);
        url.searchParams.set('perPage', perPage);
        window.location.href = url.toString();
    }

    // Only redirect if perPage is not set (to avoid infinite reloads)
    if (!new URLSearchParams(window.location.search).has('perPage')) {
        window.addEventListener('load', calculateItemsPerPage);
    }
}
