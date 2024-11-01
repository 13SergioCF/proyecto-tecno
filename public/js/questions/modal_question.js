document.addEventListener("DOMContentLoaded", function () {
    if (!localStorage.getItem("firstLoginShown")) {
        $('#questionModal').modal('show');
        localStorage.setItem("firstLoginShown", "true");
    }
});