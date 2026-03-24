<?php
session_start();

// Verificar autenticación
if (empty($_SESSION['user'])) {
    header('Location: ' . BASE_URI . '/index.php?controller=auth&action=login');
    exit;
}

// Verificar CSRF
csrf_validate();

// Solo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URI . '/index.php?controller=dashboard&action=perfil');
    exit;
}

$pdo     = DB::conn();
$user_id = (int)$_SESSION['user']['id'];

// Validación backend
$nombre = trim($_POST['nombre'] ?? '');
$email  = trim($_POST['email']  ?? '');

if (strlen($nombre) < 2) {
    $_SESSION['flash_error_perfil'] = 'El nombre debe tener al menos 2 caracteres.';
    header('Location: ' . BASE_URI . '/index.php?controller=dashboard&action=perfil');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['flash_error_perfil'] = 'El correo electrónico no tiene un formato válido.';
    header('Location: ' . BASE_URI . '/index.php?controller=dashboard&action=perfil');
    exit;
}

// Verificar email único (excluyendo el propio usuario)
$stChk = $pdo->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
$stChk->execute([$email, $user_id]);
if ($stChk->fetch()) {
    $_SESSION['flash_error_perfil'] = 'Ese correo ya está en uso por otro usuario.';
    header('Location: ' . BASE_URI . '/index.php?controller=dashboard&action=perfil');
    exit;
}

$foto_ruta = null;

// --- Manejo de la foto (validación de tipo) ---
if (!empty($_FILES['foto_perfil']['name'])) {

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($_FILES['foto_perfil']['tmp_name']);

    if (!in_array($mime, $allowedTypes, true)) {
        $_SESSION['flash_error_perfil'] = 'Tipo de archivo no permitido. Use JPG, PNG, GIF o WEBP.';
        header('Location: ' . BASE_URI . '/index.php?controller=dashboard&action=perfil');
        exit;
    }

    $maxSize = 2 * 1024 * 1024; // 2 MB
    if ($_FILES['foto_perfil']['size'] > $maxSize) {
        $_SESSION['flash_error_perfil'] = 'La imagen no debe superar 2 MB.';
        header('Location: ' . BASE_URI . '/index.php?controller=dashboard&action=perfil');
        exit;
    }

    $carpeta = dirname(__DIR__) . '/public/uploads/perfiles/';
    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0755, true);
    }

    $ext        = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
    $nuevoNombre = 'perfil_' . $user_id . '_' . time() . '.' . strtolower($ext);
    $rutaFinal   = $carpeta . $nuevoNombre;

    if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaFinal)) {
        $foto_ruta = 'uploads/perfiles/' . $nuevoNombre;
        $_SESSION['user']['foto_perfil'] = $foto_ruta;
    }
}

// --- Actualizar en BD ---
if ($foto_ruta) {
    $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, email = ?, foto_perfil = ?, actualizado_en = NOW() WHERE id = ?");
    $stmt->execute([$nombre, $email, $foto_ruta, $user_id]);
} else {
    $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, email = ?, actualizado_en = NOW() WHERE id = ?");
    $stmt->execute([$nombre, $email, $user_id]);
}

// Actualizar sesión
$_SESSION['user']['nombre'] = $nombre;
$_SESSION['user']['email']  = $email;

Bitacora::registrar('actualizar', 'perfil', 'Perfil actualizado', [
    'usuario_id' => $user_id,
    'email'      => $email,
]);

header('Location: ' . BASE_URI . '/index.php?controller=dashboard&action=perfil&msg=Perfil+actualizado');
exit;
