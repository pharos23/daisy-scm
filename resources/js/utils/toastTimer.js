// Timers for toast notifications
export function setupToastTimer() {
    const successToast = document.getElementById('toast-success');
    const deletedToast = document.getElementById('toast-deleted');
    const errorToasts = document.getElementsByClassName('error-alert');

    if (successToast) {
        setTimeout(() => {
            successToast.classList.add('opacity-0', 'transition', 'duration-300');
            setTimeout(() => successToast.remove(), 300);
        }, 4000); // 4 seconds
    }

    if (deletedToast) {
        setTimeout(() => {
            deletedToast.classList.add('opacity-0', 'transition', 'duration-300');
            setTimeout(() => deletedToast.remove(), 300);
        }, 4000); // 4 seconds
    }

    if (errorToasts.length > 0) {
        Array.from(errorToasts).forEach(toast => {
            setTimeout(() => {
                toast.classList.add('opacity-0', 'transition', 'duration-300');
                setTimeout(() => toast.remove(), 300);
            }, 4000); // 4 seconds
        });
    }
}
