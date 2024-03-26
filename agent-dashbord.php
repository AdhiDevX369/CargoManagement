<?php
    session_start();
    if (!isset($_SESSION['username'])) {
     header('Location: user-login.php');
     exit(); 
 }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include "css.php";
    ?>
    <title>
        Agent Dashbord
    </title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>


<body class="sidebar-expand">

    <?php
     include "agent-header.php";
    ?>

    <!-- MAIN CONTENT -->
    <div class="main">
        <div class="main-content user">
            <div class="box">
                <div class="box-body pb-30">
                    <div class="row">
                        <div class="col-md-4 col-sm-12 mb-24">
                            <div class="form-group"> <label class="form-label">Invoice ID</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="invoice_id" name="invoice_id"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-2 mb-0">
                            <div class="form-group mt-32"> <a href="#" class="btn bg-primary btn-block color-white"
                                    id="search">Search</a>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-2 mb-0">
                            <div class="form-group mt-32">
                                <button class="btn btn-danger" id="reset" type="reset">Clear</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <div id="task-profile_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-vcenter text-nowrap table-bordered dataTable no-footer"
                                        id="task-profile" role="grid">
                                        <thead>
                                        </thead>
                                        <tbody id="ordersTableBody">
                                            <!--ORDERS TABLE BODY-->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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
            $('#search').click(function(e) {
                e.preventDefault(); 

                var invoiceId = $('#invoice_id').val(); 

                $.ajax({
                    url: 'invoice/findInvoiceById.php', 
                    type: 'POST',
                    dataType: 'json', 
                    data: { invoice_id: invoiceId }, 
                    success: function(response) {
                        
                        if (response.status ==='error') {
                            $('#ordersTableBody').html('<tr><td colspan="2">' + response.message + '</td></tr>');

                        }   
                         else {                           
                            var detailsHtml = "";
                            detailsHtml += "<tr><td>ID</td><td>" + response.id + "</td></tr>";
                            detailsHtml += "<tr><td>Invoice ID</td><td>" + response.invoice_number + "</td></tr>";
                            detailsHtml += "<tr><td>Order ID</td><td>" + response.order_id + "</td></tr>";
                            detailsHtml += "<tr><td>Received Date</td><td>" + response.received_date + "</td></tr>";
                            detailsHtml += "<tr><td>Shipping Company</td><td>" + response.shipping_company + "</td></tr>";
                            detailsHtml += "<tr><td>Container ID</td><td>" + response.container_id + "</td></tr>";
                            detailsHtml += "<tr><td>Shipping Date</td><td>" + response.shipping_date + "</td></tr>";
                            detailsHtml += "<tr><td>Total Packages</td><td>" + response.total_packages + "</td></tr>";
                            detailsHtml += "<tr><td>Total Volume</td><td>" + response.total_volume + "</td></tr>";
                            detailsHtml += "<tr><td>Total Weight</td><td>" + response.total_weight + "</td></tr>";
                            detailsHtml += "<tr><td>Total Value</td><td>" + response.total_value + "</td></tr>";
                            detailsHtml += "<tr><td>Freight Charges</td><td>" + response.freight_charges + "</td></tr>";
                            detailsHtml += "<tr><td>Handling Charges</td><td>" + response.handling_charges + "</td></tr>";
                            detailsHtml += "<tr><td>Door To Door Charges</td><td>" + response.dtd_charges + "</td></tr>";
                            detailsHtml += "<tr><td>Domestic Charges</td><td>" + response.domestic_charges + "</td></tr>";
                            detailsHtml += "<tr><td>Insurance Charges</td><td>" + response.insurance_charges + "</td></tr>";
                            detailsHtml += "<tr><td>Packing Charges</td><td>" + response.packing_charges + "</td></tr>";
                            detailsHtml += "<tr><td>Tax</td><td>" + response.tax + "</td></tr>";
                            detailsHtml += "<tr><td>Total Amount</td><td>" + response.total_amount + "</td></tr>";
                            $('#ordersTableBody').html(detailsHtml);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error occurred: " + status + "\nError: " + error);
                    }
                });
            });
            $('#reset').click(function() {            
                $('#ordersTableBody').empty();
                $('#invoice_id').val('');
            });
        });
    </script>










</body>


<!-- Mirrored from themesflat.co/html/protend/user-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Oct 2023 16:20:40 GMT -->

</html>