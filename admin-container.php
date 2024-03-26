<?php
    session_start();
    if (!isset($_SESSION['username'])) {
     header('Location: user-login.php');
     exit(); 
 }

?>
<?php
include 'DB/dbconfig.php';
$invoiceNumbers = [];
$query = "SELECT invoice_number FROM invoice";
$result = $conn->query($query);
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $invoiceNumbers[] = $row['invoice_number'];
    }
} else {
    echo "No invoices found";
}
?>
<?php
include 'DB/dbconfig.php';
$containerIds = [];
$query = "SELECT container_id FROM container";
$result = $conn->query($query);
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $containerIds[] = $row['container_id'];
    }
} else {
    echo "No container IDs found";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include "css.php";
    ?>
    <title>
        Add container ID
    </title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    
</head>


<body class="sidebar-expand">

    <?php
    include "header.php";
    ?>

    <!-- MAIN CONTENT -->
    <div class="main">
        <div class="main-content user">
            <div class="box">
                <div class="box-body pb-30">
                    <div class="row">
                    <div class="col-md-6 col-sm-12 mb-24">
                            <div class="form-group">
                                <label class="form-label">Invoice ID</label>
                                <select class="form-control" id="invoice_id" name="invoice_id" required>
                                    <option value="">---Select Invoice ID---</option>
                                    <?php foreach($invoiceNumbers as $invoiceNumber): ?>
                                        <option value="<?php echo htmlspecialchars($invoiceNumber); ?>">
                                            <?php echo htmlspecialchars($invoiceNumber); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>    
                        </div>
                    </div>
                    <!--Row02-->
                    <div class="row">
                    <div class="col-md-6 col-sm-12 mb-24">
                                <div class="form-group">
                                    <label class="form-label">Container ID</label>
                                    <select class="form-control" id="con_id" name="con_id" required>
                                        <option value="">---Select Container ID---</option>
                                        <?php foreach($containerIds as $containerId): ?>
                                            <option value="<?php echo htmlspecialchars($containerId); ?>">
                                                <?php echo htmlspecialchars($containerId); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>    
                            </div>
                    </div>
                    <!--End row02-->
                    <!--Row03-->
                    <div class="row">
                        <div class="gr-btn mt-15 ">
                            <button class="btn btn-primary" id="create_invoice" type="submit">Add Container ID</button>
                            <button class="btn btn-danger" id="reset" type="reset">Clear</button>
                        </div>
                    </div>
                      <!--End row03-->
                      <div class="row">
                        <div class="col-md-12 col-sm-12 mb-24 mt-3">
                            <div class="alert alert-success" role="alert" id="success-message" style="display: none;"></div>
                            <div class="alert alert-danger" role="alert" id="error-message" style="display: none;"></div>
                        </div>
                      </div>
                </div>
                <!--End of row-->
            </div>
        </div>

        </div>
    </div>
    <!-- END MAIN CONTENT -->
    <div>
    <div class="overlay"></div>

    <!-- SCRIPT -->
    <!-- APEX CHART -->

    <!--script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script-->
    <script src="libs/jquery/jquery.min.js"></script>
    <script src="libs/jquery/jquery-ui.min.js"></script>
    <script src="libs/moment/min/moment.min.js"></script>
    <script src="libs/apexcharts/apexcharts.js"></script>
    <script src="libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="libs/peity/jquery.peity.min.js"></script>
    <script src="libs/chart.js/Chart.bundle.min.js"></script>
    <script src="libs/owl.carousel/owl.carousel.min.js"></script>
    <script src="libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="libs/bootstrap-datepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script src="js/countto.js"></script>
    <script src="libs/date-picker/datepicker.js"></script>
    <script src="libs/rating/js/custom-ratings.js"></script>
    <script src="libs/rating/js/jquery.barrating.js"></script>
    <script src="libs/circle-progress/circle-progress.min.js"></script>
    <script src="libs/simplebar/simplebar.min.js"></script>


    <!-- APP JS -->
    <script src="js/main.js"></script>
    <script src="js/shortcode.js"></script>
    <script src="js/pages/datepicker.js"></script>
    <script src="js/pages/chart-circle.js"></script>

    <script>
    $(document).ready(function() {
     
        $('#create_invoice').click(function(e) {
            e.preventDefault(); 

            var invoiceId = $('#invoice_id').val();
            var containerId = $('#con_id').val();

            $.ajax({
                type: 'POST', 
                url: 'invoice/addContainerId.php', 
                data: {
                    invoice_id: invoiceId,
                    con_id: containerId
                },
                success: function(response) {
                    
                    //alert('Data submitted successfully');
                    if(response.status === 'success') {
                        $('#success-message').text(response.message).show();
                        $('#error-message').hide();
                    } else if(response.status === 'error') {
                        $('#error-message').text(response.message).show();
                        $('#success-message').hide();
                    }
                },
                error: function(xhr, status, error) {
                   
                    //alert('An error occurred');
                    $('#error-message').text('An error occurred while processing your request.').show();
                    $('#success-message').hide();
                }
            });
        });

        // Reset button codes
        $('#reset').click(function() {
            $('#invoice_id').val('');
            $('#con_id').val('');
            $('#success-message').hide();
            $('#error-message').hide();
            location.reload();
            });
    });
    </script>
 
</body>
<!-- Mirrored from themesflat.co/html/protend/user-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Oct 2023 16:20:40 GMT -->

</html>