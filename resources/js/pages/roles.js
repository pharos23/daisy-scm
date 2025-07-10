// JS file to initialize scripts for the Roles management page

// Import function to validate the 'New Role' modal form
import { setupValidateNewRoleModal } from '../event-handler/validateNewRoleModal.js';
// Import function to handle editing existing roles in a modal
import { setupEditRoleModal } from '../event-handler/editRoleModal.js';

// Wait for the DOM to be fully loaded before attaching event handlers
document.addEventListener('DOMContentLoaded', () => {
    setupValidateNewRoleModal();
    setupEditRoleModal();
});
