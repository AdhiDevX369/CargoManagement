<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'dbconfig.php';
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $sql = "SELECT id, username, password FROM superuserrr WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {

            $_SESSION['superuser'] = $username;
            header("Location: index.php");
            exit();
        } else {

            $_SESSION['error'] = 'Incorrect username or password.';
            header("Location: login.php");
            exit();
        }
    } else {

        $_SESSION['error'] = 'Incorrect username or password.';
        header("Location: login.php");
        exit();
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Super Admin Login</title>
    <?php include 'css.php'; ?>
</head>

<body class="bg-theme bg-theme1">
    <div id="wrapper">
        <div class="card card-authentication1 mx-auto my-5">
            <div class="card-body">
                <div class="card-content p-2">
                    <div class="text-center">
                        <img src="assets/images/logo-icon.webp" alt="logo icon">
                    </div>
                    <div class="card-title text-uppercase text-center py-3">Sign In</div>
                    <?php

                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    }
                    ?>
                    <form action="login.php" method="post">
                        <div class="form-group">
                            <label for="exampleInputUsername" class="sr-only">Username</label>
                            <div class="position-relative has-icon-right">
                                <input type="text" id="username" name="username" class="form-control input-shadow" placeholder="Enter Username" required>
                                <div class="form-control-position">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword" class="sr-only">Password</label>
                            <div class="position-relative has-icon-right">
                                <input type="password" id="password" name="password" class="form-control input-shadow" placeholder="Enter Password" required>
                                <div class="form-control-position">
                                    <i class="icon-lock"></i>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-light btn-block">Sign In</button>
                        <button type="reset" class="btn btn-light btn-block">Reset</button>
                    </form>
                </div>
            </div>
        </div>
        <!--start color switcher-->
        <?php include 'colorswitch.php'; ?>
        <!--end color switcher-->
    </div>
    <!-- Include your JS here -->
    <?php include 'js.php'; ?>
</body>

</html>