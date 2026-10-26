<!DOCTYPE html>
<html lang="<?= e($_SESSION['lang']) ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e(t('app_title')) ?></title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="topbar">
  <div class="brand"><?= e(t('app_title')) ?></div>
  <div class="topbar-right">
    <span class="lang">
      <?= e(t('language')) ?>:
      <a href="set_lang.php?lang=id&back=<?= e(basename($_SERVER['PHP_SELF'])) ?>" class="<?= $_SESSION['lang']==='id'?'active':'' ?>">ID</a> |
      <a href="set_lang.php?lang=en&back=<?= e(basename($_SERVER['PHP_SELF'])) ?>" class="<?= $_SESSION['lang']==='en'?'active':'' ?>">EN</a>
    </span>
    <?php if (!empty($_SESSION['user_id'])): ?>
      <span><?= e(t('welcome')) ?>, <b><?= e($_SESSION['nama']) ?></b></span>
      <a class="btn btn-sm btn-gray" href="logout.php"><?= e(t('logout')) ?></a>
    <?php endif; ?>
  </div>
</header>
<main class="container">
