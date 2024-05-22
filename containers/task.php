<?php
include "dbConnect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="/styles/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="body p-3">
        <section class="pageTitle1 p-3">
            <h2>Tasks</h2>
        </section>
        <div class="separator"></div>

        <section class="p-4">
            <div class="table-responsive">
                <table class="table datatable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Project</th>
                            <th scope="col">Task</th>
                            <th scope="col">Project Date Started</th>
                            <th scope="col">Task Due Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="addData">
                        <?php
                        $sql = "SELECT t.task_id, t.task_name, t.task_description, t.deadline AS task_deadline, 
                                   t.task_status, p.project_name, p.start_date AS project_start_date
                            FROM tasks t
                            LEFT JOIN projects p ON t.project_id = p.project_id";

                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            $index = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $taskDescription = base64_decode($row['task_description']);
                                $plainTextDescription = strip_tags($taskDescription);
                                $shortDescription = substr($plainTextDescription, 0, 110) . '...';
                                echo "<tr>";
                                echo "<td>" . $index++ . "</td>";
                                echo "<td><strong>" . htmlspecialchars($row['project_name']) . "</strong></td>";
                                echo "<td class='project-column'><div><div class='fw-bold fs-5'>" . htmlspecialchars($row['task_name']) . "</div>
                                <div class='text-wrap text-muted small'>" . htmlspecialchars($shortDescription) . "</div>
                                </div></td>";
                                echo "<td>" . date('M d, Y', strtotime($row['project_start_date'])) . "</td>";
                                echo "<td>" . date('M d, Y', strtotime($row['task_deadline'])) . "</td>";
                                echo "<td>";
                                $status = htmlspecialchars($row['task_status']);
                                $badgeClass = '';
                                switch ($status) {
                                    case 'Active':
                                        $badgeClass = 'bg-primary';
                                        break;
                                    case 'Completed':
                                        $badgeClass = 'bg-success';
                                        break;
                                    case 'Pending':
                                        $badgeClass = 'bg-warning';
                                        break;
                                    case 'Past-due':
                                        $badgeClass = 'bg-danger';
                                        break;
                                    default:
                                        $badgeClass = 'bg-secondary';
                                        break;
                                }
                                echo "<span class='badge rounded-pill $badgeClass'>$status</span>";
                                echo "</td>";
                                echo "<td>
                                    <div class='btn-group'>
                                    <button type='button' class='taskviewbtn btn btn-outline-primary' data-task-id='" . $row['task_id'] . "'><i class='lni lni-eye'></i></button>
                                    <button type='button' class='taskeditbtn btn btn-outline-secondary' data-task-id='" . $row['task_id'] . "'><i class='bx bxs-edit'></i></button>
                                    </div>
                                </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No tasks found</td></tr>";
                        }

                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <div class="modal fade" id="viewTaskModal2" tabindex="-1" aria-labelledby="viewTaskModalLabel2" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewTaskModalLabel2">View Task Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col ml-3">
                                <h7 class="line"><strong> Task Name </strong></h7>
                                <p id="viewTaskName2" class="mt-1"></p>
                                <h7 class="line"><strong> Task Description </strong></h7>
                                <p id="viewTaskDescription2" class="mt-2"></p>
                            </div>
                            <div class="col ml-3">
                                <h7 class="line"><strong> Due Date </strong></h7>
                                <p id="viewTaskDueDate2" class="mt-1"></p>
                                <h7 class="line"><strong> Priority </strong></h7>
                                <p id="viewTaskPriority2" class="mt-1"></p>
                                <h7 class="line"><strong> Status </strong></h7>
                                <p id="viewTaskStatus2" class="mt-1"></p>
                                <h7 class="line"><strong> Task Created by </strong></h7>
                                <div class="row-6">
                                <p id="viewTaskCreator2" class="member-pill mt-1"></p>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTaskModalLabel">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateTaskForm" class="needs-validation">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="uptaskName" class="form-label">Task Name</label>
                                    <input type="text" class="form-control" id="uptaskName" name="uptask_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="uptaskPriority" class="form-label">Priority</label>
                                    <select class="form-select" id="uptaskPriority" name="uppriority" required>
                                        <option value="Low">Low</option>
                                        <option value="Medium">Medium</option>
                                        <option value="High">High</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="uptaskDeadline" class="form-label">Deadline</label>
                                    <input type="date" class="form-control" id="uptaskDeadline" name="updeadline"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="uptaskStatus" class="form-label">Status</label>
                                    <select class="form-select" id="uptaskStatus" name="uptask_status" required>
                                        <option value="Pending">Pending</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Past-due">Past-due</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <label for="upprojcontent" class="form-label">Task Description</label>
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
                                        <button class="btn btn-light" type="button"
                                            onclick="formatDoc('strikeThrough')"><i
                                                class='bx bx-strikethrough'></i></button>
                                        <button class="btn btn-light" type="button"
                                            onclick="formatDoc('justifyLeft')"><i class='bx bx-align-left'></i></button>
                                        <button class="btn btn-light" type="button"
                                            onclick="formatDoc('justifyCenter')"><i
                                                class='bx bx-align-middle'></i></button>
                                        <button class="btn btn-light" type="button"
                                            onclick="formatDoc('justifyRight')"><i
                                                class='bx bx-align-right'></i></button>
                                        <button class="btn btn-light" type="button"
                                            onclick="formatDoc('justifyFull')"><i
                                                class='bx bx-align-justify'></i></button>
                                        <button class="btn btn-light" type="button"
                                            onclick="formatDoc('insertOrderedList')"><i
                                                class='bx bx-list-ol'></i></button>
                                        <button class="btn btn-light" type="button"
                                            onclick="formatDoc('insertUnorderedList')"><i
                                                class='bx bx-list-ul'></i></button>
                                    </div>
                                    <div class="textArea border p-3" contenteditable="true" spellcheck="false"
                                        style="min-height: 150px;" id="upprojcontent"></div>
                                    <input type="hidden" name="uptask_description" id="uphiddenDescription">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="upedittaskId">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateTaskButton">Apply Changes</button>
                </div>
            </div>
        </div>
    </div>




        <script src="containers/task.js"  >
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>

</html>
