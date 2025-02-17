<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <link rel="stylesheet" href="/css/registro.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
</head>

<body>
    <div class="container">
        <h1>RESTABLECER CONTRASEÑA</h1>
        <form method="post" action="">
            <div class="form-grid">
                <label for="nueva_contrasena">Nueva Contraseña:</label>
                <input type="password" name="nueva_contrasena" id="nueva_contrasena" required>
                <label for="confirmar_contrasena">Confirmar Nueva Contraseña:</label>
                <input type="password" name="confirmar_contrasena" id="confirmar_contrasena" required>
                <input type="hidden" name="usuario" value="<?php echo $_GET['usuario']; ?>">
                <button type="submit" name="restablecer" class="boton">Restablecer Contraseña</button>
            </div>
        </form>
    </div>
</body>

</html>

<?php
if ($_POST) {
    // Código para restablecer la contraseña
    $usuario = $_POST['usuario'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    if ($nueva_contrasena === $confirmar_contrasena) {
        $nueva_contrasena_hashed = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

        // Conectar a la base de datos
        $conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');

        // Actualizar la contraseña en la base de datos
        $sql = "UPDATE usuario SET contraseña='$nueva_contrasena_hashed' WHERE identificacion='$usuario'";
        if ($conexion->query($sql) === TRUE) {
            echo "<script>alert('Contraseña actualizada exitosamente.');</script>";
        } else {
            echo "<script>alert('Error al actualizar la contraseña.');</script>";
        }

        $conexion->close();
    } else {
        echo "<script>alert('Las contraseñas no coinciden. Inténtelo de nuevo.');</script>";
    }
}
?>
