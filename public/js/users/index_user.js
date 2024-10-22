$(function () {
  $(document).on(
    "click",
    ".delete-user",
    confirmDeleteExerciseTypes
  );


});

async function confirmDeleteExerciseTypes(e) {
  e.preventDefault();

  const id = $(e.currentTarget).data("id");
  const isConfirmed = await SwalHandler.confirm(
    `¿Confirma eliminar usuario seleccionado?`,
    "Eliminar Usuario"
  );

  if (!isConfirmed) return;

  SwalHandler.simpleLoading()
  $.ajax({
    url: `${base_url}users/${id}`,
    headers: { "X-CSRF-TOKEN": _crf },
    type: "DELETE",
    async success(response) {
      await SwalHandler.success(response.message)
      window.location.href = `${base_url}users`;
    },
    error: _callBackAjaxError,

  });

}