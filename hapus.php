<?php
require 'includes/init.php';
require_login();
require 'config/koneksi.php';

// DELETE: hanya via POST + CSRF token
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_valid($_POST['csrf'] ?? null)) {
    $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
    if ($id) {
        $stmt = $koneksi->prepare('DELETE FROM barang WHERE id_barang = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        flash_set('success', t('msg_deleted'));
    }
} else {
    flash_set('error', t('invalid_token'));
}
header('Location: index.php');
exit;
