<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';

$drivers = getAllDrivers($conn);

  $cname = filter_input(INPUT_POST, 'cname', FILTER_SANITIZE_STRING);
  $caddress = filter_input(INPUT_POST, 'caddress', FILTER_SANITIZE_STRING);
  $cnum = filter_input(INPUT_POST, 'cnum', FILTER_SANITIZE_STRING);
  $cpass = filter_input(INPUT_POST, 'cpass', FILTER_SANITIZE_STRING);
  $pdate = filter_input(INPUT_POST, 'pdate', FILTER_SANITIZE_STRING);
  $pdriver = filter_input(INPUT_POST, 'pdriver', FILTER_SANITIZE_STRING);
  $pmethod = filter_input(INPUT_POST, 'pmethod', FILTER_SANITIZE_STRING);
  $rname = filter_input(INPUT_POST, 'rname', FILTER_SANITIZE_STRING);
  $raddress = filter_input(INPUT_POST, 'raddress', FILTER_SANITIZE_STRING);
  $rnum = filter_input(INPUT_POST, 'rnum', FILTER_SANITIZE_STRING);
  $rmethod = filter_input(INPUT_POST, 'rmethod', FILTER_SANITIZE_STRING);
  $tot = filter_input(INPUT_POST, 'tot', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
  
  $ewdlarge = filter_input(INPUT_POST, 'ewdlarge', FILTER_SANITIZE_NUMBER_INT);
  $ewdxlarge = filter_input(INPUT_POST, 'ewdxlarge', FILTER_SANITIZE_NUMBER_INT);
  $ewd1m = filter_input(INPUT_POST, 'ewd1m', FILTER_SANITIZE_NUMBER_INT);
  $ewd15m = filter_input(INPUT_POST, 'ewd15m', FILTER_SANITIZE_NUMBER_INT);
  $ewd2m = filter_input(INPUT_POST, 'ewd2m', FILTER_SANITIZE_NUMBER_INT);
  $ewd25m = filter_input(INPUT_POST, 'ewd25m', FILTER_SANITIZE_NUMBER_INT);
  $ewd35m = filter_input(INPUT_POST, 'ewd35m', FILTER_SANITIZE_NUMBER_INT);
  $ecsmall = filter_input(INPUT_POST, 'ecsmall', FILTER_SANITIZE_NUMBER_INT);
  $ecmedium = filter_input(INPUT_POST, 'ecmedium', FILTER_SANITIZE_NUMBER_INT);
  $eclarge = filter_input(INPUT_POST, 'eclarge', FILTER_SANITIZE_NUMBER_INT);
  $ecjumbo = filter_input(INPUT_POST, 'ecjumbo', FILTER_SANITIZE_NUMBER_INT);
  $ecxl = filter_input(INPUT_POST, 'ecxl', FILTER_SANITIZE_NUMBER_INT);
  $etsmall = filter_input(INPUT_POST, 'etsmall', FILTER_SANITIZE_NUMBER_INT);
  $etmedium = filter_input(INPUT_POST, 'etmedium', FILTER_SANITIZE_NUMBER_INT);
  $etlarge = filter_input(INPUT_POST, 'etlarge', FILTER_SANITIZE_NUMBER_INT);
  $etxl = filter_input(INPUT_POST, 'etxl', FILTER_SANITIZE_NUMBER_INT);
  $etxxl = filter_input(INPUT_POST, 'etxxl', FILTER_SANITIZE_NUMBER_INT);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['action'])) {
    if ($_POST['action'] == 'sub') {
      if (pickupOnlyOrder(
        $conn,
        $cname,
        $caddress,
        $cnum,
        $cpass,
        $pdate,
        $pdriver,
        $pmethod,
        $rname,
        $raddress,
        $rnum,
        $rmethod,
        $tot,
        $ewdlarge,
        $ewdxlarge,
        $ewd1m,
        $ewd15m,
        $ewd2m,
        $ewd25m,
        $ewd35m,
        $ecsmall,
        $ecmedium,
        $eclarge,
        $ecjumbo,
        $ecxl,
        $etsmall,
        $etmedium,
        $etlarge,
        $etxl,
        $etxxl
      ) ) {
        echo
        "<script>alert('Order Placed Succesfully'); window.location.href='pickuporder.php';</script>";
      }
      else{
        echo
        "<script>alert('An error occured plz try again!!!'); window.location.href='pickuporder.php';</script>";
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
  <title>Pickup Only Order</title>
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
                <div class="card-title">Pickup Only Order Form</div>
                <hr>
                <form method="post">
                  <div class="form-group">
                    <label for="input-1">Customer Name</label>
                    <input type="text" class="form-control" name="cname" placeholder="customer name" required>
                  </div>
                  <div class="form-group">
                    <label for="input-2">Customer Address</label>
                    <textarea class="form-control" name="caddress" placeholder="Customer Address" required rows="5"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Customer Contact Number</label>
                    <input type="text" class="form-control" name="cnum" placeholder="Customer contact number" required>
                  </div>
                  <div class="form-group">
                    <label for="input-4">Customer Passport Number</label>
                    <input type="text" class="form-control" name="cpass" placeholder="Customer Passport Number" required>
                  </div>
                  <div class="form-group">
                    <label for="input-5">Pickup Date</label>
                    <input type="date" class="form-control" name="pdate" placeholder="PickUp date" required>
                  </div>
                  <div class="form-group">
                    <label for="input-5">Pickup Driver</label>
                    <select class="form-control" name="pdriver" id="input-5" required>
                      <option value="">Select a Driver</option>
                      <?php foreach ($drivers as $driver) : ?>
                        <option value="<?php echo htmlspecialchars($driver['username']); ?>">
                          <?php echo htmlspecialchars($driver['username']); ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="input-5">Payment Method</label>
                    <select class="form-control" name="pmethod" required>
                      <option value="">Select Payment Method</option>
                      <option value="Full Payment">Full Payment</option>
                      <option value="Installments">Installments</option>
                      <option value="Cash on delivery">Cash on Delivery</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="input-1">Reciever Name</label>
                    <input type="text" class="form-control" name="rname" placeholder="Reciever name" required>
                  </div>
                  <div class="form-group">
                    <label for="input-2">Reciever Address</label>
                    <textarea class="form-control" name="raddress" placeholder="Reciever Address" required rows="5"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Reciever Contact Number</label>
                    <input type="text" class="form-control" name="rnum" placeholder="Reciever contact number" required>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Receive Method</label>
                    <select class="form-control" name="rmethod" required>
                      <option value="">Select a Method</option>
                      <option value="Door to Door">Door to Door</option>
                      <option value="Pickup">Pickup</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Total Payment</label>
                    <input type="number" min="0" class="form-control" name="tot" placeholder="Total Payment" required>
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
                    <input type="number" min="0" class="form-control" value="0" name="ewdlarge" placeholder="Large" required>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Extra Large</label>
                    <input type="number" min="0" class="form-control" value="0" name="ewdxlarge" placeholder="Extra Large" required>
                  </div>
                  <div class="form-group">
                    <label for="input-3">1M</label>
                    <input type="number" min="0" class="form-control" value="0" name="ewd1m" placeholder="1M" required>
                  </div>
                  <div class="form-group">
                    <label for="input-3">1.5M</label>
                    <input type="number" min="0" class="form-control" value="0" name="ewd15m" placeholder="1.5M" required>
                  </div>
                  <div class="form-group">
                    <label for="input-3">2M/4X4</label>
                    <input type="number" min="0" class="form-control" value="0" name="ewd2m" placeholder="2M/4X4" required>
                  </div>
                  <div class="form-group">
                    <label for="input-3">2.5M=6X4</label>
                    <input type="number" min="0" class="form-control" value="0" name="ewd25m" placeholder="2.5M=6X4" required>
                  </div>
                  <div class="form-group">
                    <label for="input-3">3.5M=8X4</label>
                    <input type="number" min="0" class="form-control" value="0" name="ewd35m" placeholder="3.5M=8X4" required>
                  </div>
                  <div class="form-group">
                    <label for="input-3">-----Empty Cartoon-----</label>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Small</label>
                    <input type="number" min="0" class="form-control" value="0" name="ecsmall" placeholder="Small" required>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Medium</label>
                    <input type="number" min="0" class="form-control" value="0" name="ecmedium" placeholder="Medium" required>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Large</label>
                    <input type="number" min="0" class="form-control" value="0" name="eclarge" placeholder="Large" required>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Jumbo</label>
                    <input type="number" min="0" class="form-control" value="0" name="ecjumbo" placeholder="Jumbo" required>
                  </div>
                  <div class="form-group">
                    <label for="input-3">XL</label>
                    <input type="number" min="0" class="form-control" value="0" name="ecxl" placeholder="XL" required>
                  </div>
                  <div class="form-group">
                    <label for="input-3">-----Empty Trunk-----</label>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Small</label>
                    <input type="number" min="0" class="form-control" value="0" name="etsmall" placeholder="small" required>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Medium</label>
                    <input type="number" min="0" class="form-control" value="0" name="etmedium" placeholder="medium" required>
                  </div>
                  <div class="form-group">
                    <label for="input-3">Large</label>
                    <input type="number" min="0" class="form-control" value="0" name="etlarge" placeholder="large" required>
                  </div>
                  <div class="form-group">
                    <label for="input-3">XL</label>
                    <input type="number" min="0" class="form-control" value="0" name="etxl" placeholder="xl" required>
                  </div>
                  <div class="form-group">
                    <label for="input-3">XXL</label>
                    <input type="number" min="0" class="form-control" value="0" name="etxxl" placeholder="xxl" required>
                  </div>
                  <div class="form-group">
                    <button type="submit" name="action" value="sub" class="btn btn-success px-3"><i class="icon-lock"></i> submit Order</button>
                    <button type="reset" class="btn btn-danger ml-3 px-3"><i class="fas fa-undo"></i> Reset</button>
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