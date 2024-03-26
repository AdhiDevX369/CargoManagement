<?php
session_start();
if (!isset($_SESSION['superuser'])) {
    echo "<script>alert('You must be logged in to access this page.'); window.location.href='login.php';</script>";
    exit(); 
}
?>
