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
        All Orders - Driver
    </title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>


<body class="sidebar-expand">

    <?php
    include "driver-header.php";
    ?>

    <!-- MAIN CONTENT -->
    <div class="main">
        <div class="main-content user">
            <div class="box">
                <div class="box-body pb-30">
                    <div class="row">
                        <!--div class="col-md-4 col-xl-2 mb-0">
                            <div class="form-group mt-32"> <a href="#" class="btn bg-primary btn-block color-white"
                                    id="search">Search</a>
                            </div>
                        </div-->
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
                            <!-- <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="dataTables_length" id="task-profile_length"><label>Show <select name="task-profile_length" aria-controls="task-profile" class="form-select form-select-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div id="task-profile_filter" class="dataTables_filter"><label><input type="search" class="form-control form-control-sm" placeholder="Search..." aria-controls="task-profile"></label></div>
                                        </div>
                                    </div> -->
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
                                                    style="width: 222.312px;">Order ID</th>
                                                <th class="border-bottom-0 sorting fs-14 font-w500" tabindex="0"
                                                    aria-controls="task-profile" rowspan="1" colspan="1"
                                                    style="width: 84.8281px;">Customer Name</th>
                                                <th class="border-bottom-0 sorting fs-14 font-w500" tabindex="0"
                                                    aria-controls="task-profile" rowspan="1" colspan="1"
                                                    style="width: 84.8281px;">Customer Contact Number</th>
                                                <th class="border-bottom-0 sorting fs-14 font-w500" tabindex="0"
                                                    aria-controls="task-profile" rowspan="1" colspan="1"
                                                    style="width: 84.8281px;">Customer Address</th>    
                                            </tr>
                                        </thead>
                                        <tbody id="ordersTableBody">

                                        </tbody>
                                    </table>
                                    <input type="hidden" id="driver" name="driver" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>">
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

    <!-- POPUP FORM -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 mb-24">
                                <div class="form-group"> <label class="form-label">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 mb-24">
                                <div class="form-group"> <label class="form-label">Payment</label>
                                    <input class="form-control" min="0" oninput="validity.valid||(value='');"
                                        id="payAmount" name="payAmount" required type="Number">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveOrderBtn">Save</button>
                </div>
            </div>
        </div>
    </div>


    <!-- END POPUP FORM -->



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
        currentDate = new Date().toISOString().split('T')[0];
        //console.log(currentDate);
        var formData = {
            selectedDate: currentDate,
            driver: $('#driver').val(),
            page: page
        };

        $.ajax({
            url: 'driver/driverallorders.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                //console.log("Response from server: ", response);
                $("#ordersTableBody").empty();
                if (response.orders && response.orders.length > 0) {
                    response.orders.forEach(function(order, index) {
                        var backgroundColor = '';
                        if (order.method === 'Pick Up Only') {
                            backgroundColor = '#aaf097'; // Green for Pick Up Only
                        } else if (order.method === 'Delivery and Pickup') {
                            backgroundColor = '#faf67a'; // Yellow for Delivery and Pickup
                        }

                        var row = `<tr style="background-color: ${backgroundColor}">
                            <td class="text-center">${index + 1 + ((currentPage - 1) * recordsPerPage)}</td>
                            <td><a href="#" onclick="fetchOrderDetails(${order.order_Id})">${order.order_Id}</a></td>
                            <td>${order.customer_Name}</td>
                            <td>${order.customer_contactNo}</td>
                            <td>${order.customer_address}</td>
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
            url: 'order/fetchalldetails.php',
            type: 'GET',
            data: { 'order_id': orderId },
            success: function(response) {
                // ... Existing code for fetchOrderDetails ...
                $('#saveOrderBtn').data('method', response.method);
                if (response.error) {
                        //console.error("Error: ", response.error);
                    } else {
                        var detailsHtml = "";
                        detailsHtml += "<tr><td>Order ID</td><td>" + response.order_Id + "</td></tr>";
                        detailsHtml += "<tr><td>Method</td><td>" + response.method + "</td></tr>";
                        detailsHtml += "<tr><td>Customer Name</td><td>" + response.customer_Name + "</td></tr>";
                        detailsHtml += "<tr><td>Customer's Address</td><td>" + response.customer_address + "</td></tr>";
                        detailsHtml += "<tr><td>Customer's Contact Number</td><td>" + response.customer_contactNo + "</td></tr>";
                        detailsHtml += "<tr><td>Box Type</td><td>" + response.box_type + "</td></tr>";
                        detailsHtml += "<tr><td>Number of Boxes</td><td>" + response.box_qty + "</td></tr>";
                        detailsHtml += "<tr><td>Delivery Date</td><td>" + (response.delivery_date ? response.delivery_date : "Not included") + "</td></tr>";
                        detailsHtml += "<tr><td>Pick up Date</td><td>" + response.pickup_date + "</td></tr>";
                        detailsHtml += "<tr><td>Payement Method</td><td>" + response.payment_method + "</td></tr>";
                        detailsHtml += "<tr><td>Total Payment for the Order</td><td>" + response.total_payment + "</td></tr>";
                        detailsHtml += "<tr><td>Cutomer Paid</td><td>" + response.customer_pay + "</td></tr>";
                        detailsHtml += "<tr><td>Remaining amount to pay</td><td>" + (response.total_payment - response.customer_pay) + "</td></tr>";
                        detailsHtml += "<tr><td>Order Remarks</td><td>" + (response.remarks ? response.remarks : "No") + "</td></tr>";
                       // detailsHtml += "<tr><td colspan='2'><button class='btn btn-primary confirm-btn' data-order-id='" + response.order_Id + "'>Confirm</button></td></tr>";
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

        $(document).on('click', '.confirm-btn', function() {
            var orderId = $(this).data('order-id');
            $('#exampleModal').modal('show');
            $('#saveOrderBtn').data('order-id', orderId); // Store orderId in the "Save" button
        });

        loadOrders(1); // Load initial set of orders

        // Event handler for showing the modal when the Confirm button is clicked
        $(document).on('click', '.confirm-btn', function() {
            var orderId = $(this).data('order-id');
            $('#exampleModal').modal('show');
        });

        // Event handler for the Save button in the modal
        $('#saveOrderBtn').click(function() {
            var orderId = $(this).data('order-id');
            var methodof = $(this).data('method');
            var remarks = $('#remarks').val();
            var paymentAmount = $('#payAmount').val();
            

            // AJAX call to send the data
            $.ajax({
                url: 'driver/driverconfirm.php', 
                type: 'POST',
                data: {
                    order_id: orderId,
                    remarks: remarks,
                    method: methodof,
                    payAmount: paymentAmount
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        console.log("Success: ", response.message);
                        // this code notify the user
                        $("#success-message").text(response.message).show();
                        $("#error-message").hide();

                         // Scroll to the success message
                            $('html, body').animate({
                                scrollTop: $("#success-message").offset().top
                            }, 'slow');
                    } else {
                        console.error("Error: ", response.message);
                        // Add code to handle the error case
                        $("#error-message").text(response.message).show();
                        $("#success-message").hide();

                        // Scroll to the error message
                            $('html, body').animate({
                                scrollTop: $("#error-message").offset().top
                            }, 'slow');
                    }
                    $('#exampleModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    //console.error("Error: ", error);
                   // $("#error-message").text(response.message).show();
                       // $("#success-message").hide();

                        // Scroll to the error message
                          /*  $('html, body').animate({
                                scrollTop: $("#error-message").offset().top
                            }, 'slow');*/
                    
                }
            });
        });
    });
</script>










</body>


<!-- Mirrored from themesflat.co/html/protend/user-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Oct 2023 16:20:40 GMT -->

</html>