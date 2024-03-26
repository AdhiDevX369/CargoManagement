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
                            <div class="form-group"> <label class="form-label">Container ID</label><input class="form-control" id="con_id" type="number" name="con_id" min="1" placeholder="Enter the Container ID" required>
                            </div>    
                        </div>
                    </div>
                    <!--End row02-->
                    <!--Row03-->
                    <div class="row">
                        <div class="gr-btn mt-15 ">
                            <button class="btn btn-primary" id="create_invoice" type="submit">Search</button>
                            <button class="btn btn-danger" id="reset" type="reset">Clear</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="container-details mt-3">
                        <table id="container-details-table" class="table">
                            <thead>
                                <tr>
                                    <th>Order Id</th>
                                    <th>Recieved Date</th>
                                    <th>Shipping Company</th>
                                    <th>Shipping Date</th>                           
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data rows will be added here -->
                            </tbody>
                        </table>
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
        // Function to convert data to CSV format
        function convertToCSV(data, containerId) {
            var csvRows = [];
            // Add heading with Container ID
            csvRows.push('Container ID: ' + containerId);
            // Add a blank row for spacing
            csvRows.push('');
            // Add header row for data
            csvRows.push('Order ID,Received Date,Shipping Company,Shipping Date');
            data.forEach(function(item) {
                csvRows.push([item.order_id, item.received_date, item.shipping_company, item.shipping_date].join(','));
            });
            return csvRows.join('\n');
        }

        // Function to download CSV file
        function downloadCSV(csvData, filename) {
            var blob = new Blob([csvData], { type: 'text/csv;charset=utf-8;' });
            var url = URL.createObjectURL(blob);
            var downloadLink = document.createElement('a');
            downloadLink.href = url;
            downloadLink.download = filename;
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
            URL.revokeObjectURL(url);
        }

        $('#create_invoice').click(function(e) {
            e.preventDefault(); 
            var containerId = $('#con_id').val();
            $.ajax({
                type: 'post', 
                url: 'invoice/getContainerDet.php',
                dataType: 'json',
                data: { con_id: containerId },
                success: function(response) {
                    $('#container-details-table tbody').empty();
                    if(response.status === 'success' && response.data.length > 0) {
                        response.data.forEach(function(item) {
                            var row = '<tr>' +
                                    '<td>' + item.order_id + '</td>' +
                                    '<td>' + item.received_date + '</td>' +
                                    '<td>' + item.shipping_company + '</td>' +
                                    '<td>' + item.shipping_date + '</td>' +
                                    '</tr>';
                            $('#container-details-table tbody').append(row);
                        });
                        var downloadButtonRow = '<tr><td colspan="4"><button class="btn btn-primary" id="download-all">Download</button></td></tr>';
                        $('#container-details-table tbody').append(downloadButtonRow);

                        // Add click event listener for Download button
                        $('#download-all').click(function() {
                            var csvData = convertToCSV(response.data, containerId);
                            downloadCSV(csvData, 'container_data.csv');
                        });

                    } else {
                        $('#container-details-table tbody').append('<tr><td colspan="4">No data found</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        $('#reset').click(function() {
            $('#con_id').val('');
            $('#container-details-table tbody').empty();
        });
    });
    </script>




    
</body>
<!-- Mirrored from themesflat.co/html/protend/user-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Oct 2023 16:20:40 GMT -->

</html>