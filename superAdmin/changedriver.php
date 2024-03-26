<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';

$orderId = filter_input(INPUT_GET, 'orderId', FILTER_SANITIZE_NUMBER_INT);
$user=singleUserDetails($conn, $orderId);
$drivers=getAllDrivers($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'updt') {
            if ($user['method']=="Delivery and Pickup") {
                $newDelDate = filter_input(INPUT_POST, 'deliveryDate', FILTER_SANITIZE_STRING);
                $newDelDriver = filter_input(INPUT_POST, 'newdeldriver', FILTER_SANITIZE_STRING);
                $newPickDate = filter_input(INPUT_POST, 'pickupDate', FILTER_SANITIZE_STRING);
                $newPickDriver = filter_input(INPUT_POST, 'newpickdriver', FILTER_SANITIZE_STRING);
                /*echo $orderId."<br/>";
                echo $newDelDate."<br/>";
                echo $newDelDriver."<br/>";
                echo $newPickDate."<br/>";
                echo $newPickDriver."<br/>";
                */
                $result=updateDelPickDetails($conn, $orderId, $newDelDriver, $newDelDate, $newPickDriver, $newPickDate);
                echo "<script>alert('{$result}'); window.location.href='index.php';</script>";
            }
            else {
                $newPickDate = filter_input(INPUT_POST, 'pickupDate', FILTER_SANITIZE_STRING);
                $newPickDriver = filter_input(INPUT_POST, 'newpickdriver', FILTER_SANITIZE_STRING);
                $result=updatePickDetails($conn, $orderId, $newPickDriver, $newPickDate);
                echo "<script>alert('{$result}'); window.location.href='index.php';</script>";
            }

        }
        
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>Change the Driver</title>
  <!--INCLUDING CSS-->
  <?php include 'css.php';?>
</head>

<body class="bg-theme bg-theme1">

<!-- start loader -->
   <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div>
   <!-- end loader -->

<!-- Start wrapper-->
 <div id="wrapper">

 <?php include 'sidebar.php'; ?>
  

<!--Start topbar header-->
<?php include 'topbar.php';?>
<!--End topbar header-->

<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

    <div class="row mt-3">
      <div class="col-lg-8">
         <div class="card">
           <div class="card-body">
           <div class="card-title">Change the driver</div>
           <hr>
            <form method="post">
           <div class="form-group">
            <label for="input-1">Order Id</label>
            <input type="text" class="form-control" name="orderId" value="<?php echo $user['order_Id'];?>" readonly>
           </div>
           <div class="form-group">
            <label for="input-2">Customer Name</label>
            <input type="text" class="form-control" value="<?php echo $user['customer_Name'];?>" readonly>
           </div>
           <div class="form-group">
            <label for="input-3">Mobile</label>
            <input type="text" class="form-control" value="<?php echo $user['customer_contactNo'];?>" readonly>
           </div>

           <?php if ($user['method'] == "Delivery and Pickup"): ?>
                <div class="form-group">
                    <label for="input-4">Current Delivery Date</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['delivery_date'] ?? ''); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="input-5">Current Delivery Driver</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['delivery_driver'] ?? ''); ?>" readonly>
                </div>
                <div class="form-group">
                <label for="input-3">New Delivery Driver</label>
                <select class="form-control" name="newdeldriver" required>
                    <?php foreach ($drivers as $driver): ?>
                        <option value="<?php echo htmlspecialchars($driver['username']); ?>"
                            <?php echo ($driver['username'] == $user['delivery_driver']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($driver['username']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="delivery-date">Delivery Date</label>
                <input type="date" class="form-control" name="deliveryDate" required>
            </div>
            <?php endif; ?>   
            
            <div class="form-group">
                    <label for="input-4">Current Pickup Date</label>
                    <input type="text" class="form-control"  value="<?php echo htmlspecialchars($user['pickup_date'] ?? ''); ?>" readonly>
            </div>
            <div class="form-group">
                    <label for="input-5">Current Pickup Driver</label>
                    <input type="text" class="form-control"  value="<?php echo htmlspecialchars($user['pickup_driver'] ?? ''); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="input-3">New Pickup Driver</label>
                <select class="form-control" name="newpickdriver" required>
                    <?php foreach ($drivers as $driver): ?>
                        <option value="<?php echo htmlspecialchars($driver['username']); ?>"
                            <?php echo ($driver['username'] == $user['pickup_driver']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($driver['username']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="delivery-date">New Pickup Date</label>
                <input type="date" class="form-control" name="pickupDate" required>
            </div>
           <div class="form-group">
            <button type="submit" name="action" value="updt" class="btn btn-success px-3"><i class="fas fa-edit"></i>Update</button>
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
	<?php include 'footer.php';?>
	<!--End footer-->
	
	 <!--start color switcher-->
     <?php include 'colorswitch.php';?>
  <!--end color switcher-->
   
  </div><!--End wrapper-->


   <!---INCLUDEING JS-->
<?php include 'js.php';?>  
</body>
</html>
