import './bootstrap';
import './pages/contacts.js'
import './pages/users.js';
import './pages/roles.js';
import './pages/permissions.js';

import { setupThemeToggle } from './utils/themeToggle.js';
import { setupToastTimer } from './utils/toastTimer.js';
import { setupSidebarHover } from "./utils/sidebarHover.js";

document.addEventListener('DOMContentLoaded', () => {
    setupSidebarHover()
    setupThemeToggle();
    setupToastTimer();
});
