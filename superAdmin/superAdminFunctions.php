<?php

/* 
Created By - Maleesha Udan Aththanayaka (Sparrow Hawk)
This file contains the main functions of the super admin section
---Content---
1) Container Functions
2) Driver Orders Functions
3) SMS Related Functions
4) Order Functions Section I
5) Invoice Functions
6) Orders Functions Section II
7) Local warehouse
8) Encryption
*/

/* Container functions Start*/
//INSERT DATA INTO THE CONTAINER TABLE
function createContainer($conn, $container_id, $container_company, $shipping_country, $warehouse_location)
{
    $stmt = $conn->prepare("SELECT * FROM container WHERE container_id = ?");
    $stmt->bind_param("s", $container_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Container ID already exists
        return "0";
    }
    $status = "Active";
    $insertStmt = $conn->prepare("INSERT INTO container (container_id, company_name, destination, warehouse, status) VALUES (?, ?, ?, ?, ?)");
    $insertStmt->bind_param("sssss", $container_id, $container_company, $shipping_country, $warehouse_location, $status);

    if ($insertStmt->execute()) {
        // Insertion successful
        return "1";
    } else {
        // Insertion failed
        return "2";
    }
}
//RETRIEVE DATA FROM THE CONTAINER TABLE
function getAllContainerDetails($conn)
{
    $allContainers = [];
    $sql = "SELECT * FROM container";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $allContainers[] = $row;
        }
    }
    return $allContainers;
}
//GET TOTAL NUMBER OF ACTIVE CONTAINERS
function allActiveContainers($conn)
{
    $query = "SELECT COUNT(*) AS total_active FROM container WHERE status = 'Active'";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        $totalActive = $row['total_active'];
        return $totalActive;
    } else {
        return 0;
    }
}
//GET TOTAL NUMBER OF COMPLETED CONTAINERS
function allCompletedContainers($conn)
{
    $query = "SELECT COUNT(*) AS total_comp FROM container WHERE status = 'Completed'";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        $totalCompleted = $row['total_comp'];
        return $totalCompleted;
    } else {
        return 0;
    }
}
//GET ALL DETAILS OF ACTIVE CONTAINERS AND LOCATION='Warehouse Loading'
function detailsOfActiveContainers($conn)
{
    $activeContainers = [];
    $sql = "SELECT * FROM container WHERE status = 'Active' AND location = 'Warehouse Loading'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $activeContainers[] = $row;
        }
    }
    return $activeContainers;
}
//CHANGE CONTAINER LOCATION, INVOICE LOCATION = "shipped"
function changeLocOfConIn($conn, $container_id)
{
    $conn->begin_transaction();

    try {
        $stmt1 = $conn->prepare("UPDATE container SET location = 'Shipped' WHERE container_id = ?");
        $stmt1->bind_param("s", $container_id);
        $stmt1->execute();
        if ($stmt1->affected_rows == 0) {
            $conn->rollback();
            return false;
        }
        $stmt2 = $conn->prepare("UPDATE invoice SET location = 'Shipped' WHERE container_id = ?");
        $stmt2->bind_param("s", $container_id);
        $stmt2->execute();
        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollback();
        return false;
    }
}
//COUNT OF ALL SHIPPED CONTAINERS
function allShippedContainers($conn)
{
    $query = "SELECT COUNT(*) AS total_comp FROM container WHERE location = 'Shipped'";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        $totalCompleted = $row['total_comp'];
        return $totalCompleted;
    } else {
        return 0;
    }
}
//GET ALL DETAILS FROM THE CONTAINER WHERE LANDED ON SRI LANKA
function landedContainers($conn)
{
    $sql = "SELECT * FROM container WHERE destination = 'SRI LANKA' AND status = 'Active' AND location = 'Shipped'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $containers = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $containers;
    } else {
        return [];
    }
}


