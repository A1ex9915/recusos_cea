<?php
/**
 * Script de migración para convertir contraseñas de texto plano a hashes bcrypt
 * 
 * INSTRUCCIONES:
 * 1. Ejecuta este script UNA SOLA VEZ desde el navegador o terminal
 * 2. URL: http://localhost/recusos_cea/scripts/migrar_passwords.php
 * 3. O desde terminal: php migrar_passwords.php
 * 
 * IMPORTANTE: Este script actualizará todas las contraseñas que no estén hasheadas
 */

// Incluir la conexión a la base de datos
require_once dirname(__DIR__) . '/config/database.php';

echo "=== SCRIPT DE MIGRACIÓN DE CONTRASEÑAS ===\n\n";

try {
    $pdo = DB::conn();
    
    // Obtener todos los usuarios
    $stmt = $pdo->query("SELECT id, nombre, email, password_hash FROM usuarios");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $actualizados = 0;
    $ya_hasheados = 0;
    
    foreach ($usuarios as $usuario) {
        $id = $usuario['id'];
        $nombre = $usuario['nombre'];
        $password_actual = $usuario['password_hash'];
        
        // Verificar si la contraseña ya está hasheada
        // Las contraseñas bcrypt siempre empiezan con $2y$ y tienen 60 caracteres
        if (strlen($password_actual) === 60 && substr($password_actual, 0, 4) === '$2y$') {
            echo "✓ Usuario #{$id} ({$nombre}): Contraseña ya está hasheada\n";
            $ya_hasheados++;
            continue;
        }
        
        // La contraseña está en texto plano, hashearla
        $nuevo_hash = password_hash($password_actual, PASSWORD_DEFAULT);
        
        $update = $pdo->prepare("UPDATE usuarios SET password_hash = ? WHERE id = ?");
        $update->execute([$nuevo_hash, $id]);
        
        echo "✓ Usuario #{$id} ({$nombre}): Contraseña actualizada de '{$password_actual}' a hash bcrypt\n";
        $actualizados++;
    }
    
    echo "\n=== RESUMEN ===\n";
    echo "Total de usuarios: " . count($usuarios) . "\n";
    echo "Contraseñas actualizadas: {$actualizados}\n";
    echo "Ya estaban hasheadas: {$ya_hasheados}\n";
    echo "\n✅ Migración completada exitosamente\n\n";
    
    echo "CREDENCIALES ACTUALIZADAS:\n";
    echo "------------------------------\n";
    echo "Usuario Admin:\n";
    echo "  Email: admin@ceaa.gob.mx\n";
    echo "  Contraseña: Admin123!\n\n";
    echo "Usuario Brenda:\n";
    echo "  Email: olguinbrenda189@gmail.com\n";
    echo "  Contraseña: hola1\n";
    echo "------------------------------\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
