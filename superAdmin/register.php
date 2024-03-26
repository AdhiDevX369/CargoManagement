<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'dbconfig.php'; 
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $conpassword = filter_input(INPUT_POST, 'conpassword', FILTER_SANITIZE_STRING);
    if ($password !== $conpassword) {
        echo "<script>alert('Passwords do not match.'); window.location.href='register.php';</script>";
        exit;
    }
    $query = $conn->prepare("SELECT * FROM superuserrr WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
       
        echo "<script>alert('Username already exists. Please choose a different username.'); window.location.href='register.php';</script>";
    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
        $insertQuery = $conn->prepare("INSERT INTO superuserrr (username, password, created_at, name) VALUES (?, ?, NOW(),?)");
        $insertQuery->bind_param("sss", $username, $hashedPassword,$name);

        if ($insertQuery->execute()) {
            echo "<script>alert('Registration successful.'); window.location.href='register.php';</script>";
        } else {
            echo "<script>alert('There was an error processing your request.'); window.location.href='register.php';</script>";
        }
    }
    $query->close();
    $insertQuery->close();
    $conn->close();
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
  <title>Hidden Register</title>
   <!--INCLUDING CSS-->
   <?php include 'css.php';?>
  
</head>

<body class="bg-theme bg-theme1">

<!-- start loader -->
   <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div>
   <!-- end loader -->

<!-- Start wrapper-->
 <div id="wrapper">

	<div class="card card-authentication1 mx-auto my-4">
		<div class="card-body">
		 <div class="card-content p-2">
		 	<div class="text-center">
		 		<img src="assets/images/logo-icon.png" alt="logo icon">
		 	</div>
		  <div class="card-title text-uppercase text-center py-3">Sign Up</div>
		    <form action="register.php" method="post">

			  <div class="form-group">
			  <label for="exampleInputName" class="sr-only">Name</label>
			   <div class="position-relative has-icon-right">
				  <input type="text" id="name" name="name" class="form-control input-shadow" placeholder="Enter Your Name" required>
				  <div class="form-control-position">
					  <i class="icon-user"></i>
				  </div>
			   </div>
			  </div>
			  <div class="form-group">
			  <label for="exampleInputEmailId" class="sr-only">Username</label>
			   <div class="position-relative has-icon-right">
				  <input type="text" id="username" name="username" class="form-control input-shadow" placeholder="Enter the username" required>
				  <div class="form-control-position">
					  <i class="icon-envelope-open"></i>
				  </div>
			   </div>
			  </div>
			  <div class="form-group">
            <label for="password" class="sr-only">Password</label>
            <div class="position-relative has-icon-right">
                <input type="password" id="password" name="password" class="form-control input-shadow" placeholder="Choose Password" required>
                <div class="form-control-position">
                    <i class="icon-lock"></i>
                </div>
                <small id="passwordHelp" class="form-text text-muted"></small>
            </div>
        </div>
        <div class="form-group">
            <label for="conpassword" class="sr-only">Confirm Password</label>
            <div class="position-relative has-icon-right">
                <input type="password" id="conpassword" name="conpassword" class="form-control input-shadow" placeholder="Re-enter the Password" required>
                <div class="form-control-position">
                    <i class="icon-lock"></i>
                </div>
                <small id="confirmPasswordHelp" class="form-text text-muted"></small>
            </div>
        </div>		  
        <button type="submit" id="submitBtn" class="btn btn-light btn-block waves-effect waves-light">Sign Up</button>

			 </form>
		   </div>
		  </div>
	     </div>
    
     <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
	
	<!--start color switcher-->
  <?php include 'colorswitch.php';?>
  <!--end color switcher-->
	
	</div><!--wrapper-->
  <script>
    document.getElementById('password').addEventListener('input', validatePassword);
    document.getElementById('conpassword').addEventListener('input', validatePassword);

    function validatePassword() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('conpassword').value;
        const passwordHelp = document.getElementById('passwordHelp');
        const confirmPasswordHelp = document.getElementById('confirmPasswordHelp');
        const submitBtn = document.getElementById('submitBtn');

        let valid = true;

        if (password.length < 8 || password.length > 15) {
            passwordHelp.textContent = 'Password must be between 8 and 15 characters.';
            passwordHelp.style.color = 'red';
            valid = false;
        } else {
            passwordHelp.textContent = '';
        }

        if (password !== confirmPassword && confirmPassword !== '') {
            confirmPasswordHelp.textContent = 'Passwords do not match.';
            confirmPasswordHelp.style.color = 'red';
            valid = false;
        } else if (confirmPassword !== '') {
            confirmPasswordHelp.textContent = '';
        }

        submitBtn.disabled = !valid;
  }
</script>
  <!---INCLUDEING JS-->
<?php include 'js.php';?> 


</body>
</html>
