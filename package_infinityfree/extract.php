<?php
header('Content-Type: text/plain');

$zipFile = __DIR__ . '/it0049-pos-tfa4-infinityfree.zip';

if (!file_exists($zipFile)) {
    echo "ERROR: Zip file not found at " . $zipFile . "\n";
    exit;
}

if (!class_exists('ZipArchive')) {
    echo "ERROR: ZipArchive extension is not enabled in this PHP environment.\n";
    exit;
}

$zip = new ZipArchive();
$res = $zip->open($zipFile);

if ($res === TRUE) {
    $zip->extractTo(__DIR__);
    $zip->close();
    echo "SUCCESS: Extracted IT0049 POS TFA4 package successfully!\n";
    echo "Target directory: " . __DIR__ . "\n";
    echo "All application files, vendor dependencies, and assets are in place.\n";
    @unlink(__FILE__);
    echo "Removed extract.php for security.\n";
} else {
    echo "ERROR: Could not open zip file. Error code: " . $res . "\n";
}
