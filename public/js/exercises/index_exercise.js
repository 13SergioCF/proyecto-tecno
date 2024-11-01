$(function () {
  $(document).on(
    "click",
    ".delete-exercise",
    confirmDeleteExercises
  );


});

async function confirmDeleteExercises(e) {
  e.preventDefault();

  const id = $(e.currentTarget).data("id");
  const isConfirmed = await SwalHandler.confirm(
    `¿Confirma eliminar el ejercicio seleccionado?`,
    "Eliminar Ejercicio"
  );

  if (!isConfirmed) return;

  SwalHandler.simpleLoading()
  $.ajax({
    url: `${base_url}exercises/${id}`,
    headers: { "X-CSRF-TOKEN": _crf },
    type: "DELETE",
    async success(response) {
      await SwalHandler.success(response.message)
      window.location.href = `${base_url}exercises`;
    },
    error: _callBackAjaxError,

  });

}