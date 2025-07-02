// JS File to call the scripts needed for this page (in this case: users page)
import { setupSearchUser } from "../event-handler/searchUserFunction.js";
import { setupValidateNewUserModal } from '../event-handler/validateNewUserModal.js';
import { setupEditUserModal } from '../event-handler/editUserModal.js';

document.addEventListener('DOMContentLoaded', () => {
    setupSearchUser();
    setupValidateNewUserModal();
    setupEditUserModal();
});
