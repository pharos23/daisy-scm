import { setupSearchPermission } from "../event-handler/searchPermissionFunction.js";
import { setupValidateNewPermissionModal } from '../event-handler/validateNewPermissionModal.js';
import { setupDynamicPermissionPagination } from '../event-handler/dynamicPermissionPagination.js';

document.addEventListener('DOMContentLoaded', () => {
    setupSearchPermission()
    setupValidateNewPermissionModal();
    setupDynamicPermissionPagination();
});
