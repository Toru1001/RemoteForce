<?php
include "dbConnect.php";

// Check if all required parameters are provided
if (
    isset($_POST['proj_id']) &&
    isset($_POST['emp_id']) &&
    isset($_POST['task_name']) &&
    isset($_POST['priority']) &&
    isset($_POST['deadline']) &&
    isset($_POST['task_status']) &&
    isset($_POST['task_description'])
) {
    $proj_id = $_POST['proj_id'];
    $emp_id = $_POST['emp_id'];
    $task_name = $_POST['task_name'];
    $priority = $_POST['priority'];
    $deadline = $_POST['deadline'];
    $task_status = $_POST['task_status'];
    $task_description = $_POST['task_description'];

    $stmt = $conn->prepare("INSERT INTO tasks (project_id, emp_id, task_name, priority, deadline, task_status, task_description) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisssss", $proj_id, $emp_id, $task_name, $priority, $deadline, $task_status, $task_description);

    if ($stmt->execute()) {
        echo "Task created successfully";
    } else {
        echo "Error creating task: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "All parameters are required";
}

$conn->close();
?>