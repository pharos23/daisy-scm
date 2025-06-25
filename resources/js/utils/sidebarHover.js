export function setupSidebarHover() {
    const sidebar = document.getElementById('sidebar');
    const hoverZone = document.getElementById('hover-zone');

    function showSidebar() {
        if (window.innerWidth < 1024) {
            sidebar.classList.remove('-translate-x-full');
        }
    }

    function hideSidebar() {
        if (window.innerWidth < 1024) {
            sidebar.classList.add('-translate-x-full');
        }
    }

    hoverZone?.addEventListener('mouseenter', showSidebar);
    sidebar?.addEventListener('mouseleave', hideSidebar);
}
