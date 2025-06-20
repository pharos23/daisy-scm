export function setupEditRoleModal() {
    document.querySelectorAll('.open-edit-role').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            const name = button.dataset.name;
            const permissions = JSON.parse(button.dataset.permissions);
            openEditModal(id, name, permissions);
        });
    });

    const editModal = document.getElementById('modal_role_edit');
    const editForm = document.getElementById('edit-role-form');
    const nameInput = document.getElementById('edit-role-name');
    const permissionsSelect = document.getElementById('edit-role-permissions');
    const submitBtn = document.getElementById('edit-submit-btn');

    function openEditModal(roleId, roleName, permissionIds) {
        // Fill form values
        nameInput.value = roleName;

        // Reset all options
        Array.from(permissionsSelect.options).forEach(opt => {
            opt.selected = permissionIds.includes(parseInt(opt.value));
        });

        // Set action URL
        editForm.action = `/roles/${roleId}`;

        // Show modal
        editModal.showModal();

        // Validate immediately
        validateEditForm();
    }

    function validateEditForm() {
        const isNameValid = nameInput.value.trim() !== '';
        const selectedPermissions = Array.from(permissionsSelect.selectedOptions);
        const isPermissionsValid = selectedPermissions.length > 0;

        document.getElementById('edit-name-error-label').classList.toggle('hidden', isNameValid);
        nameInput.classList.toggle('input-error', !isNameValid);

        document.getElementById('edit-permissions-error-label').classList.toggle('hidden', isPermissionsValid);
        permissionsSelect.classList.toggle('select-error', !isPermissionsValid);

        submitBtn.disabled = !(isNameValid && isPermissionsValid);
    }

    nameInput.addEventListener('input', validateEditForm);
    permissionsSelect.addEventListener('change', validateEditForm);
}
