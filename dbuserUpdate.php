<?php
include "dbConnect.php";

$empId = $_POST['emp_id'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$position = $_POST['position'];
$department = $_POST['department'];
$password = $_POST['password'];

echo "Emp ID: " . $empId . "<br>";
echo "First Name: " . $firstname . "<br>";
echo "Last Name: " . $lastname . "<br>";
echo "Email: " . $email . "<br>";
echo "Position: " . $position . "<br>";
echo "Department: " . $department . "<br>";
echo "Password: " . $password . "<br>";

$sql = "UPDATE employees SET empl_firstname = '$firstname', empl_lastname = '$lastname', email = '$email',";

if ($position !== '0' && $position !== null) {
    $sql .= " position = '$position',";
}

if ($department !== '0' && $department !== null) {
    $sql .= " department_id = '$department',";
}

if (!empty($password)) {
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    $sql .= " password = '$password_hashed',";
}

$sql = rtrim($sql, ',');
$sql .= " WHERE emp_id = '$empId'";

echo "SQL query: " . $sql . "<br>";

if (mysqli_query($conn, $sql)) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>