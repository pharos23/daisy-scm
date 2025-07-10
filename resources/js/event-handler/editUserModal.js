export function setupEditUserModal() {    // Get references to modal and form elements

    // Get references to modal and form elements
    const tableBody = document.getElementById('usersTable').querySelector('tbody');
    const editModal = document.getElementById('modal_user_edit');
    const editForm = document.getElementById('edit-user-form');
    const editName = document.getElementById('edit-name');
    const editUsername = document.getElementById('edit-username');
    const editPassword = document.getElementById('edit-password');
    const editPasswordConfirm = document.getElementById('edit-password-confirmation');
    const editRoles = document.getElementById('edit-roles');
    const editSubmitBtn = document.getElementById('edit-submit-btn');
    const editForcePasswordChange = document.getElementById('edit-force-password-change');

    // Shortcut to translation strings
    const t = window.translations;

    // Listen for clicks on the users table body to detect clicks on edit buttons
    tableBody.addEventListener('click', (event) => {
        if (event.target.classList.contains('open-edit-user')) {
            const btn = event.target;
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const username = btn.dataset.username;
            const roles = JSON.parse(btn.dataset.roles);
            const forcePasswordChange = btn.dataset.forcePasswordChange === 'true';

            // Open the modal with the user’s current data
            openEditUserModal(id, name, username, roles, forcePasswordChange);
        }
    });

    // Open the edit modal and populate form fields with current user data
    function openEditUserModal(id, name, username, roles, forcePasswordChange) {
        editForm.action = `/users/${id}`;
        editName.value = name;
        editUsername.value = username;
        editPassword.value = '';            // Clear password field for security
        editPasswordConfirm.value = '';     // Clear confirm password field

        // Select the roles that the user currently has
        Array.from(editRoles.options).forEach(opt => {
            opt.selected = roles.includes(opt.value);
        });

        // Set the force password change checkbox
        editForcePasswordChange.checked = forcePasswordChange;

        // Validate the form initially
        validateEditForm();

        // Show the modal dialog
        editModal.showModal();
    }

    // Validate the edit user form inputs
    function validateEditForm() {
        // Name: 3-50 chars, letters, accents, spaces, apostrophes, hyphens allowed
        const nameValid = /^[A-Za-zÀ-ÿ' -]{3,50}$/.test(editName.value.trim());
        // Username: starts with letter, 3-30 chars, letters, numbers, hyphens allowed
        const usernameValid = /^[A-Za-z][A-Za-z0-9\-]{2,29}$/.test(editUsername.value);
        // Roles: at least one role must be selected
        const rolesValid = Array.from(editRoles.selectedOptions).length > 0;

        // Password: either empty (no change) or must be strong
        const password = editPassword.value;
        const passwordValid = password === '' || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(password);

        // Confirm password must match password
        const confirmValid = password === editPasswordConfirm.value;

        // Show or hide validation error messages with translations
        document.getElementById('edit-name-error').textContent = nameValid ? "" : t['validation.invalid_name'];
        document.getElementById('edit-username-error').textContent = usernameValid ? "" : t['validation.invalid_username'];
        document.getElementById('edit-password-error').textContent = passwordValid ? "" : t['validation.password_strength'];
        document.getElementById('edit-confirm-password-error').textContent = confirmValid ? "" : t['validation.passwords_do_not_match'];
        document.getElementById('edit-roles-error').textContent = rolesValid ? "" : t['validation.select_at_least_one_role'];

        // Toggle visibility of error messages based on validity
        document.getElementById('edit-name-error').classList.toggle('hidden', nameValid);
        document.getElementById('edit-username-error').classList.toggle('hidden', usernameValid);
        document.getElementById('edit-password-error').classList.toggle('hidden', passwordValid);
        document.getElementById('edit-confirm-password-error').classList.toggle('hidden', confirmValid);
        document.getElementById('edit-roles-error').classList.toggle('hidden', rolesValid);

        // Enable submit button only if all validations pass
        editSubmitBtn.disabled = !(nameValid && usernameValid && passwordValid && confirmValid && rolesValid);
    }

    // Attach validation on input/change events for relevant fields
    [editName, editUsername, editPassword, editPasswordConfirm, editRoles].forEach(el =>
        el.addEventListener('input', validateEditForm)
    );
}
