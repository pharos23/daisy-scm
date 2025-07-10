export function setupEditRoleModal() {

    // Get references to modal elements
    const editModal = document.getElementById('modal_role_edit');
    const editForm = document.getElementById('edit-role-form');
    const nameInput = document.getElementById('edit-role-name');
    const permissionsSelect = document.getElementById('edit-role-permissions');
    const submitBtn = document.getElementById('edit-submit-btn');

    // Elements to display validation errors for the role name
    const nameError = document.getElementById('edit-name-error-label');
    const nameErrorText = document.getElementById('edit-name-error-text');

    // Attach click event listeners to all buttons that open the edit role modal
    document.querySelectorAll('.open-edit-role').forEach(button => {
        button.addEventListener('click', () => {
            // Get role data from button's data attributes
            const id = button.dataset.id;
            const name = button.dataset.name;
            const permissions = JSON.parse(button.dataset.permissions);

            // Open modal and populate with role data
            openEditModal(id, name, permissions);
        });
    });

    // Function to open the modal and populate form fields
    function openEditModal(roleId, roleName, permissionIds) {

        // Set the role name input value
        nameInput.value = roleName;

        // Select permissions that belong to the role
        Array.from(permissionsSelect.options).forEach(opt => {
            opt.selected = permissionIds.includes(parseInt(opt.value));
        });

        // Update form action URL to the current role's update route
        editForm.action = `/roles/${roleId}`;
        // Show the modal dialog
        editModal.showModal();
        // Validate the form initially
        validateEditForm();
    }

    // Function to validate the edit role form inputs
    function validateEditForm() {
        // Role name must be 3-30 characters, letters, numbers, spaces, underscores or hyphens
        const isValidName = /^[A-Za-zÀ-ÿ0-9 _-]{3,30}$/.test(nameInput.value.trim());

        // Show or hide error message depending on validation result
        nameErrorText.textContent = isValidName ? "" : window.translations?.validation?.invalid_role_name || "Invalid role name";
        nameError.classList.toggle('hidden', isValidName);

        // Add or remove error styling on the input
        nameInput.classList.toggle('input-error', !isValidName);

        // Disable submit button if form is invalid
        // Permissions are optional, so no validation for them here
        submitBtn.disabled = !isValidName;
    }

    // Validate form whenever user types or changes permissions
    nameInput.addEventListener('input', validateEditForm);
    permissionsSelect.addEventListener('change', validateEditForm);
}
