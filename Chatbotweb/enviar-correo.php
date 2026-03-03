<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Si usas Composer
// O si lo agregaste manualmente:
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';
// require 'PHPMailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = strip_tags($_POST["nombre"]);
    $correo = filter_var($_POST["correo"], FILTER_VALIDATE_EMAIL);
    $mensaje = strip_tags($_POST["mensaje"]);

    if (!$correo || empty($nombre) || empty($mensaje)) {
        http_response_code(400);
        echo "Todos los campos son requeridos y el correo debe ser válido.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'lotlwaresolutions@gmail.com'; // Tu correo
        $mail->Password = 'lyij odlh jvkf adiy'; // ⚠️ Contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // TLS si usas puerto 587
        $mail->Port = 465;

        // Remitente y destinatario
        $mail->setFrom('lotlwaresolutions@gmail.com', 'Lotli');
        $mail->addAddress('lotlwaresolutions@gmail.com');

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = "ChatLotli";
        $mail->Body = "
            <h2></strong> {$nombre}</h2>
            <p><strong>Nombre:</strong> {$nombre}</p>
            <p><strong>Correo:</strong> {$correo}</p>
            <p><strong>Mensaje:</strong><br>{$mensaje}</p>
        ";

        $mail->send();
        http_response_code(200);
        echo "✅ Mensaje enviado correctamente.";
    } catch (Exception $e) {
        http_response_code(500);
        echo "❌ Error al enviar el mensaje. Detalles: {$mail->ErrorInfo}";
    }
}
?>
