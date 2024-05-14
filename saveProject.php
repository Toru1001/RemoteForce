<?php
include "dbConnect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $projectName = $_POST['project_name'];
    $status = $_POST['status'];
    $startDate = $_POST['startdate'];
    $endDate = $_POST['enddate'];
    $projectManager = $_POST['projectmanager'];
    $projectDescription = $_POST['projectDescription'];
    $members = $_POST['members'];

    if (empty($projectName) || empty($status) || empty($startDate) || empty($endDate) || empty($projectManager) || empty($projectDescription)) {
        echo "All fields are required.";
        exit();
    }

    $sql = "INSERT INTO projects (project_name, project_status, start_date, end_date, project_manager, proj_description) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("ssssss", $projectName, $status, $startDate, $endDate, $projectManager, $projectDescription);

    if ($stmt->execute()) {
        $projectId = $stmt->insert_id;
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO project_members (project_id, emp_id) VALUES (?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        foreach ($members as $member) {
            $stmt->bind_param("ii", $projectId, $member);
            $stmt->execute();
        }

        echo "Project saved successfully!";
    } else {
        echo "Error: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>