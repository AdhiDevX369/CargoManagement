<?php
require_once '../DB/dbconfig.php';
require_once 'driverfunctions.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $order_id = filter_input(INPUT_POST, 'order_id', FILTER_SANITIZE_NUMBER_INT);
    $remarks = filter_input(INPUT_POST, 'remarks', FILTER_SANITIZE_STRING);
    $amount = filter_input(INPUT_POST, 'payAmount', FILTER_SANITIZE_NUMBER_INT);
    $method = filter_input(INPUT_POST, 'method', FILTER_SANITIZE_STRING);

    if ($method === 'Pick Up') {
        $pickup_status='Completed';
        $response = confirmPickupOrder($conn, $order_id, $remarks, $amount,$pickup_status);
    } elseif ($method === 'Delivery') {
        $delivery_status='Completed';
        $response = confirmDeliveryOrder($conn, $order_id, $remarks, $amount,$delivery_status);
    } else {
        $response = json_encode(['status' => 'error', 'message' => 'Invalid method']);
    }

    echo $response;
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}


?>
