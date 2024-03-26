<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';
require 'enckey.php';
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $userId = decrypt($_GET['id'], $key);
    $userId = $conn->real_escape_string($userId);
    $stmt = $conn->prepare("DELETE FROM user WHERE user_id = ?");
    $stmt->bind_param("i", $userId); 
    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully.'); window.location.href='users.php';</script>";
    } else {
        echo "<script>alert('There was an error deleting the user.'); window.location.href='users.php';</script>";
    }
    $stmt->close();
} else {
    //header("Location: users.php");
    exit();
}
$conn->close();
?>
