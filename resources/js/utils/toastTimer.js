// Timers for toast notifications
export function setupToastTimer() {
    // Get the success toast element (usually green)
    const successToast = document.getElementById('toast-success');
    // Get the deleted toast element (usually yellow/orange)
    const deletedToast = document.getElementById('toast-deleted');
    // Get all error toast elements (typically red), which may be multiple
    const errorToasts = document.getElementsByClassName('error-alert');

    // If a success toast is present, auto-hide it after 4 seconds
    if (successToast) {
        setTimeout(() => {
            // Fade out the toast
            successToast.classList.add('opacity-0', 'transition', 'duration-300');
            // Remove it completely from the DOM after fade-out completes
            setTimeout(() => successToast.remove(), 300);
        }, 4000); // 4 seconds
    }

    // Same logic for the deleted toast
    if (deletedToast) {
        setTimeout(() => {
            deletedToast.classList.add('opacity-0', 'transition', 'duration-300');
            setTimeout(() => deletedToast.remove(), 300);
        }, 4000); // 4 seconds
    }

    // Loop through all error toasts and apply the same fade-out + removal logic
    if (errorToasts.length > 0) {
        Array.from(errorToasts).forEach(toast => {
            setTimeout(() => {
                toast.classList.add('opacity-0', 'transition', 'duration-300');
                setTimeout(() => toast.remove(), 300);
            }, 4000); // 4 seconds
        });
    }
}
