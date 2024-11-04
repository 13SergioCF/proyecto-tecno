$(function () {
  $(document).on(
    "click",
    ".delete-question-types",
    confirmDeleteQuestionTypes
  );


});

async function confirmDeleteQuestionTypes(e) {
  e.preventDefault();

  const id = $(e.currentTarget).data("id");
  const isConfirmed = await SwalHandler.confirm(
    `¿Confirma eliminar el tipo de pregunta seleccionado?`,
    "Eliminar Tipo de Pregunta"
  );

  if (!isConfirmed) return;

  SwalHandler.simpleLoading()
  $.ajax({
    url: `${base_url}question-types/${id}`,
    headers: { "X-CSRF-TOKEN": _crf },
    type: "DELETE",
    async success(response) {
      await SwalHandler.success(response.message)
      window.location.href = `${base_url}question-types`;
    },
    error: _callBackAjaxError,

  });

}