<?php
session_start();
include 'dbConnect.php';


if (isset($_POST['submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepare the statement to select user details
        $stmt = $conn->prepare("SELECT emp_id, password, position FROM employees WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($emp_id, $hashed_password, $position);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Check if the position is 'Administrator'
                if ($position == 'Administrator') {
                    $_SESSION['user_id'] = $emp_id;
                    header('Location: main.php');
                } else {
                    $message['message'] = "Employee page not available.";
                }
            } else {
                $message['message'] = "Invalid email or password.";
            }
        } else {
            $message['message'] = "Invalid email or password.";
        }

        $stmt->close();
        $conn->close();
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remote Force: Sign-In</title>
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="styles/login.css">
</head>

<body>
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<div class="error-message">' . $message . '</div>';
        }
    }
    ?>
    <div class="containers">

        <div class="forms-container">
            <div class="signin-signup">
                <form action="" class="sign-in-form" method="post" enctype="multipart/form-data">
                    <?php
                    if (isset($message)) {
                        if (is_array($message) || is_object($message)) {
                            foreach ($message as $msg) {
                                echo '<div class="error-message">' . $msg . '</div>';
                            }
                        } else {
                            echo '<div class="error-message">' . $message . '</div>';
                        }
                    }
                    ?>
                    <h2 class="title">Sign in</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>

                    <input name="submit" type="submit" value="Login" class="btn solid">
                </form>


                <form action="" class="sign-up-form" method="post" enctype="multipart/form-data">
                    <h2 class="title">Sign up</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="firstname" placeholder="Firstname" required>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="lastname" placeholder="Lastname" required>
                    </div>
                    <div class="input-field">
                        <i class='bx bx-user icons'></i>

                        <input type="text" name="username" placeholder="Username" required>
                    </div>
                    <div class="input-field">
                        <i class='bx bxs-envelope icons'></i>
                        <input type="text" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-field">
                        <i class='bx bxs-lock-alt icons'></i>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="input-field">
                        <i class='bx bxs-lock-alt icons'></i>
                        <input type="password" name="repassword" placeholder="Re-enter Password" required>
                    </div>
                    <h5>Select Profile Picture:</h5>
                    <div class="input-field">
                        <i class='bx bxs-camera'></i>
                        <input name="img" type="file" class="file-container" accept="image/jpg, image/jpeg, image/png"
                            required>
                    </div>
                    <input type="submit" name="regsubmit" value="Login" class="btn solid">
                </form>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>New Here?</h3>
                    <p>"RemoteForce: The ultimate solution for seamless remote work management. Stay effortlessly
                        organized and productive with our intuitive task management interface, simplifying your
                        workflow."</p>
                    <!-- <button class="btn transparent" id="sign-up-btn">Sign Up</button> -->
                </div>
                <img src="img/logo.png" class="image" alt="">
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Already have an account?</h3>
                    <p>"TaskHub: Your go-to solution for effortless task management, keeping you organized and
                        productive with a simple and intuitive to-do list interface."</p>
                    <button class="btn transparent" id="sign-in-btn">Sign In</button>
                </div>
                <img src="img/logo.png" class="image" alt="">
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>