$(document).ready(function() {
    var table = $('#data-table').DataTable();

    // Filtrar la tabla por estado
    $('#filter').change(function() {
        var status = $(this).val();

        table.rows().every(function() {
            var row = this.node();
            // Mostrar todas las filas si se selecciona "Todos"
            if (status === 'all') {
                $(row).show();
            } else {
                // Mostrar solo filas con la clase correspondiente
                if ($(row).hasClass('status-' + status)) {
                    $(row).show();
                } else {
                    $(row).hide();
                }
            }
        });
        table.draw(); // Redibujar la tabla para aplicar los cambios
    });
});