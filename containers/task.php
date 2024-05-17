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
</head>

<body>
    <div class="body p-3">
        <section class="pageTitle1 p-3">
            <h2>Projects</h2>
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
                            <th scope="col">Date Started</th>
                            <th scope="col">Due Date</th>
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
                                    case 'Past-Due':
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
                                        <button type='button' class='btn btn-sm btn-outline-primary' data-bs-toggle='dropdown' aria-expanded='false'>
                                            <strong><i class='bx bx-dots-vertical'></i></strong>
                                        </button>
                                        <ul class='dropdown-menu'>
                                            <li><a id='taskviewbtn' class='taskviewbtn dropdown-item' href='#' data-task-id='" . $row['task_id'] . "'>View</a></li>
                                            <li><a id='taskeditbtn' class='taskeditbtn dropdown-item' href='#' data-task-id='" . $row['task_id'] . "'>Edit</a></li>
                                            <li><hr class='dropdown-divider'></li>
                                            <li><a id='taskdeletebtn' class='taskdeletebtn text-danger dropdown-item' href='#' data-task-id='" . $row['task_id'] . "'>Delete</a></li>
                                        </ul>
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>

</html>