/* Container functions End*/
/*---------------------------------------------------------------------------------------------------- */
/*---------------------------------------------------------------------------------------------------- */
/*---------------------------------------------------------------------------------------------------- */
/*Driver Orders Functions Start*/
//RETRIVE ALL DRIVERS' DUE ORDERS
function driverDueOrders($conn)
{
    $dueOrders = [];
    // SQL query to select orders that are overdue and pending
    $query = "SELECT * FROM orders WHERE 
              (delivery_status = 'Pending' AND delivery_date < CURDATE()) OR 
              (pickup_status = 'Pending' AND pickup_date < CURDATE())";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dueOrders[] = $row;
        }
    }
    return $dueOrders;
}
//Count Number of due orders by drivers
function countDueOrders($conn)
{
    $query = "SELECT COUNT(*) AS total_due FROM orders WHERE 
              (delivery_status = 'Pending' AND delivery_date < CURDATE()) OR 
              (pickup_status = 'Pending' AND pickup_date < CURDATE())";

    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total_due'];
    } else {
        return 0;
    }
}

/*Driver Orders Functions End*/
/**
 * -----------------------------------------------------------------------------
 * -----------------------------------------------------------------------------
 * -----------------------------------------------------------------------------
 * SMS Related functions
 */
/**
 * Check Balance
 */
function checkBalance($apiKey)
{
    $ch = curl_init();
    $url = "https://e-sms.dialog.lk/api/v1/message-via-url/check/balance?esmsqk={$apiKey}";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        $result = 'Error:' . curl_error($ch);
    } else {
        list($status, $balance) = explode("|", $response, 2);
        switch (trim($status)) {
            case "1":
                $result = "Success - Balance: " . $balance;
                break;
            case "2001":
                $result = "Error occurred during campaign creation";
                break;
            case "2002":
                $result = "Bad request";
                break;
            case "2006":
                $result = "Not eligible to send messages via GET requests (Admin hasn’t provided the access level)";
                break;
            case "2007":
                $result = "Invalid key (esmsqk parameter is invalid)";
                break;
            default:
                $result = "Unknown response or error";
                break;
        }
    }
    curl_close($ch);
    return $result;
}
//Function for sending messages
function sendMessage($apiKey, $numberList, $message, $sourceAddress)
{
    $ch = curl_init();
    $list = $numberList;
    $pushNotificationUrl = "https://xx/xx";
    $url = "https://e-sms.dialog.lk/api/v1/message-via-url/create/url-campaign?esmsqk={$apiKey}&list={$list}&source_address={$sourceAddress}&message=" . urlencode($message) . "&push_notification_url=" . urlencode($pushNotificationUrl);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        $result = 'Error:' . curl_error($ch);
    } else {
        switch (trim($response)) {
            case "1":
                $result = "Success";
                break;
            case "2001":
                $result = "Error occurred during campaign creation";
                break;
            case "2002":
                $result = "Bad request";
                break;
            case "2003":
                $result = "Empty number list";
                break;
            case "2004":
                $result = "Empty message body";
                break;
            case "2005":
                $result = "Invalid number list format";
                break;
            case "2006":
                $result = "Not eligible to send messages via GET requests (Admin hasn’t provided the access level)";
                break;
            case "2007":
                $result = "Invalid key (esmsqk parameter is invalid)";
                break;
            case "2008":
                $result = "Not enough money in the user's wallet or not enough messages left in the package for the user. (When consuming package payments)";
                break;
            case "2009":
                $result = "No valid numbers found after the removal of mask blocked numbers.";
                break;
            case "2010":
                $result = "Not eligible to consume packaging";
                break;
            case "2011":
                $result = "Transactional error";
                break;
            default:
                $result = "Unknown response: " . $response;
                break;
        }
    }
    curl_close($ch);
    return $result;
}
/**
 * SMS Functions Finished
 */
/**
 * --------------------------------------------------------------------
 * --------------------------------------------------------------------
 * --------------------------------------------------------------------
 */
