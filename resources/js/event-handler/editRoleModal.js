export function setupEditRoleModal() {
    const editModal = document.getElementById('modal_role_edit');
    const editForm = document.getElementById('edit-role-form');
    const nameInput = document.getElementById('edit-role-name');
    const permissionsSelect = document.getElementById('edit-role-permissions');
    const submitBtn = document.getElementById('edit-submit-btn');

    const nameError = document.getElementById('edit-name-error-label');
    const nameErrorText = document.getElementById('edit-name-error-text');
    const permissionsError = document.getElementById('edit-permissions-error-label');

    document.querySelectorAll('.open-edit-role').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            const name = button.dataset.name;
            const permissions = JSON.parse(button.dataset.permissions);
            openEditModal(id, name, permissions);
        });
    });

    function openEditModal(roleId, roleName, permissionIds) {
        nameInput.value = roleName;

        Array.from(permissionsSelect.options).forEach(opt => {
            opt.selected = permissionIds.includes(parseInt(opt.value));
        });

        editForm.action = `/roles/${roleId}`;
        editModal.showModal();
        validateEditForm();
    }

    function validateEditForm() {
        const isValidName = /^[A-Za-zÀ-ÿ0-9 _-]{3,30}$/.test(nameInput.value.trim());
        const selectedPermissions = Array.from(permissionsSelect.selectedOptions);
        const isPermissionsValid = selectedPermissions.length > 0;

        nameErrorText.textContent = isValidName ? "" : window.translations['validation.invalid_role_name'];
        nameError.classList.toggle('hidden', isValidName);
        nameInput.classList.toggle('input-error', !isValidName);

        permissionsError.classList.toggle('hidden', isPermissionsValid);
        permissionsSelect.classList.toggle('select-error', !isPermissionsValid);

        submitBtn.disabled = !(isValidName && isPermissionsValid);
    }

    nameInput.addEventListener('input', validateEditForm);
    permissionsSelect.addEventListener('change', validateEditForm);
}
