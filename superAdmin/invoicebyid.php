<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';
require 'enckey.php';
$invoice = [];
if (isset($_GET['invoice_number'])) {
  $invoice_number = decrypt($_GET['invoice_number'], $key);
  $invoice = getInvoiceAllDetails($conn, $invoice_number);
} else {
  $invoice = [];
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
  <title>Invoice Details</title>
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
                <div class="card-title">Invoice Details</div>
                <hr>
                <form method="post">
                  <div class="form-group">
                    <label for="input-1">Order Id</label>
                    <input type="text" class="form-control" value="<?php echo $invoice['order_id']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-1">Invoice Number</label>
                    <input type="text" class="form-control" value="<?php echo $invoice['invoice_number']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-1">Customer Name</label>
                    <input type="text" class="form-control" value="<?php echo $invoice['cname']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-1">Payment Method</label>
                    <input type="text" class="form-control" value="<?php echo $invoice['pmethod']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-1">Reciever Name</label>
                    <input type="text" class="form-control" value="<?php echo $invoice['rname']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="input-2">Reciever Address</label>
                    <textarea class="form-control" readonly rows="5"><?php echo $invoice['raddress']; ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Reciever Contact Number</label>
                    <input type="text" class="form-control" value="<?php echo $invoice['rnum']; ?>" readonly>
                    <div class="form-group">
                      <label for="input-3">Recieve Method</label>
                      <input type="text" class="form-control" value="<?php echo $invoice['rmethod']; ?>" readonly>
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
                      <input type="number" class="form-control" value="<?php echo $invoice['ewdlarge']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Extra Large</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['ewdxlarge']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">1M</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['ewd1m']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">1.5M</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['ewd15m']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">2M/4X4</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['ewd2m']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">2.5M=6X4</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['ewd25m']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">3.5M=8X4</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['ewd35m']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">-----Empty Cartoon-----</label>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Small</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['ecsmall']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Medium</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['ecmedium']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Large</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['eclarge']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Jumbo</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['ecjumbo']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">XL</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['ecxl']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">-----Empty Trunk-----</label>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Small</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['etsmall']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Medium</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['etmedium']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Large</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['etlarge']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">XL</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['etxl']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">XXL</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['etxxl']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-4">Other Items</label>
                      <textarea class="form-control" readonly><?php echo $invoice['other']; ?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="input-3">-----Invoice Related Details-----</label>
                    </div>
                    <div class="form-group">
                      <label for="input-5">Kuwait warehouse Recieved Date</label>
                      <input type="text" class="form-control" value="<?php echo $invoice['recievedate']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-5">Shipping Date</label>
                      <input type="text" class="form-control" value="<?php echo $invoice['shippingdate']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-1">Shipping company</label>
                      <input type="text" class="form-control" value="<?php echo $invoice['shippingcompany']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Total Packages</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['totalpackages']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Total Volume</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['totalvolume']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Total Weight</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['totalweight']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Total Value</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['totalvalue']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Freight charges</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['freightcharges']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Handling charges</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['handlingcharges']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Door to door charges</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['d2dcharges']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Domestic Charges</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['domesticcharges']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Insurance Charges</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['insurancecharges']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Tax</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['tax']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Total Payment</label>
                      <input type="number" class="form-control" value="<?php echo $invoice['tot']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <button type="button" name="action" value="sub" class="btn btn-success px-3" onclick="window.location.href='allinvoices.php';">
                        <i class="fas fa-arrow-left"></i> Back
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