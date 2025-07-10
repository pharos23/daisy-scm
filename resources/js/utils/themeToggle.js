// Function to handle toggling between light and dark themes
export function setupThemeToggle() {
    // Get the checkbox/switch element used to toggle the theme
    const themeSwitcher = document.getElementById('theme-switcher');

    // Function to switch theme based on the switch state
    function toggleTheme() {
        // If switch is checked, use dark theme ("dim"), otherwise use light ("emerald")
        const theme = themeSwitcher.checked ? 'dim' : 'emerald';
        // Apply the selected theme to the HTML root element
        document.documentElement.setAttribute('data-theme', theme);
        // Persist the theme selection in localStorage so it's remembered on page reload
        localStorage.setItem('theme', theme);
    }

    // When the page finishes loading...
    window.addEventListener('DOMContentLoaded', () => {
        // Try to load the previously saved theme from localStorage
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            // Apply the saved theme to the HTML element
            document.documentElement.setAttribute('data-theme', savedTheme);
            // Set the switch to reflect the current theme
            themeSwitcher.checked = (savedTheme === 'dim');
        }
    });

    // Listen for changes in the toggle switch and apply the corresponding theme
    themeSwitcher.addEventListener('change', toggleTheme);
}
