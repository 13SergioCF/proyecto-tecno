function toggleInput(selectId, inputId) {
    const selectElement = document.getElementById(selectId);
    const inputElement = document.getElementById(inputId);

    if (selectElement.value === "si") {
        inputElement.classList.remove('d-none');
    } else {
        inputElement.classList.add('d-none');
        const inputField = inputElement.querySelector('input');
        if (inputField) {
            inputField.value = '';
        }
    }
}
