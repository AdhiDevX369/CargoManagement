<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';

$dueorders = driverDueOrders($conn);
$activecon = allActiveContainers($conn);
$comcon = allCompletedContainers($conn);
$dueordercount = countDueOrders($conn);
$todayorderscount = numOfTodayOrders($conn);
$shippedInvoices = countOfShippedInvoices($conn);
$shippedContainers = allShippedContainers($conn);
?>
<?php
// Getting All number of oders
$query = "SELECT COUNT(*) AS orderCount FROM orders";
$result = $conn->query($query);

$numberOfOrders = 0;
if ($result) {
  $row = $result->fetch_assoc();
  $numberOfOrders = $row['orderCount'];
}
?>
<?php
// Getting all number of users
$query = "SELECT COUNT(*) AS userCount FROM user";
$result = $conn->query($query);

$numberOfUsers = 0;
if ($result) {
  $row = $result->fetch_assoc();
  $numberOfUsers = $row['userCount'];
}
?>
<?php
// Getting all number of invoices
$query = "SELECT COUNT(*) AS invoiceCount FROM invoice";
$result = $conn->query($query);

$numberOfInvoices = 0;
if ($result) {
  $row = $result->fetch_assoc();
  $numberOfInvoices = $row['invoiceCount'];
}
?>

<?php
/*This is for calculating Total Due Payments*/

// Total customer payments
$queryCustomerPay = "SELECT SUM(customer_pay) AS totalCustomerPayments FROM orders";
$resultCustomerPay = $conn->query($queryCustomerPay);

$totalCustomerPayments = 0;
if ($resultCustomerPay) {
  $row = $resultCustomerPay->fetch_assoc();
  $totalCustomerPayments = $row['totalCustomerPayments'];
}

// Total payments
$queryTotalPayment = "SELECT SUM(total_payment) AS totalPayments FROM orders";
$resultTotalPayment = $conn->query($queryTotalPayment);

$totalPayments = 0;
if ($resultTotalPayment) {
  $row = $resultTotalPayment->fetch_assoc();
  $totalPayments = $row['totalPayments'];
}

// Calculating total due amount
$totalDueAmount = $totalPayments - $totalCustomerPayments;
?>

<?php
// Total customer payments
$query = "SELECT SUM(customer_pay) AS totalPayments FROM orders";
$result = $conn->query($query);

$totalPayments = 0;
if ($result) {
  $row = $result->fetch_assoc();
  $totalPayments = $row['totalPayments'];
}
?>

<?php
/* Get total number of orders placed and orders completed*/
$queryPlaced = "SELECT COUNT(*) AS orderCount FROM orders WHERE status='Order Placed'";
$resultPlaced = $conn->query($queryPlaced);
$numberOfOrdersPlaced = 0;
if ($resultPlaced) {
  $rowPlaced = $resultPlaced->fetch_assoc();
  $numberOfOrdersPlaced = $rowPlaced['orderCount'];
}

$queryCompleted = "SELECT COUNT(*) AS orderCount FROM orders WHERE status='Order is Completed'";
$resultCompleted = $conn->query($queryCompleted);
$numberOfOrdersCompleted = 0;
if ($resultCompleted) {
  $rowCompleted = $resultCompleted->fetch_assoc();
  $numberOfOrdersCompleted = $rowCompleted['orderCount'];
}

?>
<?php
// Getting the number of orders where method is 'Both Delivery And Pickup'
$queryBoth = "SELECT COUNT(*) AS orderCount FROM orders WHERE method='Delivery and Pickup'";
$resultBoth = $conn->query($queryBoth);
$numberOfOrdersBoth = 0;
if ($resultBoth) {
  $rowBoth = $resultBoth->fetch_assoc();
  $numberOfOrdersBoth = $rowBoth['orderCount'];
}

