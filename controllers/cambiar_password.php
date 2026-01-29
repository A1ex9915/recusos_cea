<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$pdo = DB::conn();

$user_id = (int) $_SESSION['user']['id'];

$actual     = $_POST['current_password'] ?? '';
$nueva      = $_POST['new_password'] ?? '';
$confirmar  = $_POST['confirm_password'] ?? '';

// 1. Validar que coincidan nueva y confirmación
if ($nueva !== $confirmar) {
    header("Location: " . BASE_URI . "/index.php?controller=dashboard&action=perfil&msg=Las contraseñas no coinciden");
    exit;
}

// 2. Obtener la contraseña actual del usuario (texto plano porque así lo usa tu BD)
$stmt = $pdo->prepare("SELECT password_hash FROM usuarios WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    header("Location: " . BASE_URI . "/index.php?controller=dashboard&action=perfil&msg=Usuario no encontrado");
    exit;
}

$passBD = $user['password_hash'];

// 3. Validar contraseña actual con password_verify
if (!password_verify($actual, $passBD)) {
    header("Location: " . BASE_URI . "/index.php?controller=dashboard&action=perfil&msg=La contraseña actual es incorrecta");
    exit;
}

// 4. Validar longitud mínima de nueva contraseña
if (strlen($nueva) < 8) {
    header("Location: " . BASE_URI . "/index.php?controller=dashboard&action=perfil&msg=La nueva contraseña debe tener mínimo 8 caracteres");
    exit;
}

// 5. Actualizar contraseña con hash seguro
$stmt = $pdo->prepare("UPDATE usuarios SET password_hash=?, actualizado_en=NOW() WHERE id=?");
$stmt->execute([password_hash($nueva, PASSWORD_DEFAULT), $user_id]);

header("Location: " . BASE_URI . "/index.php?controller=dashboard&action=perfil&msg=Contraseña actualizada");
exit;
