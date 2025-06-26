export function setupEditUserModal() {
    const tableBody = document.getElementById('usersTable').querySelector('tbody'); // Parent element for user rows
    const editModal = document.getElementById('modal_user_edit');
    const editForm = document.getElementById('edit-user-form');
    const editName = document.getElementById('edit-name');
    const editUsername = document.getElementById('edit-username');
    const editPassword = document.getElementById('edit-password');
    const editPasswordConfirm = document.getElementById('edit-password-confirmation');
    const editRoles = document.getElementById('edit-roles');
    const editSubmitBtn = document.getElementById('edit-submit-btn');

    // Event delegation for dynamically loaded "Edit" buttons
    tableBody.addEventListener('click', (event) => {
        if (event.target.classList.contains('open-edit-user')) {
            const btn = event.target;
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const username = btn.dataset.username;
            const roles = JSON.parse(btn.dataset.roles);

            openEditUserModal(id, name, username, roles);
        }
    });

    function openEditUserModal(id, name, username, roles) {
        editForm.action = `/users/${id}`;
        editName.value = name;
        editUsername.value = username;
        editPassword.value = '';
        editPasswordConfirm.value = '';

        Array.from(editRoles.options).forEach(opt => {
            opt.selected = roles.includes(opt.value);
        });

        validateEditForm();
        editModal.showModal();
    }

    function validateEditForm() {
        const nameValid = editName.value.trim().length >= 3;
        const usernameValid = /^[A-Za-z][A-Za-z0-9\-]{2,29}$/.test(editUsername.value);
        const rolesValid = Array.from(editRoles.selectedOptions).length > 0;

        const password = editPassword.value;
        const passwordValid = password === '' || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(password);
        const confirmValid = password === editPasswordConfirm.value;

        document.getElementById('edit-name-error').classList.toggle('hidden', nameValid);
        document.getElementById('edit-username-error').classList.toggle('hidden', usernameValid);
        document.getElementById('edit-password-error').classList.toggle('hidden', passwordValid);
        document.getElementById('edit-confirm-password-error').classList.toggle('hidden', confirmValid);
        document.getElementById('edit-roles-error').classList.toggle('hidden', rolesValid);

        editSubmitBtn.disabled = !(nameValid && usernameValid && passwordValid && confirmValid && rolesValid);
    }

    [editName, editUsername, editPassword, editPasswordConfirm, editRoles].forEach(el =>
        el.addEventListener('input', validateEditForm)
    );
}
