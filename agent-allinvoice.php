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
                        <div class="col-md-12 col-xl-10 mb-0">
                            <div class="row">
                                <div class="form-group"> <label class="form-label">Select the option</label> </div>
                                <br>

                                <!-- Radio button -->
                                <div class="col-md-6 col-sm-12 mb-24">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault2"
                                            id="pickup" value="rcvDate" checked>
                                        <label class="form-check-label" for="flexRadioDefault5">
                                            Recieved Date
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-24">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault2"
                                            id="delipickup" value="shpDate">
                                        <label class="form-check-label" for="flexRadioDefault5">
                                            Shipping Date
                                        </label>
                                    </div>
                                </div>

                                 <!--End  Radio button -->
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12 mb-24">
                            <div class="form-group"> <label class="form-label">Date</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="pickup_date" name="pickup_date"
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
                <!-- Information table -->
                <div class="box-body">
                    <div class="table-responsive">
                        <div id="task-profile_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-vcenter text-nowrap table-bordered dataTable no-footer"
                                        id="task-profile" role="grid">
                                        <thead>
                                            <tr class="top">
                                            <th class="border-bottom-0 text-center sorting fs-14 font-w500"
                                                    tabindex="0" aria-controls="task-profile" rowspan="1" colspan="1"
                                                    style="width: 26.6562px;">No</th>
                                                    <th class="border-bottom-0 sorting fs-14 font-w500" tabindex="0"
                                                    aria-controls="task-profile" rowspan="1" colspan="1"
                                                    style="width: 222.312px;">Invoice Number</th>
                                                <th class="border-bottom-0 sorting fs-14 font-w500" tabindex="0"
                                                    aria-controls="task-profile" rowspan="1" colspan="1"
                                                    style="width: 222.312px;">Order ID</th>
                                                <th class="border-bottom-0 sorting fs-14 font-w500" tabindex="0"
                                                    aria-controls="task-profile" rowspan="1" colspan="1"
                                                    style="width: 84.8281px;">Recieved Date</th>
                                                <th class="border-bottom-0 sorting fs-14 font-w500" tabindex="0"
                                                    aria-controls="task-profile" rowspan="1" colspan="1"
                                                    style="width: 84.8281px;">Shipping Date</th>
                                                <th class="border-bottom-0 sorting fs-14 font-w500" tabindex="0"
                                                    aria-controls="task-profile" rowspan="1" colspan="1"
                                                    style="width: 84.8281px;">Total Amount</th>    
                                            </tr>
                                        </thead>
                                        <tbody id="ordersTableBody">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <!--Pagination comes here-->
                                <div class="col-sm-12">
                                    <div class="pagination-container">
                                        <ul class="pagination">
                                            <!-- Pagination links will be dynamically inserted here by your JavaScript -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3 col-xl-12">

            <div class="box left-dot pt-39 mb-30">
                <div class="box-header  border-0 ">
                    <div class="box-title fs-20 font-w600">Order Info</div>
                </div>
                <div class="box-body pt-16 user-profile">
                    <div class="table-responsive">
                        <table class="table mb-0 mw-100 color-span">
                            <tbody id="driverOrderDetailsBody">
                                <!--Here fetch all driver order details of a specific user-->
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 mb-24">
            <div class="alert alert-success" role="alert" id="success-message" style="display: none;"></div>
            <div class="alert alert-danger" role="alert" id="error-message" style="display: none;"></div>
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
    var currentPage = 1; // Start with page 1
    var recordsPerPage = 5; // Set the number of records per page

    function loadOrders(page) {
        currentPage = page;
        var formData = {
            selectedDate: $('#pickup_date').val(),
            selectedOption: $('input[name="flexRadioDefault2"]:checked').val(),
            page: page
        };

        $.ajax({
            url: 'invoice/fetchInvoices.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                //console.log("Response from server: ", response);
                $("#ordersTableBody").empty();
                if (response.orders && response.orders.length > 0) {
                    response.orders.forEach(function(order, index) {
                        var row = `<tr>
                            <td class="text-center">${index + 1 + ((currentPage - 1) * recordsPerPage)}</td>
                            <td><a href="#" onclick="fetchOrderDetails('${order.invoice_number}')">${order.invoice_number}</a></td>
                            <td>${order.order_id}</td>
                            <td>${order.received_date}</td>
                            <td>${order.shipping_date}</td>
                            <td>${order.total_amount}</td>
                        </tr>`;
                        $("#ordersTableBody").append(row);
                    });
                    updatePagination(response.totalRecords, recordsPerPage, currentPage);
                } else {
                    $("#ordersTableBody").append('<tr><td colspan="7" class="text-center">No orders found</td></tr>');
                    $(".pagination").empty();
                }
            },
            error: function(xhr, status, error) {
                //console.error("Error: ", error);
            }
        });
    }

    function updatePagination(totalRecords, recordsPerPage, currentPage) {
        var totalPages = Math.ceil(totalRecords / recordsPerPage);
        var paginationHtml = '';
        for (var i = 1; i <= totalPages; i++) {
            paginationHtml += `<li class="paginate_button page-item ${i === currentPage ? 'active' : ''}">
                <a href="#" class="page-link" data-page="${i}">${i}</a>
            </li>`;
        }
        $(".pagination").html(paginationHtml);
    }

    function fetchOrderDetails(orderId) {
        $.ajax({
            url: 'invoice/fetchAllInvoices.php',
            type: 'GET',
            data: { 'order_id': orderId },
            success: function(response) {
                // ... Existing code for fetchOrderDetails ...
                //console.log(data);
                if (response.error) {
                        //console.error("Error: ", response.error);
                    } else {
                        var detailsHtml = "";
                        detailsHtml += "<tr><td>Invoice Number</td><td>" + response.invoice_number + "</td></tr>";
                        detailsHtml += "<tr><td>Order ID</td><td>" + response.order_id + "</td></tr>";
                        detailsHtml += "<tr><td>Recieved Date</td><td>" + response.received_date + "</td></tr>";
                        detailsHtml += "<tr><td>Shipping Company</td><td>" + response.shipping_company + "</td></tr>";
                        detailsHtml += "<tr><td>Container ID</td><td>" + (response.container_id ? response.container_id : "NOT YET") + "</td></tr>";
                        detailsHtml += "<tr><td>Shipping Date</td><td>" + response.shipping_date + "</td></tr>";
                        detailsHtml += "<tr><td>Total Packages</td><td>" + response.total_packages + "</td></tr>";
                        detailsHtml += "<tr><td>Total Volume</td><td>" + response.	total_volume+ "</td></tr>";
                        detailsHtml += "<tr><td>Total Weight</td><td>" + response.total_weight + "</td></tr>";
                        detailsHtml += "<tr><td>Total Value</td><td>" + response.total_value + "</td></tr>";
                        detailsHtml += "<tr><td>Freight Charges</td><td>" + response.freight_charges + "</td></tr>";
                        detailsHtml += "<tr><td>Handling Charges</td><td>" + response.handling_charges + "</td></tr>";
                        detailsHtml += "<tr><td>Door To Door Charges</td><td>" + response.dtd_charges+ "</td></tr>";
                        detailsHtml += "<tr><td>Domestic Charges</td><td>" + response.domestic_charges + "</td></tr>";
                        detailsHtml += "<tr><td>Insurance Charges</td><td>" + response.insurance_charges + "</td></tr>";
                        detailsHtml += "<tr><td>Tax</td><td>" + response.tax + "</td></tr>";
                        detailsHtml += "<tr><td>Packing Charges</td><td>" + response.packing_charges + "</td></tr>";
                        detailsHtml += "<tr><td>Total Amount</td><td>" + response.total_amount + "</td></tr>";
                        $("#driverOrderDetailsBody").html(detailsHtml);
                    }
                    //scroll to id=orderDetailsBody
                    $('html, body').animate({
                        scrollTop: $("#driverOrderDetailsBody").offset().top
                    });
            },
            error: function(xhr, status, error) {
                //console.error("Error fetching order details: ", error);
            }
        });
    }

    $(document).ready(function() {
        $('#search').click(function(e) {
            e.preventDefault();
            loadOrders(1);
        });

        $('#reset').click(function() {
            location.reload();
        });
        loadOrders(1); // Load initial set of orders
    });
</script>
</body>
<!-- Mirrored from themesflat.co/html/protend/user-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Oct 2023 16:20:40 GMT -->

</html>