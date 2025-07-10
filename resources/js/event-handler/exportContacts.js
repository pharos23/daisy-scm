export function setupExportContacts() {

    // Get references to the import trigger button, hidden file input, and the import form
    const triggerBtn = document.getElementById('trigger-import');
    const fileInput = document.getElementById('import-file');
    const importForm = document.getElementById('import-form');

    // When the trigger button is clicked, open the file picker by clicking the hidden file input
    triggerBtn.addEventListener('click', () => {
        fileInput.click();
    });

    // When a file is selected via the file input, automatically submit the import form
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            importForm.submit();
        }
    });
}
