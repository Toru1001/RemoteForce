<?php
include "dbConnect.php";

if (isset($_POST['emp_id'])) {
    $empId = $_POST['emp_id'];

    $sql = "DELETE FROM employees WHERE emp_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $empId);

    if (mysqli_stmt_execute($stmt)) {
        echo "User deleted successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Employee ID is missing";
}

mysqli_close($conn);
?>