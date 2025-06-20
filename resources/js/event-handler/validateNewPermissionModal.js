export function setupValidateNewPermissionModal() {
    const nameInput = document.getElementById('permission-name');
    const errorLabel = document.getElementById('permission-error-label');
    const submitBtn = document.getElementById('permission-submit');

    function validatePermissionName() {
        const isValid = nameInput.value.trim().length > 0;
        errorLabel.classList.toggle('hidden', isValid);
        nameInput.classList.toggle('input-error', !isValid);
        submitBtn.disabled = !isValid;
    }

    nameInput.addEventListener('input', validatePermissionName);
    validatePermissionName();
}
