import { setupSearchUser } from "../event-handler/searchUserFunction.js";
import { setupValidateNewUserModal } from '../event-handler/validateNewUserModal.js';
import { setupEditUserModal } from '../event-handler/editUserModal.js';

document.addEventListener('DOMContentLoaded', () => {
    setupSearchUser()
    setupValidateNewUserModal();
    setupEditUserModal();
});
