<?php
include "dbConnect.php";

if (isset($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['position'], $_POST['department'])) {

    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $department = $_POST['department'];

    $sql = "INSERT INTO employees (empl_firstname, empl_lastname, email, password, position, department_id) 
            VALUES ('$firstname', '$lastname', '$email', '$password', '$position', '$department')";

    if (mysqli_query($conn, $sql)) {
        echo "User created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);

    }
} else {
    echo "All form fields are required";
}

mysqli_close($conn);
?>