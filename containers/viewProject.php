<?php

include "dbConnect.php";

if (isset($_GET['id'])) {
    $proj_id = base64_decode($_GET['id']);
} else {
    echo "Project ID not provided";
}

$stmt = $conn->prepare("SELECT p.project_id, p.project_name, p.start_date, p.end_date, 
CONCAT(e.empl_firstname, ' ', e.empl_lastname) AS project_manager_name, 
p.project_status, p.proj_description,
d.department_name
FROM projects p 
INNER JOIN employees e ON p.project_manager = e.emp_id 
INNER JOIN departments d ON e.department_id = d.department_id
WHERE p.project_id = ?
");
$stmt->bind_param("i", $proj_id);
$stmt->execute();
$projdetails = $stmt->get_result();

if ($projdetails->num_rows > 0) {
    $retrieve = $projdetails->fetch_assoc();
    $project_name = $retrieve['project_name'];
    $startDate = date('F d, Y', strtotime($retrieve['start_date']));
    $endDate = date('F d, Y', strtotime($retrieve['end_date']));
    $projectManager = $retrieve['project_manager_name'];
    $project_status = $retrieve['project_status'];
    $proj_description = base64_decode($retrieve['proj_description']);
    $department = $retrieve['department_name'];
}
$stmt->close();


$sql = "SELECT 
            p.tracking_id, e.empl_firstname, e.empl_lastname, 
            t.task_name, 
            p.date, p.start_time, p.end_time, p.prod_description 
        FROM productivitytracking p
        JOIN tasks t ON p.task_id = t.task_id
        JOIN employees e ON p.emp_id = e.emp_id
        WHERE t.project_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $proj_id);
$stmt->execute();
$result = $stmt->get_result();

$productivity_entries = [];
while ($row = $result->fetch_assoc()) {
    $productivity_entries[] = $row;
}

$stmt->close();



$stmt = $conn->prepare("SELECT task_id, task_name, priority, task_status, deadline, task_description FROM tasks WHERE project_id = ?");
$stmt->bind_param("i", $proj_id);
$stmt->execute();
$tasks = $stmt->get_result();

$taskList = [];
if ($tasks->num_rows > 0) {
    while ($task = $tasks->fetch_assoc()) {
        $taskList[] = $task;
    }
}
$stmt->close();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Project</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/dashboard.css">
</head>

