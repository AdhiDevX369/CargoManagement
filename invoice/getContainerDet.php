<?php

require_once '../DB/dbconfig.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $container_id = filter_input(INPUT_POST, 'con_id', FILTER_SANITIZE_NUMBER_INT);

    $stmt = $conn->prepare("SELECT * FROM invoice WHERE container_id = ?");
    $stmt->bind_param("i", $container_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        $data = $result->fetch_all(MYSQLI_ASSOC);

        if ($data) {
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No data found for the specified container ID']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Query execution failed']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

?>
