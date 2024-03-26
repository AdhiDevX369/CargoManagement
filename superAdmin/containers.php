<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';
require 'enckey.php';

$encryptedOrderId;
$containers = getAllContainerDetails($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Containers</title>
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
                <div class="row">
                  <form action="containers.php" method="post">
                    <h4>Add new Container</h4>
                    <hr>
                    <div class="form-group">
                      <label for="input-1">Container ID</label>
                      <input type="text" class="form-control" id="cid" name="cid" placeholder="Enter the container id" required>
                    </div>
                    <div class="form-group">
                      <label for="input-2">Container Company</label>
                      <input type="text" class="form-control" id="company" name="company" placeholder="Enter the container company name" required>
                    </div>
                    <div class="form-group">
                      <label for="inputcountry">Shipping Country</label>
                      <select class="form-control" id="country" name="country" required>
                        <option value="">--Select Shipping Country--</option>
                        <option value="SRI LANKA">Sri Lanka</option>
                        <option value="PHILIPINES">Philipines</option>
                        <option value="ETHIOPIA">Ethiopiya</option>
                        <!--Add other shipping countries -->
                      </select>
                      <div class="form-group">
                        <label for="inputwarehouselocation">Warehouse Location</label>
                        <select class="form-control" id="warehouse" name="warehouse" required>
                          <option value="">--Select Warehouse Location--</option>
                          <option value="GALLE">Galle</option>
                          <option value="KURUNEGALA">Kurunegala</option>
                          <option value="KANDY">Kandy</option>
                          <!--Add other warehouse locations-->
                        </select>
                      </div>
                      <div class="form-group">
                        <button type="submit" class="btn btn-light px-5">
                          <i class="icon-lock"></i> Register
                        </button>
                        <button type="reset" class="btn btn-light px-5"><i class="zmdi zmdi-alert-octagon"></i> Reset</button>
                      </div>
                  </form>
                </div>
              </div><!--End Row-->
              <div class="row">
                <hr>
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Container ID</th>
                        <th scope="col">Container's Company</th>
                        <th scope="col">Shipping Country</th>
                        <th scope="col">Warehouse Location</th>
                        <th scope="col">Current Location</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($containers as $container) : ?>
                        <tr>
                          <?php $encryptedOrderId = encrypt($container['container_id'], $key); ?>
                          <td>
                            <a href="containerDetails.php?container_id=<?php echo urlencode($encryptedOrderId); ?>">
                              <?php echo htmlspecialchars($container['container_id']); ?>
                            </a>
                          </td>
                          <td><?php echo htmlspecialchars($container['company_name']); ?></td>
                          <td><?php echo htmlspecialchars($container['destination']); ?></td>
                          <td><?php echo htmlspecialchars($container['warehouse']); ?></td>
                          <td><?php echo strtoupper(htmlspecialchars($container['location'])); ?></td>
                          <td><?php echo htmlspecialchars($container['status']); ?></td>
                          <td>
                            <button style='background-color: red; color: white;' onclick='if(confirm("Are you sure you want to delete this container?")) location.href="deleteContainer.php?id=<?php echo $encryptedOrderId; ?>";'>Delete</button>
                            <button style='background-color: green; color: white;' onclick='location.href="shipment.php?containerId=<?php echo $encryptedOrderId; ?>";'>Shipment</button>
                            <button style='background-color: #2521ed; color: white;' onclick='if(confirm("Are you sure you want to complete this container?")) location.href="completeContainer.php?id=<?php echo $encryptedOrderId; ?>";'>Complete Container</button>
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