<body>
    <div class="body p-3">
        <section class="pageTitle1 p-3">
            <h2>View Project</h2>
        </section>
        <div class="separator"></div>

        <section class="projects">
            <div class="card border-left-primary shadow h-100 py-2 m-4">
                <div class="row mt-3">
                    <div class="col ml-4">
                        <h7 class="line"><strong> Project Name </strong></h7>
                        <p id="projectName">
                            <?php echo $project_name ?>
                        </p>
                        <h7 class="line"><strong> Project Description </strong></h7>
                        <p id="projectDescription"><?php echo $proj_description ?></p>
                    </div>
                    <div class="col ml-4">
                        <h7 class="line"><strong> Start Date </strong></h7>
                        <p id="startDate"><?php echo $startDate ?></p>
                        <h7 class="line"><strong> End Date </strong></h7>
                        <p id="endDate"><?php echo $endDate ?></p>
                        <h7 class="line"><strong> Status </strong></h7>
                        <p id="projectStatus"><?php echo $project_status ?></p>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container-fluid mt-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-header top-border-box">
                                <h5><strong>Team:</strong></h5>
                            </div>
                            <div class="card-body">
                                <h5 class="mb-0"><strong id="projectManager">
                                        <?php
                                        if ($projectManager == null) {
                                            echo 'Waiting to reassign';
                                        } else {
                                            echo $projectManager;
                                        } ?>
                                    </strong></h5>
                                <p class="text-muted">Project Manager
                                    <i><?php echo " " . "(" . $department . ")"; ?></i>
                                </p>
                                <h5><strong>Members:</strong></h5>
                                <div id="memberList">
                                    <?php
                                    $stmt = $conn->prepare("SELECT e.empl_firstname, e.empl_lastname
                                    FROM project_members pm
                                    INNER JOIN employees e ON pm.emp_id = e.emp_id
                                    WHERE pm.project_id = ?");
                                    $stmt->bind_param("i", $proj_id);
                                    $stmt->execute();
                                    $projectMembersResult = $stmt->get_result();

                                    $projectMembers = array();

                                    if ($projectMembersResult->num_rows > 0) {

                                        while ($row = $projectMembersResult->fetch_assoc()) {
                                            $fullName = $row['empl_firstname'] . ' ' . $row['empl_lastname'];
                                            echo '<span class="member-pill">' . $fullName . '</span>';
                                        }
                                    }

                                    $stmt->close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center top-border-box">
                                <h5><strong>Task List:</strong></h5>
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#createTaskModal"><i class='bx bx-plus-circle'></i> New
                                    Task</button>
                            </div>
                            <div class="card-body p-0">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Task</th>
                                            <th>Priority</th>
                                            <th>Status</th>
                                            <th>Due-Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" id="edittaskId" name="proj_id">
                                        <?php if (!empty($taskList)): ?>
                                            <?php foreach ($taskList as $index => $task): ?>
                                                <tr>
                                                    <td><?php echo $index + 1; ?></td>
                                                    <td class='project-column'>
                                                        <div>
                                                            <div class='fw-bold fs-6'>
                                                                <?php echo htmlspecialchars($task['task_name']); ?>
                                                            </div>
                                                            <div class='text-wrap text-muted small'>
                                                                <?php
                                                                $newdesc = base64_decode($task['task_description']);
                                                                $plainTextContent = strip_tags($newdesc);
                                                                echo substr($plainTextContent, 0, 100) . '...';
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?php
                                                    $prio = htmlspecialchars($task['priority']);
                                                    $badgeClass = '';
                                                    switch ($prio) {
                                                        case 'Low':
                                                            $badgeClass = 'bg-secondary';
                                                            break;
                                                        case 'Medium':
                                                            $badgeClass = 'bg-warning';
                                                            break;
                                                        case 'High':
                                                            $badgeClass = 'bg-danger';
                                                            break;
                                                        default:
                                                            $badgeClass = 'bg-secondary';
                                                            break;
                                                    }

                                                    ?>
                                                        <span
                                                            class="badge rounded-pill <?php echo $badgeClass; ?>"><?php echo $prio; ?></span>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $status = htmlspecialchars($task['task_status']);
                                                        $badgeClass = '';
                                                        switch ($status) {
                                                            case 'Completed':
                                                                $badgeClass = 'bg-success';
                                                                break;
                                                            case 'Pending':
                                                                $badgeClass = 'bg-warning';
                                                                break;
                                                            case 'Past-Due':
                                                                $badgeClass = 'bg-danger';
                                                                break;
                                                            default:
                                                                $badgeClass = 'bg-secondary';
                                                                break;
                                                        }
                                                        ?>
                                                        <span
                                                            class="badge rounded-pill <?php echo $badgeClass; ?>"><?php echo $status; ?></span>
                                                    </td>
                                                    <td><small><?php echo date('F d, Y', strtotime($task['deadline'])); ?></small>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle='dropdown'
                                                            aria-expanded='false'><strong><i
                                                                    class='bx bx-dots-vertical'></i></strong></button>
                                                        <ul class='dropdown-menu'>
                                                            <li><a id='taskviewbtn' class='taskviewbtn dropdown-item'
                                                                    data-task-id="<?php echo $task['task_id']; ?>">View</a></li>
                                                            <li><a id='taskeditbtn' class='taskeditbtn dropdown-item' href='#'
                                                                    data-task-id="<?php echo $task['task_id']; ?>">Edit</a></li>
                                                            <li>
                                                                <hr class='dropdown-divider'>
                                                            </li>
                                                            <li><a id='taskdeletebtn'
                                                                    class='taskdeletebtn text-danger dropdown-item' href='#'
                                                                    data-task-id="<?php echo $task['task_id']; ?>">Delete</a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center">No tasks found for this project.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
        </section>

        <section>
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center border-none">
                    <h5><strong>Members Progress/Activity</strong></h5>
                    <button class="btn btn-outline-primary btn-sm" id="addProdBtn"><i class='bx bx-plus-circle'></i> New
                        Productivity</button>
                </div>
                <?php foreach ($productivity_entries as $entry): ?>
                    <div class="card mt-1 ml-3 mr-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <i class='bx bx-user-circle' style="font-size: 2rem;"></i>
                                    <div class="ml-3">
                                        <div>
                                            <strong><?php echo htmlspecialchars($entry['empl_firstname'] . ' ' . $entry['empl_lastname']); ?></strong>
                                            [ <a href="#" class="text-primary">
                                                <?php echo htmlspecialchars($entry['task_name']); ?>
                                            </a> ]
                                        </div>
                                        <div class="text-muted small">
                                            <i class='bx bx-calendar'></i>
                                            <?php echo date('M d, Y', strtotime($entry['date'])); ?>
                                            <i class='bx bx-time-five ml-2'></i> Start:
                                            <?php echo date('h:i A', strtotime($entry['start_time'])); ?>
                                            <i class='bx bx-time-five ml-2'></i> End:
                                            <?php echo date('h:i A', strtotime($entry['end_time'])); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm" data-bs-toggle='dropdown' aria-expanded='false'>
                                        <strong><i class='bx bx-dots-horizontal-rounded'
                                                style="font-size: 1.5rem;"></i></strong>
                                    </button>
                                    <ul class='dropdown-menu'>
                                        <li>
                                            <a id='proddeletebtn' class='deletebtn dropdown-item' href='#'
                                                data-tracking-id="<?php echo $entry['tracking_id']; ?>">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <?php echo base64_decode($entry['prod_description']); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>


    </div>

    </section>

    <!-- Modal for the creation of task -->
    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTaskModalLabel">Create New Task</h5>
                    <button type="button" class="btn-close" data-bs dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createTaskForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="taskName" class="form-label">Task
                                        Name</label>
                                    <input type="text" class="form-control" id="taskName" name="task_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="taskPriority" class="form-label">Priority</label>
                                    <select class="form-select" id="taskPriority" name="priority" required>
                                        <option value="Low">Low</option>
                                        <option value="Medium">Medium</option>
                                        <option value="High">High</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="taskDeadline" class="form-label">Deadline</label>
                                    <input type="date" class="form-control" id="taskDeadline" name="deadline" required>
                                </div>
                                <div class="mb-3">
                                    <label for="taskStatus" class="form-label">Status</label>
                                    <select class="form-select" id="taskStatus" name="task_status" required>
                                        <option value="Pending">Pending</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Past-due">Past-due</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <label for="projcontent" class="form-label">Task Description</label>
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
                                        style="min-height: 150px;" id="projcontent"></div>
                                    <input type="hidden" name="task_description" id="hiddenDescription">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveTaskButton">Save Task</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View task Modal -->
    <div class="modal fade" id="viewTaskModal" tabindex="-1" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTaskModalLabel">View Task Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col ml-3">
                            <h7 class="line"><strong> Task Name </strong></h7>
                            <p id="viewTaskName" class="mt-1"></p>
                            <h7 class="line"><strong> Task Description </strong></h7>
                            <p id="viewTaskDescription" class="mt-2"></p>
                        </div>
                        <div class="col ml-3">
                            <h7 class="line"><strong> Due Date </strong></h7>
                            <p id="viewTaskDueDate" class="mt-1"></p>
                            <h7 class="line"><strong> Priority </strong></h7>
                            <p id="viewTaskPriority" class="mt-1"></p>
                            <h7 class="line"><strong> Status </strong></h7>
                            <p id="viewTaskStatus" class="mt-1"></p>
                            <h7 class="line"><strong> Task Created by </strong></h7>
                            <p id="viewTaskCreator" class="mt-1"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for editing task -->

    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTaskModalLabel">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateTaskForm">
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

    <!-- Modal for the add productivity -->
    <div class="modal fade" id="addProductivityModal" tabindex="-1" aria-labelledby="addProductivityModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductivityModalLabel">Add Productivity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductivityForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="taskDropdown" class="form-label">Task</label>
                                    <select class="form-select" id="taskDropdown" name="task" required></select>
                                </div>
                                <div class="mb-3">
                                    <label for="productivityDate" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="productivityDate" name="date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="startTime" class="form-label">Start Time</label>
                                    <input type="time" class="form-control" id="startTime" name="start_time" required>
                                </div>
                                <div class="mb-3">
                                    <label for="endTime" class="form-label">End Time</label>
                                    <input type="time" class="form-control" id="endTime" name="end_time" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="productivityDescription" class="form-label">Productivity
                                    Description</label>
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
                                    style="min-height: 150px;" id="productivityDescription"></div>
                                <input type="hidden" name="description" id="hiddenDescription">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveProductivityButton">Save</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('.projviewbtn').click(function (e) {
            e.preventDefault();
            var taskId = $(this).data('taskid');
            viewTask(taskId);
        });

        document.getElementById('saveTaskButton').addEventListener('click', function () {
            var taskName = document.getElementById('taskName').value;
            var taskPriority = document.getElementById('taskPriority').value;
            var taskDeadline = document.getElementById('taskDeadline').value;
            var taskStatus = document.getElementById('taskStatus').value;
            var taskDescription = document.getElementById('projcontent').innerHTML;
            var encodedDescription = btoa(taskDescription);

            var formData = new FormData();
            formData.append('proj_id', <?php echo json_encode($proj_id); ?>);
            formData.append('emp_id', <?php echo json_encode($userId); ?>);
            formData.append('task_name', taskName);
            formData.append('priority', taskPriority);
            formData.append('deadline', taskDeadline);
            formData.append('task_status', taskStatus);
            formData.append('task_description', encodedDescription);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'dbsaveTask.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log('Server response: ' + xhr.responseText);
                    if (xhr.responseText.includes('Task created successfully')) {
                        alert('Task created successfully');
                        $('#createTaskModal').modal('hide');
                        document.getElementById('taskName').value = '';
                        document.getElementById('taskPriority').value = 'Low';
                        document.getElementById('taskDeadline').value = '';
                        document.getElementById('taskStatus').value = 'Pending';
                        document.getElementById('projcontent').innerHTML = '';
                        location.reload();
                    } else {
                        alert('An error occurred while creating the task. Response: ' + xhr.responseText);
                    }
                } else {
                    alert('An error occurred while creating the task. Status: ' + xhr.status);
                    console.log('Error status: ' + xhr.status + ' - ' + xhr.statusText);
                }
            };
            xhr.onerror = function () {
                alert('An error occurred while sending the request.');
                console.log('Request error: ' + xhr.statusText);
            };
            xhr.send(formData);
        });

        document.getElementById('addProdBtn').addEventListener('click', showAddProductivityModal);

        function showAddProductivityModal() {
            const projectId = <?php echo json_encode($proj_id); ?>; 
            fetch(`db_fetchtasks.php?project_id=${projectId}`)
                .then(response => response.text())
                .then(text => {
                    try {
                        const tasks = JSON.parse(text);
                        populateTaskDropdown(tasks);
                    } catch (error) {
                        console.error('Error parsing JSON:', error, 'Response text:', text);
                    }
                })
                .catch(error => console.error('Error fetching tasks:', error));
        }

        document.getElementById('startTime').addEventListener('change', function () {
            var startTime = this.value;
            document.getElementById('endTime').min = startTime;
        });

        document.getElementById('endTime').addEventListener('change', function () {
            var endTime = this.value;
            var startTime = document.getElementById('startTime').value;

            if (endTime <= startTime) {
                alert("End time cannot be earlier than start time.");
                this.value = '';
            }
        });

        document.getElementById('saveProductivityButton').addEventListener('click', function () {
            var taskDropdown = document.getElementById('taskDropdown').value;
            var productivityDate = document.getElementById('productivityDate').value;
            var startTime = document.getElementById('startTime').value;
            var endTime = document.getElementById('endTime').value;
            var productivityDescription = document.getElementById('productivityDescription').innerHTML;
            var encodedDescription = btoa(productivityDescription);

            var formData = new FormData();
            formData.append('emp_id', <?php echo json_encode($userId); ?>);
            formData.append('task_id', taskDropdown);
            formData.append('date', productivityDate);
            formData.append('start_time', startTime);
            formData.append('end_time', endTime);
            formData.append('prod_description', encodedDescription);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'dbsave_productivity.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log('Server response: ' + xhr.responseText);
                    if (xhr.responseText.includes('Productivity saved successfully')) {
                        alert('Productivity saved successfully');
                        $('#addProductivityModal').modal('hide');
                        document.getElementById('addProductivityForm').reset();
                        document.getElementById('productivityDescription').innerHTML = '';
                        location.reload();
                    } else {
                        alert('An error occurred while saving productivity. Response: ' + xhr.responseText);
                    }
                } else {
                    alert('An error occurred while saving productivity. Status: ' + xhr.status);
                    console.log('Error status: ' + xhr.status + ' - ' + xhr.statusText);
                }
            };
            xhr.onerror = function () {
                alert('An error occurred while sending the request.');
                console.log('Request error: ' + xhr.statusText);
            };
            xhr.send(formData);
        });



    </script>
    <script src="containers/viewProject.js"></script>

</body>

</html>