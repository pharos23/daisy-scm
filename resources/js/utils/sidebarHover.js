// If the browser window is small (typically on mobile/tablet),
// this function shows the sidebar when hovering and hides it when the mouse leaves.

export function setupSidebarHover() {
    // Sidebar element (the actual menu)
    const sidebar = document.getElementById('sidebar');
    // Invisible area on the left edge of the screen to detect hover
    const hoverZone = document.getElementById('hover-zone');

    // Show the sidebar if window width is below 1024px (Tailwind's 'lg' breakpoint)
    function showSidebar() {
        if (window.innerWidth < 1024) {
            sidebar.classList.remove('-translate-x-full');
        }
    }

    // Hide the sidebar when the mouse leaves it (on small screens only)
    function hideSidebar() {
        if (window.innerWidth < 1024) {
            sidebar.classList.add('-translate-x-full');
        }
    }

    // When mouse enters the hover zone (left edge), show sidebar
    hoverZone?.addEventListener('mouseenter', showSidebar);

    // When mouse leaves the sidebar itself, hide it again
    sidebar?.addEventListener('mouseleave', hideSidebar);
}
