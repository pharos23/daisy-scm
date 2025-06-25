// JS File to call the scripts needed for this page (in this case: roles page)
import { setupValidateNewRoleModal } from '../event-handler/validateNewRoleModal.js';
import { setupEditRoleModal } from '../event-handler/editRoleModal.js';

document.addEventListener('DOMContentLoaded', () => {
    setupValidateNewRoleModal();
    setupEditRoleModal();
});
