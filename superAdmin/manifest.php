<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';

$containers = detailsOfallActiveContainers($conn);

$results = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['action'])) {
    if ($_POST['action'] == 'show') {
      $containerId = filter_input(INPUT_POST, 'containerId', FILTER_SANITIZE_STRING);
      $results = getInvoicesByContainer($conn, $containerId);
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
  <title>Add Container ID</title>
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
                <div class="card-title">Enter the Container ID</div>
                <hr>
                <form method="post">
                  <div class="form-group">
                    <label for="input-1">Container ID</label>
                    <select class="form-control" id="containerId" name="containerId" required>
                      <option value="">Select a Container</option>
                      <?php foreach ($containers as $container) : ?>
                        <option value="<?php echo htmlspecialchars($container['container_id']); ?>">
                          <?php echo htmlspecialchars($container['container_id']); ?>
                        </option>
                      <?php endforeach; ?>
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
                        <th scope="col">Location</th>
                        <th scope="col">Status</th>
                        <th scope="col">Download Manifest</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($results as $row) : ?>
                        <tr>
                          <td><?php echo htmlspecialchars($row['invoice_number']); ?></td>
                          <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                          <td><?php echo htmlspecialchars($row['container_id']); ?></td>
                          <td><?php echo htmlspecialchars($row['location']); ?></td>
                          <td><?php echo htmlspecialchars($row['status']); ?></td>
                          <td>
                            <form action="downloadmani.php" method="post">
                              <input type="hidden" name="container_id" value="<?php echo htmlspecialchars($row['container_id']); ?>">
                              <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-download"></i> Download
                              </button>
                            </form>
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