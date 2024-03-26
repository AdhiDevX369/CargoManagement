<?php
$authorizedFiles = ['file1.php', 'file2.php', 'config.php', 'checksums.json']; // Extend this list
$directoryToScan = '/path/to/your/directory'; // Define the directory

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directoryToScan));

foreach ($iterator as $file) {
    if ($file->isDir()) continue;

    $filePath = $file->getPathname();
    $fileName = $file->getFilename();

    if (!in_array($fileName, $authorizedFiles)) {
        echo "Unauthorized file detected: " . $filePath . "\n";
    }
}
?>