// Getting the number of orders where method is 'Pickup Only'
$queryPickupOnly = "SELECT COUNT(*) AS orderCount FROM orders WHERE method='Pick Up Only'";
$resultPickupOnly = $conn->query($queryPickupOnly);
$numberOfPickupOnly = 0;
if ($resultPickupOnly) {
  $rowPickupOnly = $resultPickupOnly->fetch_assoc();
  $numberOfPickupOnly = $rowPickupOnly['orderCount'];
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
  <title>Super Admin Sri Sara</title>
  <!--INCLUDING CSS-->
  <?php include 'css.php'; ?>
</head>

<body class="bg-theme bg-theme1">
  <!-- Start wrapper-->
  <div id="wrapper">

    <?php include 'sidebar.php'; ?>

    <!--Start topbar header-->
    <?php include 'topbar.php'; ?>
    <!--End topbar header-->

    <div class="clearfix"></div>
    <div class="content-wrapper">
      <div class="container-fluid">
        <!--Start Dashboard Content-->
        <div class="card mt-3">
          <div class="card-content">
            <div class="row row-group m-0">
              <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                  <h5 class="text-white mb-0"><?php echo $numberOfOrders; ?><span class="float-right"><i class="fa fa-shopping-cart"></i></span></h5>
                  <div class="progress my-3" style="height:<?php echo $numberOfOrders; ?>px;">
                  </div>
                  <p class="mb-0 text-white small-font">Number of Orders <span class="float-right"></span></p>
                </div>
              </div>

              <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                  <h5 class="text-white mb-0"><?php echo $numberOfUsers; ?> <span class="float-right"><i class="zmdi zmdi-account"></i></span></h5>
                  <div class="progress my-3" style="height:3px;">
                    <div class="progress-bar" style="height:<?php echo $numberOfUsers; ?>px;"></div>
                  </div>
                  <p class="mb-0 text-white small-font">Number of All Users <span class="float-right"></span></p>
                </div>
              </div>

              <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                  <h5 class="text-white mb-0"><?php echo $numberOfInvoices; ?> <span class="float-right"><i class="zmdi zmdi-card"></i></span></h5>
                  <div class="progress my-3" style="height:3px;">
                    <div class="progress-bar" style="height:<?php echo $numberOfInvoices; ?>px;"></div>
                  </div>
                  <p class="mb-0 text-white small-font">Number of All Invoices <span class="float-right"></span></p>
                </div>
              </div>

              <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                  <h5 class="text-white mb-0"><?php echo $shippedInvoices; ?> <span class="float-right"><i class="fas fa-truck"></i></span></h5>
                  <div class="progress my-3" style="height:3px;">
                    <div class="progress-bar" style="height:<?php echo $shippedInvoices; ?>px;"></div>
                  </div>
                  <p class="mb-0 text-white small-font">Number of All Shipped Invoices <span class="float-right"></span></p>
                </div>
              </div>

              <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                  <h5 class="text-white mb-0"><?php echo $totalDueAmount; ?><span class="float-right"><i class="zmdi zmdi-balance"></i></span></h5>
                  <div class="progress my-3" style="height:3px;">
                    <div class="progress-bar" style="height:<?php echo $totalDueAmount; ?>px;"></div>
                  </div>
                  <p class="mb-0 text-white small-font">Total Due Payments <span class="float-right"></span></p>
                </div>
              </div>

              <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                  <h5 class="text-white mb-0"><?php echo $totalPayments; ?><span class="float-right"><i class="zmdi zmdi-balance-wallet"></i></span></h5>
                  <div class="progress my-3" style="height:3px;">
                    <div class="progress-bar" style="height:<?php echo $totalPayments; ?>px;"></div>
                  </div>
                  <p class="mb-0 text-white small-font">Total Customers' Payments <span class="float-right"></span></p>
                </div>
              </div>
              <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                  <h5 class="text-white mb-0"><?php echo $activecon; ?><span class="float-right"><i class="zmdi zmdi-bookmark"></i></span></h5>
                  <div class="progress my-3" style="height:3px;">
                    <div class="progress-bar" style="height:<?php echo $activecon; ?>px;"></div>
                  </div>
                  <p class="mb-0 text-white small-font">Number of All Active Containers <span class="float-right"></span></p>
                </div>
              </div>
              <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                  <h5 class="text-white mb-0"><?php echo $comcon; ?><span class="float-right"><i class="zmdi zmdi-case-check"></i></span></h5>
                  <div class="progress my-3" style="height:3px;">
                    <div class="progress-bar" style="height:<?php echo $comcon; ?>px;"></div>
                  </div>
                  <p class="mb-0 text-white small-font">Number of All Completed Containers <span class="float-right"></span></p>
                </div>
              </div>
              <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                  <h5 class="text-white mb-0"><?php echo $shippedContainers; ?><span class="float-right"><i class="fas fa-truck"></i></span></h5>
                  <div class="progress my-3" style="height:3px;">
                    <div class="progress-bar" style="height:<?php echo $shippedContainers; ?>px;"></div>
                  </div>
                  <p class="mb-0 text-white small-font">Number of All Shipped Containers <span class="float-right"></span></p>
                </div>
              </div>
              <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                  <h5 class="text-white mb-0"><?php echo $dueordercount; ?><span class="float-right"><i class="zmdi zmdi-case-check"></i></span></h5>
                  <div class="progress my-3" style="height:3px;">
                    <div class="progress-bar" style="height:<?php echo $dueordercount; ?>px;"></div>
                  </div>
                  <p class="mb-0 text-white small-font">Kuwait Drivers' Due Orders<span class="float-right"></span></p>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-lg-8 col-xl-8">
            <div class="card">
              <div class="card-header">Orders Deatils
                <div class="card-action">
                  <div class="dropdown">
                  </div>
                </div>
              </div>
              <div class="card-body">
                <ul class="list-inline">
                  <li class="list-inline-item"><i class="fa fa-circle mr-2 "></i>Number of Placed Orders</li>
                  <li class="list-inline-item"><i class="fa fa-circle mr-2 "></i>Number of Completed Orders</li>
                </ul>
                <div class="chart-container-1" style="position: relative; height:40vh; width:80vw">
                  <canvas id="myBarChart"></canvas>
                </div>
              </div>
              <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
              <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
              <script>
                var ctx = document.getElementById('myBarChart').getContext('2d');
                var myBarChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                    labels: ['Categories'], // Single category label
                    datasets: [{
                      label: 'Number of Placed Orders',
                      data: [<?php echo  $numberOfOrdersPlaced; ?>], // Data for Orders
                      backgroundColor: 'rgba(54, 162, 235, 0.2)',
                      borderColor: 'rgba(54, 162, 235, 1)',
                      borderWidth: 1
                    }, {
                      label: 'Number of Completed Orders',
                      data: [<?php echo $numberOfOrdersCompleted; ?>], // Data for Invoices
                      backgroundColor: 'rgba(255, 206, 86, 0.2)',
                      borderColor: 'rgba(255, 206, 86, 1)',
                      borderWidth: 1
                    }]
                  },
                  options: {
                    scales: {
                      yAxes: [{
                        ticks: {
                          beginAtZero: true,
                          fontColor: "#FFFFFF" // Change y-axis tick color to white
                        }
                      }],
                      xAxes: [{
                        ticks: {
                          fontColor: "#FFFFFF" // Change x-axis tick color to white
                        }
                      }]
                    },
                    legend: {
                      labels: {
                        fontColor: "#FFFFFF" // Change legend text color to white
                      }
                    }
                  }
                });
              </script>
              <div class="row m-0 row-group text-center border-top border-light-3">
                <div class="col-12 col-lg-4">
                  <div class="p-3">
                    <h5 class="mb-0"><?php echo $numberOfPickupOnly; ?></h5>
                    <small class="mb-0">Number of Pickup Only Orders</small>
                  </div>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="p-3">
                    <h5 class="mb-0"><?php echo $numberOfOrdersBoth; ?></h5>
                    <small class="mb-0">Number of both Delivery and Pickup Orders</small>
                  </div>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="p-3">
                    <h5 class="mb-0"><?php echo $todayorderscount; ?></h5>
                    <small class="mb-0">Number of Orders Placed Today</small>
                  </div>
                </div>
              </div>

            </div>
          </div>



          <div class="col-12 col-lg-4 col-xl-4">
            <div class="card">
              <div class="card-header">Weekly sales
                <div class="card-action">
                  <div class="dropdown">
                    <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                      <i class="icon-options"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item" href="javascript:void();">Action</a>
                      <a class="dropdown-item" href="javascript:void();">Another action</a>
                      <a class="dropdown-item" href="javascript:void();">Something else here</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="javascript:void();">Separated link</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="chart-container-2">
                  <canvas id="chart2"></canvas>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table align-items-center">
                  <tbody>
                    <tr>
                      <td><i class="fa fa-circle text-white mr-2"></i> Direct</td>
                      <td>$5856</td>
                      <td>+55%</td>
                    </tr>
                    <tr>
                      <td><i class="fa fa-circle text-light-1 mr-2"></i>Affiliate</td>
                      <td>$2602</td>
                      <td>+25%</td>
                    </tr>
                    <tr>
                      <td><i class="fa fa-circle text-light-2 mr-2"></i>E-mail</td>
                      <td>$1802</td>
                      <td>+15%</td>
                    </tr>
                    <tr>
                      <td><i class="fa fa-circle text-light-3 mr-2"></i>Other</td>
                      <td>$1105</td>
                      <td>+5%</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div><!--End Row-->

        <div class="row">
          <div class="col-12 col-lg-12">
            <div class="card">
              <div class="card-header">Drivers' Due Orders
                <div class="table-responsive">
                  <table class="table align-items-center table-flush table-borderless">
                    <thead>
                      <tr>
                        <th>Order ID</th>
                        <th>Customer's Name</th>
                        <th>Order Type</th>
                        <th>Total Payment</th>
                        <th>Delivery Date</th>
                        <th>Delivery Status</th>
                        <th>Pick up Date</th>
                        <th>Pick up Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($dueorders as $order) : ?>
                        <tr>
                          <td><a href="changedriver.php?orderId=<?php echo htmlspecialchars($order['order_Id']); ?>"><?php echo htmlspecialchars($order['order_Id']); ?></a></td>
                          <td><?php echo htmlspecialchars($order['customer_Name']); ?></td>
                          <td><?php echo htmlspecialchars($order['method']); ?></td>
                          <td><?php echo htmlspecialchars($order['total_payment']); ?></td>
                          <td><?php echo !empty($order['delivery_date']) ? htmlspecialchars($order['delivery_date']) : 'NOT APPLIED'; ?></td>
                          <td><?php echo !empty($order['delivery_status']) ? htmlspecialchars($order['delivery_status']) : 'NOT APPLIED'; ?></td>
                          <td><?php echo htmlspecialchars($order['pickup_date']); ?></td>
                          <td><?php echo htmlspecialchars($order['pickup_status']); ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div><!--End Row-->

          <!--End Dashboard Content-->

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