/**
 * ORDERS FUNCTIONS STARTS
 */
//Get the count of today placed orders
function numOfTodayOrders($conn)
{
    $query = "SELECT COUNT(*) AS total_today FROM orders WHERE DATE(ordered_date) = CURDATE()";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total_today'];
    } else {
        return 0;
    }
}
//GET A SINGLE USER'S DETAILS
function singleUserDetails($conn, $orderId)
{
    $orderDetails = [];
    $sql = "SELECT * FROM orders WHERE order_Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $orderDetails = $result->fetch_assoc();
        return $orderDetails;
    } else {
        return $orderDetails;
    }
    $stmt->close();
}
//GET ALL DRIVERS
function getAllDrivers($conn)
{
    $drivers = [];
    $sql = "SELECT * FROM user WHERE level_id = 4";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $drivers[] = $row;
        }
    }
    return $drivers;
}
//UPDATE NEW PICKUP AND NEW DELIVERY DETAILS
function updateDelPickDetails($conn, $orderId, $delDriver, $delDate, $pickDriver, $pickDate)
{
    $response = "";
    $sql = "UPDATE orders SET 
                delivery_driver = ?, 
                delivery_date = ?, 
                pickup_driver = ?, 
                pickup_date = ? 
            WHERE order_Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $delDriver, $delDate, $pickDriver, $pickDate, $orderId);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response = "Successfully Updated";
            return $response;
        } else {
            $reponse = "No changes made or order not found";
            return $response;
        }
    } else {
        $reponse = "Error updating order details";
        return $response;
    }
    $stmt->close();
}
//UPDATE NEW PICKUP DETAILS
function updatePickDetails($conn, $orderId, $pickDriver, $pickDate)
{
    $response = "";
    $sql = "UPDATE orders SET 
                pickup_driver = ?, 
                pickup_date = ? 
            WHERE order_Id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $pickDriver, $pickDate, $orderId);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response = "Successfully Updated";
        } else {
            $response = "No changes made or order not found";
        }
    } else {
        $response = "Error updating order details";
    }
    $stmt->close();
    return $response;
}
//ALL DETAILS OF LAST TEN ORDERS
function lastTenOrderDetails($conn)
{
    $orderDetails = [];
    $sql = "SELECT * FROM orders ORDER BY order_Id DESC LIMIT 10";
    if ($result = $conn->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $orderDetails[] = $row;
        }
        $result->close();
    }
    return $orderDetails;
}
//GET CUSTOMER PAID DETAILS
function customerPaid($conn, $orderid)
{
    $customerPay = 0.0;
    $stmt = $conn->prepare("SELECT customer_pay FROM orders WHERE order_Id = ?");
    $stmt->bind_param("i", $orderid);
    $stmt->execute();
    $stmt->bind_result($customerPay);
    if ($stmt->fetch()) {
        $stmt->close();
        return $customerPay;
    } else {
        $stmt->close();
        return 0.0;
    }
}

function completeInvoice($conn, $invoice, $orderId, $payment)
{
    $conn->begin_transaction();
    try {
        // Step 1: Update customer_pay if payment > 0
        if ($payment > 0) {
            $stmt = $conn->prepare("UPDATE orders SET customer_pay = customer_pay + ? WHERE order_Id = ?");
            $stmt->bind_param("di", $payment, $orderId);
            if (!$stmt->execute()) {
                throw new Exception("Failed to update customer_pay.");
            }
            $stmt->close();
        }

        // Step 2: Update status in orders table
        $stmt = $conn->prepare("UPDATE orders SET status = 'Completed' WHERE order_Id = ?");
        $stmt->bind_param("i", $orderId);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update status in orders.");
        }
        $stmt->close();

        // Step 3: Update status and location in invoice table
        $stmt = $conn->prepare("UPDATE invoice SET status = 'Completed', location = 'Delivered' WHERE invoice_number = ?");
        $stmt->bind_param("s", $invoice);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update invoice.");
        }
        $stmt->close();

        // If all operations were successful, commit the transaction
        $conn->commit();
        return true;
    } catch (Exception $e) {
        // An error occurred, roll back the transaction
        $conn->rollback();
        return false;
    }
}


