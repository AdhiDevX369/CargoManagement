<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';

if (isset($_GET['orderId']) && !empty($_GET['orderId'])) {
    $orderId = filter_input(INPUT_GET, 'orderId', FILTER_SANITIZE_NUMBER_INT);
    

  
}
?>
