export function setupValidateNewContactModal() {
    const form = document.getElementById('contact-form');
    const submitBtn = document.getElementById('submitBtn');

    const fields = {
        local: document.getElementById('local'),
        grupo: document.getElementById('grupo'),
        nome: document.getElementById('nome'),
        telemovel: document.getElementById('telemovel')
    };

    const errors = {
        local: document.getElementById('local-error'),
        grupo: document.getElementById('grupo-error'),
        nome: document.getElementById('nome-error'),
        telemovel: document.getElementById('telemovel-error')
    };

    function setErrorText(errorElement, key) {
        const span = errorElement.querySelector('span');
        if (span && window.translations?.[key]) {
            span.textContent = window.translations[key];
        }
    }

    function validateField(field, errorElement, validatorFn, translationKey) {
        const isValid = validatorFn(field);
        field.classList.toggle('input-error', !isValid);
        errorElement.classList.toggle('hidden', isValid);
        if (!isValid && translationKey) setErrorText(errorElement, translationKey);
        return isValid;
    }

    function validateForm() {
        // Validate text inputs normally
        const isNomeValid = validateField(fields.nome, errors.nome, f => f.value.trim().length > 0);
        const isTelemovelValid = validateField(fields.telemovel, errors.telemovel, f => /^\d{9}$/.test(f.value));

        // Only validate selects if text inputs are valid (soft reminder logic)
        const shouldValidateSelects = isNomeValid && isTelemovelValid;

        // Check if selects have a valid selection (not placeholder)
        const isLocalValid = fields.local.value !== '' && fields.local.selectedIndex !== 0;
        const isGrupoValid = fields.grupo.value !== '' && fields.grupo.selectedIndex !== 0;

        // Show errors on selects only if other fields are valid
        errors.local.classList.toggle('hidden', isLocalValid || !shouldValidateSelects);
        fields.local.classList.toggle('input-error', !isLocalValid && shouldValidateSelects);

        errors.grupo.classList.toggle('hidden', isGrupoValid || !shouldValidateSelects);
        fields.grupo.classList.toggle('input-error', !isGrupoValid && shouldValidateSelects);

        // Enable submit only if all fields are valid
        submitBtn.disabled = !(isNomeValid && isTelemovelValid && isLocalValid && isGrupoValid);
    }

    Object.values(fields).forEach(field => {
        field.addEventListener('input', validateForm);
        field.addEventListener('change', validateForm);
    });

    validateForm(); // initial state
}
