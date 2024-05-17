<?php
include "dbConnect.php";

if (isset($_GET['taskId'])) {
    $taskId = $_GET['taskId'];

    $stmt = $conn->prepare("SELECT t.*, CONCAT(e.empl_firstname, ' ', e.empl_lastname) AS creator_name 
                            FROM tasks t 
                            INNER JOIN employees e ON t.emp_id = e.emp_id 
                            WHERE t.task_id = ?");
    $stmt->bind_param("i", $taskId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $taskDetails = $result->fetch_assoc();
        echo json_encode($taskDetails);
    } else {
        http_response_code(404);
        echo "Task not found.";
    }
} else {
    http_response_code(400);
    echo "Task ID is required.";
}
$stmt->close();
$conn->close();
?>