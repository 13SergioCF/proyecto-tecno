console.log("hola mundo")
$(document).ready(function () {
    $('#data-table').DataTable({
        "paging": true,          // Habilitar paginación
        "searching": true,       // Habilitar búsqueda
        "info": true,            // Mostrar información del estado
        "ordering": true,        // Habilitar ordenamiento de columnas
        "lengthChange": true,    // Permitir cambiar el número de registros mostrados
        "language": {            // Personalizar los textos
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros en total)",
            "search": "Buscar:",
        }
    });
});


