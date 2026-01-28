<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
  header('Location: ' . BASE_URI . '/index.php?controller=auth&action=login');
  exit;
}

$usuario     = $_SESSION['user'];
$currentPage = $_GET['action']     ?? '';
$currentCtrl = $_GET['controller'] ?? '';
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Panel de Administración — CEAA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?= asset('img/logoo.png') ?>">
  <link rel="stylesheet" href="<?= asset('css/dashboard.css') ?>?v=1">
 <link rel="stylesheet" href="<?= asset('css/dashboard.css') ?>?v=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<?php
  $currentCtrl = $_GET['controller'] ?? '';

  // Formatos
  if ($currentCtrl === 'formatos'): ?>
    <link rel="stylesheet" href="<?= asset('css/formatos.css') ?>?v=1">
<?php endif; ?>

<?php
  // Inventario (captura) y Reportes de inventario
  if ($currentCtrl === 'inventario' || ($currentCtrl === 'reportes' && $currentPage === 'inventario')): ?>
    <link rel="stylesheet" href="<?= asset('css/inventario-reporte.css') ?>?v=1">
<?php endif; ?>
<?php
  // CSS para el módulo de Inventario (formulario)
  if ($currentCtrl === 'inventario'): ?>
    <link rel="stylesheet" href="<?= asset('css/inventario-captura.css') ?>?v=1">
<?php endif; ?>
<?php
  if ($currentCtrl === 'reportes' && $currentPage === 'inventario'): ?>
      <link rel="stylesheet" href="<?= asset('css/excel-modal.css') ?>?v=1">
<?php endif; ?>
<?php
  if ($currentCtrl === 'formatos' && $currentPage === 'capturaECA'): ?>
    <link rel="stylesheet" href="<?= asset('css/captura-eca.css') ?>?v=1">
<?php endif; ?>




</head>

<body>
<div class="wrapper" id="wrapper">
  <input type="checkbox" id="toggle">

  <!-- Header -->
  <header class="header">
    <div class="header-left">
      <label for="toggle" class="toggle-menu">
        <i class="fa-solid fa-bars"></i>
      </label>
    </div>
    <img src="<?= asset('img/Logotipo1.png') ?>" class="header-img logo-animado" alt="Encabezado CEAA">
  </header>

  <!-- Sidebar -->
  <aside class="barra-lateral" id="sidebar">
    <div class="usuario-lateral-icono"><i class="fa-solid fa-user"></i></div>
    <h3 class="adm">Administrador</h3>
    <p class="bienvenida">
      Bienvenid@,<br>
      <strong><?= htmlspecialchars($usuario['nombre']) ?></strong>
    </p>

    <a href="<?= BASE_URI ?>/index.php?controller=dashboard&action=inicio"
       class="<?= ($currentCtrl === 'dashboard' && $currentPage === 'inicio') ? 'activo' : '' ?>">
      Inicio
    </a>

    <a href="<?= BASE_URI ?>/index.php?controller=dashboard&action=perfil"
       class="<?= ($currentCtrl === 'dashboard' && $currentPage === 'perfil') ? 'activo' : '' ?>">
      Perfil
    </a>

    <a href="<?= BASE_URI ?>/index.php?controller=users&action=index"
       class="<?= ($currentCtrl === 'users' && $currentPage === 'index') ? 'activo' : '' ?>">
      Gestión de Usuarios
    </a>

    <a href="<?= BASE_URI ?>/index.php?controller=formatos&action=index"
       class="<?= ($currentCtrl === 'formatos' && $currentPage === 'index') ? 'activo' : '' ?>">
      Formatos / Capturas
    </a>

    <a href="<?= BASE_URI ?>/index.php?controller=inventario&action=form"
   class="<?= ($currentCtrl === 'inventario' && $currentPage === 'form') ? 'activo' : '' ?>">
  Inventario
</a>


    <a href="<?= BASE_URI ?>/index.php?controller=reportes&action=inventario"
       class="<?= ($currentCtrl === 'reportes' && $currentPage === 'inventario') ? 'activo' : '' ?>">
      Reportes de inventario
    </a>

    <a href="<?= BASE_URI ?>/index.php?controller=auth&action=logout">
      Cerrar sesión
    </a>

    <label for="toggle" class="cerrar">&#10005;</label>
  </aside>

  <!-- Contenido -->
  <main class="contenido fade-in-up" id="contenido">
    <?php
      $vista = $_SESSION['vista'] ?? null;
      $ruta  = $vista ? dirname(__DIR__) . "/views/{$vista}" : null;

      // 🔹 Extraer variables pasadas desde el controlador (ej. ['formatos' => $formatos])
      if (isset($viewData) && is_array($viewData)) {
        extract($viewData);
      }

      if ($ruta && is_file($ruta)) {
        include $ruta;
      } else {
        echo '<div class="portada-bienvenida"></div>';
      }
    ?>
  </main>
</div>
</body>
</html>
