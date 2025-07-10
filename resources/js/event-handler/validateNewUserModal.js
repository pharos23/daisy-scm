export function setupValidateNewUserModal() {

    // Input elements
    const nameInput = document.getElementById('name');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const rolesSelect = document.getElementById('roles');
    const submitBtn = document.getElementById('submitBtn');

    // Error display elements
    const nameError = document.getElementById('name-error');
    const usernameError = document.getElementById('username-error');
    const passwordError = document.getElementById('password-error');
    const confirmPasswordError = document.getElementById('confirm-password-error');
    const rolesError = document.getElementById('roles-error');

    // Translation object for error messages
    const t = window.translations;

    // Validate name: allows letters (including accented), apostrophes, spaces, hyphens; length 3-50
    function validateName() {
        const isValid = /^[A-Za-zÀ-ÿ' -]{3,50}$/.test(nameInput.value.trim());
        nameError.textContent = isValid ? "" : t['validation.invalid_name'];
        nameError.classList.toggle('hidden', isValid);
        nameInput.classList.toggle('input-error', !isValid);
        return isValid;
    }

    // Validate username: at least 3 chars, starts with a letter, only letters, numbers, and hyphens allowed
    function validateUsername() {
        const isValid = usernameInput.value.trim().length >= 3 && /^[A-Za-z][A-Za-z0-9\-]*$/.test(usernameInput.value);
        usernameError.textContent = isValid ? "" : t['validation.invalid_username'];
        usernameError.classList.toggle('hidden', isValid);
        usernameInput.classList.toggle('input-error', !isValid);
        return isValid;
    }

    // Validate password strength: at least 8 chars, with at least one digit, one lowercase, and one uppercase letter
    function validatePassword() {
        const pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
        const isValid = pattern.test(passwordInput.value);
        passwordError.textContent = isValid ? "" : t['validation.password_strength'];
        passwordError.classList.toggle('hidden', isValid);
        passwordInput.classList.toggle('input-error', !isValid);
        return isValid;
    }

    // Validate password confirmation matches password and is not empty
    function validatePasswordConfirmation() {
        const isValid = passwordConfirmInput.value === passwordInput.value && passwordConfirmInput.value.length > 0;
        confirmPasswordError.textContent = isValid ? "" : t['validation.passwords_do_not_match'];
        confirmPasswordError.classList.toggle('hidden', isValid);
        passwordConfirmInput.classList.toggle('input-error', !isValid);
        return isValid;
    }

    // Validate that at least one role is selected
    function validateRoles() {
        const selected = Array.from(rolesSelect.options).filter(opt => opt.selected);
        const isValid = selected.length > 0;
        rolesError.textContent = isValid ? "" : t['validation.select_at_least_one_role'];
        rolesError.classList.toggle('hidden', isValid);
        rolesSelect.classList.toggle('select-error', !isValid);
        return isValid;
    }

    // Run all validations and enable submit button only if all valid
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

    // Bind input/change events to validation on all fields
    nameInput.addEventListener('input', validateAll);
    usernameInput.addEventListener('input', validateAll);
    passwordInput.addEventListener('input', validateAll);
    passwordConfirmInput.addEventListener('input', validateAll);
    rolesSelect.addEventListener('change', validateAll);

    // Initial validation on load
    validateAll();
}
