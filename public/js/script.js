var titleSwalCallBackError = "Oops! HA ocurrido un error";

function _callBackAjaxError(jqXHR, exception, errorThrown) {
    console.log(jqXHR.responseJSON);
    SwalHandler.hideLoading()
    let title = titleSwalCallBackError || "Error";
    let text = "Ha ocurrido un error inesperado";

    if (jqXHR.responseJSON) {
        switch (jqXHR.status) {
            case 403:
                text =
                    jqXHR.responseJSON.message ||
                    "No cuenta con permiso para realizar esta acción";
                break;
            case 422:
                text =
                    "Existe un error de validación, vuelve a revisar tus datos antes de enviar";
                if (jqXHR.responseJSON.errors) {
                    if (typeof jqXHR.responseJSON.errors === "object") {
                        text = Object.values(jqXHR.responseJSON.errors).flat().join(", ");
                    } else {
                        text = jqXHR.responseJSON.errors;
                    }
                }
                break;
            case 406:
                text =
                    jqXHR.responseJSON.error ||
                    "Existe un error de validación, vuelve a revisar tus datos antes de enviar";
                break;
            case 404:
                text = jqXHR.responseJSON.message || "Lo que buscas no se encuentra";
                break;
            case 500:
                text =
                    jqXHR.responseJSON.message ||
                    "Inténtelo nuevamente. Si el problema persiste, contacte con el equipo de soporte";
                break;
            case 400:
                text =
                    jqXHR.responseJSON.message ||
                    "Inténtelo nuevamente. Si el problema persiste, contacte con el equipo de soporte";
                break;
        }
    }

    console.log("Swal.fire called with:", { title, text }); // Verifica los parámetros

    SwalHandler.error(text, title)
}