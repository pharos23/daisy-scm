import './bootstrap';

// JS file to call all the js scripts we want to call

import { setupThemeToggle } from './utils/themeToggle.js';
import { setupToastTimer } from './utils/toastTimer.js';
import { setupSidebarHover } from "./utils/sidebarHover.js";

document.addEventListener('DOMContentLoaded', () => {
    setupSidebarHover()
    setupThemeToggle();
    setupToastTimer();
});
