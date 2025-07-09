// Change the page theme
export function setupThemeToggle() {
    const themeSwitcher = document.getElementById('theme-switcher');

    function toggleTheme() {
        const theme = themeSwitcher.checked ? 'dim' : 'emerald';
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
    }

    window.addEventListener('DOMContentLoaded', () => {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
            themeSwitcher.checked = (savedTheme === 'dim');
        }
    });

    themeSwitcher.addEventListener('change', toggleTheme);
}
