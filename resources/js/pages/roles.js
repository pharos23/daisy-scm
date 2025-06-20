import { setupValidateNewRoleModal } from '../event-handler/validateNewRoleModal.js';
import { setupEditRoleModal } from '../event-handler/editRoleModal.js';

document.addEventListener('DOMContentLoaded', () => {
    setupValidateNewRoleModal();
    setupEditRoleModal();
});
