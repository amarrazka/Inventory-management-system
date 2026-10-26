<?php
require 'includes/init.php';
require_login();
require 'config/koneksi.php';
require 'includes/validasi.php';

// Ambil id unik dari URL (GET) atau form (POST)
$id = filter_var($_GET['id'] ?? ($_POST['id'] ?? null), FILTER_VALIDATE_INT);
if (!$id) { flash_set('error', t('not_found')); header('Location: index.php'); exit; }

$stmt = $koneksi->prepare('SELECT * FROM barang WHERE id_barang = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
if (!$data) { flash_set('error', t('not_found')); header('Location: index.php'); exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valid($_POST['csrf'] ?? null)) {
        $errors[] = t('invalid_token');
    } else {
        [$data, $errors] = proses_input_barang($_POST);

        if (!$errors) {
            // Kode harus unik (kecuali milik data ini sendiri)
            $cek = $koneksi->prepare('SELECT 1 FROM barang WHERE kode_barang = ? AND id_barang <> ?');
            $cek->bind_param('si', $data['kode_barang'], $id);
            $cek->execute();
            if ($cek->get_result()->num_rows > 0) { $errors[] = t('err_code_exists'); }
        }
        if (!$errors) {
            // UPDATE
            $up = $koneksi->prepare('UPDATE barang SET kode_barang=?, nama_barang=?, kategori=?, jumlah=?, harga=?, lokasi=? WHERE id_barang=?');
            $up->bind_param('sssidsi', $data['kode_barang'], $data['nama_barang'], $data['kategori'],
                            $data['jumlah'], $data['harga'], $data['lokasi'], $id);
            $up->execute();
            flash_set('success', t('msg_updated'));
            header('Location: index.php');
            exit;
        }
    }
}
$action = 'edit.php?id=' . $id;
$submit_label = t('update');
require 'includes/header.php';
?>
<div class="card card-narrow">
  <h2><?= e(t('edit_title')) ?></h2>
  <?php require 'includes/form_barang.php'; ?>
</div>
<?php require 'includes/footer.php'; ?>
