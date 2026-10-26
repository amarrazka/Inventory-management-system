<?php
require 'includes/init.php';
require_login();
require 'config/koneksi.php';
require 'includes/validasi.php';

$data = ['kode_barang'=>'','nama_barang'=>'','kategori'=>'','jumlah'=>'','harga'=>'','lokasi'=>''];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valid($_POST['csrf'] ?? null)) {
        $errors[] = t('invalid_token');
    } else {
        [$data, $errors] = proses_input_barang($_POST);

        if (!$errors) {
            // Cek kode unik
            $cek = $koneksi->prepare('SELECT 1 FROM barang WHERE kode_barang = ?');
            $cek->bind_param('s', $data['kode_barang']);
            $cek->execute();
            if ($cek->get_result()->num_rows > 0) {
                $errors[] = t('err_code_exists');
            }
        }
        if (!$errors) {
            // CREATE
            $stmt = $koneksi->prepare('INSERT INTO barang (kode_barang, nama_barang, kategori, jumlah, harga, lokasi) VALUES (?,?,?,?,?,?)');
            $stmt->bind_param('sssids', $data['kode_barang'], $data['nama_barang'], $data['kategori'],
                              $data['jumlah'], $data['harga'], $data['lokasi']);
            $stmt->execute();
            flash_set('success', t('msg_added'));
            header('Location: index.php');
            exit;
        }
    }
}
$action = 'tambah.php';
$submit_label = t('save');
require 'includes/header.php';
?>
<div class="card card-narrow">
  <h2><?= e(t('add_title')) ?></h2>
  <?php require 'includes/form_barang.php'; ?>
</div>
<?php require 'includes/footer.php'; ?>
