<?php
require '../DB/dbconfig.php'; 
/*$json = file_get_contents('php://input');
$data = json_decode($json);*/

$invoiceId = filter_input(INPUT_POST,'invoice_id', FILTER_SANITIZE_STRING);
$invoiceId = strtoupper(str_replace(' ', '', $invoiceId)); 
$query = "SELECT * FROM invoice WHERE invoice_number = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("s", $invoiceId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {      
        $invoiceData = $result->fetch_assoc();  
        header('Content-Type: application/json');
        echo json_encode($invoiceData);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invoice ID Not Found']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Query error']);
}
$conn->close();
?>
