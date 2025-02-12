<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Asegura que PHP reconoce PHPMailer


session_start(); // Iniciar sesión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $codigoRandom = rand(100000, 999999);
    $_SESSION['codigo_recuperacion'] = $codigoRandom;  // Guardar en la sesión
    $_SESSION['email_recuperacion'] = $email;  // Guardar el email para verificar después

    $mensaje = "Hola, tu código de acceso es: <strong>$codigoRandom</strong>";

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tu-correo@gmail.com';
        $mail->Password = 'tu-contraseña-de-aplicación';  // No uses tu clave normal
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('tu-correo@gmail.com', 'Moto Racer');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Código de acceso - Moto Racer';
        $mail->Body    = $mensaje;
        $mail->AltBody = "Tu código de acceso es: $codigoRandom";

        $mail->send();
        echo "<script>alert('Código enviado al correo');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error al enviar correo: " . $mail->ErrorInfo . "');</script>";
    }
}

session_start();  // Asegurar que tenemos la sesión activa

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codigo'], $_POST['password'])) {
    $codigoIngresado = trim($_POST['codigo']);
    $nuevaPassword = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);  // Encriptar contraseña
    $emailRecuperacion = $_SESSION['email_recuperacion'] ?? '';

    // Verificar si el código ingresado es correcto
    if ($codigoIngresado == $_SESSION['codigo_recuperacion']) {
        // Aquí deberías actualizar la contraseña en la base de datos
        echo "<script>alert('Contraseña cambiada con éxito');</script>";
        unset($_SESSION['codigo_recuperacion']);  // Borrar código usado
    } else {
        echo "<script>alert('Código incorrecto');</script>";
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
        <form id="formEnviarCodigo" method="post">
    <label for="email">Correo electrónico del usuario</label>
    <input type="email" name="email" required>
    <button type="submit">Enviar Código</button>
</form>

<!-- Formulario de Cambio de Contraseña -->
<form id="formCambioContraseña" method="post" style="display:none;">
    <label for="codigo">Código de Verificación</label>
    <input type="text" name="codigo" required>

    <label for="password">Nueva Contraseña</label>
    <input type="password" name="password" required>

    <button type="submit">Cambiar Contraseña</button>
</form>

<script>
    document.getElementById("formEnviarCodigo").onsubmit = function(event) {
        event.preventDefault();
        document.getElementById("formEnviarCodigo").style.display = "none";
        document.getElementById("formCambioContraseña").style.display = "block";
    };
</script>

</body>

</html>