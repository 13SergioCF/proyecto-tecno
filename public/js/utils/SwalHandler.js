class SwalHandler {
    static success(message, title = "Éxito", okButtonText = "OK", options = {}) {
      return Swal.fire({
        icon: "success",
        title: title,
        text: message,
        confirmButtonText: okButtonText,
        confirmButtonColor: "#34c3af",
        ...options,
      });
    }
  
    static async error(message, title = "Error", options = {}) {
      if (typeof message === "object") {
        let errorMessage = "";
        for (const key in message) {
          if (message.hasOwnProperty(key)) {
            errorMessage += `${key}: ${message[key]}\n`;
          }
        }
        message = errorMessage;
      }
      return await Swal.fire({
        icon: "error",
        title: title,
        text: message,
        confirmButtonColor: "#34c3af",
        ...options,
      });
    }
  
    static warning(message, title = "Advertencia", options = {}) {
      return Swal.fire({
        icon: "warning",
        title: title,
        text: message,
        ...options,
      });
    }
  
    static info(message, title = "Información", options = {}) {
      return Swal.fire({
        icon: "info",
        title: title,
        text: message,
        ...options,
      });
    }
  
    static custom(message, title, type = "info", options = {}) {
      return Swal.fire({
        icon: type,
        title: title,
        text: message,
        ...options,
      });
    }
  
    static async confirm(
      message,
      title = "Confirm Action",
      confirmText = `Sí, ${title}`,
      cancelText = "Cancelar",
      options = {}
    ) {
      const result = await Swal.fire({
        title: title,
        text: message,
        icon: "question",
        showCancelButton: true,
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        confirmButtonColor: "#34c3af",
        cancelButtonColor: "#f46a6a",
        ...options,
      });
  
      return result.isConfirmed;
    }
  
    static async evaluate(
      message,
      title = "Confirmar Acción",
      aceptarText = "Aceptar",
      rechazarText = "Rechazar",
      cancelarText = "Cancelar",
      options = {}
    ) {
      const result = await Swal.fire({
        title: title,
        text: message,
        icon: "question",
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: aceptarText,
        denyButtonText: rechazarText,
        cancelButtonText: cancelarText,
        confirmButtonColor: "#34c3af",
        denyButtonColor: "#f46a6a",
        cancelButtonColor: "#d1d1d1",
        ...options,
      });
  
      if (result.isConfirmed) {
        return 1;
      } else if (result.isDenied) {
        return -1;
      } else {
        return null;
      }
    }
  
    static showLoading(title = "Loading...", callback) {
      Swal.fire({
        title: title,
        text: "Please wait...",
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: async () => {
          Swal.showLoading();
          try {
            await callback(); // ejecuta callback!
            Swal.close();
            await SwalHandler.success("Operation completed successfully!");
          } catch (error) {
            console.error(`Error: ${error.message}`);
            Swal.close();
            SwalHandler.error("Error occurred during the operation.");
          }
        },
      });
    }
  
    static hideLoading() {
      Swal.close();
    }
  
    static simpleLoading() {
      Swal.fire({
        title: "Cargando...",
        text: "Por Favor Espere...",
        showConfirmButton: false,
        allowOutsideClick: false,
        willOpen: async () => {
          Swal.showLoading();
        },
      });
    }
  
    static async prompt(
      title,
      confirmButtonText = "OK",
      cancelButtonText = "Cancel",
      inputValidator = null,
      inputType = "text"
    ) {
      const {
        value,
        isConfirmed
      } = await Swal.fire({
        title: title,
        input: inputType,
        inputAttributes: {
          autocapitalize: "off",
          style: "z-index: 100000",
        },
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
        inputValidator: inputValidator,
      });
  
      return {
        isConfirmed,
        value: isConfirmed ? value : null
      };
    }
    static async promptNumber(
      title,
      confirmButtonText = "OK",
      cancelButtonText = "Cancelar",
      min = 1,
      step = 1
    ) {
      const {
        value,
        isConfirmed
      } = await Swal.fire({
        title: title,
        html: `
          <input
            id="number-input"
            type="number"
            step="${step}"
            class="swal2-input"
            min="${min}"
            placeholder="Ingrese cantidad de actividades ejecutadas">`,
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
        preConfirm: () => {
          const input = document.getElementById('number-input');
          if (!input.value || isNaN(input.value)) {
            Swal.showValidationMessage('Debe ingresar un valor numérico válido.');
            return false;
          }
          return input.value;
        }
      });
      
      return {
        isConfirmed,
        value: isConfirmed ? value : null
      };
    }
    
  }