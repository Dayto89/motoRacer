<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $codigoRandom = rand(100000, 999999);
    $mensaje = "Hola, tu código de acceso es $codigoRandom";

    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'zeepster7r@gmail.com';
        $mail->Password = 'Tonyyamigo89'; // Es mejor usar una contraseña de aplicación si usas Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinatarios
        $mail->setFrom('zeepster7r@gmail.com', 'Moto Racer');
        $mail->addAddress($email);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Código de acceso - Moto Racer';
        $mail->Body    = $mensaje;
        $mail->AltBody = 'Este es el cuerpo del mensaje en formato texto plano';

        $mail->send();
        echo "<script>alert('Se ha enviado un correo con tu código de acceso');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $mail->ErrorInfo . "');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Cambio Contraseña/Moto Racer</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <link rel="stylesheet" href="/css/olvidar.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
</head>

<body>
    <div class="container">
        <img src="/imagenes/motoracer.png" alt="Fondo" class="fondo">
        <img src="/imagenes/LOGO.png" alt="Logo" class="logo_inicio" style="filter: drop-shadow(0 0 0.5rem rgb(255, 255, 255))">
        <div class="barra"></div>
        <h1>CAMBIO CONTRASEÑA</h1>

        <!-- Formulario de Enviar Código -->
        <form id="formEnviarCodigo" method="post" onsubmit="mostrarFormularioCambio(event)">
            <input type="hidden" name="action" value="enviar_codigo">
            <label for="email">Correo electrónico del suario</label>
            <input type="email" name="email" required>
            <button type="submit">Enviar Código</button>
        </form>

        <!-- Formulario de Cambio de Contraseña -->
        <form id="formCambioContraseña" method="post" style="display:none;">
            <input type="hidden" name="action" value="verificar_codigo">
            <label for="codigo" id="codigo">Código de Verificación</label>
            <input type="text" name="codigo" required>

            <label for="password" id="password">Nueva Contraseña</label>
            <input type="password" name="password" required>

            <button type="submit" id="cambiar-contrasena">Cambiar Contraseña</button>
        </form>
    </div>
    <script>
        // Función que oculta el formulario de enviar código y muestra el de cambio de contraseña
        function mostrarFormularioCambio(event) {
            event.preventDefault();  // Evitar que el formulario se envíe de inmediato

            // Ocultar el formulario de enviar código
            document.getElementById("formEnviarCodigo").style.display = "none";

            // Mostrar el formulario de cambio de contraseña
            document.getElementById("formCambioContraseña").style.display = "block";
        }
    </script>
</body>

</html>