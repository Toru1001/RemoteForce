<?php
include "dbConnect.php";

$empId = $_POST['emp_id'];

$sql = "SELECT e.empl_firstname, e.empl_lastname, e.email, e.position, d.department_name, e.password 
        FROM employees e
        INNER JOIN departments d ON e.department_id = d.department_id
        WHERE e.emp_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $empId);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$userData = mysqli_fetch_assoc($result);

echo json_encode($userData);

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>