<?php
// Konfigurasi koneksi database MySQL (sesuaikan dengan server Anda)
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'db_inventaris';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $koneksi = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $koneksi->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    die('Koneksi database gagal. Pastikan MySQL aktif dan database sudah di-import.');
}
