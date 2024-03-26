<?php
require_once '../DB/dbconfig.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $invoice_id = filter_input(INPUT_POST, 'invoice_id', FILTER_SANITIZE_STRING);
    $order_id = filter_input(INPUT_POST, 'order_id', FILTER_SANITIZE_NUMBER_INT);
    $rec_date = filter_input(INPUT_POST, 'rec_date', FILTER_SANITIZE_STRING);
    $ship_company = filter_input(INPUT_POST, 'ship_company', FILTER_SANITIZE_STRING);
    $ship_date = filter_input(INPUT_POST, 'ship_date', FILTER_SANITIZE_STRING);
    $tot_pack = filter_input(INPUT_POST, 'tot_pack', FILTER_SANITIZE_NUMBER_INT);
    $tot_vol = filter_input(INPUT_POST, 'tot_vol', FILTER_SANITIZE_NUMBER_INT);
    $tot_wei = filter_var($_POST['tot_wei'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $tot_val = filter_var($_POST['tot_val'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $freight = filter_var($_POST['freight'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $handling = filter_var($_POST['handling'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $dtod = filter_var($_POST['dtod'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $domestic = filter_var($_POST['domestic'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $inscharge = filter_var($_POST['inscharge'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $tax = filter_var($_POST['tax'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $pkncharge = filter_var($_POST['pkncharge'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $total_amount = filter_var($_POST['total_amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $invoice_id = strtoupper(str_replace(' ', '', $invoice_id));

    // Check for existing invoice_id or order_id
    $checkStmt = $conn->prepare("SELECT invoice_number FROM invoice WHERE invoice_number = ? OR order_id = ?");
    $checkStmt->bind_param("si", $invoice_id, $order_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $checkStmt->close();

    if ($checkResult->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invoice ID or Order ID already exists']);
        exit;
    }


    
    $checkOrderSql = "SELECT * FROM orders WHERE order_Id = ?";
    if ($orderStmt = $conn->prepare($checkOrderSql)) {
        $orderStmt->bind_param("i", $order_id);
        $orderStmt->execute();
        $result = $orderStmt->get_result();
        if ($result->num_rows === 0) {
            echo json_encode(['status' => 'error', 'message' => 'Order ID does not exist']);
            $orderStmt->close();
            exit;
        }
        $orderStmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error preparing order check statement: ' . $conn->error]);
        exit;
    }

    
    $sql = "INSERT INTO invoice (invoice_number, order_id, received_date, shipping_company,shipping_date, total_packages, total_volume, total_weight, total_value, freight_charges, handling_charges, dtd_charges, domestic_charges, insurance_charges, tax, packing_charges, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sisssdddddddddddd", $invoice_id, $order_id, $rec_date, $ship_company, $ship_date, $tot_pack, $tot_vol, $tot_wei, $tot_val, $freight, $handling, $dtod, $domestic, $inscharge, $tax, $pkncharge, $total_amount);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Invoice added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error adding invoice: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error preparing invoice insert statement: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
