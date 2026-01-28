<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Inicio de Sesión — CEAA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= asset('css/login.css') ?>?v=1">
  <!-- (Opcional) Iconos si usarás <i> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="login-container">
    <form method="post" action="index.php?controller=auth&action=doLogin" autocomplete="off">
      <div class="logo-container">
        <img src="<?= asset('img/logo.png') ?>" alt="Hidalgo CEAA">
      </div>

      <h2>Inicio de Sesión</h2>

      <?php if (!empty($_SESSION['flash'])): ?>
        <div class="mensaje-error"><?= $_SESSION['flash']; unset($_SESSION['flash']); ?></div>
      <?php endif; ?>

      <label>Correo electrónico</label>
      <div class="input-icon">
        <i class="fa-solid fa-user"></i>
        <input type="email" name="email" placeholder="admin@ceaa.gob.mx" required>
      </div>

      <label>Contraseña</label>
      <div class="input-icon">
        <i class="fa-solid fa-lock"></i>
        <input type="password" name="password" placeholder="••••••••" required>
      </div>

      <button type="submit">Iniciar Sesión</button>
      <!-- <a class="boton-secundario" href="#">¿Olvidaste tu contraseña?</a> -->
    </form>
  </div>
</body>
</html>
