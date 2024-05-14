<?php
include "dbConnect.php";

$projId = $_POST['proj_id'];

$sql = "SELECT p.project_name, p.start_date, p.end_date, p.project_manager, p.project_status, p.proj_description 
        FROM projects p 
        INNER JOIN employees e ON p.project_manager = e.emp_id
        WHERE p.project_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $projId);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$userData = mysqli_fetch_assoc($result);

echo json_encode($userData);

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>