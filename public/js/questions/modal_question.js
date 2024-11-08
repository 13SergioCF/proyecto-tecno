const DOMstrings = {
    stepsBtnClass: 'multisteps-form__progress-btn',
    stepsBtns: document.querySelectorAll(`.multisteps-form__progress-btn`),
    stepsBar: document.querySelector('.multisteps-form__progress'),
    stepsForm: document.querySelector('.multisteps-form__form'),
    stepsFormTextareas: document.querySelectorAll('.multisteps-form__textarea'),
    stepFormPanelClass: 'multisteps-form__panel',
    stepFormPanels: document.querySelectorAll('.multisteps-form__panel'),
    stepPrevBtnClass: 'js-btn-prev',
    stepNextBtnClass: 'js-btn-next'
};

// Mostrar el formulario con efecto de entrada después de un breve retraso
window.addEventListener('DOMContentLoaded', function () {
    setTimeout(() => {
        DOMstrings.stepsForm.classList.add('show'); // Muestra el formulario
        DOMstrings.stepsBar.classList.add('show');   // Muestra el contenedor de progreso
    }, 500); // 500 ms de retraso para la animación de entrada
});

// Función para eliminar clases de un conjunto de elementos
const removeClasses = (elemSet, className) => {
    elemSet.forEach(elem => {
        elem.classList.remove(className);
    });
};

// Función para encontrar el nodo padre de un elemento específico
const findParent = (elem, parentClass) => {
    let currentNode = elem;
    while (!currentNode.classList.contains(parentClass)) {
        currentNode = currentNode.parentNode;
    }
    return currentNode;
};

// Obtener el número de paso activo
const getActiveStep = elem => {
    return Array.from(DOMstrings.stepsBtns).indexOf(elem);
};

// Activar el paso correspondiente en la barra de progreso
const setActiveStep = activeStepNum => {
    removeClasses(DOMstrings.stepsBtns, 'js-active');
    DOMstrings.stepsBtns.forEach((elem, index) => {
        if (index <= activeStepNum) {
            elem.classList.add('js-active');
        }
    });
};

// Obtener el panel activo
const getActivePanel = () => {
    let activePanel;
    DOMstrings.stepFormPanels.forEach(elem => {
        if (elem.classList.contains('js-active')) {
            activePanel = elem;
        }
    });
    return activePanel;
};

// Activar el panel correspondiente al paso activo
const setActivePanel = activePanelNum => {
    removeClasses(DOMstrings.stepFormPanels, 'js-active');
    DOMstrings.stepFormPanels.forEach((elem, index) => {
        if (index === activePanelNum) {
            elem.classList.add('js-active');
            setFormHeight(elem);
        }
    });
};

// Ajustar la altura del formulario al panel actual
const formHeight = activePanel => {
    const activePanelHeight = activePanel.offsetHeight;
    DOMstrings.stepsForm.style.height = `${activePanelHeight}px`;
};

const setFormHeight = () => {
    const activePanel = getActivePanel();
    formHeight(activePanel);
};

// Evento de clic en la barra de pasos para activar el paso correspondiente
DOMstrings.stepsBar.addEventListener('click', e => {
    const eventTarget = e.target;
    if (!eventTarget.classList.contains(`${DOMstrings.stepsBtnClass}`)) return;

    const activeStep = getActiveStep(eventTarget);
    setActiveStep(activeStep);
    setActivePanel(activeStep);
});

// Evento de clic en los botones Prev/Next
DOMstrings.stepsForm.addEventListener('click', e => {
    const eventTarget = e.target;
    if (!(eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`) || eventTarget.classList.contains(`${DOMstrings.stepNextBtnClass}`))) return;

    const activePanel = findParent(eventTarget, `${DOMstrings.stepFormPanelClass}`);
    let activePanelNum = Array.from(DOMstrings.stepFormPanels).indexOf(activePanel);

    // Aumentar o reducir el número del panel dependiendo del botón (Prev o Next)
    if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
        activePanelNum--;
    } else {
        activePanelNum++;
    }

    setActiveStep(activePanelNum);
    setActivePanel(activePanelNum);
});

// Ajustar la altura del formulario al cargar la página
window.addEventListener('load', setFormHeight, false);

// Ajustar la altura del formulario al cambiar el tamaño de la ventana
window.addEventListener('resize', setFormHeight, false);
