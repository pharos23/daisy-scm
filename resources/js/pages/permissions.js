// JS File to call the scripts needed for this page (in this case: permissions page)
import { setupSearchPermission } from "../event-handler/searchPermissionFunction.js";
import { setupValidateNewPermissionModal } from '../event-handler/validateNewPermissionModal.js';

document.addEventListener('DOMContentLoaded', () => {
    setupSearchPermission()
    setupValidateNewPermissionModal();
});
