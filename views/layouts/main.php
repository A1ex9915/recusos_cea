<?php $user = $_SESSION['user'] ?? null; ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>CEAA — Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= asset('css/app.css') ?>?v=1">
</head>

<body class="bg">
<header class="topbar">
  <img src="<?= asset('img/logo.png') ?>" alt="Hidalgo">
  <img src="<?= asset('img/Logotipo1.png') ?>" alt="CEAA">
</header>

<aside class="sidebar">
  <div class="sb-user">
    <div class="avatar">👤</div>
    <div>
      <strong><?= htmlspecialchars($user['nombre'] ?? 'Invitado') ?></strong>
      <div class="small"><?= htmlspecialchars($user['email'] ?? '') ?></div>
    </div>
  </div>
  <nav>
    <a href="index.php?controller=dashboard&action=inicio" class="item">Inicio</a>
    <a href="index.php?controller=users&action=index" class="item">Gestión de Usuarios</a>
    <a href="index.php?controller=formatos&action=index" class="item">Formatos / Capturas</a>
    <a href="index.php?controller=inventario&action=index" class="item">Inventario</a>
    <a href="index.php?controller=reportes&action=inventario" class="item">Reportes de inventario</a>
    <a href="index.php?controller=auth&action=logout" class="item">Cerrar sesión</a>
  </nav>
</aside>

<main class="content">
  <?= $content ?? '' ?>
</main>
</body>
</html>
