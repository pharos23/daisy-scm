// JS File to call the scripts needed for this page (in this case: contacts page)

// Import the search functionality for contacts
import { setupSearchContact } from "../event-handler/searchContactFunction.js";
// Import the validation logic for the "New Contact" modal form
import { setupValidateNewContactModal } from '../event-handler/validateNewContactModal.js';
// Import functionality to handle exporting contacts
import { setupExportContacts} from "../event-handler/exportContacts.js";

// When the DOM is fully loaded, initialize all needed features
document.addEventListener('DOMContentLoaded', () => {
    setupSearchContact();
    setupValidateNewContactModal();
    setupExportContacts();
});
