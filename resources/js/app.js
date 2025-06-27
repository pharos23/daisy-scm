import './bootstrap';
import Alpine from 'alpinejs';

import { setupThemeToggle } from './utils/themeToggle.js';
import { setupToastTimer } from './utils/toastTimer.js';
import { setupSidebarHover } from "./utils/sidebarHover.js";

// JS file to call all the js scripts we want to call

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    setupSidebarHover()
    setupThemeToggle();
    setupToastTimer();
});
