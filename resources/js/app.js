// Import Laravel Vite bootstrap configuration (e.g., CSRF setup, Echo, etc.)
import './bootstrap';
// Import Alpine.js (used for declarative UI behavior)
import Alpine from 'alpinejs';

// Import individual utility functions
import { setupThemeToggle } from './utils/themeToggle.js';
import { setupToastTimer } from './utils/toastTimer.js';
import { setupSidebarHover } from "./utils/sidebarHover.js";

// JS file to call all the JS scripts we want to run globally

// Make Alpine available globally
window.Alpine = Alpine;
// Start Alpine to initialize its components
Alpine.start();

// Run scripts after the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    // Enable sidebar hover interactivity (e.g., expand on hover)
    setupSidebarHover();
    // Setup the theme toggle (light/dark mode switching)
    setupThemeToggle();
    // Setup auto-dismissal for toast notifications (success, error, etc.)
    setupToastTimer();
});
