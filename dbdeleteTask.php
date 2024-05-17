<?php
include "dbConnect.php";

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data['task_id'])) {
    $taskId = $data['task_id'];

    mysqli_begin_transaction($conn);

    try {
        $sql = "DELETE FROM productivitytracking WHERE task_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $taskId);
        mysqli_stmt_execute($stmt);

        $sql = "DELETE FROM tasks WHERE task_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $taskId);
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