/**
 * ORDER FUNCTIONS FINISHED
 */
/**
 * --------------------------------------------------------------------
 * --------------------------------------------------------------------
 * --------------------------------------------------------------------
 */
/**
 * INVOICE FUNCTIONS START
 */
//GET ALL STATUS="ACTIVE" INVOICES
function getActiveInvoices($conn)
{
    $activeInvoices = [];
    $sql = "SELECT * FROM invoice WHERE location = 'Waiting For the shipment' AND status = 'Order Placed'";

    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $activeInvoices[] = $row;
            }
        }
    } else {
        // Handle query error
        error_log("Error executing query in getActiveInvoices: " . $conn->error);
        // Optionally, return false or throw an exception based on your error handling strategy
    }

    return $activeInvoices;
}

//SHOW INVOICES BY SEARCHING CONTAINER ID
function getInvoicesByContainer($conn, $container_id)
{
    $invoices = [];
    $sql = "SELECT * FROM invoice WHERE container_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $container_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $invoices[] = $row;
        }
    }
    $stmt->close();

    return $invoices;
}
//ASSIGN CONTAINER ID FOR AN INVOICE
function addContainerIdtoInvoice($conn, $container_id, $invoice_id)
{
    $sql = "UPDATE invoice SET container_id = ?, status = 'Container Added' WHERE invoice_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $container_id, $invoice_id);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    } else {
        $stmt->close();
        return false;
    }
}
//GET ALL STATUS="Container Added" INVOICES
function getConAddInvoices($conn)
{
    $activeInvoices = [];
    $sql = "SELECT * FROM invoice WHERE location = 'Waiting For the shipment' AND status = 'Container Added'";

    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $activeInvoices[] = $row;
            }
        }
    } else {
        // Handle query error
        error_log("Error executing query in getActiveInvoices: " . $conn->error);
        // Optionally, return false or throw an exception based on your error handling strategy
    }

    return $activeInvoices;
}
//Update invoice status="Order placed" and Remove container id
function rmvConIdchngStatus($conn, $invoice_id)
{
    $sql = "UPDATE invoice SET container_id = NULL, status = 'Order Placed' WHERE invoice_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $invoice_id);
    $executeSuccess = $stmt->execute();
    $stmt->close();
    return $executeSuccess;
}
//GET INVOICE ID ACCORDING TO THE ORDER ID FROM THE INVOICE TABLE
function getInvoiceDetails($conn, $order_id)
{
    $invoiceDetails = [];
    $sql = "SELECT * FROM invoice WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $invoiceDetails = $result->fetch_assoc();
        } else {
            $invoiceDetails = [];
        }
    } else {
        $invoiceDetails = [];
    }
    $stmt->close();
    return $invoiceDetails;
}
//COUNT OF ALL SHIPPED INVOICES
function countOfShippedInvoices($conn)
{
    $count = 0;
    $sql = "SELECT COUNT(*) as count FROM invoice WHERE location = 'Shipped'";
    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
        $result->close();
    }
    return $count;
}
//GET INVOICE DETAILS AFTER ARRIVED TO LOCAL WAREHOUSE
function arrivedInvoices($conn, $warehouse)
{
    $query = "SELECT invoice.*
              FROM invoice
              INNER JOIN container ON invoice.container_id = container.container_id
              WHERE container.warehouse = ?
              AND container.status = 'Active'
              AND container.location = 'Arrived'
              AND invoice.location = 'Arrived'";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $warehouse);
    $stmt->execute();
    $result = $stmt->get_result();

    $invoices = [];
    while ($row = $result->fetch_assoc()) {
        $invoices[] = $row;
    }
    $stmt->close();

    return $invoices;
}
//GET ALL DETAILS FROM INVOICE FOR AN INVOICE NUMBER
function getInvoiceAllDetails($conn, $invoice)
{
    $sql = "SELECT * FROM invoice WHERE invoice_number = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $invoice);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    } else {
        return null;
    }
}
//CALCULATE DUE PAYMENT FROM THE INVOICES
function invoiceDueAmount($conn, $invoice, $order_id)
{
    $dueAmount = 0.0;
    $stmt = $conn->prepare("SELECT tot FROM invoice WHERE invoice_number = ?");
    $stmt->bind_param("s", $invoice);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tot = (float)$row['tot'];
    } else {
        $tot = 0.0;
    }
    $stmt->close();
    $stmt = $conn->prepare("SELECT customer_pay FROM orders WHERE order_Id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $customer_pay = (float)$row['customer_pay'];
    } else {
        $customer_pay = 0.0;
    }
    $stmt->close();
    $dueAmount = $tot - $customer_pay;
    return $dueAmount;
}
/**
 * INVOICE FUNCTIONS END
 */
