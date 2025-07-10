export function setupValidateNewRoleModal() {

    // Get references to form elements: role name input, permissions select, submit button
    const nameInput = document.getElementById('name');
    const permissionsSelect = document.getElementById('permissions');
    const submitBtn = document.getElementById('submitBtn');

    // Get references to error display elements for name and permissions
    const nameError = document.getElementById('name-error-label');
    const permissionsError = document.getElementById('permissions-error-label');
    const nameErrorText = document.getElementById('name-error-text');

    // Validate the role name input against regex pattern (letters, numbers, spaces, _ and -)
    function validateName() {
        const isValid = /^[A-Za-zÀ-ÿ0-9 _-]{3,30}$/.test(nameInput.value.trim());
        // Show or clear error message text depending on validity
        nameErrorText.textContent = isValid ? "" : window.translations['validation.invalid_role_name'];
        // Toggle visibility of the error label
        nameError.classList.toggle('hidden', isValid);
        // Toggle error styling on the input
        nameInput.classList.toggle('input-error', !isValid);
        return isValid;
    }

    // Validate that at least one permission is selected in the multi-select
    function validatePermissions() {
        const selected = Array.from(permissionsSelect.options).filter(opt => opt.selected);
        const isValid = selected.length > 0;
        // Toggle visibility of permissions error label
        permissionsError.classList.toggle('hidden', isValid);
        // Toggle error styling on the select box
        permissionsSelect.classList.toggle('select-error', !isValid);
        return isValid;
    }

    // Validate both name and permissions; enable submit only if both are valid
    function validateAll() {
        const allValid = validateName() && validatePermissions();
        submitBtn.disabled = !allValid;
    }

    // Attach input/change event listeners to trigger validation on user interaction
    nameInput.addEventListener('input', validateAll);
    permissionsSelect.addEventListener('change', validateAll);

    // Initial validation call to set proper state on load
    validateAll();
}
