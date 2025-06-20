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

    function validateField(field, errorElement, validatorFn) {
        const isValid = validatorFn(field);
        field.classList.toggle('input-error', !isValid);
        errorElement.classList.toggle('hidden', isValid);
        return isValid;
    }

    function validateForm() {
        const isLocalValid = validateField(fields.local, errors.local, f => f.value !== 'Escolha o Local');
        const isGrupoValid = validateField(fields.grupo, errors.grupo, f => f.value !== 'Escolha o grupo');
        const isNomeValid = validateField(fields.nome, errors.nome, f => f.value.trim().length > 0);
        const isTelemovelValid = validateField(fields.telemovel, errors.telemovel, f => /^\d{9}$/.test(f.value));
        submitBtn.disabled = !(isLocalValid && isGrupoValid && isNomeValid && isTelemovelValid);
    }

    Object.values(fields).forEach(field => {
        field.addEventListener('input', validateForm);
        field.addEventListener('change', validateForm);
    });

    validateForm(); // initial state
}
