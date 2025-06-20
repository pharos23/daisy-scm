export function setupValidateNewRoleModal() {
    const nameInput = document.getElementById('name');
    const permissionsSelect = document.getElementById('permissions');
    const submitBtn = document.getElementById('submitBtn');

    const nameError = document.getElementById('name-error-label');
    const permissionsError = document.getElementById('permissions-error-label');

    function validateName() {
        const isValid = nameInput.value.trim().length > 0;
        nameError.classList.toggle('hidden', isValid);
        nameInput.classList.toggle('input-error', !isValid);
        return isValid;
    }

    function validatePermissions() {
        const selected = Array.from(permissionsSelect.options).filter(opt => opt.selected);
        const isValid = selected.length > 0;
        permissionsError.classList.toggle('hidden', isValid);
        permissionsSelect.classList.toggle('select-error', !isValid);
        return isValid;
    }

    function validateAll() {
        const allValid = validateName() && validatePermissions();
        submitBtn.disabled = !allValid;
    }

    nameInput.addEventListener('input', validateAll);
    permissionsSelect.addEventListener('change', validateAll);

    validateAll();
}
