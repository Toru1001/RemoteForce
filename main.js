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

  function showToast(message) {
    var toastHtml = `
      <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
        <div class="toast-header">
          <strong class="me-auto">Notification</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
          ${message}
        </div>
      </div>`;

    $('#toastContainer').append(toastHtml);

    // Initialize Bootstrap toast for the new toast element
    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    var toastList = toastElList.map(function (toastEl) {
      return new bootstrap.Toast(toastEl);
    });

    // Show the newly added toast
    toastList[toastList.length - 1].show();

    // Remove the toast element from DOM after it's hidden
    $('.toast').on('hidden.bs.toast', function () {
      $(this).remove();
    });
  }