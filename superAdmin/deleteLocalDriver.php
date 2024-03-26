<?php
require 'dbconfig.php';
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $userId = $conn->real_escape_string($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM warehousedriver WHERE id = ?");
    $stmt->bind_param("i", $userId); 
    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully.'); window.location.href='localdrivers.php';</script>";
    } else {
        echo "<script>alert('There was an error deleting the user.'); window.location.href='localdrivers.php';</script>";
    }
    $stmt->close();
} else {
    //header("Location: users.php");
    exit();
}
$conn->close();
?>
