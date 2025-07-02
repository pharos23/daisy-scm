export function updateWaitWheel() {
    const form = document.getElementById("deployForm");
    const button = document.getElementById("deployBtn");
    const text = document.getElementById("deployText");
    const spinner = document.getElementById("deploySpinner");

    if (form) {
        form.addEventListener("submit", function (e) {
            const confirmMessage = form.dataset.confirmMessage || "Are you sure?";

            if (!confirm(confirmMessage)) {
                e.preventDefault();
                return;
            }

            button.disabled = true;
            text.style.display = "none";
            spinner.classList.remove("hidden");
        });
    }
}
