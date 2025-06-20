import { setupSearchContact } from "../event-handler/searchContactFunction.js";
import { setupValidateNewContactModal } from '../event-handler/validateNewContactModal.js';
import { setupDynamicContactPagination } from '../event-handler/dynamicContactPagination.js';

document.addEventListener('DOMContentLoaded', () => {
    setupSearchContact()
    setupValidateNewContactModal();
    setupDynamicContactPagination();
});
