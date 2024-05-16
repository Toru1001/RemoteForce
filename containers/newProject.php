<?php
include "dbConnect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/css/multi-select-tag.css">
  <link rel="stylesheet" href="styles/textArea.css">
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <div class="body p-3">

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


    <section class="pageTitle1 p-3">
      <h2>New Project</h2>
    </section>
    <div class="separator"></div>

    <div class="container p-3">
      <div class="top-border-box">

        <form id="projectForm" class="projectForm row g-3" name="projectForm">
          <div class="col-md-6">
            <label for="validationDefault01" class="form-label">Project Name</label>
            <input name="project_name" type="text" class="form-control" id="validationDefault01" required>
          </div>

          <div class="col-md-6">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" value="Select Status" required>
              <option value="" disabled selected>Select Status</option>
              <option value="Active">Active</option>
              <option value="Completed">Completed</option>
              <option value="On Hold">On-hold</option>
            </select>
          </div>

          <div class="col-md-6">
            <label for="validationDefault02" class="form-label">Start Date</label>
            <input name="startdate" type="date" class="form-control" id="validationDefault02" required>
          </div>
          <div class="col-md-6">
            <label for="validationDefault03" class="form-label">End Date</label>
            <input name="enddate" type="date" class="form-control" id="validationDefault03" required>
          </div>
          <div class="col-md-6">
            <label for="projectmanager" class="form-label">Project Manager</label>
            <select class="form-select" id="projectmanager" name="projectmanager" value="Select Project Manager"
              required>
              <option value="" disabled selected>Select Project Manager</option>
              <?php
              $sql = "SELECT * FROM employees WHERE position = 'Project Manager'";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row["emp_id"] . "'>" . $row["empl_firstname"] . " " . $row["empl_lastname"] . "</option>";
                }
              } else {
                echo "<option value='' disabled>No project managers available</option>";
              }
              ?>
            </select>
          </div>
          <div class="col-md-6">
            <label for="members" class="form-label">Members</label>
            <select class="form-select" name="members" id="members" multiple>
              <?php
              $sql = "SELECT * FROM employees WHERE position='Employee'";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row["emp_id"] . "'>" . $row["empl_firstname"] . " " . $row["empl_lastname"] . "</option>";
                }
              } else {
                echo "<option value='' disabled>No members available</option>";
              }
              ?>
            </select>
          </div>

          <div class="col-md-10">
            <label for="projectDescription" class="form-label">Project Description</label>
            <div class="btn-toolbar mb-2">
              <button class="btn btn-light" type="button" onclick="formatDoc('undo')"><i
                  class='bx bx-undo'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('redo')"><i
                  class='bx bx-redo'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('bold')"><i
                  class='bx bx-bold'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('underline')"><i
                  class='bx bx-underline'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('italic')"><i
                  class='bx bx-italic'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('strikeThrough')"><i
                  class='bx bx-strikethrough'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('justifyLeft')"><i
                  class='bx bx-align-left'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('justifyCenter')"><i
                  class='bx bx-align-middle'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('justifyRight')"><i
                  class='bx bx-align-right'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('justifyFull')"><i
                  class='bx bx-align-justify'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('insertOrderedList')"><i
                  class='bx bx-list-ol'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('insertUnorderedList')"><i
                  class='bx bx-list-ul'></i></button>
            </div>
            <div class="textArea form-control border p-3" id="content" contenteditable="true" spellcheck="false"
              style="min-height: 150px;">
              <p>Start writing here...</p>
            </div>
            <input type="hidden" name="projectDescription" id="hiddenDescription">
          </div>

          <div class="col-12 p-4">
            <button id="submitBtn" class="btn btn-primary" type="button">Submit</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/js/multi-select-tag.js"></script>
  <script>
    new MultiSelectTag('members', {
      rounded: true,
      shadow: true,
      tagColor: {
        textColor: '#327b2c',
        borderColor: '#004b55',
        bgColor: '#0000',
      },
      onChange: function (values) {
        console.log(values)
      }
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#submitBtn').on('click', function () {
        var projectName = $('input[name="project_name"]').val();
        var status = $('select[name="status"]').val();
        var startDate = $('input[name="startdate"]').val();
        var endDate = $('input[name="enddate"]').val();
        var projectManager = $('select[name="projectmanager"]').val();
        var projectDescription = $('#content').html();

        var encodedDescription = btoa(projectDescription);
        var members = $('#members').val();

        $.ajax({
          url: 'saveProject.php',
          type: 'POST',
          data: {
            project_name: projectName,
            status: status,
            startdate: startDate,
            enddate: endDate,
            projectmanager: projectManager,
            projectDescription: encodedDescription,
            members: members
          },
          success: function (response) {
            $('.toast-body').html('You created a new PROJECT!');
            $('.toast').toast('show');
            setTimeout(function () {
              window.location.href = 'main.php';
            }, 1500);
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.error(textStatus, errorThrown);
          }
        });
      });
    });
  </script>




  <script src="containers/newProject.js"> </script>
</body>

</html>