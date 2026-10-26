<?php
require 'includes/init.php';
require_login();
require 'config/koneksi.php';

// READ: ambil data (dengan pencarian opsional)
$q = trim($_GET['q'] ?? '');
if ($q !== '') {
    $like = '%' . $q . '%';
    $stmt = $koneksi->prepare('SELECT * FROM barang WHERE nama_barang LIKE ? OR kode_barang LIKE ? ORDER BY id_barang DESC');
    $stmt->bind_param('ss', $like, $like);
} else {
    $stmt = $koneksi->prepare('SELECT * FROM barang ORDER BY id_barang DESC');
}
$stmt->execute();
$rows = $stmt->get_result();
$flash = flash_get();

require 'includes/header.php';
?>
<div class="card">
  <div class="card-head">
    <h2><?= e(t('data_list')) ?></h2>
    <a class="btn" href="tambah.php">+ <?= e(t('add')) ?></a>
  </div>

  <?php if ($flash): ?><div class="alert alert-<?= e($flash[0]) ?>"><?= e($flash[1]) ?></div><?php endif; ?>

  <form method="GET" action="index.php" class="search">
    <input type="text" name="q" placeholder="<?= e(t('search')) ?>" value="<?= e($q) ?>">
    <button class="btn" type="submit"><?= e(t('search_btn')) ?></button>
  </form>

  <div class="table-wrap">
  <table>
    <thead><tr>
      <th><?= e(t('no')) ?></th><th><?= e(t('code')) ?></th><th><?= e(t('name')) ?></th>
      <th><?= e(t('category')) ?></th><th><?= e(t('qty')) ?></th><th><?= e(t('price')) ?></th>
      <th><?= e(t('location')) ?></th><th><?= e(t('action')) ?></th>
    </tr></thead>
    <tbody>
    <?php if ($rows->num_rows === 0): ?>
      <tr><td colspan="8" class="center"><?= e(t('no_data')) ?></td></tr>
    <?php else: $no = 1; while ($r = $rows->fetch_assoc()): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= e($r['kode_barang']) ?></td>
        <td><?= e($r['nama_barang']) ?></td>
        <td><?= e($r['kategori']) ?></td>
        <td><?= e($r['jumlah']) ?></td>
        <td><?= number_format((float)$r['harga'], 0, ',', '.') ?></td>
        <td><?= e($r['lokasi']) ?></td>
        <td class="nowrap">
          <a class="btn btn-sm btn-warn" href="edit.php?id=<?= (int)$r['id_barang'] ?>"><?= e(t('edit')) ?></a>
          <form method="POST" action="hapus.php" class="inline"
                onsubmit="return confirm('<?= e(t('confirm_delete')) ?>');">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <input type="hidden" name="id" value="<?= (int)$r['id_barang'] ?>">
            <button class="btn btn-sm btn-danger" type="submit"><?= e(t('delete')) ?></button>
          </form>
        </td>
      </tr>
    <?php endwhile; endif; ?>
    </tbody>
  </table>
  </div>
</div>
<?php require 'includes/footer.php'; ?>
