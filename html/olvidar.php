<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Asegura que PHP reconoce PHPMailer

session_start(); // Iniciar sesión

$conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Enviar código de verificación al correo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar_codigo'])) {
    $email = trim($_POST['email']);

    // Verificar si el correo existe en la base de datos
    $query = "SELECT identificacion FROM usuario WHERE correo = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $codigoRandom = rand(100000, 999999);
        $_SESSION['codigo_recuperacion'] = $codigoRandom;
        $_SESSION['email_recuperacion'] = $email;

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
    } else {
        echo "<script>alert('El correo no está registrado');</script>";
    }

    $stmt->close();
}

// Verificar código y cambiar contraseña
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_contraseña'])) {
    $codigoIngresado = trim($_POST['codigo']);
    $nuevaPassword = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $emailRecuperacion = $_SESSION['email_recuperacion'] ?? '';

    if ($codigoIngresado == $_SESSION['codigo_recuperacion']) {
        // Actualizar la contraseña en la base de datos
        $query = "UPDATE usuario SET contraseña = ? WHERE correo = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ss", $nuevaPassword, $emailRecuperacion);

        if ($stmt->execute()) {
            echo "<script>alert('Contraseña cambiada con éxito');</script>";
            unset($_SESSION['codigo_recuperacion']);
        } else {
            echo "<script>alert('Error al actualizar la contraseña');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Código incorrecto');</script>";
    }
}

mysqli_close($conexion);
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
            <button type="submit" name="enviar_codigo">Enviar Código</button>
        </form>

        <!-- Formulario de Cambio de Contraseña -->
        <form id="formCambioContraseña" method="post" style="display:none;">
            <label for="codigo">Código de Verificación</label>
            <input type="text" name="codigo" required>

            <label for="password">Nueva Contraseña</label>
            <input type="password" name="password" required>

            <button type="submit" name="cambiar_contraseña">Cambiar Contraseña</button>
        </form>

        <script>
            document.getElementById("formEnviarCodigo").onsubmit = function(event) {
                event.preventDefault();
                this.submit();  // Enviar el formulario para procesar el código
                document.getElementById("formEnviarCodigo").style.display = "none";
                document.getElementById("formCambioContraseña").style.display = "block";
            };
        </script>

    </div>
</body>
</html>
