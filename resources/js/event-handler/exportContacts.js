export function setupExportContacts() {
    const triggerBtn = document.getElementById('trigger-import');
    const fileInput = document.getElementById('import-file');
    const importForm = document.getElementById('import-form');

    triggerBtn.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            importForm.submit();
        }
    });
}
