<?php
require 'session.php';
require 'dbconfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
    if (!empty($status) && in_array($status, ['Active', 'Disable'])) {
        $stmt = $conn->prepare("UPDATE systemstat SET status = ?");
        $stmt->bind_param("s", $status);
        if ($stmt->execute()) {
            echo "<script>alert('Status updated successfully.'); window.location = 'systatus.php';</script>";
        } else {
            echo "<script>alert('Failed to update status.'); window.location = 'systatus.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Invalid status.'); window.location = 'systatus.php';</script>";
    }
    $conn->close();
    exit; 
}
$data="";
$stmt = $conn->prepare("SELECT * FROM systemstat");
$stmt->execute();
$result = $stmt->get_result(); 

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data = $row['status'];
        
    } else {
        $data="Disable";
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
  <title>System Status</title>
  <!--INCLUDING CSS-->
  <?php include 'css.php';?>
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
            <div class="tab-pane" id="edit">
                <form action="systatus.php" method="POST">

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Current Status</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" value="<?= htmlspecialchars($data, ENT_QUOTES, 'UTF-8') ?>" readonly style="background-color: <?= $data == 'Active' ? 'green' : ($data == 'Disable' ? 'red' : 'defaultColor'); ?>;">
                        </div>
                    </div>             
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Change Status To :</label>
                        <div class="col-lg-9">
                            <select class="form-control" name="status" required>
                                <option value="">---Select Option---</option>
                                <option value="Active">Active</option>
                                <option value="Disable">Disable</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label"></label>
                        <div class="col-lg-9">
                            <input type="reset" class="btn btn-secondary" value="Cancel">
                            <input type="submit" class="btn btn-primary" value="Save Changes">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--start overlay-->
    <div class="overlay toggle-menu"></div>
    <!--end overlay-->
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
