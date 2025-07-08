// JS File to call the scripts needed for this page (in this case: contacts page)
import { setupSearchContact } from "../event-handler/searchContactFunction.js";
import { setupValidateNewContactModal } from '../event-handler/validateNewContactModal.js';
import { setupExportContacts} from "../event-handler/exportContacts.js";

document.addEventListener('DOMContentLoaded', () => {
    setupSearchContact();
    setupValidateNewContactModal();
    setupExportContacts();
});
