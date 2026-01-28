<?php
session_start();
$pdo = DB::conn();

// ID del usuario REAL según tu sistema
$user_id = $_SESSION['user']['id'];

$nombre = trim($_POST['nombre']);
$email  = trim($_POST['email']);

$foto_ruta = null;

// --- Manejo de la foto ---
if (!empty($_FILES['foto_perfil']['name'])) {

    $carpeta = "uploads/perfiles/";

    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    $nuevoNombre = "perfil_" . $user_id . "_" . time() . "_" . basename($_FILES['foto_perfil']['name']);
    $rutaFinal = $carpeta . $nuevoNombre;

    if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaFinal)) {
        $foto_ruta = $rutaFinal;
    }
}

// --- Si se subió foto: actualiza todo ---
if ($foto_ruta) {

    $stmt = $pdo->prepare("
        UPDATE usuarios 
        SET nombre = ?, email = ?, foto_perfil = ?, actualizado_en = NOW()
        WHERE id = ?
    ");

    $stmt->execute([$nombre, $email, $foto_ruta, $user_id]);

} else {

    // sin foto: actualiza solo nombre/email
    $stmt = $pdo->prepare("
        UPDATE usuarios 
        SET nombre = ?, email = ?, actualizado_en = NOW()
        WHERE id = ?
    ");

    $stmt->execute([$nombre, $email, $user_id]);
}

header("Location: " . BASE_URI . "/index.php?controller=dashboard&action=perfil&msg=Perfil actualizado");
exit;
