<?php
require_once '../DB/dbconfig.php';
require_once '../order/orderfunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedDate = filter_input(INPUT_POST, "selectedDate", FILTER_SANITIZE_STRING);
    $driver = filter_input(INPUT_POST, "driver", FILTER_SANITIZE_STRING);
    

    // Define pagination variables
    $currentPage = filter_input(INPUT_POST, "page", FILTER_SANITIZE_NUMBER_INT) ?: 1;
    $recordsPerPage = 5; /* you can select how many records should be shown at frontend*/

    $ordersData = driverAllOrders($conn,$selectedDate, $currentPage, $recordsPerPage, $driver);

    if (!isset($ordersData['error'])) {
        // If there's no error, send the orders and totalRecords as JSON
        header('Content-Type: application/json');
        echo json_encode($ordersData);
    } else {
        // Handle any errors encountered in the getOrders function
        echo json_encode(["error" => $ordersData['error']]);
    }
} else {
    // Handle case where the request method is not POST
    echo json_encode(["error" => "Invalid request method"]);
}
?>