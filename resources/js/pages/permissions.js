import { setupSearchPermission } from "../event-handler/searchPermissionFunction.js";
import { setupValidateNewPermissionModal } from '../event-handler/validateNewPermissionModal.js';

document.addEventListener('DOMContentLoaded', () => {
    setupSearchPermission()
    setupValidateNewPermissionModal();
});
