$(function () {
  $(document).on(
    "click",
    ".delete-exercise-types",
    confirmDeleteExerciseTypes
  );


});

async function confirmDeleteExerciseTypes(e) {
  e.preventDefault();

  const id = $(e.currentTarget).data("id");
  const isConfirmed = await SwalHandler.confirm(
    `¿Confirma eliminar el tipo de ejercicio seleccionado?`,
    "Eliminar Tipo de Ejercicio"
  );

  if (!isConfirmed) return;

  SwalHandler.simpleLoading()
  $.ajax({
    url: `${base_url}exercise-types/${id}`,
    headers: { "X-CSRF-TOKEN": _crf },
    type: "DELETE",
    async success(response) {
      await SwalHandler.success(response.message)
      window.location.href = `${base_url}exercise-types`;
    },
    error: _callBackAjaxError,

  });

}