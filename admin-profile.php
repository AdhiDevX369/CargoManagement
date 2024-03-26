<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include "css.php"; 
    include "DB/dbconfig.php"; 
    session_start(); 
    $userId = $username = $fname = $lname = $tele = $address = "";

    if (isset($_SESSION['username'])) {
        $stmt = $conn->prepare("SELECT user_id, username, fname, lname, tele, address FROM user WHERE username = ?");
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userId = $row['user_id'];
            $username = $row['username'];
            $fname = $row['fname'];
            $lname = $row['lname'];
            $tele = $row['tele'];
            $address = $row['address'];
        }
        $stmt->close();
    }
    ?>
    <title>Admin Profile</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="sidebar-expand">
    <?php include "header.php"; ?>

    <!-- MAIN CONTENT -->
    <div class="main">
        <div class="main-content user">
            <div class="row">
                <div class="col-md-6">
                    <form>
                        <div class="mb-3">
                            <label for="userId" class="form-label">User ID</label>
                            <input type="text" class="form-control" id="userId" value="<?php echo $userId; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" value="<?php echo $username; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" value="<?php echo $fname; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" value="<?php echo $lname; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="telephone" class="form-label">Telephone Number</label>
                            <input type="tel" class="form-control" id="telephone" value="<?php echo $tele; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" rows="3" readonly><?php echo $address; ?></textarea>
                        </div>
                    </form>
                </div>
                <!-- Additional code can be placed here -->
            </div>
        </div>
    </div>
    <div class="overlay"></div>

    <!-- SCRIPT AND LIBRARY INCLUDES -->
     <!--script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script-->
     <script src="libs/jquery/jquery.min.js"></script>
    <script src="libs/jquery/jquery-ui.min.js"></script>
    <script src="libs/moment/min/moment.min.js"></script>
    <script src="libs/apexcharts/apexcharts.js"></script>
    <script src="libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="libs/peity/jquery.peity.min.js"></script>
    <script src="libs/chart.js/Chart.bundle.min.js"></script>
    <script src="libs/owl.carousel/owl.carousel.min.js"></script>
    <script src="libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="libs/bootstrap-datepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script src="js/countto.js"></script>
    <script src="libs/date-picker/datepicker.js"></script>
    <script src="libs/rating/js/custom-ratings.js"></script>
    <script src="libs/rating/js/jquery.barrating.js"></script>
    <script src="libs/circle-progress/circle-progress.min.js"></script>
    <script src="libs/simplebar/simplebar.min.js"></script>

    <!-- APP JS -->
    <script src="js/main.js"></script>
    <script src="js/shortcode.js"></script>
    <script src="js/pages/datepicker.js"></script>
    <script src="js/pages/chart-circle.js"></script>
</body>
</html>
