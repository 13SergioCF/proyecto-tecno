$(document).ready(function () {
    $('#usuario').DataTable();
    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
});


new DataTable('#usuario');
