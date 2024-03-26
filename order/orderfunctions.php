<?php

function getOrderId($conn) {
    $stmt = $conn->prepare("SELECT MAX(order_Id) as maxId FROM orders");
    $stmt->execute();
    $stmt->bind_result($maxId);
    if ($stmt->fetch()) {
        if ($maxId === null) {
            return 1;
        } else {
            $nextId = $maxId + 1;
            return $nextId;
        }
    } else {
        echo "Error: " . $stmt->error;
        return null;
    }
    $stmt->close();
}

function pickupOnlyEnter($conn,$customer_name,$customer_address,$customer_contact,$box_type,$box_qty,$pickup_date,$pickup_driver,$payment_method,$rec_name,$rec_address,$rec_contact,$rec_method,$total_payment,$status,$method,$ordered_time,$ordered_date,$pickup_status){
    $stmt = $conn->prepare("INSERT INTO orders (customer_Name, customer_address, customer_contactNo, box_type, box_qty, pickup_date, pickup_driver, payment_method, receiver_name, receiver_address, receiver_contactNo, receiving_method, total_payment, status, method,ordered_time,ordered_date,pickup_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)");
    $stmt->bind_param("ssisisssssssisssss", $customer_name, $customer_address, $customer_contact, $box_type, $box_qty, $pickup_date, $pickup_driver, $payment_method, $rec_name, $rec_address, $rec_contact, $rec_method, $total_payment, $status, $method,$ordered_time,$ordered_date,$pickup_status);
    
    if ($stmt->execute()) {
        return "1";
    }
    else {
        return "0";
    }
    $stmt->close();
}

function pickupAndDeliveryEnter($conn, $customer_name, $customer_address, $customer_contact, $box_type, $box_qty, $delivery_date, $pickup_date, $delivery_driver, $pickup_driver, $payment_method, $rec_name, $rec_address, $rec_contact, $rec_method, $total_payment, $status, $method,$ordered_time,$ordered_date,$pickup_status,$delivery_status) {
    $stmt = $conn->prepare("INSERT INTO orders (customer_Name, customer_address, customer_contactNo, box_type, box_qty, delivery_date, pickup_date, delivery_driver, pickup_driver, payment_method, receiver_name, receiver_address, receiver_contactNo, receiving_method, total_payment, status, method,ordered_time,ordered_date,pickup_status,delivery_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?)");
    $stmt->bind_param("ssisisssssssssissssss", $customer_name, $customer_address, $customer_contact, $box_type, $box_qty, $delivery_date, $pickup_date, $delivery_driver, $pickup_driver, $payment_method, $rec_name, $rec_address, $rec_contact, $rec_method, $total_payment, $status, $method,$ordered_time,$ordered_date,$pickup_status,$delivery_status);

    $result = $stmt->execute();
    $stmt->close();
    
    return $result ? "1" : "0";
}

function getOrders($conn, $option, $date, $page, $recordsPerPage,$driver) {
    $offset = ($page - 1) * $recordsPerPage;

    // Initialize the array to store the orders
    $orders = [];

    // Query to fetch the paginated orders
    if ($option == "Pick Up") {
        $stmt = $conn->prepare("SELECT order_id, customer_Name, customer_contactNo, method, pickup_driver,customer_address,remarks,total_payment,customer_pay, status FROM orders WHERE pickup_date = ? AND pickup_driver = ? LIMIT ? OFFSET ?");
        $stmt->bind_param("ssii", $date, $driver, $recordsPerPage, $offset);
    } elseif ($option == "Delivery") {
        $stmt = $conn->prepare("SELECT order_id, customer_Name, customer_contactNo, method, delivery_driver,customer_address,remarks,total_payment,customer_pay, status FROM orders WHERE delivery_date = ? AND delivery_driver = ? LIMIT ? OFFSET ?");
        $stmt->bind_param("ssii", $date, $driver,  $recordsPerPage, $offset);
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
    if ($option == "Pick Up") {
        $countStmt = $conn->prepare("SELECT COUNT(*) FROM orders WHERE pickup_date = ?");
        $countStmt->bind_param("s", $date);
    } elseif ($option == "Delivery") {
        $countStmt = $conn->prepare("SELECT COUNT(*) FROM orders WHERE delivery_date = ?");
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
    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);

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
function deleteOrder($conn, $orderId) {
    $stmt = $conn->prepare("DELETE FROM orders WHERE order_id=?");
    $stmt->bind_param("i", $orderId);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $stmt->close();
            return 1; 
        } else {
            $stmt->close();
            return 0; 
        }
    } else {
        $stmt->close();
        return 0;
    }
}

function driverAllOrders($conn,$date, $page, $recordsPerPage, $driver) {
    $offset = ($page - 1) * $recordsPerPage;

    // Initialize the array to store the orders
    $orders = [];

    // Query to fetch the paginated orders
    $stmt = $conn->prepare("SELECT * FROM orders WHERE (pickup_date = ? AND pickup_driver = ?) OR (delivery_date = ? AND delivery_driver = ?) LIMIT ? OFFSET ?");
    $stmt->bind_param("ssssii", $date, $driver, $date, $driver, $recordsPerPage, $offset);


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
    
        $countStmt = $conn->prepare("SELECT COUNT(*) FROM orders WHERE pickup_date = ? OR delivery_date = ?");
        $countStmt->bind_param("ss", $date,$date);
    

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

/* To get order details for admins*/
function getOrdersAdmin($conn, $option, $date, $page, $recordsPerPage) {
    $offset = ($page - 1) * $recordsPerPage;

    // Initialize the array to store the orders
    $orders = [];

    // Query to fetch the paginated orders
    if ($option == "Pick Up") {
        $stmt = $conn->prepare("SELECT order_id, customer_Name, customer_contactNo, method, pickup_driver,customer_address,remarks,total_payment,customer_pay, status FROM orders WHERE pickup_date = ? LIMIT ? OFFSET ?");
        $stmt->bind_param("sii", $date, $recordsPerPage, $offset);
    } elseif ($option == "Delivery") {
        $stmt = $conn->prepare("SELECT order_id, customer_Name, customer_contactNo, method, delivery_driver,customer_address,remarks,total_payment,customer_pay, status FROM orders WHERE delivery_date = ? LIMIT ? OFFSET ?");
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
    if ($option == "Pick Up") {
        $countStmt = $conn->prepare("SELECT COUNT(*) FROM orders WHERE pickup_date = ?");
        $countStmt->bind_param("s", $date);
    } elseif ($option == "Delivery") {
        $countStmt = $conn->prepare("SELECT COUNT(*) FROM orders WHERE delivery_date = ?");
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

//new admin all orders
function adminAllOrders($conn,$page, $recordsPerPage) {
    $offset = ($page - 1) * $recordsPerPage;

    // Initialize the array to store the orders
    $orders = [];

    // Query to fetch the paginated orders
    $stmt = $conn->prepare("SELECT * FROM orders LIMIT ? OFFSET ?");
    $stmt->bind_param("ii",$recordsPerPage, $offset);


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
    
        $countStmt = $conn->prepare("SELECT COUNT(*) FROM orders");
        //$countStmt->bind_param("ss", $date,$date);
    

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





?>