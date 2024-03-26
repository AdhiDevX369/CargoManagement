<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';
require 'enckey.php';

$orderId = decrypt($_GET['order_Id'], $key);
$results = singleUserDetails($conn, $orderId);
$invoice = getInvoiceDetails($conn, $orderId);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Order Details</title>
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
                <div class="card-title">Order Details</div>
                <hr>
                <form method="post">
                  <div class="form-group">
                    <label for="input-1">Order ID</label>
                    <input type="text" class="form-control" value="<?php echo $results['order_Id']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-1">Invoice Number</label>
                    <input type="text" class="form-control" id="input-1" value="<?php echo isset($invoice['invoice_number']) && $invoice['invoice_number'] !== null ? htmlspecialchars($invoice['invoice_number']) : 'Not Yet Assigned'; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Order Method</label>
                    <input type="text" class="form-control" value="<?php echo $results['method']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-1">Customer Name</label>
                    <input type="text" class="form-control" value="<?php echo $results['customer_Name']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-2">Customer Address</label>
                    <textarea class="form-control" readonly rows="5"><?php echo htmlspecialchars($results['customer_address']); ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Customer Contact Number</label>
                    <input type="text" class="form-control" value="<?php echo $results['customer_contactNo']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-4">Customer Passport Number</label>
                    <input type="text" class="form-control" value="<?php echo $results['passport']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-5">Pickup Date</label>
                    <input type="text" class="form-control" value="<?php echo $results['pickup_date']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-5">Pickup Driver</label>
                    <input type="text" class="form-control" value="<?php echo $results['pickup_driver']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-5">Delivery Date</label>
                    <input type="text" class="form-control" value="<?php echo $results['delivery_date'] ? htmlspecialchars($results['delivery_date']) : 'Not Applicable'; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-5">Delivery Driver</label>
                    <input type="text" class="form-control" value="<?php echo $results['delivery_driver'] ? htmlspecialchars($results['delivery_driver']) : 'Not Applicable'; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-5">Payment Method</label>
                    <input type="text" class="form-control" value="<?php echo $results['payment_method']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-1">Reciever Name</label>
                    <input type="text" class="form-control" value="<?php echo $results['receiver_name']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-2">Reciever Address</label>
                    <textarea class="form-control" readonly rows="5"><?php echo htmlspecialchars($results['receiver_address']); ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Reciever Contact Number</label>
                    <input type="text" class="form-control" value="<?php echo $results['receiver_contactNo']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Receive Method</label>
                    <input type="text" class="form-control" value="<?php echo $results['receiving_method']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Total Payment</label>
                    <input type="number" class="form-control" value="<?php echo $results['total_payment']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Order Status</label>
                    <input type="text" class="form-control" value="<?php echo $results['status']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-2">Order Remarks</label>
                    <textarea class="form-control" readonly rows="5"><?php echo htmlspecialchars($results['remarks']); ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Delivery Status</label>
                    <input type="text" class="form-control" value="<?php echo $results['delivery_status'] ? htmlspecialchars($results['delivery_status']) : 'Not Applicable'; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Pickup Status</label>
                    <input type="text" class="form-control" value="<?php echo $results['pickup_status']; ?>" readonly>
                  </div>
                  <hr>
                  <hr>
                  <div class="form-group">
                    <label for="input-3">Box/Packages</label>
                  </div>
                  <div class="form-group">
                    <label for="input-3">-----Empty wood box-----</label>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Large</label>
                    <input type="number" class="form-control" value="<?php echo $results['ewdlarge']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Extra Large</label>
                    <input type="number" class="form-control" value="<?php echo $results['ewdxlarge']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">1M</label>
                    <input type="number" class="form-control" value="<?php echo $results['ewd1m']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">1.5M</label>
                    <input type="number" class="form-control" value="<?php echo $results['ewd15m']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">2M/4X4</label>
                    <input type="number" class="form-control" value="<?php echo $results['ewd2m']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">2.5M=6X4</label>
                    <input type="number" class="form-control" value="<?php echo $results['ewd25m']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">3.5M=8X4</label>
                    <input type="number" class="form-control" value="<?php echo $results['ewd35m']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">-----Empty Cartoon-----</label>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Small</label>
                    <input type="number" class="form-control" value="<?php echo $results['ecsmall']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Medium</label>
                    <input type="number" class="form-control" value="<?php echo $results['ecmedium']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Large</label>
                    <input type="number" class="form-control" value="<?php echo $results['eclarge']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Jumbo</label>
                    <input type="number" class="form-control" value="<?php echo $results['ecjumbo']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">XL</label>
                    <input type="number" class="form-control" value="<?php echo $results['ecxl']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">-----Empty Trunk-----</label>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Small</label>
                    <input type="number" class="form-control" value="<?php echo $results['etsmall']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Medium</label>
                    <input type="number" class="form-control" value="<?php echo $results['etmedium']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Large</label>
                    <input type="number" class="form-control" value="<?php echo $results['etlarge']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">XL</label>
                    <input type="number" class="form-control" value="<?php echo $results['etxl']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-3">XXL</label>
                    <input type="number" class="form-control" value="<?php echo $results['etxxl']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <button type="button" class="btn btn-success px-3" onclick="window.location.href='allorders.php';"><i class="fas fa-arrow-left"></i> Back</button>
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