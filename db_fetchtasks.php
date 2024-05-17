<?php
include 'dbConnect.php'; // Make sure to include your database connection

header('Content-Type: application/json');

$project_id = $_GET['project_id'];

if (!isset($project_id)) {
    echo json_encode(['status' => 'error', 'message' => 'Project ID is missing']);
    exit();
}

$sql = "SELECT task_id, task_name FROM tasks WHERE project_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'SQL prepare statement failed: ' . $conn->error]);
    exit();
}

$stmt->bind_param("i", $project_id);

if (!$stmt->execute()) {
    echo json_encode(['status' => 'error', 'message' => 'SQL execute failed: ' . $stmt->error]);
    exit();
}

$result = $stmt->get_result();

if (!$result) {
    echo json_encode(['status' => 'error', 'message' => 'SQL get_result failed: ' . $stmt->error]);
    exit();
}

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

echo json_encode($tasks);
?>