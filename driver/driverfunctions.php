<?php

function confirmPickupOrder($conn, $order_id, $remarks, $amount,$pickup_status) {
    // Start transaction for data consistency
    $conn->begin_transaction();

    try {
        // Get current remarks and customer_pay from the order
        $stmt = $conn->prepare("SELECT remarks, customer_pay FROM orders WHERE order_Id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $currentRemarks = $row['remarks'];
            $currentPay = $row['customer_pay'];

            // Append new remarks to existing ones
            $updatedRemarks = $currentRemarks ? $currentRemarks . " " . $remarks : $remarks;

            // Add amount to existing customer_pay
            $updatedPay = $currentPay + $amount;

            // Update the order
            $updateStmt = $conn->prepare("UPDATE orders SET customer_pay = ?, remarks = ?, pickup_status =? WHERE order_Id = ?");
            $updateStmt->bind_param("issi", $updatedPay, $updatedRemarks,$pickup_status, $order_id);
            $updateStmt->execute();

            // Check for successful update
            if ($updateStmt->affected_rows > 0) {
                // Commit transaction
                $conn->commit();
                return json_encode(['status' => 'success', 'message' => 'Order updated successfully']);
            } else {
                // No rows updated, possibly due to no changes being made
                $conn->commit();
                return json_encode(['status' => 'success', 'message' => 'No update required']);
            }
        } else {
            // Order ID not found
            return json_encode(['status' => 'error', 'message' => 'Order not found']);
        }
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        return json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
}

function confirmDeliveryOrder($conn, $order_id, $remarks, $amount,$deliver_status){
     // Start transaction for data consistency
     $conn->begin_transaction();

     try {
         // Get current remarks and customer_pay from the order
         $stmt = $conn->prepare("SELECT remarks, customer_pay FROM orders WHERE order_Id = ?");
         $stmt->bind_param("i", $order_id);
         $stmt->execute();
         $result = $stmt->get_result();
 
         if ($result->num_rows > 0) {
             $row = $result->fetch_assoc();
             $currentRemarks = $row['remarks'];
             $currentPay = $row['customer_pay'];
 
             // Append new remarks to existing ones
             $updatedRemarks = $currentRemarks ? $currentRemarks . " " . $remarks : $remarks;
 
             // Add amount to existing customer_pay
             $updatedPay = $currentPay + $amount;
 
             // Update the order
             $updateStmt = $conn->prepare("UPDATE orders SET customer_pay = ?, remarks = ?, delivery_status =? WHERE order_Id = ?");
             $updateStmt->bind_param("issi", $updatedPay, $updatedRemarks,$deliver_status, $order_id);
             $updateStmt->execute();
 
             // Check for successful update
             if ($updateStmt->affected_rows > 0) {
                 // Commit transaction
                 $conn->commit();
                 return json_encode(['status' => 'success', 'message' => 'Order updated successfully']);
             } else {
                 // No rows updated, possibly due to no changes being made
                 $conn->commit();
                 return json_encode(['status' => 'success', 'message' => 'No update required']);
             }
         } else {
             // Order ID not found
             return json_encode(['status' => 'error', 'message' => 'Order not found']);
         }
     } catch (Exception $e) {
         // Rollback transaction on error
         $conn->rollback();
         return json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
     }
}


?>