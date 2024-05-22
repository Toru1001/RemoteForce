<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/dashboard.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
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
        <section class="pageTitle1 p-3">
            <h2>Projects</h2>
        </section>
        <div class="separator"></div>

        <nav class="navbar mt-2 mr-3">
            <div class="container-fluid d-flex align-items-center space-in-between">
                <div></div>
                <button class="adbtn btn btn-outline-primary btn-sm mb-0" type="button"
                    onclick="window.location.href='main.php?page=newProject'">+ New Project</button>
            </div>
        </nav>

        <section class="p-4">
            <div class="table-responsive">
                <table class="table datatable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col" class="project-column">Project</th>
                            <th scope="col">Date Started</th>
                            <th scope="col">Due Date</th>
                            <th scope="col">Project Manager</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="addData">
                        <?php
                        include "dbConnect.php";

                        $sql = "SELECT p.project_id, p.project_name, p.start_date, p.end_date, 
                                   CONCAT(e.empl_firstname, ' ', e.empl_lastname) AS project_manager_name, 
                                   p.project_status, p.proj_description 
                                FROM projects p 
                                LEFT JOIN employees e ON p.project_manager = e.emp_id";

                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $content = base64_decode($row['proj_description']);
                                $plainTextContent = strip_tags($content);
                                $shortContent = substr($plainTextContent, 0, 130) . '...';
                                echo "<tr>";
                                echo "<td>" . $row['project_id'] . "</td>";
                                echo "<td class='project-column'><div><div class='fw-bold fs-5'>" . $row['project_name'] . "</div>
                                    <div class='text-wrap text-muted small'>" . $shortContent . "</div>
                                    </div></td>";
                                echo "<td>" . date('M d, Y', strtotime($row['start_date'])) . "</td>";
                                echo "<td>" . date('M d, Y', strtotime($row['end_date'])) . "</td>";
                                echo "<td>" . $row['project_manager_name'] . "</td>";
                                echo "<td>";
                                $stats = htmlspecialchars($row['project_status']);
                                $badgeClass = '';
                                switch ($stats) {
                                    case 'Active':
                                        $badgeClass = 'bg-primary';
                                        break;
                                    case 'Completed':
                                        $badgeClass = 'bg-success';
                                        break;
                                    case 'On Hold':
                                        $badgeClass = 'bg-warning';
                                        break;
                                    default:
                                        $badgeClass = 'bg-secondary';
                                        break;
                                }
                                echo "<span class='badge rounded-pill $badgeClass'>$stats</span>";
                                echo "</td>";
                                echo "<td><div class='btn-group'>
                                <button type='button' class='btn btn-outline-secondary dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
                                  Action
                                </button>
                                <ul class='dropdown-menu'>
                                  <li><a id='projviewbtn' class='projviewbtn dropdown-item' href='?page=viewproject&id=" . base64_encode($row['project_id']) . "' data-projId='" . $row['project_id'] . "'>View</a></li>
                                  <li><a id='projeditbtn' class='projeditbtn dropdown-item' href='#' data-projId='" . $row['project_id'] . "'>Edit</a></li>
                                  <li><hr class='dropdown-divider'></li>
                                  <li><a id='projdeletebtn' class='projdeletebtn text-danger dropdown-item' href='#' data-projId='" . $row['project_id'] . "'>Delete</a></li>
                                </ul>
                              </div>
                                  </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No projects found</td></tr>";
                        }

                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <div class="modal fade" id="projeditModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProjectForm">
                        <input type="hidden" id="editprojId" name="proj_id">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="editProjectName" class="form-label">Project Name</label>
                                <input name="project_name" type="text" class="form-control" id="editProjectName"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="editProjectStatus" class="form-label">Status</label>
                                <select class="form-select" id="editProjectStatus" name="project_status" required>
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Completed">Completed</option>
                                    <option value="On Hold">On-hold</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="editStartDate" class="form-label">Start Date</label>
                                <input name="start_date" type="date" class="form-control" id="editStartDate" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editEndDate" class="form-label">End Date</label>
                                <input name="end_date" type="date" class="form-control" id="editEndDate" required>
                            </div>
                            <div class="col-md-6">
                                <label for="projectmanager" class="form-label">Project Manager</label>
                                <select class="form-select" id="projectmanager" name="project_manager" required>
                                    <option value="" disabled selected>Select Project Manager</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="projcontent" class="form-label">Project Description</label>
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
                                    <button class="btn btn-light" type="button"
                                        onclick="formatDoc('insertOrderedList')"><i class='bx bx-list-ol'></i></button>
                                    <button class="btn btn-light" type="button"
                                        onclick="formatDoc('insertUnorderedList')"><i
                                            class='bx bx-list-ul'></i></button>
                                </div>
                                <div class="textArea border p-3" contenteditable="true" spellcheck="false"
                                    style="min-height: 150px;" id="projcontent"></div>
                                <input type="hidden" name="proj_description" id="hiddenDescription">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateBtn">Update</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('.table').addEventListener('click', function (event) {
                if (event.target.classList.contains('projdeletebtn')) {
                    var projectId = event.target.getAttribute('data-projId');

                    if (confirm('Are you sure you want to delete this project?')) {
                        fetch('dbdeleteProject.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ project_id: projectId })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    $('.toast-body').html('You deleted a PROJECT!');
                                    $('.toast').toast('show');
                                    setTimeout(function () {
                                    window.location.href = '/remoteforce/main.php?page=projects';
                                    }, 1500);
                                } else {
                                    alert('Error deleting project: ' + data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('An error occurred while deleting the project.');
                            });
                    }
                }
            });
        });

    </script>
    <script src="containers/projects.js"></script>
</body>

</html>