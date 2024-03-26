<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';
require 'enckey.php';
$containerId = decrypt($_GET['containerId'], $key);
if (changeLocOfConIn($conn, $containerId)) {
    echo "<script>alert('Location updated succesfully'); window.location.href='containers.php';</script>"; 
}
else
{
    echo "<script>alert('An error occured!!!'); window.location.href='containers.php';</script>"; 
}
?>
