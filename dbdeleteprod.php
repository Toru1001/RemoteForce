<?php
include "dbConnect.php";

if (isset($_POST['tracking_id'])) {
    $prod_id = $_POST['tracking_id'];

    $stmt = $conn->prepare("DELETE FROM productivitytracking WHERE tracking_id = ?");
    $stmt->bind_param("i", $prod_id);

    if ($stmt->execute()) {
        echo "Productivity entry deleted successfully";
    } else {
        echo "Error deleting productivity entry: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "prod_id parameter is required";
}

$conn->close();
?>