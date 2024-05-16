<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: loginform.php');
  exit();
}

$userId = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RemoteForce | Main</title>
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="mains.css" />
  <link rel="stylesheet" href="styles/dashboard.css" />
  <link rel="stylesheet" href="styles/sb-admin-2.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
</head>

<body>
  <div class="wrapper">
    <!-- == SIDEBAR == -->
    <aside id="sidebar">
      <div class="d-flex">
        <button class="toggle-btn" type="button">
          <i class="lni lni-grid-alt"></i>
        </button>
        <div class="sidebar-logo">
          <a href="#">RemoteForce</a>
        </div>
      </div>
      <ul class="sidebar-nav">
        <li class="sidebar-item">
          <a href="?page=dashboard" class="sidebar-link">
            <i class="lni lni-dashboard"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#auth"
            aria-expanded="false" aria-controls="auth">
            <i class="lni lni-folder"></i>
            <span>Projects</span>
          </a>
          <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item">
              <a href="?page=newProject" class="sidebar-link">Create New Project</a>
            </li>
            <li class="sidebar-item">
              <a href="?page=projects" class="sidebar-link">View Projects</a>
            </li>
          </ul>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="lni lni-agenda"></i>
            <span>Task</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="lni lni-popup"></i>
            <span>Report</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#multi-two"
            aria-expanded="false" aria-controls="multi-two">
            <i class="lni lni-users"></i>
            <span>Employees</span>
          </a>
          <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
            <li class="sidebar-item">
              <a href="?page=newUser" class="sidebar-link">Add New Employee</a>
            </li>
            <li class="sidebar-item">
              <a href="?page=employeeList" class="sidebar-link">Employee List</a>
            </li>
          </ul>
        </li>

        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="lni lni-cog"></i>
            <span>Setting</span>
          </a>
        </li>
      </ul>
      <div class="sidebar-footer">
        <a href="?page=login" class="sidebar-link">
          <i class="lni lni-exit"></i>
          <span>Logout</span>
        </a>
      </div>
    </aside>

    <!-- == Right Body == -->
    <div class="main">
      <!-- == Header == -->

      <div class="header">
        <h1></h1>
        <span class="account p-3">
          <i class="lni lni-user"></i>
          <span class="p-3">Administrator</span>
        </span>
      </div>

      <!-- == Contents == -->
      <section class="content-container ">
        <?php
        if (isset($_GET['page'])) {
          $page = $_GET['page'];
          if ($page === 'dashboard') {
            include ('containers/dashboard.php');
          } else if ($page === 'newUser') {
            include ('containers/newUser.php');
          } else if ($page === 'employeeList') {
            include ('containers/employeeList.php');
          } else if ($page === 'newProject') {
            include ('containers/newProject.php');
          } else if ($page === 'projects') {
            include ('containers/projects.php');
          } else if ($page === 'viewproject') {
            include ('containers/viewProject.php');
          } else if ($page === 'login') {
            unset($userId);
            unset($userRole);
            session_destroy();
            header('location: loginform.php');
          }
        } else {
          include ('containers/dashboard.php');
        }
        ?>
      </section>
    </div>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
  <script src="main.js"></script>
  <script src="containers/newProject.js"></script>
</body>

</html>