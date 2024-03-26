<?php
require 'session.php';
require 'dbconfig.php';
?>
<?php
$sql = "SELECT * FROM warehousedriver";
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
  <title>Local Drivers</title>
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
                  <form action="" method="post">
                    <h4>Local Warehouse Drivers' Registration</h4>
                    <hr>
                    <div class="form-group">
                      <label for="input-1">First Name</label>
                      <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter the first Name" required>
                    </div>
                    <div class="form-group">
                      <label for="input-2">Last Name</label>
                      <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter the last Name" required>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Username</label>
                      <input type="text" class="form-control" id="username" name="username" placeholder="Enter the username" required>
                    </div>
                    <div class="form-group">
                      <label for="input-4">Password</label>
                      <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                    </div>
                    <div class="form-group">
                      <label for="input-5">Confirm Password</label>
                      <input type="password" class="form-control" id="conpass" name="conpass" placeholder="Confirm Password" onblur="validatePasswords()" required>
                      <small id="passwordError" class="form-text text-muted" style="color: red;"></small>
                    </div>
                    <script>
                      function validatePasswords() {
                        var password = document.getElementById("password").value;
                        var confirmPassword = document.getElementById("conpass").value;
                        var passwordError = document.getElementById("passwordError");
                        if (password !== confirmPassword) {
                          passwordError.textContent = "Passwords do not match.";
                        } else {
                          passwordError.textContent = "";
                        }
                      }
                    </script>
                    <div class="form-group">
                      <label for="inputGender">Warehouse</label>
                      <select class="form-control" id="warehouse" name="warehouse" required>
                        <option value="">--Warehouse Location--</option>
                        <option value="KURUNEGALA">Kurunegala</option>
                        <option value="GALLE">Galle</option>
                        <option value="KANDY">Kandy</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="input-3">Mobile Number</label>
                      <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter the Mobile Number" required>
                    </div>
                    <div class="form-group">
                      <label for="address">Address</label>
                      <textarea class="form-control" id="address" name="address" rows="5" placeholder="Enter the address" required></textarea>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-light px-5">
                        <i class="icon-lock"></i> Register
                      </button>
                      <button type="reset" class="btn btn-light px-5"><i class="zmdi zmdi-alert-octagon"></i> Reset</button>
                    </div>
                  </form>
                </div><!--End Row-->
                <div class="row">
                  <hr>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">User Id</th>
                          <th scope="col">Username</th>
                          <th scope="col">First Name</th>
                          <th scope="col">Mobile Number</th>
                          <th scope="col">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                          // Output data of each row
                          while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<th scope='row'>" . htmlspecialchars($row['id']) . "</th>";
                            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['fname']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['mobile']) . "</td>";
                            echo "<td>" .
                            "<button style='background-color: red; color: white;' onclick='if(confirm(\"Are you sure you want to delete this user?\")) location.href=\"deleteLocalDriver.php?id=" . $row['id'] . "\"'>Delete</button>" .
                              "</td>";
                            echo "</tr>";
                          }
                        } else {
                          echo "<tr><td colspan='4'>No users found</td></tr>";
                        }
                        ?>
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
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $fname = strtoupper($conn->real_escape_string($_POST['fname']));
    $lname = strtoupper($conn->real_escape_string($_POST['lname']));
    $warehouse = strtoupper($conn->real_escape_string($_POST['lname']));
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $address = strtoupper($conn->real_escape_string($_POST['address']));
    
    $stmt = $conn->prepare("SELECT username FROM warehousedriver WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      echo "<script>alert('Username already exists.'); window.location.href='localdrivers.php';</script>";
    } else {
      $stmt = $conn->prepare("INSERT INTO warehousedriver (username, password, fname, lname, mobile, address, warehouse) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("sssssss", $username, password_hash($password, PASSWORD_DEFAULT), $fname, $lname, $mobile, $address,$warehouse);

      if ($stmt->execute()) {
        echo "<script>alert('User registered successfully.'); window.location.href='localdrivers.php';</script>";
      } else {
        echo "<script>alert('There was an error registering the user.'); window.location.href='localdrivers.php';</script>";
      }
      $stmt->close();
    }
    $conn->close();
  } else {
    //header("Location: users.php");
    exit();
  }
  ?>
</body>

</html>