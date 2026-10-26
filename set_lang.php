<?php
require 'includes/init.php';

// Simpan pilihan bahasa ke $_SESSION (hanya nilai yang diizinkan)
$lang = $_GET['lang'] ?? 'id';
if (in_array($lang, ['id', 'en'], true)) {
    $_SESSION['lang'] = $lang;
}

// Kembali ke halaman sebelumnya (whitelist agar aman dari open redirect)
$allowed = ['index.php', 'login.php', 'tambah.php'];
$back = $_GET['back'] ?? 'index.php';
if ($back === 'edit.php' && isset($_SERVER['HTTP_REFERER'])) {
    $ref = parse_url($_SERVER['HTTP_REFERER']);
    if (!empty($ref['query']) && preg_match('/^id=\d+$/', $ref['query'])) {
        header('Location: edit.php?' . $ref['query']);
        exit;
    }
}
if (!in_array($back, $allowed, true)) { $back = 'index.php'; }
header('Location: ' . $back);
exit;
