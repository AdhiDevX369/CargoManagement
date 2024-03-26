<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';
require 'enckey.php';
$encryptedInvoiceId;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;
$total = $conn->query("SELECT COUNT(*) as total FROM invoice")->fetch_assoc()['total'];
$pages = ceil($total / $perPage);
$sql = "SELECT * FROM invoice LIMIT {$start}, {$perPage}";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>All Invoices Details</title>
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
          <div class="col-lg-10">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">All Invoices Details</h5>
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Invoice Id</th>
                        <th scope="col">Order Id</th>
                        <th scope="col">Shipping Date</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                          <?php $encryptedInvoiceId = encrypt($row['invoice_number'], $key); ?>
                          <td><a href="invoicebyid.php?invoice_number=<?php echo $encryptedInvoiceId; ?>"><?php echo htmlspecialchars($row['invoice_number']); ?></a></td>
                          <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                          <td><?php echo htmlspecialchars($row['shippingdate']); ?></td>
                          <td><?php echo htmlspecialchars($row['status']); ?></td>
                        </tr>
                      <?php endwhile; ?>
                    </tbody>
                  </table>
                </div>
                <nav aria-label="Page navigation">
                  <ul class="pagination">
                    <?php for ($i = 1; $i <= $pages; $i++) : ?>
                      <li class="page-item<?php echo ($i === $page) ? ' active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php endfor; ?>
                  </ul>
                </nav>
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