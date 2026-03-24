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
  <link rel="stylesheet" href="<?= asset('css/dashboard.css') ?>?v=3">
 <link rel="stylesheet" href="<?= asset('css/dashboard.css') ?>?v=3">
  <link rel="stylesheet" href="<?= asset('css/chatbot-soporte.css') ?>?v=2">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<?php
  $currentCtrl = $_GET['controller'] ?? '';

  // Formatos
  if ($currentCtrl === 'formatos'): ?>
    <link rel="stylesheet" href="<?= asset('css/formatos.css') ?>?v=2">
<?php endif; ?>

<?php
  // Inventario (captura) y Reportes de inventario
  if ($currentCtrl === 'inventario' || ($currentCtrl === 'reportes' && $currentPage === 'inventario')): ?>
    <link rel="stylesheet" href="<?= asset('css/inventario-reporte.css') ?>?v=3">
<?php endif; ?>
<?php
  // CSS para el módulo de Inventario (formulario)
  if ($currentCtrl === 'inventario'): ?>
    <link rel="stylesheet" href="<?= asset('css/inventario-captura.css') ?>?v=2">
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
    <div class="user-info">
      <?php
        // Leer siempre desde BD para no depender de si la sesión tiene foto_perfil
        $dbFoto = DB::conn()
                    ->prepare("SELECT foto_perfil FROM usuarios WHERE id = ? LIMIT 1");
        $dbFoto->execute([(int)$usuario['id']]);
        $fotoPerfil = (string)($dbFoto->fetchColumn() ?? '');

        // Ignorar la imagen por defecto si el archivo no existe en disco
        $fotoEnDisco = ($fotoPerfil !== '' && $fotoPerfil !== 'assets/img/default-profile.png')
                        ? realpath(__DIR__ . '/../../public/' . ltrim($fotoPerfil, '/'))
                        : false;

        // Construir URL con cada segmento codificado para soportar nombres con espacios
        if ($fotoEnDisco) {
            $segmentos = explode('/', ltrim($fotoPerfil, '/'));
            $fotoUrl   = BASE_URI . '/' . implode('/', array_map('rawurlencode', $segmentos));
        } else {
            $fotoUrl = '';
        }

        $inicial = mb_strtoupper(mb_substr($usuario['nombre'], 0, 1, 'UTF-8'), 'UTF-8');

        // Actualizar sesión con el valor real de la BD
        $_SESSION['user']['foto_perfil'] = $fotoPerfil;
      ?>
      <div class="usuario-lateral-icono">
        <?php if ($fotoUrl): ?>
          <img src="<?= htmlspecialchars($fotoUrl, ENT_QUOTES, 'UTF-8') ?>"
               alt="Foto de perfil"
               class="sidebar-avatar"
               onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
          <span class="sidebar-inicial" style="display:none"><?= $inicial ?></span>
        <?php else: ?>
          <span class="sidebar-inicial"><?= $inicial ?></span>
        <?php endif; ?>
      </div>
      <div class="user-details">
        <h3 class="adm">Administrador</h3>
        <p class="bienvenida">
          Bienvenid@,<br>
          <strong><?= htmlspecialchars($usuario['nombre']) ?></strong>
        </p>
      </div>
    </div>

    <a href="<?= BASE_URI ?>/index.php?controller=dashboard&action=inicio"
       class="<?= ($currentCtrl === 'dashboard' && $currentPage === 'inicio') ? 'activo' : '' ?>">
      <i class="fa-solid fa-house"></i>
      <span class="menu-text">Inicio</span>
    </a>

    <a href="<?= BASE_URI ?>/index.php?controller=dashboard&action=perfil"
       class="<?= ($currentCtrl === 'dashboard' && $currentPage === 'perfil') ? 'activo' : '' ?>">
      <i class="fa-solid fa-user-circle"></i>
      <span class="menu-text">Perfil</span>
    </a>

    <a href="<?= BASE_URI ?>/index.php?controller=users&action=index"
       class="<?= ($currentCtrl === 'users' && $currentPage === 'index') ? 'activo' : '' ?>">
      <i class="fa-solid fa-users"></i>
      <span class="menu-text">Gestión de Usuarios</span>
    </a>

    <a href="<?= BASE_URI ?>/index.php?controller=formatos&action=index"
       class="<?= ($currentCtrl === 'formatos' && $currentPage === 'index') ? 'activo' : '' ?>">
      <i class="fa-solid fa-file-lines"></i>
      <span class="menu-text">Formatos / Capturas</span>
    </a>

    <a href="<?= BASE_URI ?>/index.php?controller=inventario&action=form"
       class="<?= ($currentCtrl === 'inventario' && $currentPage === 'form') ? 'activo' : '' ?>">
      <i class="fa-solid fa-boxes-stacked"></i>
      <span class="menu-text">Inventario</span>
    </a>

    <a href="<?= BASE_URI ?>/index.php?controller=reportes&action=inventario"
       class="<?= ($currentCtrl === 'reportes' && $currentPage === 'inventario') ? 'activo' : '' ?>">
      <i class="fa-solid fa-chart-bar"></i>
      <span class="menu-text">Reportes de inventario</span>
    </a>

    <a href="<?= BASE_URI ?>/index.php?controller=manual&action=ver"
       class="<?= ($currentCtrl === 'manual') ? 'activo' : '' ?>">
      <i class="fa-solid fa-book"></i>
      <span class="menu-text">Manual de usuario</span>
    </a>

    <?php if (($usuario['email'] ?? '') === 'luis.roldangamero@gmail.com'): ?>
    <a href="<?= BASE_URI ?>/index.php?controller=bitacora&action=index"
       class="<?= ($currentCtrl === 'bitacora') ? 'activo' : '' ?>">
      <i class="fa-solid fa-shield-halved"></i>
      <span class="menu-text">Bitácora</span>
    </a>
    <?php endif; ?>

    <a href="<?= BASE_URI ?>/index.php?controller=auth&action=logout">
      <i class="fa-solid fa-right-from-bracket"></i>
      <span class="menu-text">Cerrar sesión</span>
    </a>

    <label for="toggle" class="cerrar">&#10005;</label>
  </aside>

  <!-- Contenido -->
  <main class="contenido fade-in-up" id="contenido">
    <?php if (!empty($_SESSION['flash_saludo'])): ?>
      <div id="flashSaludo" class="flash-saludo" role="status" aria-live="polite">
        <span><?= htmlspecialchars($_SESSION['flash_saludo']) ?></span>
        <button type="button" class="flash-saludo-cerrar" aria-label="Cerrar alerta">×</button>
      </div>
      <?php unset($_SESSION['flash_saludo']); ?>
    <?php endif; ?>

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

  <button id="chatbotToggle" class="chatbot-toggle" type="button" aria-label="Abrir soporte">
    <i class="fa-solid fa-comments"></i>
  </button>

  <section id="chatbotWidget" class="chatbot-widget" aria-label="Asistente de soporte" aria-hidden="true">
    <header class="chatbot-header">
      <div class="chatbot-title-wrap">
        <strong>Asistente CEAA</strong>
        <span>Soporte del sistema</span>
      </div>
      <button id="chatbotClose" class="chatbot-close" type="button" aria-label="Cerrar">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </header>

    <div id="chatbotMessages" class="chatbot-messages"></div>
    <div id="chatbotQuick" class="chatbot-quick"></div>

    <form id="chatbotForm" class="chatbot-form" autocomplete="off">
      <input id="chatbotInput" type="text" maxlength="180" placeholder="Ej. no puedo iniciar sesión" />
      <button type="submit" aria-label="Enviar">
        <i class="fa-solid fa-paper-plane"></i>
      </button>
    </form>
  </section>
</div>
<script>
  (function () {
    var toast = document.getElementById('flashSaludo');
    if (!toast) return;

    var closeBtn = toast.querySelector('.flash-saludo-cerrar');
    var hide = function () {
      toast.classList.add('is-hiding');
      window.setTimeout(function () {
        if (toast && toast.parentNode) {
          toast.parentNode.removeChild(toast);
        }
      }, 380);
    };

    if (closeBtn) {
      closeBtn.addEventListener('click', hide);
    }

    window.setTimeout(hide, 5000);
  })();

  window.CEAA_CHATBOT_CONFIG = {
    baseUri: '<?= BASE_URI ?>',
    userName: '<?= htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8') ?>',
    rolId: <?= (int)$usuario['rol_id'] ?>,
    csrfToken: '<?= csrf_token() ?>'
  };
</script>
<script src="<?= asset('js/chatbot-soporte.js') ?>?v=3"></script>
</body>
</html>
