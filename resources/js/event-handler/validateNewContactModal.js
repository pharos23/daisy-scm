export function setupValidateNewContactModal() {

    // Get references to the form and submit button
    const form = document.getElementById('contact-form');
    const submitBtn = document.getElementById('submitBtn');

    // Get references to input/select fields
    const fields = {
        local: document.getElementById('local'),
        grupo: document.getElementById('grupo'),
        nome: document.getElementById('nome'),
        telemovel: document.getElementById('telemovel')
    };

    // Get references to error display elements associated with each field
    const errors = {
        local: document.getElementById('local-error'),
        grupo: document.getElementById('grupo-error'),
        nome: document.getElementById('nome-error'),
        telemovel: document.getElementById('telemovel-error')
    };

    // Helper to set localized error message text inside the error element's <span>
    function setErrorText(errorElement, key) {
        const span = errorElement.querySelector('span');
        if (span && window.translations?.[key]) {
            span.textContent = window.translations[key];
        }
    }

    // Validates a single field using a provided validator function.
    // Toggles input error styles and visibility of the error message.
    // Optionally sets localized error text if invalid.
    function validateField(field, errorElement, validatorFn, translationKey) {
        const isValid = validatorFn(field);
        field.classList.toggle('input-error', !isValid);
        errorElement.classList.toggle('hidden', isValid);
        if (!isValid && translationKey) setErrorText(errorElement, translationKey);
        return isValid;
    }

    // Main validation function for the entire form
    function validateForm() {

        // Validate text inputs:
        // - nome: must not be empty after trimming whitespace
        // - telemovel: must be exactly 9 digits
        const isNomeValid = validateField(fields.nome, errors.nome, f => f.value.trim().length > 0);
        const isTelemovelValid = validateField(fields.telemovel, errors.telemovel, f => /^\d{9}$/.test(f.value));

        // Only validate selects if text inputs are valid (soft validation approach)
        const shouldValidateSelects = isNomeValid && isTelemovelValid;

        // Validate selects to ensure a valid option is selected (not the placeholder)
        const isLocalValid = fields.local.value !== '' && fields.local.selectedIndex !== 0;
        const isGrupoValid = fields.grupo.value !== '' && fields.grupo.selectedIndex !== 0;

        // Show or hide error messages and input error styles for selects based on validation and soft reminder logic
        errors.local.classList.toggle('hidden', isLocalValid || !shouldValidateSelects);
        fields.local.classList.toggle('input-error', !isLocalValid && shouldValidateSelects);

        errors.grupo.classList.toggle('hidden', isGrupoValid || !shouldValidateSelects);
        fields.grupo.classList.toggle('input-error', !isGrupoValid && shouldValidateSelects);

        // Enable submit button only if all fields pass validation
        submitBtn.disabled = !(isNomeValid && isTelemovelValid && isLocalValid && isGrupoValid);
    }

    // Attach input and change event listeners to all fields to validate on user interaction
    Object.values(fields).forEach(field => {
        field.addEventListener('input', validateForm);
        field.addEventListener('change', validateForm);
    });

    // Initial validation to set the form state correctly on load
    validateForm();
}
