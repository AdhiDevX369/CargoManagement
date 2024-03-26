<?php
require_once '../DB/dbconfig.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $invoice_id = filter_input(INPUT_POST, 'invoice_id', FILTER_SANITIZE_STRING);
    $container_id = filter_input(INPUT_POST, 'con_id', FILTER_SANITIZE_STRING);
    $invoice_id = strtoupper(str_replace(' ', '', $invoice_id));

    // Check if invoice_id already exists
    $stmt = $conn->prepare("SELECT * FROM invoice WHERE invoice_number = ?");
    $stmt->bind_param("s", $invoice_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update container_id for the existing invoice_id
        $update_stmt = $conn->prepare("UPDATE invoice SET container_id = ? WHERE invoice_number = ?");
        $update_stmt->bind_param("ss", $container_id, $invoice_id);
        if ($update_stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Container ID updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error updating Container ID']);
        }
    } else {
        // Invoice ID does not exist
        echo json_encode(['status' => 'error', 'message' => 'Invoice ID does not exist']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
