<?php
session_start();

/* Helpers de ruta para assets */
define('BASE_URI', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/')); // p.ej. /ceaa_recursos/public
function asset(string $path): string {
    return BASE_URI . '/assets/' . ltrim($path, '/');
}

/* Autoload: busca en /app/* y también en la raíz (/controllers, /models) */
spl_autoload_register(function ($class) {
    $roots = [
        __DIR__ . '/../app/controllers/',
        __DIR__ . '/../app/models/',
        __DIR__ . '/../controllers/',
        __DIR__ . '/../models/',
    ];
    foreach ($roots as $dir) {
        $file = $dir . $class . '.php';
        if (is_file($file)) {
            require_once $file;
            return;
        }
    }
});

/* Config/DB */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

/* Router */
$controller = $_GET['controller'] ?? 'auth';
$action     = $_GET['action'] ?? 'login';

$map = [
    'auth'       => 'AuthController',
    'dashboard'  => 'DashboardController',
    'users'      => 'UserController',
    'formatos'   => 'FormatoController',
    'inventario' => 'InventarioController',
    'reportes'   => 'ReporteController',
    'reporte'    => 'ReporteController',  // ← AGREGAR ESTA LÍNEA
];


if (!isset($map[$controller])) {
    http_response_code(404);
    exit('Controlador no encontrado');
}

$klass = $map[$controller];

if (!class_exists($klass)) {
    http_response_code(500);
    exit("No se encontró la clase '$klass'. Verifica nombre del archivo y clase ({$klass}.php con class {$klass} { ... }).");
}

$instance = new $klass();

if (!method_exists($instance, $action)) {
    http_response_code(404);
    exit('Acción no encontrada');
}

echo $instance->$action();
