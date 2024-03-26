<?php
require_once 'DB/dbconfig.php';
require_once 'vendor/tecnickcom/tcpdf/tcpdf.php';
date_default_timezone_set('Asia/Colombo');
function safeOutput($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sri Sara Cargo');
$pdf->SetTitle('Order Details');
$pdf->SetSubject('Order Details PDF');
$pdf->AddPage();
$query = "SELECT * FROM orders WHERE order_Id = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $html = '<h1>Order Details for Order ID: ' . safeOutput($order_id) . '</h1>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0">';
        $html .= '<tr><th>Field</th><th>Value</th></tr>';
        $html .= "<tr><td>Customer Name</td><td>" . safeOutput($row['customer_Name']) . "</td></tr>";
        $html .= "<tr><td>Customer Contact No</td><td>" . safeOutput($row['customer_contactNo']) . "</td></tr>";
        $html .= "<tr><td>Payment Method</td><td>" . safeOutput($row['payment_method']) . "</td></tr>";
        $html .= "<tr><td>Receiver Name</td><td>" . safeOutput($row['receiver_name']) . "</td></tr>";
        $html .= "<tr><td>Receiver Address</td><td>" . safeOutput($row['receiver_address']) . "</td></tr>";
        $html .= "<tr><td>Receiver Contact Number</td><td>" . safeOutput($row['receiver_contactNo']) . "</td></tr>";
        $html .= "<tr><td>Receiving Method</td><td>" . safeOutput($row['receiving_method']) . "</td></tr>";
        $html .= "<tr><td>Total Payment</td><td>" . safeOutput($row['total_payment']) . "</td></tr>";
        $html .= "<tr><td>Customer Paid</td><td>" . safeOutput($row['customer_pay']) . "</td></tr>";
        $html .= "<tr><td>Box Type</td><td>" . safeOutput($row['box_type']) . "</td></tr>";
        $html .= "<tr><td>Box Quantity</td><td>" . safeOutput($row['box_qty']) . "</td></tr>";
        $html .= '</table>';
        $currentDateTime = date("Y-m-d h:i:s A");  
        $html .= "<p>Reciept Printed on: $currentDateTime</p>";
        $html .= "<p>Warehouse Manager's Signature: ........................................</p>";
        $html .= "<p>Driver Name: ........................................</p>";
        $html .= "<p>Driver's Signnature: ........................................</p>";
        $html .= "<p>Receiver's Name : ........................................</p>";
        $html .= "<p>Receiver's Identity card Number : ........................................</p>";
        $html .= "<p>Received Date : ........................................</p>";
        $html .= "<p>Received at : ........................................</p>";
        $html .= "<p style='margin-top: 20px;'><strong>Disclaimer:</strong> By accepting the delivery of the packages/boxes/goods, the receiver acknowledges that all items have been inspected and received in good condition. From this point forward, <strong>Sri Sara Cargo</strong> will not be held responsible for any loss, damage, or discrepancies that may be discovered after the receipt of the goods. It is the receiver's responsibility to ensure that the delivery is complete and in satisfactory condition at the time of acceptance.</p>";
        $html .= "<p><input type='checkbox' style='width: 20px; height: 20px;' disabled='disabled'>&nbsp;<label for='agree'>I Agree</label></p>";
        $html .= "<p>Reciever's Signature : ........................................</p>";

        $pdf->writeHTML($html, true, false, true, false, '');
    } else {
        $pdf->writeHTML("<p>No details found for Order ID: " . safeOutput($order_id) . "</p>", true, false, true, false, '');
    }
    $stmt->close();
} else {
    $pdf->writeHTML("<p>Error preparing statement: " . $conn->error . "</p>", true, false, true, false, '');
}
$pdf->Output('order_details_' . $order_id . '.pdf', 'I');
$conn->close();
?>
