<?php

require_once '../DB/dbconfig.php';
require_once 'orderfunctions.php'; 

header('Content-Type: application/json'); 

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $orderId = filter_input(INPUT_POST, 'order_id', FILTER_SANITIZE_NUMBER_INT);
    if ($orderId) {
        $result = deleteOrder($conn, $orderId);
        if ($result == 1) {
            echo json_encode(['status' => 'success', 'message' => 'Order successfully deleted']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Order could not be deleted']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid order ID']);
    }
} else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
