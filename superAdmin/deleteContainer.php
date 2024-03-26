<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';
require 'enckey.php';
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $containerId = decrypt($_GET['id'], $key);
    $containerId = $conn->real_escape_string($containerId);
    $stmt = $conn->prepare("DELETE FROM container WHERE container_id = ?");
    $stmt->bind_param("s", $containerId);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Container deleted successfully.'); window.location.href='containers.php';</script>";
        } else {
            echo "<script>alert('No container found with the provided ID.'); window.location.href='containers.php';</script>";
        }
    } else {
        echo "<script>alert('Error deleting container.'); window.location.href='containers.php';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href='containers.php';</script>";
}
$conn->close();
?>
