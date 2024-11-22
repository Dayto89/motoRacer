<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse/Moto Racer</title>
    <link rel="stylesheet" href="/css/registro.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
</head>

<body>
    <div class="container">
        <img src="../imagenes/motoracer.png" alt="Fondo" class="fondo">
        <img src="../imagenes/LOGO.png" alt="Logo" class="logo_inicio" style="filter: drop-shadow(0 0 0.5rem rgb(255, 255, 255))">
        <div class="barra"></div>
        <h1>CREAR USUARIO</h1>
        <form name="formulario" method="post" action="">
            <div class="campo"><label for="identificacion">Identificación: </label><input type="text" name="identificacion" id="identificacion"></div>
            <div class="campo"><label for="nombre">Nombre: </label><input type="text" name="nombre" id="nombre"></div>
            <div class="campo"><label for="apellido">Apellido: </label><input type="text" name="apellido" id="apellido"></div>
            <div class="campo"><label for="telefono">Telefono: </label><input type="text" name="telefono" id="telefono"></div>
            <div class="campo"><label for="direccion">Dirección: </label><input type="text" name="direccion" id="direccion"></div>
            <div class="campo"><label for="correo">Correo: </label><input type="text" name="correo" id="correo"></div>
            <div class="campo"><label for="contrasena">Contraseña: </label><input type="password" name="contrasena" id="contrasena"></div>
            <div class="campo"><label for="confirmar">Confirmar Contraseña: </label><input type="password" name="confirmar" id="confirmar"></div>
            <div class="button_container">
                <button type="submit" class="boton">Registrar</button>
                <a href="/index.php" class="boton">Volver</a>
                <a href="/html/olvidar.php" class="boton">Olvidaste tu Contraseña ?</a>

</html>

<?php
if ($_POST) {
    $identificacion = $_POST['identificacion'];
    $contrasena = $_POST['contrasena'];
    $confirmar = $_POST['confirmar'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    
    
    // Validar los campos
    if (empty($identificacion) || empty($contrasena) || empty($confirmar)) {
        echo "<script>alert('Todos los campos son obligatorios')</script>";
        exit;
    }

    if ($contrasena !== $confirmar) {
        echo "<script>alert('Las contraseñas no coinciden')</script>";
        exit;
    }

    // Hashear la contraseña
    $contrasenaHashed = password_hash($contrasena, PASSWORD_DEFAULT);

    // Asignar valores predeterminados
    $rol = 'gerente';
    $estado = 'activo';
    $tipoDocumento = 'cedula de ciudadania';
    $conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");

    if ($conexion === false) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    $stmt = $conexion->prepare("INSERT INTO usuario (identificacion, tipoDocumento, rol, nombre, apellido, telefono, direccion, correo, contraseña, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . mysqli_error($conexion));
    }

    $stmt->bind_param("ssssssssss", $identificacion, $tipoDocumento, $rol, $nombre, $apellido, $telefono, $direccion, $correo, $contrasenaHashed, $estado);

    if ($stmt->execute()) {
        echo "<script>alert('Registro exitoso')</script>";
    } else {
        echo "<script>alert('Error al guardar')</script>";
    }

    // Cerrar la sentencia y la conexión
    $stmt->close();
    mysqli_close($conexion);


        } 


?>