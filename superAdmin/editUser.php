<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';
require 'enckey.php';
?>
<?php
$userdata = ['fname' => '', 'lname' => '', 'username' => '', 'mobile' => '', 'address' => '', 'gender' => '', 'userType' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && !empty($_GET['id'])) {
    $id = decrypt($_GET['id'], $key);
    $stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $userdata = $result->fetch_assoc(); 
        } else {
            echo "No user found with the specified ID.";
        }
    } else {
        echo "Error executing query.";
    }
    $stmt->close();
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
  <title>Edit Users</title>
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
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
          <form action="editUser.php" method="post">
          <h4>Update User Details</h4>
          <hr>
           <div class="form-group">
            <label for="input-1">First Name</label>
            <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $userdata['fname']; ?>" required>

           </div>
           <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
           <div class="form-group">
            <label for="input-2">Last Name</label>
            <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $userdata['lname']; ?>" required>
           </div>
           <div class="form-group">
            <label for="input-3">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $userdata['username']; ?>" readonly >
           </div>
           <div class="form-group">
                <label for="input-4">Password</label>
                <input type="text" class="form-control" id="password" name="password" placeholder="Enter new password"  required>
            </div>
            <div class="form-group">
                <label for="input-5">Confirm Password</label>
                <input type="text" class="form-control" id="conpass" name="conpass" placeholder="Confirm Password" onblur="validatePasswords()" required>
                <small id="passwordError" class="form-text text-muted" style="color: red;"></small>
            </div>
            <script>
              function validatePasswords() {
                  var password = document.getElementById("password").value;
                  var confirmPassword = document.getElementById("conpass").value;
                  var passwordError = document.getElementById("passwordError");
                  if (password !== confirmPassword) {
                      passwordError.textContent = "Passwords do not match.";
                      updateButton.disabled = true;
                  } else {
                      passwordError.textContent = "";
                      updateButton.disabled = false;
                  }
              }
              </script>
           <div class="form-group">
              <label for="inputGender">Gender</label>
              <select class="form-control" id="gender" name="gender" required>
                  <option value="">--Select Gender--</option>
                  <option value="1">Male</option>
                  <option value="2">Female</option>
              </select>
          </div>
          <div class="form-group">
            <label for="input-3">Mobile Number</label>
            <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $userdata['tele']; ?>" required>
           </div>
           <div class="form-group">
              <label for="userType">User Type</label>
              <select class="form-control" id="userType" name="userType" required>
                  <option value="">--Select User Type--</option>
                  <option value="1">Admin</option>
                  <option value="2">Agent</option>
                  <option value="3">Warehouse Manager</option>
                  <option value="4">Driver</option>
              </select>
          </div>
          <div class="form-group">
              <label for="address">Address</label>
              <textarea class="form-control" id="address" name="address" rows="5" required><?php echo htmlspecialchars($userdata['address']); ?></textarea>
          </div>
           <div class="form-group">
           <button type="submit" class="btn btn-light px-5" id="updateButton">
              <i class="icon-lock"></i> Update
          </button>

            <button type="reset" class="btn btn-light px-5"><i class="zmdi zmdi-alert-octagon"></i> Reset</button>
          </div>
          </form>
          </div><!--End Row-->
        
          <div class="row">
         
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
	<?php include 'footer.php';?>
	<!--End footer-->
	
	<!--start color switcher-->
  <?php include 'colorswitch.php';?>
  <!--end color switcher-->
   
  </div><!--End wrapper-->
   <!---INCLUDEING JS-->
<?php include 'js.php';?>  
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $conn->real_escape_string($_POST['id']); 
    $fname = strtoupper($conn->real_escape_string($_POST['fname']));
    $lname = strtoupper($conn->real_escape_string($_POST['lname']));
    $password = $conn->real_escape_string($_POST['password']); 
    $gender_id = $conn->real_escape_string($_POST['gender']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $userType = $conn->real_escape_string($_POST['userType']);
    $address = strtoupper($conn->real_escape_string($_POST['address']));
    $passwordSql = !empty($password) ? "password = '".password_hash($password, PASSWORD_DEFAULT)."'," : "";
    $sql = "UPDATE user SET fname = '$fname', lname = '$lname', {$passwordSql} tele = '$mobile', address = '$address', gender_id = '$gender_id', level_id = '$userType' WHERE user_id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('User updated successfully.'); window.location.href='users.php';</script>"; 
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
}
?>
</body>
</html>
