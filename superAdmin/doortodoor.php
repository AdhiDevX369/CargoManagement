<?php
  require 'session.php';
  require 'dbconfig.php';
  require 'superAdminFunctions.php';
  require 'enckey.php';

$responses = [];
$encryptedOrderId;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['action'])) {
    if ($_POST['action'] == 'show') {
      $warehouse = filter_input(INPUT_POST, 'warehouse', FILTER_SANITIZE_STRING);
      $responses = arrivedInvoices($conn, $warehouse);
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
  <title>Arrived Invoices</title>
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
                <div class="card-title">Select the warehouse Location : <?php if (isset($warehouse) && !empty($warehouse)) {
                                                                          echo $warehouse;
                                                                        } ?></div>
                <hr>
                <form method="post">
                  <div class="form-group">
                    <label for="input-1">warehouse Location</label>
                    <select class="form-control" id="warehouse" name="warehouse" required>
                      <option value="">Select a warehouse location</option>
                      <option value="GALLE">GALLE</option>
                      <option value="KURUNEGALA">KURUNEGALA</option>
                      <option value="KANDY">KANDY</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <button type="submit" name="action" value="show" class="btn btn-success px-3"><i class="fas fa-eye"></i> Show</button>
                  </div>
                </form>
                <form action="downloadmani.php" method="post">
                  <input type="hidden" name="container_id" id="hiddenContainerId">
                </form>
              </div>
            </div>
          </div>
        </div><!--End Row-->
        <div class="row">
          <div class="col-lg-11">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Invoice Details</h5>
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">Invoice Number</th>
                        <th scope="col">Order Id</th>
                        <th scope="col">Container Id</th>
                        <th scope="col">Receiving Method</th>
                        <th scope="col">Receiving Address</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($responses as $row) : ?>
                        <tr>
                          <?php $encryptedOrderId = encrypt($row['order_id'], $key); ?>
                          <td><?php echo htmlspecialchars($row['invoice_number']); ?></td>
                          <td><a href="orderdetails.php?order_Id=<?php echo $encryptedOrderId ?>"><?php echo htmlspecialchars($row['order_id']); ?></a></td>
                          <td><?php echo htmlspecialchars($row['container_id']); ?></td>
                          <td><?php echo htmlspecialchars($row['rmethod']); ?></td>
                          <td><?php echo htmlspecialchars($row['raddress']); ?></td>
                          <td>
                            <?php if ($row['rmethod'] === "Door to Door") : ?>
                              <a href="d2dDriver.php?invoice_number=<?php echo urlencode($row['invoice_number']); ?>">Assign a Door to Door Driver</a>
                            <?php endif; ?>
                          </td>
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