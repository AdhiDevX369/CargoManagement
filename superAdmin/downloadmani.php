<?php
require 'session.php';
require 'dbconfig.php';

$container_id = isset($_POST['container_id']) ? $_POST['container_id'] : '';

if (!$container_id) {
    die("Container ID is required.");
}
function createManifest($conn, $container_id)
{
    $fileName = "manifest_container_" . $container_id . "_" . date('Ymd') . ".csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ["Invoices in container $container_id"]);

    $headers = [
        'Invoice Number', 'Order ID', 'Customer Name', 'Customer Address', 'Customer Phone Number',
        'Customer Passport Number', 'Receiver Name', 'Receiver Address', 'Receiver Contact Number',
        'EWD Large', 'EWD Extra Large', 'EWD 1M', 'EWD 1.5M', 'EWD 2M/4X4', 'EWD 2.5M/6X4', 'EWD 3.5M/8X4',
        'EC small', 'EC Medium', 'EC Large', 'EC Jumbo', 'EC XL', 'ET Small', 'ET Medium', 'ET Large',
        'ET XL', 'ET XXL','Others'
    ];
    fputcsv($output, $headers);
    $sql = "SELECT invoice_number, order_id, cname, caddress, cnum, cpass, rname, raddress, rnum,
            ewdlarge, ewdxlarge, ewd1m, ewd15m, ewd2m, ewd25m, ewd35m,
            ecsmall, ecmedium, eclarge, ecjumbo, ecxl, etsmall, etmedium, etlarge, etxl, etxxl,other
            FROM invoice WHERE container_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $container_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, array_values($row));
    }
    fclose($output);
    $stmt->close();
}
createManifest($conn, $container_id);
