<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';
require 'enckey.php';

$encryptedOrderId;
$results = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['action'])) {
    if ($_POST['action'] == 'submt') {
      $findBy = filter_input(INPUT_POST, 'findBy', FILTER_SANITIZE_STRING);
      if ($findBy === "All") {
        $results = allOrdersDetails($conn);
      } elseif ($findBy === "Order Placed") {
        $results = orderPlacedOrders($conn);
      } elseif ($findBy === "Today") {
        $results = todaysOrdersDetails($conn);
      } elseif ($findBy === "Completed") {
        $results = allCompletedOrder($conn);
      } elseif ($findBy === "Delivery and Pickup") {
        $results = DelAndpickupOrderDetails($conn);
      } elseif ($findBy === "Pick Up Only") {
        $results = pickUpOnlyOrdersDetails($conn);
      } else {
        $results = [];
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
  <title>All Orders Details</title>
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
                <div class="card-title">Select</div>
                <hr>
                <form method="post">
                  <div class="form-group">
                    <label for="input-1">Find By</label>
                    <select class="form-control" id="input-1" name="findBy" required>
                      <option value="">---Select---</option>
                      <option value="All">All Orders</option>
                      <option value="Order Placed">Active Orders</option>
                      <option value="Today">Today Orders</option>
                      <option value="Completed">Completed Orders</option>
                      <option value="Delivery and Pickup">Delivery and Pickup Orders</option>
                      <option value="Pick Up Only">Pick Up Only Orders</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <button type="submit" name="action" value="submt" class="btn btn-warning px-5"><i class="fas fa-search"></i> Find</button>
                    <button type="reset" class="btn btn-danger ml-2 px-3"><i class="fas fa-undo"></i> Reset</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div><!--End Row-->
        <div class="row">
          <div class="col-lg-10">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Details</h5>
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Order Id</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Method</th>
                        <th scope="col">Total Payment</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($results as $row) : ?>
                        <tr>
                          <?php $encryptedOrderId = encrypt($row['order_Id'], $key); ?>
                          <td><a href="orderdetails.php?order_Id=<?php echo urlencode($encryptedOrderId); ?>"><?php echo htmlspecialchars($row['order_Id']); ?></a></td>
                          <td><?php echo htmlspecialchars($row['customer_Name']); ?></td>
                          <td><?php echo htmlspecialchars($row['method']); ?></td>
                          <td><?php echo htmlspecialchars($row['total_payment']); ?></td>
                          <td><?php echo htmlspecialchars($row['status']); ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
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