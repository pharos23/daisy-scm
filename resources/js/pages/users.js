// JS file to initialize scripts for the Users management page

// Import function to handle dynamic user table search, role filter, and deleted filter
import { setupSearchUser } from "../event-handler/searchUserFunction.js";
// Import function to validate the 'New User' modal form
import { setupValidateNewUserModal } from '../event-handler/validateNewUserModal.js';
// Import function to handle editing users in a modal
import { setupEditUserModal } from '../event-handler/editUserModal.js';

// Wait for the DOM to be fully loaded before initializing all event handlers
document.addEventListener('DOMContentLoaded', () => {
    setupSearchUser();
    setupValidateNewUserModal();
    setupEditUserModal();
});
