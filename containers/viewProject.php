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
WHERE p.project_id = ?");
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Project</title>
    <link rel="stylesheet" href="styles/dashboard.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
                                <h5><strong>Team Members:</strong></h5>
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

                                    $stmt->close(); // Close the statement
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center top-border-box">
                                <h5><strong>Task List:</strong></h5>
                                <button class="btn btn-outline-primary btn-sm"><i class='bx bx-plus-circle'></i> New
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
                                        <tr>
                                            <td>1</td>
                                            <td class='project-column'>
                                                <div>
                                                    <div class='fw-bold fs-6'>Create This</div>
                                                    <div class='text-wrap text-muted small'>Lorem ipsum dolor sit amet.
                                                        Qui nobis dolorem aut odit minus id quaerat totam ut quae quod
                                                        quo adipisci libero ut neque sunt...</div>
                                            </td>
                                            <td><small>High</small></td>
                                            <td><small>In Progress</small></td>
                                            <td><small>May 20, 2024</small></td>
                                            <td><button class="btn btn-sm btn-outline-primary"><i
                                                        class='bx bx-edit'></i></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center border-none">
                    <h5><strong>Productivity Tracker:</strong></h5>
                    <button class="btn btn-outline-primary btn-sm"><i class='bx bx-plus-circle'></i> Add
                        Productivity</button>
                </div>
                <div class="card">
                    <!-- Productivity tracker content -->
                </div>
            </div>
        </section>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </div>
</body>

</html>