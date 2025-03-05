<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identificacion = htmlspecialchars(trim($_POST['identificacion']));
    $contrasena = trim($_POST['contrasena']);

    if (empty($identificacion) || empty($contrasena)) {
        echo "<script>alert('Por favor, llena todos los campos.');</script>";
        exit;
    }

    $conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");

    if (!$conexion) {
        die("Error en la conexión: " . mysqli_connect_error());
    }

    $stmt = $conexion->prepare("SELECT * FROM usuario WHERE identificacion = ?");
    $stmt->bind_param("s", $identificacion);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($contrasena, $usuario['contraseña'])) {
            $_SESSION['usuario_id'] = $usuario['identificacion']; // Establecer variables de sesión
            $_SESSION['usuario_nombre'] = $usuario['nombre'];

            header("Location: ../html/inicio.php");
            exit;
        } else {
            echo "<script>alert('Contraseña incorrecta.');</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado.');</script>";
    }

    $stmt->close();
    mysqli_close($conexion);
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moto Racer</title>
    <link rel="stylesheet" href="./style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
</head>

<body>

    <div class="container">
        <img src="/imagenes/motoracer.png" alt="Fondo" class="fondo">
        <img src="/imagenes/LOGO.png" alt="Logo" class="logo_inicio"
            style="filter: drop-shadow(0 0 0.5rem rgb(255, 255, 255))">
        <div class="barra"></div>
        <h1>INICIAR SESIÓN</h1>
        <form name="formulario" method="post" action="">
            <div class="input-wrapper">
                <i class='bx bx-user-circle'></i>
                <input type="text" placeholder="Identificación" name="identificacion" />
            </div>
            <div class="input-wrapper">
                <i class='bx bx-lock-alt'></i>
                <input type="password" placeholder="Contraseña" name="contrasena" />
            </div>
           
            <button type="submit" class="boton">Iniciar Sesión</button>
            <div class="container_boton">
                <a href="../html/olvidar.php" class="boton">¿Olvidaste tu Contraseña?</a>
            </div>
    </div>
    </form>
    </div>

</body>

</html>