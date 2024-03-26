<?php

require_once '../DB/dbconfig.php';
require_once 'orderfunctions.php';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    if (empty($_POST['diliverydate'])) {
        $method="Pick Up Only";
        $status="Order Placed";
        $cname = filter_input(INPUT_POST, "cname", FILTER_SANITIZE_STRING);
        $cus_address = filter_input(INPUT_POST, "cus_address", FILTER_SANITIZE_STRING);
        $contacnum = filter_input(INPUT_POST, "contacnum", FILTER_SANITIZE_STRING);
        $boxtype = filter_input(INPUT_POST, "boxtype", FILTER_SANITIZE_STRING);
        $boxqty = filter_input(INPUT_POST, "boxqty", FILTER_SANITIZE_NUMBER_INT);
        $pickup_date = filter_input(INPUT_POST, "pickup_date", FILTER_SANITIZE_STRING);
        $pickup_driver = filter_input(INPUT_POST, "pickup_driver", FILTER_SANITIZE_STRING);
        $payment_method = filter_input(INPUT_POST, "payment_method", FILTER_SANITIZE_STRING);
        $receiver_name = filter_input(INPUT_POST, "receiver_name", FILTER_SANITIZE_STRING);
        $receiver_contact_number = filter_input(INPUT_POST, "receiver_contact_number", FILTER_SANITIZE_STRING);
        $receiver_address = filter_input(INPUT_POST, "receiver_address", FILTER_SANITIZE_STRING);
        $receiving_method = filter_input(INPUT_POST, "receiving_method", FILTER_SANITIZE_STRING);
        $total_payment = filter_input(INPUT_POST, "total_payment", FILTER_SANITIZE_NUMBER_INT);

        /*This is adjusted for sri lankan time zone <you can adjust it according to your country>*/
        date_default_timezone_set('Asia/Colombo');
        $ordered_time = date('H:i:s');
        $ordered_date = date('Y-m-d'); 
        $pickup_status = 'Pending';
        $delivery_status = 'Pending';

        if (pickupOnlyEnter($conn,$cname,$cus_address,$contacnum,$boxtype,$boxqty,$pickup_date,$pickup_driver,$payment_method,$receiver_name,$receiver_address,$receiver_contact_number,$receiving_method,$total_payment,$status,$method,$ordered_time,$ordered_date,$pickup_status)==="1") {
            echo json_encode(["status" => "success", "message" => "Order created successfully"]);
        }
        else {
            echo json_encode(["status" => "error", "message" => "unable to create the order"]);
        }
        
       


    }
    if(!empty($_POST['diliverydate'])){
        $method="Delivery and Pickup";
        $status="Order Placed";
        $cname = filter_input(INPUT_POST, "cname", FILTER_SANITIZE_STRING);
        $cus_address = filter_input(INPUT_POST, "cus_address", FILTER_SANITIZE_STRING);
        $contacnum = filter_input(INPUT_POST, "contacnum", FILTER_SANITIZE_STRING);
        $boxtype = filter_input(INPUT_POST, "boxtype", FILTER_SANITIZE_STRING);
        $boxqty = filter_input(INPUT_POST, "boxqty", FILTER_SANITIZE_NUMBER_INT);
        $delivery_date= filter_input(INPUT_POST, "diliverydate", FILTER_SANITIZE_STRING);
        $pickup_date = filter_input(INPUT_POST, "pickup_date", FILTER_SANITIZE_STRING);
        $delivery_driver = filter_input(INPUT_POST, "delivery_driver", FILTER_SANITIZE_STRING);
        $pickup_driver = filter_input(INPUT_POST, "pickup_driver", FILTER_SANITIZE_STRING);
        $payment_method = filter_input(INPUT_POST, "payment_method", FILTER_SANITIZE_STRING);
        $receiver_name = filter_input(INPUT_POST, "receiver_name", FILTER_SANITIZE_STRING);
        $receiver_contact_number = filter_input(INPUT_POST, "receiver_contact_number", FILTER_SANITIZE_STRING);
        $receiver_address = filter_input(INPUT_POST, "receiver_address", FILTER_SANITIZE_STRING);
        $receiving_method = filter_input(INPUT_POST, "receiving_method", FILTER_SANITIZE_STRING);
        $total_payment = filter_input(INPUT_POST, "total_payment", FILTER_SANITIZE_NUMBER_INT);

        /*This is adjusted for sri lankan time zone <you can adjust it according to your country>*/
        date_default_timezone_set('Asia/Colombo');
        $ordered_time = date('H:i:s');
        $ordered_date = date('Y-m-d'); 
        $pickup_status = 'Pending';
        $delivery_status = 'Pending';

        if (pickupAndDeliveryEnter($conn,$cname,$cus_address,$contacnum,$boxtype,$boxqty,$delivery_date,$pickup_date,$delivery_driver,$pickup_driver,$payment_method,$receiver_name,$receiver_address,$receiver_contact_number,$receiving_method,$total_payment,$status,$method,$ordered_time,$ordered_date,$pickup_status,$delivery_status)==="1") {
            echo json_encode(["status" => "success", "message" => "Order created successfully"]);
        }
        else {
            echo json_encode(["status" => "error", "message" => "unable to create the order"]);
        }
    }
}




?>