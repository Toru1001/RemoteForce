<?php
include "dbConnect.php";

$sqlProjects = "SELECT COUNT(*) AS total_projects FROM projects";
$resultProjects = mysqli_query($conn, $sqlProjects);
$rowProjects = mysqli_fetch_assoc($resultProjects);
$totalProjects = $rowProjects['total_projects'];

$sqlEmployees = "SELECT COUNT(*) AS total_employees FROM employees WHERE position = 'Employee' OR position = 'Project Manager' ";
$resultEmployees = mysqli_query($conn, $sqlEmployees);
$rowEmployees = mysqli_fetch_assoc($resultEmployees);
$totalEmployees = $rowEmployees['total_employees'];

$sqlTasks = "SELECT COUNT(*) AS total_tasks FROM tasks";
$resultTasks = mysqli_query($conn, $sqlTasks);
$rowTasks = mysqli_fetch_assoc($resultTasks);
$totalTasks = $rowTasks['total_tasks'];

$sqlCompletedProjects = "SELECT COUNT(*) AS completed_projects FROM projects WHERE project_status = 'Completed'";
$resultCompletedProjects = mysqli_query($conn, $sqlCompletedProjects);
$rowCompletedProjects = mysqli_fetch_assoc($resultCompletedProjects);
$completedProjects = $rowCompletedProjects['completed_projects'];

$sqlProjects = "SELECT p.project_id, p.project_name, p.start_date, p.end_date, p.project_status, 
                    COUNT(t.task_id) AS total_tasks,
                    SUM(CASE WHEN t.task_status = 'Completed' THEN 1 ELSE 0 END) AS completed_tasks
                FROM projects p
                LEFT JOIN tasks t ON p.project_id = t.project_id
                GROUP BY p.project_id";
$resultProjects = mysqli_query($conn, $sqlProjects);

$sqlAdmin = "SELECT empl_firstname, empl_lastname FROM employees WHERE position = 'Administrator'";
$resultAdmin = mysqli_query($conn, $sqlAdmin);
$rowAdmin = mysqli_fetch_assoc($resultAdmin);
$adminName = $rowAdmin['empl_firstname'] . ' ' . $rowAdmin['empl_lastname'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/styles/dashboard.css">
</head>

<body>
    <div class="body p-3">
        <section class="pageTitle p-3">
            <h1>Dashboard</h1>
        </section>

        <div class="separator"></div>

        <section class="subh">
            <h5 class="p-3">Welcome <?php echo $adminName; ?>!</h5>
        </section>

        <section class="summary p-3">
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Projects</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalProjects; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="lni lni-folder" id="icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Employees</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalEmployees; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class='bx bxs-user' id="icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Tasks</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalTasks; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class='bx bx-list-ul' id="icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Completed Projects</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $completedProjects; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class='bx bxs-check-square' id="icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="projects">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body font-weight-bold p-3">
                    Project Progress
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Project</th>
                            <th scope="col">Progress</th>
                            <th scope="col">Due Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($resultProjects) > 0) {
                            while ($row = mysqli_fetch_assoc($resultProjects)) {
                                $completionPercentage = ($row['total_tasks'] > 0) ? ($row['completed_tasks'] / $row['total_tasks']) * 100 : 0;
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $row['project_id']; ?></th>
                                    <td><?php echo $row['project_name']; ?></td>
                                    <td>
                                        <div class="progress" role="progressbar" aria-label="Progress"
                                            aria-valuenow="<?php echo $completionPercentage; ?>" aria-valuemin="0"
                                            aria-valuemax="100">
                                            <div class="progress-bar <?php echo ($completionPercentage <= 25) ? 'bg-danger' : (($completionPercentage <= 50) ? 'bg-warning' : (($completionPercentage <= 75) ? 'bg-info' : 'bg-success')); ?>"
                                                style="width: <?php echo $completionPercentage; ?>%">
                                                <?php echo ($completionPercentage == 0) ? '0%' : round($completionPercentage) . '%'; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo date('m/d/Y', strtotime($row['end_date'])); ?></td>
                                    <td><?php
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

                                    ?>
                                        <span class="badge rounded-pill <?php echo $badgeClass; ?>"><?php echo $stats; ?></span>
                                    </td>
                                    <td><button type="button" class="btn btn-outline-primary"
                                            onclick="window.location.href = '?page=viewproject&id=<?php echo base64_encode($row['project_id']); ?>'">View</button>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6">No projects found</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>

</html>
<?php
mysqli_close($conn);
?>
