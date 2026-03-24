<?php
/**
 * Helpers globales — cargados antes de cualquier controlador
 */

/* =========================================================
 *  ESCAPE XSS — siempre usar e() en las vistas
 * ========================================================= */

/**
 * Escapa una cadena para salida HTML segura (previene XSS).
 * Úsalo en vistas: <?= e($variable) ?>
 */
function e(?string $str): string
{
    return htmlspecialchars((string)$str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/* =========================================================
 *  ROLES Y PERMISOS
 * ========================================================= */

/*
 * IDs de roles del sistema:
 *   1 = Administrador   — acceso total
 *   2 = Capturista      — alta/edición de datos
 *   3 = Consultor       — sólo lectura / reportes
 */
define('ROL_ADMIN',      1);
define('ROL_CAPTURISTA', 2);
define('ROL_CONSULTOR',  3);

/**
 * Devuelve el rol_id del usuario en sesión (0 si no autenticado).
 */
function rol_actual(): int
{
    return (int)($_SESSION['user']['rol_id'] ?? 0);
}

/**
 * Verifica que el usuario esté autenticado Y tenga uno de los roles indicados.
 * - Si no hay sesión → redirige al login.
 * - Si no tiene permiso → HTTP 403 con página amigable.
 *
 * Uso: require_role([ROL_ADMIN, ROL_CAPTURISTA]);
 */
function require_role(array $roles_permitidos): void
{
    if (empty($_SESSION['user'])) {
        header('Location: ' . BASE_URI . '/index.php?controller=auth&action=login');
        exit;
    }

    if (!in_array(rol_actual(), $roles_permitidos, true)) {
        http_response_code(403);
        echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">
<title>Acceso denegado &mdash; CEAA</title>
<style>body{font-family:\'Segoe UI\',sans-serif;background:#f4f5f7;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0}
.box{background:#fff;border-radius:16px;padding:48px 40px;text-align:center;box-shadow:0 8px 24px rgba(0,0,0,.1);max-width:420px}
.icon{font-size:3rem;margin-bottom:12px}
h2{color:#7b1b3b;margin:0 0 8px}p{color:#6b7280;margin:0 0 24px}
a{display:inline-block;padding:10px 24px;background:linear-gradient(135deg,#7b1b3b,#a83260);color:#fff;border-radius:999px;text-decoration:none;font-weight:600}</style>
</head><body><div class="box">
<div class="icon">&#128274;</div>
<h2>Acceso denegado</h2>
<p>No tienes permiso para realizar esta acci&oacute;n.<br>Contacta al administrador si crees que es un error.</p>
<a href="' . BASE_URI . '/index.php?controller=dashboard&action=inicio">&#8592; Volver al inicio</a>
</div></body></html>';
        exit;
    }
}

/* =========================================================
 *  PROTECCIÓN CSRF
 * ========================================================= */

function csrf_token(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf_token" value="'
        . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

/**
 * Aborta la petición si el token CSRF no coincide.
 * En peticiones AJAX (fetch) responde JSON 403.
 * En formularios normales responde texto 403.
 */
function csrf_validate(): void
{
    $token = $_POST['_csrf_token'] ?? '';
    if (!hash_equals(csrf_token(), $token)) {
        http_response_code(403);
        $isJson = !empty($_SERVER['HTTP_ACCEPT'])
            && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false;
        if ($isJson) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'error' => 'Sesión expirada. Recarga la página.']);
        } else {
            echo 'Solicitud inválida (token CSRF). Vuelve atrás y vuelve a intentarlo.';
        }
        exit;
    }
}
