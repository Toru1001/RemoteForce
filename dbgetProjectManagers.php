<?php
include "dbConnect.php";

$sql = "SELECT emp_id, empl_firstname, empl_lastname FROM employees";
$result = $conn->query($sql);

$managers = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $managers[] = $row;
    }
} else {
    $managers[] = array("emp_id" => "", "empl_firstname" => "No", "empl_lastname" => "members available");
}

echo json_encode($managers);

$conn->close();
?>