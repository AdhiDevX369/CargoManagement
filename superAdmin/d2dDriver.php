<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';
$localdrivers = localdriverdetails($conn);

 $invoiceNumber="";
if (isset($_GET['invoice_number'])) {
  $invoiceNumber = filter_input(INPUT_GET, 'invoice_number', FILTER_SANITIZE_STRING);
  $invoice = getInvoiceAllDetails($conn, $invoiceNumber);
} else {
  $invoiceNumber = null;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['action'])) {
    if ($_POST['action'] == 'sub') {
      $driver = filter_input(INPUT_POST, 'ddriver', FILTER_SANITIZE_STRING);
      if (assignDriver($conn, $invoiceNumber, $driver)) {
        echo "<script>alert('Succesfully Updated'); window.location.href='doortodoor.php';</script>";
      }
      else {
        echo "<script>alert('An error ocurred,Try again!'); window.location.href='doortodoor.php';</script>";
      }
      
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
  <title>Assign Door To Door Driver</title>
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
                <div class="card-title">Assign A Door to Door Driver</div>
                <hr>
                <form action="" method="post">
                  <div class="form-group">
                    <label for="input-1">Invoice ID</label>
                    <input type="text" class="form-control" value="<?php echo $invoice['invoice_number']; ?>" name="invoice" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-2">Order ID</label>
                    <input type="number" class="form-control" id="order" value="<?php echo $invoice['order_id']; ?>" name="order" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Reciever's Address</label>
                    <textarea class="form-control" id="raddress" name="raddress" rows="3" readonly><?php echo htmlspecialchars($invoice['raddress']); ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Door to Door Driver</label>
                    <select class="form-control" id="ddriver" name="ddriver" required>
                      <option value="">Please Select a Driver</option>
                      <?php
                      foreach ($localdrivers as $driver) {
                        echo '<option value="' . htmlspecialchars($driver['username']) . '">' . htmlspecialchars($driver['username']) . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <button type="submit" name="action" value="sub" class="btn btn-success px-3"><i class="fas fa-user-plus"></i> Assign</button>
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