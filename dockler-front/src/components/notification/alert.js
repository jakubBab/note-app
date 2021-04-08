import Swal from 'sweetalert2'


export function alert (type, text) {
    switch (type) {
        case 'success':
        case 'error':
            Swal.fire({
                position: 'top-end',
                icon: type,
                title: text,
                showConfirmButton: false,
                timer: 1500
            })
            break;
        default:
            console.log(`Type does not exists ${type}.`);
    }

}