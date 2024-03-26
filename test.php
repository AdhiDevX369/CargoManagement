<?php
include 'DB/dbconfig.php';

    $order_id = 19;
    $response = ['status' => 'error', 'message' => 'No results found'];

    $sql = "SELECT box_qty FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = ['status' => 'success', 'box_qty' => $row["box_qty"]];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;

?>