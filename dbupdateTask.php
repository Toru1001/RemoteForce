<?php
include "dbConnect.php";

if (
    isset($_POST['taskId']) &&
    isset($_POST['taskName']) &&
    isset($_POST['taskPriority']) &&
    isset($_POST['taskDeadline']) &&
    isset($_POST['taskStatus']) &&
    isset($_POST['taskDescription'])
) {
    $taskId = $_POST['taskId'];
    $taskName = $_POST['taskName'];
    $taskPriority = $_POST['taskPriority'];
    $taskDeadline = $_POST['taskDeadline'];
    $taskStatus = $_POST['taskStatus'];
    $taskDescription = $_POST['taskDescription'];

    $stmt = $conn->prepare("UPDATE tasks SET task_name = ?, priority = ?, task_status = ?, deadline = ?, task_description = ? WHERE task_id = ?");
    $stmt->bind_param("sssssi", $taskName, $taskPriority, $taskStatus, $taskDeadline, $taskDescription, $taskId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo 'Task updated successfully';
    } else {
        echo 'Failed to update task';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'Incomplete data received';
}
?>