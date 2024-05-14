const hamBurger = document.querySelector(".toggle-btn");
hamBurger.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.toggle("expand");
});

$(document).ready(function () {
    $('.datatable').DataTable({
      "paging": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "lengthChange": true,
      "pageLength": 10
    });
  });
