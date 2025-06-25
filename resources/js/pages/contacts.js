import { setupSearchContact } from "../event-handler/searchContactFunction.js";
import { setupValidateNewContactModal } from '../event-handler/validateNewContactModal.js';

document.addEventListener('DOMContentLoaded', () => {
    setupSearchContact()
    setupValidateNewContactModal();
});
