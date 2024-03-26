<?php

function getInvoices($conn, $option, $date, $page, $recordsPerPage) {
    $offset = ($page - 1) * $recordsPerPage;

    // Initialize the array to store the orders
    $orders = [];

    // Query to fetch the paginated orders
    if ($option == "rcvDate") {
        $stmt = $conn->prepare("SELECT * FROM invoice WHERE received_date = ? LIMIT ? OFFSET ?");
        $stmt->bind_param("sii", $date, $recordsPerPage, $offset);
    } elseif ($option == "shpDate") {
        $stmt = $conn->prepare("SELECT * FROM invoice WHERE shipping_date = ? LIMIT ? OFFSET ?");
        $stmt->bind_param("sii", $date, $recordsPerPage, $offset);
    }

    // Execute the query and fetch data
    if (isset($stmt) && $stmt->execute()) {
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } else {
        // Handle query execution error
        return ['error' => "Error: " . (isset($stmt) ? $stmt->error : 'Invalid option')];
    }

    // Count total records for pagination
    $totalRecords = 0;
    if ($option == "rcvDate") {
        $countStmt = $conn->prepare("SELECT COUNT(*) FROM invoice WHERE received_date = ?");
        $countStmt->bind_param("s", $date);
    } elseif ($option == "shpDate") {
        $countStmt = $conn->prepare("SELECT COUNT(*) FROM invoice WHERE shipping_date = ?");
        $countStmt->bind_param("s", $date);
    }

    if (isset($countStmt) && $countStmt->execute()) {
        $result = $countStmt->get_result();
        $row = $result->fetch_array();
        $totalRecords = $row[0];
        $countStmt->close();
    } else {
        return ['error' => "Error: Failed to count total records"];
    }

    // Return the fetched orders and the total number of records
    return ['orders' => $orders, 'totalRecords' => $totalRecords];
}


function getAllDetails($conn, $order_id) {
    $stmt = $conn->prepare("SELECT * FROM invoice WHERE invoice_number = ?");
    $stmt->bind_param("s", $order_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {

            $stmt->close();
            return $row;
        } else {

            $stmt->close();
            return null;
        }
    } else {
        //handling errors
        $error = $stmt->error;
        $stmt->close();
        return ['error' => $error];
    }
}



?>