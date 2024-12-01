let selectedCount = 0;
let muscles = [];

document.addEventListener('DOMContentLoaded', () => {
    // Asignar evento de clic a cada tarjeta
    document.querySelectorAll('.card-muscle').forEach(card => {
        card.addEventListener('click', function () {
            const id = this.id.replace('muscle-card-', '');
            toggleMuscle(id);
        });
    });
});

// Alternar selección del músculo
function toggleMuscle(id) {
    const card = document.getElementById(`muscle-card-${id}`);
    const status = document.getElementById(`muscle-status-${id}`);
    const isSelected = card.getAttribute('data-selected') === 'true';
    let indice
    if (isSelected) {
        card.classList.remove('selected');
        indice = muscles.indexOf(id);
        if (indice !== -1) {
            muscles.splice(indice, 1)
        }
        card.setAttribute('data-selected', 'false');
        status.textContent = 'Click para seleccionar';
        selectedCount--;
    } else {
        muscles.push(id);
        card.classList.add('selected');
        card.setAttribute('data-selected', 'true');
        status.textContent = 'Seleccionado';
        selectedCount++;
    }
    document.getElementById('selected-count').textContent = selectedCount;
    document.getElementById('selected-count-badge').classList.toggle('selected', selectedCount > 0);
}

// Función para guardar la selección (modificar según necesidad)
function saveSelection() {
    const selectedMuscles = [];
    document.querySelectorAll('[data-selected="true"]').forEach(card => {
        selectedMuscles.push(card.id.replace('muscle-card-', ''));
    });

    // Enviar datos seleccionados al backend (puedes implementar lo que sea necesario)
    console.log('Músculos seleccionados:', selectedMuscles);
}
document.querySelectorAll('.card-muscle').forEach(card => {
    card.addEventListener('click', () => {
        const checkbox = card.querySelector('input[type="checkbox"]');

        // Alternar el estado del checkbox
        checkbox.checked = !checkbox.checked;

        // Cambiar el estado visual de la tarjeta
        if (checkbox.checked) {
            card.classList.add('border-blue-500', 'bg-blue-100'); // Agrega clases para estado seleccionado
        } else {
            card.classList.remove('border-blue-500', 'bg-blue-100'); // Elimina clases para estado no seleccionado
        }
    });
});