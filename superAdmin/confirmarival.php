<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';
require 'enckey.php';
$containers = landedContainers($conn);
$encryptedConId;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Confirm Shipment Arrival</title>
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
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Please Confirm the Shipment Arrival (Sri Lanka)</h5>
                <div class="row">
                  <hr>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">Container ID</th>
                          <th scope="col">Container's Company</th>
                          <th scope="col">Warehouse Location</th>
                          <th scope="col">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($containers as $container) : ?>
                          <tr>
                            <?php $encryptedConId = encrypt($container['container_id'], $key); ?>
                            <td><?php echo htmlspecialchars($container['container_id']); ?></td>
                            <td><?php echo htmlspecialchars($container['company_name']); ?></td>
                            <td><?php echo htmlspecialchars($container['warehouse']); ?></td>
                            <td>
                              <button type="button" class="btn btn-success" onclick='location.href="confirmshiparrival.php?containerId=<?php echo $encryptedConId; ?>";'>Confirm</button>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">

                </div>

                <div class="row">

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
  <?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['cid']) && !empty($_POST['company'])) {
    $containerId = filter_input(INPUT_POST, 'cid', FILTER_SANITIZE_STRING);
    $containerCompany = strtoupper(filter_input(INPUT_POST, 'company', FILTER_SANITIZE_STRING));
    $shippingCountry = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
    $warehouseLocation = filter_input(INPUT_POST, 'warehouse', FILTER_SANITIZE_STRING);

    $result = createContainer($conn, $containerId, $containerCompany, $shippingCountry, $warehouseLocation);

    if ($result == "1") {
      // Success
      echo "<script>alert('Container added successfully.'); window.location.href='containers.php';</script>";
    } elseif ($result == "0") {
      // Container ID already exists
      echo "<script>alert('Container ID already exists.'); window.location.href='containers.php';</script>";
    } else {
      // Failure
      echo "<script>alert('Failed to add container.'); window.location.href='containers.php';</script>";
    }
  }
  ?>

</body>

</html>