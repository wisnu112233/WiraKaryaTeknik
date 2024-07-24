<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
session_start(); // Start session management

if (isset($_POST['user_login'])) {
    $user_username = $_POST['user_username'];
    $user_password = $_POST['user_password'];

    // Fetch user data from the database
    $select_query = "SELECT * FROM user_table WHERE username='$user_username'";
    $select_result = mysqli_query($con, $select_query);
    $row_data = mysqli_fetch_assoc($select_result);
    $row_count = mysqli_num_rows($select_result);

    if ($row_count > 0 && password_verify($user_password, $row_data['user_password'])) {
        // User authentication successful
        $_SESSION['username'] = $user_username;

        // Redirect to main menu page
        header('Location: http://localhost/WKT/index.php');
        exit(); // Stop further script execution after redirection
    } else {
        // Invalid credentials
        echo "<script>alert('Invalid Credentials')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wira Karya Teknik User Login Page</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
</head>
<body>
    <div class="register">
        <div class="container py-3">
            <h2 class="text-center mb-4">User Login</h2>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <form action="" method="post" class="d-flex flex-column gap-4">
                        <!-- username field  -->
                        <div class="form-outline">
                            <label for="user_username" class="form-label">Username</label>
                            <input type="text" placeholder="Enter your username" autocomplete="off" required="required" name="user_username" id="user_username" class="form-control">
                        </div>
                        <!-- password field  -->
                        <div class="form-outline">
                            <label for="user_password" class="form-label">Password</label>
                            <input type="password" placeholder="Enter your password" autocomplete="off" required="required" name="user_password" id="user_password" class="form-control">
                        </div>
                        <div><a href="" class="text-decoration-underline">Forget your password?</a></div>
                        <div>
                            <input type="submit" value="Login" class="btn btn-primary mb-2" name="user_login">
                            <p>
                                Don't have an account? <a href="user_registration.php" class="text-primary text-decoration-underline"><strong>Register</strong></a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/bootstrap.bundle.js"></script>
</body>
</html>
