<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Create User</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="styles/dashboard.css">
</head>

<body>
  <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000"
    style="position: absolute; top: 0; right: 0;">
    <div class="toast-header">
      <strong class="me-auto">Remote Force</strong>
      <small>Just now</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
    </div>
  </div>

  <div class="body p-3">
    <section class="pageTitle p-3">
      <h1>Create New User</h1>
    </section>
    <div class="separator"></div>

    <form id="userForm" class="row g-3 needs-validation p-5">
      <div class="col-md-6">
        <label for="validationTooltip01" class="form-label">First Name</label>
        <input type="text" class="form-control" id="validationTooltip01" name="firstname" required />
      </div>
      <div class="valid-tooltip">Looks good!</div>
      <div class="col-md-6">
        <label for="lastname" class="form-label">Last Name</label>
        <input type="text" class="form-control" id="lastname" name="lastname" required />
      </div>
      <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required />
      </div>
      <div class="col-md-6">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required />
      </div>
      <div class="col-md-6">
        <label for="position" class="form-label">Position</label>
        <select class="form-select" id="position" name="position" value="Select Position" required>
          <option value="" disabled selected>Select Position</option>
          <option value="Administrator">Administrator</option>
          <option value="Project Manager">Project Manager</option>
          <option value="Employee">Employee</option>
        </select>
      </div>
      <div class="col-md-6">
        <label for="department" class="form-label">Department</label>
        <select class="form-select" id="department" name="department" required>
          <option value="" disabled selected>Select Department</option>
          <option value="1">Bussiness Development</option>
          <option value="2">Development</option>
          <option value="3">Design</option>
          <option value="4">Marketing</option>
          <option value="5">Customer Support</option>
          <option value="6">Cybersecurity</option>
        </select>
      </div>
      <div class="d-flex justify-content-center mt-5 col-12">
        <button type="submit" class="btn btn-primary me-2">
          Create Account
        </button>
        <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='index.html'">
          Cancel
        </button>
      </div>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(document).ready(function () {
      $("#userForm").submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
          type: "POST",
          url: "dbCreateAcc.php",
          data: formData,
          success: function (response) {
            $('.toast-body').html('You created a NEW USER!');
            $('.toast').toast('show');
            setTimeout(function () {
              window.location.href = 'main.php?page=employeeList';
            }, 1500);
          },
          error: function (xhr, status, error) {
            console.error(xhr.responseText);
          },
        });
      });
    });
  </script>
</body>

</html>