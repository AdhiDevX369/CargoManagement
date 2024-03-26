<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';
$apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MTI5ODYsImN1c3RvbWVyX3JvbGUiOjAsImlhdCI6MTcwODE4NzE4MiwiZXhwIjo0ODMyMzg5NTgyfQ.CuVDT-RxUyzCc__XonDZV6G63VBM_bF1mGroNEjWnV4"; // Replace with your actual API key
$balance = checkBalance($apiKey);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['action'])) {
    if ($_POST['action'] == 'sub') {
      $phone = filter_input(INPUT_POST, 'pnum', FILTER_SANITIZE_NUMBER_INT);
      $message = filter_input(INPUT_POST, 'msg', FILTER_SANITIZE_STRING);
      $sourceAddress = "KuwaitLanka";

      $response = sendMessage($apiKey, $phone, $message, $sourceAddress);
      echo "<script>alert('{$response}'); window.location.href='sms.php';</script>";
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Send SMS</title>
  <!--INCLUDING CSS-->
  <?php include 'css.php'; ?>
</head>

<body class="bg-theme bg-theme1">

  <!-- start loader -->
  <div id="pageloader-overlay" class="visible incoming">
    <div class="loader-wrapper-outer">
      <div class="loader-wrapper-inner">
        <div class="loader"></div>
      </div>
    </div>
  </div>
  <!-- end loader -->

  <!-- Start wrapper-->
  <div id="wrapper">

    <?php include 'sidebar.php'; ?>

    <!--Start topbar header-->
    <?php include 'topbar.php'; ?>
    <!--End topbar header-->

    <div class="clearfix"></div>

    <div class="content-wrapper">
      <div class="container-fluid">

        <div class="row mt-3">
          <div class="col-lg-10">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Send SMS</div>
                <hr>
                <form action="" method="post">
                  <div class="form-group">
                    <label for="input-1">Balance</label>
                    <input type="text" class="form-control" value="<?php echo $balance; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-2">Phone Number</label>
                    <input type="number" class="form-control" id="pnum" name="pnum" placeholder="076XXXXXXX" required>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Message</label>
                    <textarea class="form-control" id="msg" name="msg" placeholder="Enter Your Message" rows="3" required></textarea>
                  </div>
                  <div class="form-group">
                    <button type="submit" name="action" value="sub" class="btn btn-primary px-3"><i class="fas fa-paper-plane"></i> Send</button>
                    <button type="reset" class="btn btn-danger px-3"><i class="fas fa-undo"></i> Reset</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div><!--End Row-->

        <!--start overlay-->
        <div class="overlay toggle-menu"></div>
        <!--end overlay-->

      </div>
      <!-- End container-fluid-->

    </div><!--End content-wrapper-->
    <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->

    <!--Start footer-->
    <?php include 'footer.php'; ?>
    <!--End footer-->


    <!--start color switcher-->
    <?php include 'colorswitch.php'; ?>
    <!--end color switcher-->

  </div><!--End wrapper-->


  <!---INCLUDEING JS-->
  <?php include 'js.php'; ?>

</body>

</html>