<?php
require 'session.php';
require 'dbconfig.php';
require 'superAdminFunctions.php';
require 'enckey.php';

$containerId = decrypt($_GET['containerId'], $key);
$containerId = mysqli_real_escape_string($conn, $containerId);

if (!empty($containerId)) {
    $updateContainer = "UPDATE container SET location = 'Arrived' WHERE container_id = '$containerId'";
    $updateInvoice = "UPDATE invoice SET location = 'Arrived' WHERE container_id = '$containerId'";
    $updateContainerResult = mysqli_query($conn, $updateContainer);
    $updateInvoiceResult = mysqli_query($conn, $updateInvoice);
    if ($updateContainerResult && $updateInvoiceResult) {
        echo "<script>
                alert('Container and invoice location updated to Arrived successfully.');
                window.location.href = 'confirmarival.php';
              </script>";
    } else {
        echo "<script>
                alert('Error updating container and invoice location.');
                window.location.href = 'confirmarival.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Invalid container ID.');
            window.location.href = 'confirmarival.php';
          </script>";
}
