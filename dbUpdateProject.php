<?php
include "dbConnect.php";

$projId = $_POST['proj_id'];
$projectName = $_POST['project_name'];
$projectStatus = $_POST['project_status'];
$startDate = $_POST['start_date'];
$endDate = $_POST['end_date'];
$projectManager = $_POST['project_manager'];
$projDescription = $_POST['proj_description'];
$encoded = base64_encode($projDescription);

$sql = "UPDATE projects 
        SET project_name = ?, project_status = ?, start_date = ?, end_date = ?, project_manager = ?, proj_description = ?
        WHERE project_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssssisi", $projectName, $projectStatus, $startDate, $endDate, $projectManager, $encoded, $projId);

if (mysqli_stmt_execute($stmt)) {
    echo "Project updated successfully.";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>