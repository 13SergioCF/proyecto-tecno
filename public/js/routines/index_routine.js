$(function () {
  $(document).on(
    "click",
    ".delete-routine",
    confirmDeleteRoutines
  );


});

async function confirmDeleteRoutines(e) {
  e.preventDefault();

  const id = $(e.currentTarget).data("id");
  const isConfirmed = await SwalHandler.confirm(
    `¿Confirma eliminar la rutina seleccionada?`,
    "Eliminar Rutina"
  );

  if (!isConfirmed) return;

  SwalHandler.simpleLoading()
  $.ajax({
    url: `${base_url}routines/${id}`,
    headers: { "X-CSRF-TOKEN": _crf },
    type: "DELETE",
    async success(response) {
      await SwalHandler.success(response.message)
      window.location.href = `${base_url}routines`;
    },
    error: _callBackAjaxError,

  });

}