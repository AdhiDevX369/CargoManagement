<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';
require 'enckey.php';
$encryptedInvoiceId;

$response = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['action'])) {
    if ($_POST['action'] == 'sub') {
      $invoice_number = filter_input(INPUT_POST, 'invoice', FILTER_SANITIZE_STRING);
      $response = getInvoiceAllDetails($conn, $invoice_number);
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
  <title>Complete Invoice</title>
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
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Invoice Number</div>
                <hr>
                <form action="" method="post">
                  <div class="form-group">
                    <label for="input-1">Enter the invoice Number Here</label>
                    <input type="text" class="form-control" id="invoice" name="invoice" placeholder="Invoice Number" required>
                  </div>
                  <div class="form-group">
                    <button type="submit" name="action" value="sub" class="btn btn-light px-5"><i class="icon-lock"></i> Search</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div><!--End Row-->
        <div class="row mt-3">
          <div class="col-lg-10">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Invoice Details</h5>
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Invoice Number</th>
                        <th scope="col">Order ID</th>
                        <th scope="col">Location</th>
                        <th scope="col">Status</th>
                        <th scope="col">Total Payment</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if (!empty($response)) {
                        echo '<tr>';
                        $encryptedInvoiceId = encrypt($response['invoice_number'], $key);
                        echo '<td><a href="completeinvoice.php?invoice_number=' .  $encryptedInvoiceId . '">' . htmlspecialchars($response['invoice_number']) . '</a></td>';
                        echo '<td>' . htmlspecialchars($response['order_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($response['location']) . '</td>';
                        echo '<td>' . htmlspecialchars($response['status']) . '</td>';
                        echo '<td>' . htmlspecialchars($response['tot']) . '</td>';
                        echo '</tr>';
                      } else {
                        echo '<tr><td colspan="4">No invoice details found.</td></tr>';
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div><!--End of the row-->

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