/**
 * ORDER FUNCTIONS START
 */
//SUBMITTING A PICKUP ONLY ORDER
function pickupOnlyOrder(
    $conn,
    $cname,
    $caddress,
    $cnum,
    $cpass,
    $pdate,
    $pdriver,
    $pmethod,
    $rname,
    $raddress,
    $rnum,
    $rmethod,
    $tot,
    $ewdlarge,
    $ewdxlarge,
    $ewd1m,
    $ewd15m,
    $ewd2m,
    $ewd25m,
    $ewd35m,
    $ecsmall,
    $ecmedium,
    $eclarge,
    $ecjumbo,
    $ecxl,
    $etsmall,
    $etmedium,
    $etlarge,
    $etxl,
    $etxxl
) {
    $sql = "INSERT INTO orders (
        customer_Name, customer_address, customer_contactNo, passport, 
        pickup_date, pickup_driver, payment_method, receiver_name, 
        receiver_address, receiver_contactNo, receiving_method, total_payment, 
        ewdlarge, ewdxlarge, ewd1m, ewd15m, ewd2m, ewd25m, ewd35m, 
        ecsmall, ecmedium, eclarge, ecjumbo, ecxl, 
        etsmall, etmedium, etlarge, etxl, etxxl, 
        status, method, ordered_time, ordered_date, pickup_status
    ) VALUES (
        ?, ?, ?, ?, 
        ?, ?, ?, ?, 
        ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, 
        'Order Placed', 'Pick Up Only', CURRENT_TIME(), CURRENT_DATE(), 'Pending'
    )";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $cname, $caddress, $cnum, $cpass,
            $pdate, $pdriver, $pmethod, $rname,
            $raddress, $rnum, $rmethod, $tot,
            $ewdlarge, $ewdxlarge, $ewd1m, $ewd15m, $ewd2m, $ewd25m, $ewd35m,
            $ecsmall, $ecmedium, $eclarge, $ecjumbo, $ecxl,
            $etsmall, $etmedium, $etlarge, $etxl, $etxxl
        ]);
        return true;
    } catch (Exception $e) {
        return false;
    }
}
//SUBMITTING A DELIVERY AND PICKUP ONLY ORDER
function DelAndpickupOrder(
    $conn,
    $ddate,
    $ddriver,
    $cname,
    $caddress,
    $cnum,
    $cpass,
    $pdate,
    $pdriver,
    $pmethod,
    $rname,
    $raddress,
    $rnum,
    $rmethod,
    $tot,
    $ewdlarge,
    $ewdxlarge,
    $ewd1m,
    $ewd15m,
    $ewd2m,
    $ewd25m,
    $ewd35m,
    $ecsmall,
    $ecmedium,
    $eclarge,
    $ecjumbo,
    $ecxl,
    $etsmall,
    $etmedium,
    $etlarge,
    $etxl,
    $etxxl
) {
    $sql = "INSERT INTO orders (
        delivery_date, delivery_driver, customer_Name, customer_address, customer_contactNo, passport, 
        pickup_date, pickup_driver, payment_method, receiver_name, 
        receiver_address, receiver_contactNo, receiving_method, total_payment, 
        ewdlarge, ewdxlarge, ewd1m, ewd15m, ewd2m, ewd25m, ewd35m, 
        ecsmall, ecmedium, eclarge, ecjumbo, ecxl, 
        etsmall, etmedium, etlarge, etxl, etxxl, 
        status, method, ordered_time, ordered_date, pickup_status, delivery_status
    ) VALUES (
        ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, 
        ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, 
        'Order Placed', 'Delivery and Pickup', CURRENT_TIME(), CURRENT_DATE(), 'Pending', 'Pending' 
    )";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $ddate, $ddriver, $cname, $caddress, $cnum, $cpass,
            $pdate, $pdriver, $pmethod, $rname,
            $raddress, $rnum, $rmethod, $tot,
            $ewdlarge, $ewdxlarge, $ewd1m, $ewd15m, $ewd2m, $ewd25m, $ewd35m,
            $ecsmall, $ecmedium, $eclarge, $ecjumbo, $ecxl,
            $etsmall, $etmedium, $etlarge, $etxl, $etxxl
        ]);
        return true;
    } catch (Exception $e) {
        return false;
    }
}
//GET ALL DETAILS OF ALL ORDERS
function allOrdersDetails($conn)
{
    $orderDetails = [];
    $sql = "SELECT * FROM orders";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orderDetails[] = $row;
        }
    }
    return $orderDetails;
}
// GET ALL DETAILS FROM THE TABLE WHERE status="Order Placed"
function orderPlacedOrders($conn)
{
    $orders = [];
    $sql = "SELECT * FROM orders WHERE status = 'Order Placed'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    }
    return $orders;
}
//DETAILS OF TODAY PLACED ORDERS
function todaysOrdersDetails($conn)
{
    $today = date("Y-m-d");
    $orderDetails = [];
    $sql = "SELECT * FROM orders WHERE ordered_date = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $today);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $orderDetails[] = $row;
            }
        }
        $stmt->close();
    }
    return $orderDetails;
}
//DETAILS OF ALL COMPLETED ORDERS
function allCompletedOrder($conn)
{
    $completedOrders = [];
    $sql = "SELECT * FROM orders WHERE status = 'Completed'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $completedOrders[] = $row;
        }
    }
    return $completedOrders;
}
//DETAILS OF ORDERS WHERE method="Delivery and Pickup"
function DelAndpickupOrderDetails($conn)
{
    $delAndPickupOrders = [];
    $sql = "SELECT * FROM orders WHERE method = 'Delivery and Pickup'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $delAndPickupOrders[] = $row;
        }
    }
    return $delAndPickupOrders;
}
//DETAILS OF ORDERS WHERE method="Pick Up Only"
function pickUpOnlyOrdersDetails($conn)
{
    $pickUpOnlyOrders = [];
    $sql = "SELECT * FROM orders WHERE method = 'Pick Up Only'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pickUpOnlyOrders[] = $row;
        }
    }
    return $pickUpOnlyOrders;
}

