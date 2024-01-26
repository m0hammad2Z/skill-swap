
function toastNotification(title, icon, timer = 3000) {
    const popup = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: timer,
        background: 'var(--lighting-color)',
        color: 'var(--darkest-color)',
        cancelButtonColor: 'var(--main-color)',
        confirmButtonColor: 'var(--red-color)',
    });
    popup.fire({
        icon: icon,
        title: title,
    });

}

// Modal

function confirmModal(title, text, icon, confirmButtonText, cancelButtonText) {
    return Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
        background: 'var(--lighting-color)',
        color: 'var(--darkest-color)',
        cancelButtonColor: 'var(--main-color)',
        confirmButtonColor: 'var(--red-color)',
    });
}

// Loading
function loadingElement(message) {
    return Swal.fire({
        title: message,
        allowOutsideClick: false,
        background: 'var(--dark-color)',
        color: 'var(--light-color)',
        showConfirmButton: false,
        onBeforeOpen: () => {
            Swal.showLoading()
        },
        timer: 1000
    });
}