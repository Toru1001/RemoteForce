<?php
include "dbConnect.php";

if (isset($_POST['emp_id'])) {
    $empId = $_POST['emp_id'];

    $sqlUpdateProjects = "UPDATE projects SET project_manager = NULL WHERE project_manager = ?";
    $stmtUpdateProjects = mysqli_prepare($conn, $sqlUpdateProjects);
    mysqli_stmt_bind_param($stmtUpdateProjects, "i", $empId);

    $sqlRemoveProjectMembers = "DELETE FROM project_members WHERE emp_id = ?";
    $stmtRemoveProjectMembers = mysqli_prepare($conn, $sqlRemoveProjectMembers);
    mysqli_stmt_bind_param($stmtRemoveProjectMembers, "i", $empId);

    $sqlRemoveEmployee = "DELETE FROM employees WHERE emp_id = ?";
    $stmtRemoveEmployee = mysqli_prepare($conn, $sqlRemoveEmployee);
    mysqli_stmt_bind_param($stmtRemoveEmployee, "i", $empId);

    $success = true;

    if (!mysqli_stmt_execute($stmtUpdateProjects)) {
        $success = false;
        echo "Error updating projects: " . mysqli_error($conn);
    }

    if (!mysqli_stmt_execute($stmtRemoveProjectMembers)) {
        $success = false;
        echo "Error removing data from project_members: " . mysqli_error($conn);
    }

    if ($success) {
        if (mysqli_stmt_execute($stmtRemoveEmployee)) {
            echo "User deleted successfully";
        } else {
            echo "Error removing data from employees: " . mysqli_error($conn);
        }
    }
    mysqli_stmt_close($stmtUpdateProjects);
    mysqli_stmt_close($stmtRemoveProjectMembers);
    mysqli_stmt_close($stmtRemoveEmployee);
} else {
    echo "Employee ID is missing";
}

mysqli_close($conn);
?>