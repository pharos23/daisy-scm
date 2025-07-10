export function setupValidateNewPermissionModal() {

    // Get references to the permission name input, error label, and submit button
    const nameInput = document.getElementById('permission-name');
    const errorLabel = document.getElementById('permission-error-label');
    const submitBtn = document.getElementById('permission-submit');

    // Function to validate that the permission name is not empty
    function validatePermissionName() {
        // Check if trimmed input length is greater than zero (not empty)
        const isValid = nameInput.value.trim().length > 0;
        // Show or hide error label based on validity
        errorLabel.classList.toggle('hidden', isValid);
        // Add or remove error input styling
        nameInput.classList.toggle('input-error', !isValid);
        // Enable or disable submit button based on validity
        submitBtn.disabled = !isValid;
    }

    // Validate on every input change
    nameInput.addEventListener('input', validatePermissionName);

    // Initial validation on script load to set the correct form state
    validatePermissionName();
}
