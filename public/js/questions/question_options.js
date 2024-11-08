function toggleOptionsField() {
    const formato = document.getElementById('formato').value;
    const opcionesContainer = document.getElementById('opciones-container');
    opcionesContainer.style.display = formato === 'eleccion_multiple' ? 'block' : 'none';
}

function addOption() {
    const opcionesList = document.getElementById('opciones-list');
    const newOption = document.createElement('div');
    newOption.classList.add('input-group', 'mb-2');
    newOption.innerHTML = `
        <input type="text" name="opciones[]" class="form-control" placeholder="Opción">
        <div class="input-group-append">
            <button type="button" class="btn btn-outline-secondary" onclick="removeOption(this)">Eliminar</button>
        </div>
    `;
    opcionesList.appendChild(newOption);
}

function removeOption(element) {
    element.parentElement.parentElement.remove();
}
