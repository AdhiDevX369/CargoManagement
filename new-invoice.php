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
        Create Invoice
    </title>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>


<body class="sidebar-expand">

    <?php
    include "agent-header.php";
    ?>

    <div class="main">

        <div class="main-content project">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-body">
                            <form id="invoiceForm" method="POST">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 mb-24">
                                        <div class="form-group"> <label class="form-label">Invoice ID</label> <input
                                                class="form-control" id="invoice_id"  name="invoice_id" placeholder="Enter the Invoice Id here"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mb-24">
                                        <div class="form-group">
                                            <label class="form-label">Order ID</label>
                                            <input class="form-control" id="order_id" type="number" name="order_id" min="1" placeholder="Enter the Order Id here" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 mb-24">
                                        <div class="form-group">
                                            <label for="date">Recieved Date</label>
                                            <input type="date" class="form-control" id="rec_date" name ="rec_date"required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mb-24">
                                        <div class="form-group"> <label class="form-label">Shipping Company</label>
                                            <input class="form-control" placeholder="Shipment  Company"
                                                id="ship_company" name="ship_company" required type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 mb-24">
                                        <div class="form-group">
                                            <label class="form-label">packing charges</label>
                                            <input type="number" class="form-control" id="pkncharge" name="pkncharge" placeholder="Enter Packing charges" min="0" required>                                      
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mb-24">
                                        <div class="form-group">
                                            <label class="form-label">Shipping Date</label>
                                            <input type="date" class="form-control" id="ship_date" name="ship_date" required>
                                        </div>
                                    </div>  
                                </div>
                                <div class="row">
                                <div class="col-md-6 col-sm-12 mb-24">
                                            <div class="form-group">
                                                <label class="form-label">Total Packages</label>
                                                <input type="number" class="form-control" id="tot_pack" name="tot_pack" min="1" required>
                                            </div>
                                        </div>
                                    <div class="col-md-6 col-sm-12 mb-24">
                                        <div class="form-group">
                                            <label class="form-label">Total Volume</label>
                                            <input type="number" class="form-control" id="tot_vol" name="tot_vol" placeholder="Enter the Total Volume" min="1" required>
                                        </div>
                                    </div>                                                                            
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 mb-24">
                                        <div class="form-group">
                                            <label class="form-label">Total weight</label>
                                            <input type="number" class="form-control" id="tot_wei" name="tot_wei" placeholder="Enter Total Weight" min="1" required>                                      
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mb-24">
                                        <div class="form-group">
                                            <label class="form-label">Total Value</label>
                                            <input type="number" class="form-control" id="tot_val" placeholder="Enter the Total Value" min="1" required>
                                        </div>
                                    </div>                                                                            
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 mb-24">
                                        <div class="form-group">
                                            <label class="form-label">Freight Charges</label>
                                            <input type="number" class="form-control" id="freight" name="freight" placeholder="Enter Freight charges" min="0" required>                                      
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mb-24">
                                        <div class="form-group">
                                            <label class="form-label">Handling Charges</label>
                                            <input type="number" class="form-control" id="handling" name="handling" placeholder="Enter Handling Charges" min="0" required>
                                        </div>
                                    </div>                                                                            
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 mb-24">
                                        <div class="form-group">
                                            <label class="form-label">Doot to Door Charges</label>
                                            <input type="number" class="form-control" id="dtod" name="dtod" placeholder="Enter Door to Door charges" min="0" required>                                      
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mb-24">
                                        <div class="form-group">
                                            <label class="form-label">Domestic Charges</label>
                                            <input type="number" class="form-control" id="domestic" name="domestic" placeholder="Enter Domestic Charges" min="0" required>
                                        </div>
                                    </div>                                                                            
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 mb-24">
                                        <div class="form-group">
                                            <label class="form-label">Insurance Charges</label>
                                            <input type="number" class="form-control" id="inscharge" name="inscharge" placeholder="Enter Insurance charges" min="0" required>                                      
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mb-24">
                                        <div class="form-group">
                                            <label class="form-label">Tax</label>
                                            <input type="number" class="form-control" id="tax" name="tax" placeholder="Enter Tax Charges" min="0" required>
                                        </div>
                                    </div>                                                                            
                                </div>
                                <div class="row">
                 
                                    <div class="col-md-6 col-sm-12 mb-24">
                                        <div class="form-group">
                                            <label class="form-label">Total Amount</label>
                                            <input type="text" class="form-control" id="totamtDisplay" readonly>
                                            <input type="hidden" id="totamt" name="totamt">
                                        </div>
                                    </div>                                                                            
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 mb-24">
                                        <div class="alert alert-success" role="alert" id="success-message" style="display: none;"></div>
                                        <div class="alert alert-danger" role="alert" id="error-message" style="display: none;"></div>
                                    </div>
                                </div>

                                <div class="gr-btn mt-15  text-center">
                                    <button class="btn btn-primary" id="create_invoice" type="submit">Create
                                        Invoice</button>
                                    <button class="btn btn-danger" id="reset" type="reset">Clear</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <!-- END MAIN CONTENT -->
        </div>

        <?php
        include "js.php";
        ?>
 <script>
    
    var freight = document.getElementById('freight');
    var handling = document.getElementById('handling');
    var dtod = document.getElementById('dtod');
    var domestic = document.getElementById('domestic');
    var inscharge = document.getElementById('inscharge');
    var tax = document.getElementById('tax');
    var pkncharge = document.getElementById('pkncharge');
    var totamt = document.getElementById('totamt');

    
    var charges = [freight, handling, dtod, domestic, inscharge, tax, pkncharge];

    
    function calculateTotal() {
    var total = 0;
    for (var i = 0; i < charges.length; i++) {
        total += parseFloat(charges[i].value) || 0;
    }
    document.getElementById('totamtDisplay').value = total.toFixed(2);
    document.getElementById('totamt').value = total.toFixed(2);

    }

    
    for (var i = 0; i < charges.length; i++) {
        charges[i].addEventListener('input', calculateTotal);
    }
