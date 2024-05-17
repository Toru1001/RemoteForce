<?php
include "dbConnect.php";

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data['project_id'])) {
    $projectId = $data['project_id'];

    mysqli_begin_transaction($conn);

    try {
        $sql = "DELETE FROM project_members WHERE project_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $projectId);
        mysqli_stmt_execute($stmt);

        $sql = "DELETE FROM productivitytracking WHERE task_id IN (SELECT task_id FROM tasks WHERE project_id = ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $projectId);
        mysqli_stmt_execute($stmt);

        $sql = "DELETE FROM tasks WHERE project_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $projectId);
        mysqli_stmt_execute($stmt);

        $sql = "DELETE FROM projects WHERE project_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $projectId);
        mysqli_stmt_execute($stmt);

        mysqli_commit($conn);

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    mysqli_close($conn);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>