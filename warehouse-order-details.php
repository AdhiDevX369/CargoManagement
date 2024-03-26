<?php
require_once 'DB/dbconfig.php';
require_once 'vendor/tecnickcom/tcpdf/tcpdf.php';
echo "<title>Order Details</title>";
function safeOutput($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = "SELECT * FROM orders WHERE order_Id = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo "<h2>Order Details for Order ID: " . safeOutput($row['order_Id']) . "</h2>";
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Field</th><th>Value</th></tr>";

        echo "<tr><td>Customer Name</td><td>" . safeOutput($row['customer_Name']) . "</td></tr>";
        echo "<tr><td>Customer Contact No</td><td>" . safeOutput($row['customer_contactNo']) . "</td></tr>";
        echo "<tr><td>Payment Method</td><td>" . safeOutput($row['payment_method']) . "</td></tr>";
        echo "<tr><td>Reciever Name</td><td>" . safeOutput($row['receiver_name']) . "</td></tr>";
        echo "<tr><td>Reciever Address</td><td>" . safeOutput($row['receiver_address']) . "</td></tr>";
        echo "<tr><td>Reciever Contact Number</td><td>" . safeOutput($row['receiver_contactNo']) . "</td></tr>";
        echo "<tr><td>Recieving Method</td><td>" . safeOutput($row['receiving_method']) . "</td></tr>";
        echo "<tr><td>Total Payment</td><td>" . safeOutput($row['total_payment']) . "</td></tr>";
        echo "<tr><td>Customer Paid</td><td>" . safeOutput($row['customer_pay']) . "</td></tr>";
        echo "<tr><td>Box Type</td><td>" . safeOutput($row['box_type']) . "</td></tr>";
        echo "<tr><td>Box Quantity</td><td>" . safeOutput($row['box_qty']) . "</td></tr>";
        echo "</table>";
        echo "<a href='download-pdf.php?id=" . safeOutput($order_id) . "' target='_blank' style='text-decoration: none; color: white; background-color: blue; padding: 10px 20px; border-radius: 5px; font-weight: bold; display: inline-block; margin-top: 10px;'>Download as PDF</a>";
     
    } else {
        echo "No details found for Order ID: " . safeOutput($order_id);
    }

    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
?>
