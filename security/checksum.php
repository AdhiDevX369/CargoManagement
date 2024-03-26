<?php
$filesToMonitor = ['../index.php', '../header.php', '../user-login.php','../dashbord.php']; 
$checksumsFile = 'checksums.json';

$checksums = [];

foreach ($filesToMonitor as $file) {
    if (file_exists($file)) {
        $checksums[$file] = md5_file($file);
    }
}

file_put_contents($checksumsFile, json_encode($checksums));
echo "Checksums generated and stored.";
?>
