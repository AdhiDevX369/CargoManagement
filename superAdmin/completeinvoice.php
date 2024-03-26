<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';
require 'enckey.php';

$invoice = [];
$dueamt = 0.0;
$cuspaid = 0.0;
$encryptedInvoiceId;
$disabledAttribute = 'disabled';
if (isset($_GET['invoice_number'])) {
  $invoice_number = decrypt($_GET['invoice_number'], $key);
  $invoice = getInvoiceAllDetails($conn, $invoice_number);
  if ($invoice['status'] == "Completed") {
    $disabledAttribute = 'disabled';
  } else {
    $disabledAttribute = '';
  }
  if (isset($invoice['order_id'])) {
    $order_id = $invoice['order_id'];
    $dueamt = invoiceDueAmount($conn, $invoice_number, $order_id);
    $cuspaid = customerPaid($conn, $order_id);
  } else {
    $dueamt = 0.0;
  }
} else {
  $invoice = [];
  $dueamt = 0.0;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['action'])) {
    if ($_POST['action'] == 'com') {
      $orderId = filter_input(INPUT_POST, 'orderId', FILTER_SANITIZE_NUMBER_INT);
      $payment = filter_input(INPUT_POST, 'newpay', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
      $invoice = filter_input(INPUT_POST, 'invoice', FILTER_SANITIZE_STRING);
      $response = completeInvoice($conn, $invoice, $orderId, $payment);
      $message = $response ? "Successfully Completed the Order" : "Error Occurred";
      echo "<script>alert('{$message}'); window.location.href='completein.php';</script>";
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
  <title>Invoice Completion Details</title>
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
          <div class="col-lg-8">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Invoice Completion Details</div>
                <hr>
                <form method="post">
                  <div class="form-group">
                    <label for="input-1">Order Id</label>
                    <input type="text" class="form-control" name="orderId" value="<?php echo $invoice['order_id']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-1">Invoice Number</label>
                    <input type="text" class="form-control" name="invoice" id="invoice" value="<?php echo $invoice['invoice_number']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-1">Reciever Name</label>
                    <input type="text" class="form-control" value="<?php echo $invoice['rname']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-1">Payment Method</label>
                    <input type="text" class="form-control" value="<?php echo $invoice['pmethod']; ?>" readonly>
                    <div class="form-group">
                      <label for="input-3">Total Payment</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['tot']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Customer Paid</label>
                      <input type="number" class="form-control" value="<?php echo $cuspaid; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Due Payment</label>
                      <input type="number" class="form-control" value="<?php echo $dueamt; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">New Payment</label>
                      <input type="number" class="form-control" id="newpay" name="newpay" value="0" min="0" required>
                    </div>
                    <div class="form-group">
                      <button type="button" name="action" value="sub" class="btn btn-success px-3" onclick="window.location.href='completein.php';">
                        <i class="fas fa-arrow-left"></i> Back
                      </button>
                      <button type="submit" name="action" value="com" class="btn btn-info px-3" <?php echo $disabledAttribute; ?>>
                        <i class="fas fa-check-circle"></i> Complete Invoice
                      </button>
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