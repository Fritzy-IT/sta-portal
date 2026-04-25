<?php
$file = $_GET['file'] ?? 'android';
$ext = ($file === 'android') ? 'apk' : 'ipa';

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="STA_Package.'.$ext.'"');

echo "Sievers Tech Activities - Distribution Package for " . strtoupper($file);
exit;