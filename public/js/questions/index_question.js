$(function () {
  $(document).on(
    "click",
    ".delete-question",
    confirmDeleteQuestion
  );


});

async function confirmDeleteQuestion(e) {
  e.preventDefault();

  const id = $(e.currentTarget).data("id");
  const isConfirmed = await SwalHandler.confirm(
    `¿Confirma eliminar la pregunta seleccionado?`,
    "Eliminar Pregunta"
  );

  if (!isConfirmed) return;

  SwalHandler.simpleLoading()
  $.ajax({
    url: `${base_url}questions/${id}`,
    headers: { "X-CSRF-TOKEN": _crf },
    type: "DELETE",
    async success(response) {
      await SwalHandler.success(response.message)
      window.location.href = `${base_url}questions`;
    },
    error: _callBackAjaxError,

  });

}