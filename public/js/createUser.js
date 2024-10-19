$(document).ready(function () {
    $('#usuario').DataTable({
        // Configuración del DataTable
    });

    // Recargar la tabla después de guardar un nuevo usuario
    $('form').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function (response) {
                Swal.fire('Éxito', 'Usuario creado con éxito', 'success');
                $('#usersTable').DataTable().ajax.reload();
                window.location.href = '/users';
            },
            error: function (xhr) {
                Swal.fire('Error', 'Hubo un problema al crear el usuario', 'error');
            }
        });
    });
});

$(document).ready(function () {
    $('.form-select2').select2({
        theme: 'bootstrap4'
    });
});
