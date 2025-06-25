import './bootstrap';

import { setupThemeToggle } from './utils/themeToggle.js';
import { setupToastTimer } from './utils/toastTimer.js';
import { setupSidebarHover } from "./utils/sidebarHover.js";

document.addEventListener('DOMContentLoaded', () => {
    setupSidebarHover()
    setupThemeToggle();
    setupToastTimer();
});
