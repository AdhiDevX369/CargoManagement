<?php
$filesToMonitor = ['../index.php', '../header.php', '../user-login.php','../dashbord.php']; // check wenna oni files wl path
$checksumsFile = 'checksums.json';

if (!file_exists($checksumsFile)) {
    die("Checksums file not found.");
}

$storedChecksums = json_decode(file_get_contents($checksumsFile), true);

foreach ($filesToMonitor as $file) {
    if (file_exists($file)) {
        $currentChecksum = md5_file($file);

        if (isset($storedChecksums[$file]) && $storedChecksums[$file] != $currentChecksum) {
            echo "File modified: " . $file . "\n";
        }
    } else {
        echo "File missing: " . $file . "\n";
    }
}
?>
