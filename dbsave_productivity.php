<?php
include "dbConnect.php";

if (
    isset($_POST['task_id']) &&
    isset($_POST['emp_id']) &&
    isset($_POST['date']) &&
    isset($_POST['start_time']) &&
    isset($_POST['end_time']) &&
    isset($_POST['prod_description'])
) {
    $task_id = $_POST['task_id'];
    $emp_id = $_POST['emp_id'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $prod_description = $_POST['prod_description'];

    $stmt = $conn->prepare("INSERT INTO productivitytracking (task_id, emp_id, date, start_time, end_time, prod_description) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $task_id, $emp_id, $date, $start_time, $end_time, $prod_description);  // Corrected type string

    if ($stmt->execute()) {
        echo "Productivity saved successfully";
    } else {
        echo "Error saving productivity: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "All parameters are required";
}

$conn->close();
?>