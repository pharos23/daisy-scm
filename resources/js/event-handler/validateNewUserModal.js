export function setupValidateNewUserModal() {
    const nameInput = document.getElementById('name');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const rolesSelect = document.getElementById('roles');
    const submitBtn = document.getElementById('submitBtn');

    const nameError = document.getElementById('name-error');
    const usernameError = document.getElementById('username-error');
    const passwordError = document.getElementById('password-error');
    const confirmPasswordError = document.getElementById('confirm-password-error');
    const rolesError = document.getElementById('roles-error');

    function validateName() {
        const isValid = nameInput.value.trim().length >= 3 && /^[A-Za-z][A-Za-z0-9\-]*$/.test(nameInput.value);
        nameError.classList.toggle('hidden', isValid);
        nameInput.classList.toggle('input-error', !isValid);
        return isValid;
    }

    function validateUsername() {
        const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(usernameInput.value);
        usernameError.classList.toggle('hidden', isValid);
        usernameInput.classList.toggle('input-error', !isValid);
        return isValid;
    }

    function validatePassword() {
        const pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
        const isValid = pattern.test(passwordInput.value);
        passwordError.classList.toggle('hidden', isValid);
        passwordInput.classList.toggle('input-error', !isValid);
        return isValid;
    }

    function validatePasswordConfirmation() {
        const isValid = passwordConfirmInput.value === passwordInput.value && passwordConfirmInput.value.length > 0;
        confirmPasswordError.classList.toggle('hidden', isValid);
        passwordConfirmInput.classList.toggle('input-error', !isValid);
        return isValid;
    }

    function validateRoles() {
        const selected = Array.from(rolesSelect.options).filter(opt => opt.selected);
        const isValid = selected.length > 0;
        rolesError.classList.toggle('hidden', isValid);
        rolesSelect.classList.toggle('select-error', !isValid);
        return isValid;
    }

    function validateAll() {
        const allValid = [
            validateName(),
            validateUsername(),
            validatePassword(),
            validatePasswordConfirmation(),
            validateRoles()
        ].every(Boolean);

        submitBtn.disabled = !allValid;
    }

    nameInput.addEventListener('input', validateAll);
    usernameInput.addEventListener('input', validateAll);
    passwordInput.addEventListener('input', validateAll);
    passwordConfirmInput.addEventListener('input', validateAll);
    rolesSelect.addEventListener('change', validateAll);

    validateAll();
}
