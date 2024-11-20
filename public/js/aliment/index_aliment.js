$(function () {
  // Evento para eliminar un alimento
  $(document).on("click", ".delete-aliment", confirmDeleteAliment);

  // Filtro por estado
  $('#filter').on('change', function () {
      const estado = $(this).val();
      const url = `${base_url}aliments?estado=${estado}`;
      window.location.href = url;
  });
});

async function confirmDeleteAliment(e) {
  e.preventDefault();

  const id = $(e.currentTarget).data("id"); // Obtener ID del alimento
  const isConfirmed = await SwalHandler.confirm(
      `¿Confirma eliminar el alimento seleccionado?`,
      "Eliminar alimento"
  );

  if (!isConfirmed) return;

  SwalHandler.simpleLoading();
  $.ajax({
      url: `${base_url}aliments/${id}`, // URL para el endpoint DELETE
      headers: { "X-CSRF-TOKEN": _crf }, // Token CSRF para protección
      type: "DELETE", // Tipo de solicitud
      success: async function (response) {
          await SwalHandler.success(response.message);

          // Actualizar fila directamente en la tabla
          const row = $(`button[data-id="${id}"]`).closest('tr');
          row.find('.badge') // Cambiar estado visual a "inactivo"
              .removeClass('bg-success')
              .addClass('bg-danger')
              .text('inactivo');
          row.find('td:last') // Remover botones de acción
              .html('<span class="text-muted">Sin acciones</span>');
      },
      error: function (xhr) {
          SwalHandler.error(
              xhr.responseJSON ? xhr.responseJSON.message : "Error desconocido"
          );
      },
  });
}