/**
 * Temporary invoices
 */
function createInvoice($conn, $invoice, $ordernumber, $recievedate, $shippingcompany, $shippingdate, $totalpackages, $totalvolume, $totalweight, $totalvalue, $freightcharges, $handlingcharges, $d2dcharges, $domesticcharges, $insurancecharges, $tax, $cname, $caddress, $cnum, $cpass, $pmethod, $rname, $raddress, $rnum, $rmethod, $tot, $ewdlarge, $ewdxlarge, $ewd1m, $ewd15m, $ewd2m, $ewd25m, $ewd35m, $ecsmall, $ecmedium, $eclarge, $ecjumbo, $ecxl, $etsmall, $etmedium, $etlarge, $etxl, $etxxl, $other)
{
    $query = "INSERT INTO invoice (invoice_number, order_id, recievedate, shippingcompany, shippingdate, totalpackages, totalvolume, totalweight, totalvalue, freightcharges, handlingcharges, d2dcharges, domesticcharges, insurancecharges, tax, cname, caddress, cnum, cpass, pmethod, rname, raddress, rnum, rmethod, tot, ewdlarge, ewdxlarge, ewd1m, ewd15m, ewd2m, ewd25m, ewd35m, ecsmall, ecmedium, eclarge, ecjumbo, ecxl, etsmall, etmedium, etlarge, etxl, etxxl, other) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, 'sssssddddddddddssssssssssddddddddddddddddds', $invoice, $ordernumber, $recievedate, $shippingcompany, $shippingdate, $totalpackages, $totalvolume, $totalweight, $totalvalue, $freightcharges, $handlingcharges, $d2dcharges, $domesticcharges, $insurancecharges, $tax, $cname, $caddress, $cnum, $cpass, $pmethod, $rname, $raddress, $rnum, $rmethod, $tot, $ewdlarge, $ewdxlarge, $ewd1m, $ewd15m, $ewd2m, $ewd25m, $ewd35m, $ecsmall, $ecmedium, $eclarge, $ecjumbo, $ecxl, $etsmall, $etmedium, $etlarge, $etxl, $etxxl, $other);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return true;
    } else {
        mysqli_stmt_close($stmt);
        return false;
    }
}
//DETAILS FROM CONTAINER TABLE WHERE STATUS="ACTIVE"
function detailsOfallActiveContainers($conn)
{
    $activeContainers = [];
    $sql = "SELECT * FROM container WHERE status = 'Active'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $activeContainers[] = $row;
        }
    }
    return $activeContainers;
}
/**
 * LOCAL WAREHOUSE FUNCTIONS
 */
