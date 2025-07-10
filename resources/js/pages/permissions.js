// JS file to initialize scripts for the Permissions management page

// Import function to enable dynamic search/filtering of permissions
import { setupSearchPermission } from "../event-handler/searchPermissionFunction.js";
// Import function to validate the 'New Permission' modal form
import { setupValidateNewPermissionModal } from '../event-handler/validateNewPermissionModal.js';

// Wait for the DOM to be fully loaded before initializing event handlers
document.addEventListener('DOMContentLoaded', () => {
    setupSearchPermission()
    setupValidateNewPermissionModal();
});