</script>

<script>
$(document).ready(function() {
    $("#invoiceForm").submit(function(event) {
    
        event.preventDefault();

        
        var formData = {
            invoice_id: $("#invoice_id").val(),
            order_id: $("#order_id").val(),
            rec_date: $("#rec_date").val(),
            ship_company: $("#ship_company").val(),
            ship_date: $("#ship_date").val(),
            tot_pack: $("#tot_pack").val(),
            tot_vol: $("#tot_vol").val(),
            tot_wei: $("#tot_wei").val(),
            tot_val: $("#tot_val").val(),
            freight: $("#freight").val(),
            handling: $("#handling").val(),
            dtod: $("#dtod").val(),
            domestic: $("#domestic").val(),
            inscharge: $("#inscharge").val(),
            tax: $("#tax").val(),
            pkncharge: $("#pkncharge").val(),
            total_amount : $("#totamt").val()
        };
        console.log(formData);

        $.ajax({
            url: 'invoice/addinvoice.php', 
            type: 'POST',
            data: formData,
            dataType: 'json', 
            success: function(response) {
                if(response.status === 'success') {
                    $("#success-message").text(response.message).show();
                    $("#error-message").hide();
                } else {
                    $("#error-message").text(response.message).show();
                    $("#success-message").hide();
                }
            },
            error: function(xhr, status, error) {
                $("#error-message").text("An error occurred: " + error).show();
                $("#success-message").hide();
            }
        });
    });

    
    $("#reset").click(function() {
        $("#success-message").hide();
        $("#error-message").hide();
        $("#invoiceForm").trigger("reset");
    });
});
</script>

<script>
$(document).ready(function(){
    $('#order_id').change(function(){
        var orderID = $(this).val();
        if(orderID) {
            $.ajax({
                url: 'order/fetchalldetails.php', 
                type: 'GET',
                data: {order_id: orderID,},
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if(response.box_qty !== undefined) {
                        $('#tot_pack').val(response.box_qty);
                    } else {
                        alert('Order details not found.');
                        $('#tot_pack').val('');
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error:", error);
                    alert('An error occurred: ' + error);
                    $('#tot_pack').val('');
                }
            });
        } else {
            $('#tot_pack').val('');
        }
    });
});
</script>
</body>
</html>