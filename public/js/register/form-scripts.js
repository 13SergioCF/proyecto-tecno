document.addEventListener("DOMContentLoaded", () => {
    const steps = document.querySelectorAll(".step");
    const formSteps = document.querySelectorAll(".form-step");
    const nextButtons = document.querySelectorAll(".btn-next");
    const prevButtons = document.querySelectorAll(".btn-prev");

    let currentStep = 0;

    nextButtons.forEach((button) => {
        button.addEventListener("click", () => {
            formSteps[currentStep].classList.remove("active");
            steps[currentStep].classList.remove("active");
            currentStep++;
            formSteps[currentStep].classList.add("active");
            steps[currentStep].classList.add("active");
        });
    });

    prevButtons.forEach((button) => {
        button.addEventListener("click", () => {
            formSteps[currentStep].classList.remove("active");
            steps[currentStep].classList.remove("active");
            currentStep--;
            formSteps[currentStep].classList.add("active");
            steps[currentStep].classList.add("active");
        });
    });
});
