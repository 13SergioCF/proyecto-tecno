$(function () {
    $(document).on(
      "click",
      ".delete-period",
      confirmDeleteQuestion
    );
  
  
  });
  
  async function confirmDeleteQuestion(e) {
    e.preventDefault();
  
    const id = $(e.currentTarget).data("id");
    const isConfirmed = await SwalHandler.confirm(
      `¿Confirma eliminar el periodo seleccionado?`,
      "Eliminar Periodo"
    );
  
    if (!isConfirmed) return;
  
    SwalHandler.simpleLoading()
    $.ajax({
      url: `${base_url}periods/${id}`,
      headers: { "X-CSRF-TOKEN": _crf },
      type: "DELETE",
      async success(response) {
        await SwalHandler.success(response.message)
        window.location.href = `${base_url}periods`;
      },
      error: _callBackAjaxError,
  
    });
  
  }