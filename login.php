<?php
require 'includes/init.php';
require 'config/koneksi.php';

if (!empty($_SESSION['user_id'])) { header('Location: index.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validasi kelengkapan data
    if ($username === '' || $password === '') {
        $error = t('login_required');
    } else {
        $stmt = $koneksi->prepare('SELECT id_user, password, nama_lengkap FROM users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);          // cegah session fixation
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['nama']    = $user['nama_lengkap'];
            header('Location: index.php');
            exit;
        } else {
            $error = t('login_failed');
        }
    }
}
require 'includes/header.php';
?>
<div class="card card-narrow">
  <h2><?= e(t('login_title')) ?></h2>
  <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
  <form method="POST" action="login.php">
    <label><?= e(t('username')) ?></label>
    <input type="text" name="username" value="<?= e($_POST['username'] ?? '') ?>" autofocus>
    <label><?= e(t('password')) ?></label>
    <input type="password" name="password">
    <button class="btn" type="submit"><?= e(t('login')) ?></button>
  </form>
  <p class="hint">Demo: admin / admin123</p>
</div>
<?php require 'includes/footer.php'; ?>