//GET ALL DETAILS FROM LOCAL WAREHOUSE DRIVERS
function localdriverdetails($conn)
{
    $drivers = array();
    $sql = "SELECT * FROM warehousedriver";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $drivers[] = $row;
        }
        mysqli_free_result($result);
    }
    return $drivers;
}
//function to assign a door to door driver for an invoice
function assignDriver($conn, $invoice, $driver)
{
    $sql = "UPDATE invoice SET doortodriver = ? WHERE invoice_number = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, 'ss', $driver, $invoice);
    if (mysqli_stmt_execute($stmt)) {
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/**
 * LOCAL WAREHOUSE FUNCTIONS END
 */
/**
 * Encryption and Decryption starts
 */
/*
function encrypt($data, $key)
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encryptedData . '::' . $iv);
}

function decrypt($data, $key)
{
    list($encryptedData, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
}

function encrypt($data, $key)
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encryptedData) . '::' . base64_encode($iv);
}

function decrypt($data, $key)
{
    list($encryptedData, $iv) = explode('::', $data, 2);
    $encryptedData = base64_decode($encryptedData);
    $iv = base64_decode($iv);
    return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
}
*/
function encrypt($data, $key)
{
    $result = '';
    $keyLength = strlen($key);
    for ($i = 0, $len = strlen($data); $i < $len; $i++) {
        $keyByte = ord($key[$i % $keyLength]);
        $dataByte = ord($data[$i]);
        $result .= chr(($dataByte + $keyByte) % 256);
    }
    return base64_encode($result);
}

function decrypt($data, $key)
{
    $data = base64_decode($data);
    $result = '';
    $keyLength = strlen($key);
    for ($i = 0, $len = strlen($data); $i < $len; $i++) {
        $keyByte = ord($key[$i % $keyLength]);
        $dataByte = ord($data[$i]);
        $result .= chr(($dataByte - $keyByte + 256) % 256);
    }
    return $result;
}
