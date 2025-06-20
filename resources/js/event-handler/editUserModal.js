export function setupEditUserModal() {
    document.querySelectorAll('.open-edit-user').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const email = btn.dataset.email;
            const roles = JSON.parse(btn.dataset.roles);

            openEditUserModal(id, name, email, roles);
        });
    });

    const editModal = document.getElementById('modal_user_edit');
    const editForm = document.getElementById('edit-user-form');

    const editName = document.getElementById('edit-name');
    const editEmail = document.getElementById('edit-email');
    const editPassword = document.getElementById('edit-password');
    const editPasswordConfirm = document.getElementById('edit-password-confirmation');
    const editRoles = document.getElementById('edit-roles');
    const editSubmitBtn = document.getElementById('edit-submit-btn');

    function openEditUserModal(id, name, email, roles) {
        editForm.action = `/users/${id}`;
        editName.value = name;
        editEmail.value = email;
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
        const emailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(editEmail.value);
        const rolesValid = Array.from(editRoles.selectedOptions).length > 0;

        const password = editPassword.value;
        const passwordValid = password === '' || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(password);
        const confirmValid = password === editPasswordConfirm.value;

        document.getElementById('edit-name-error').classList.toggle('hidden', nameValid);
        document.getElementById('edit-email-error').classList.toggle('hidden', emailValid);
        document.getElementById('edit-password-error').classList.toggle('hidden', passwordValid);
        document.getElementById('edit-confirm-password-error').classList.toggle('hidden', confirmValid);
        document.getElementById('edit-roles-error').classList.toggle('hidden', rolesValid);

        editSubmitBtn.disabled = !(nameValid && emailValid && passwordValid && confirmValid && rolesValid);
    }

    [editName, editEmail, editPassword, editPasswordConfirm, editRoles].forEach(el =>
        el.addEventListener('input', validateEditForm)
    );
}
