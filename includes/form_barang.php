<?php
// Partial form (dipakai tambah.php & edit.php). Variabel: $data, $errors, $action, $submit_label
?>
<?php if ($errors): ?>
  <div class="alert alert-error"><ul>
    <?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?>
  </ul></div>
<?php endif; ?>
<form method="POST" action="<?= e($action) ?>">
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
  <label><?= e(t('code')) ?></label>
  <input type="text" name="kode_barang" maxlength="20" value="<?= e($data['kode_barang']) ?>">
  <label><?= e(t('name')) ?></label>
  <input type="text" name="nama_barang" maxlength="100" value="<?= e($data['nama_barang']) ?>">
  <label><?= e(t('category')) ?></label>
  <input type="text" name="kategori" maxlength="50" value="<?= e($data['kategori']) ?>">
  <label><?= e(t('qty')) ?></label>
  <input type="text" name="jumlah" value="<?= e($data['jumlah']) ?>">
  <label><?= e(t('price')) ?></label>
  <input type="text" name="harga" value="<?= e($data['harga']) ?>">
  <label><?= e(t('location')) ?></label>
  <input type="text" name="lokasi" maxlength="100" value="<?= e($data['lokasi']) ?>">
  <div class="actions">
    <button class="btn" type="submit"><?= e($submit_label) ?></button>
    <a class="btn btn-gray" href="index.php"><?= e(t('cancel')) ?></a>
  </div>
</form>
