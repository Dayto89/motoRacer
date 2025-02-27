<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear usuario</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/css/registro.css">
    <link rel="stylesheet" href="/componentes/header.html">
    <link rel="stylesheet" href="/componentes/header.css">
    <link
        href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
        rel="stylesheet" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
    <script src="/js/index.js"></script>
</head>

<body>
    <!-- Aquí se cargará el header -->
    <div id="menu"></div>


    <h1>CREAR USUARIO</h1>

    <form name="formulario" method="post" action="">
        <div class="container">
            <div class="form-grid">
                <div class="campo"><label for="identificacion">Identificación: </label><input type="text" name="identificacion" id="identificacion" required></div>
                <div class="campo"><label for="rol">Rol: </label><select name="rol" id="rol" required>
                        <option value="gerente" selected>Gerente </option>
                       
                    </select></div>
                <div class="campo"><label for="nombre">Nombre: </label><input type="text" name="nombre" id="nombre" required></div>
                <div class="campo"><label for="apellido">Apellido: </label><input type="text" name="apellido" id="apellido" required></div>
                <div class="campo"><label for="telefono">Teléfono: </label><input type="number" name="telefono" id="telefono" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required></div>
                <div class="campo"><label for="direccion">Dirección: </label><input type="text" name="direccion" id="direccion" required></div>
                <div class="campo"><label for="correo">Correo: </label><input type="text" name="correo" id="correo" required></div>
                <div class="campo"><label for="contrasena">Contraseña: </label><input type="password" name="contrasena" id="contrasena" required></div>
                <div class="campo"><label for="confirmar">Confirmar Contraseña: </label><input type="password" name="confirmar" id="confirmar" required></div>

                <?php
                // Conectar a la base de datos
                $conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
                if ($conexion->connect_error) {
                    die("Error de conexión: " . $conexion->connect_error);
                }

                // Obtener las opciones de preguntaSeguridad (ENUM)
                $sql = "SHOW COLUMNS FROM usuario LIKE 'preguntaSeguridad'";
                $resultado = $conexion->query($sql);

                if ($resultado->num_rows > 0) {
                    $fila = $resultado->fetch_assoc();
                    // Extraer las opciones del ENUM
                    $opciones = explode("','", preg_replace("/(enum\('|'\))/", "", $fila['Type']));
                }
                ?>

                <div class="campo"><label for="preguntaSeguridad">Pregunta de Seguridad:</label>
                    <select name="preguntaSeguridad" id="preguntaSeguridad" required>
                        <option value="">Seleccione una pregunta de seguridad</option>
                        <?php if (!empty($opciones)) { ?>
                            <?php foreach ($opciones as $opcion) { ?>
                                <option value="<?php echo $opcion; ?>">
                                    <?php echo $opcion; ?>
                                </option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="campo"><label for="respuestaSeguridad">Respuesta:</label>
                    <input type="text" name="respuestaSeguridad" id="respuestaSeguridad" required>
                </div>
            </div>
        </div>
        <div class="button_container">
            <button type="submit" name="registrar" class="boton">Registrar</button>
            <a href="../html/gestionusuario.php" class="botonn">Volver</a>
        </div>
    </form>

    <?php
    if ($_POST && isset($_POST['registrar'])) {
        // Código de registro
        $identificacion = $_POST['identificacion'];
        $rol = $_POST['rol'];
        $contrasena = $_POST['contrasena'];
        $confirmar = $_POST['confirmar'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $correo = $_POST['correo'];
        $preguntaSeguridad = $_POST['preguntaSeguridad'];
        $respuestaSeguridad = $_POST['respuestaSeguridad'];

        // Validar campos
        if (empty($identificacion) || empty($contrasena) || empty($confirmar) || empty($nombre) || empty($apellido) || empty($telefono) || empty($direccion) || empty($correo) || empty($preguntaSeguridad) || empty($respuestaSeguridad)) {
            echo "<script>alert('Todos los campos son obligatorios');</script>";
            exit;
        }

        if ($contrasena !== $confirmar) {
            echo "<script>alert('Las contraseñas no coinciden');</script>";
            exit;
        }

        // Hashear la contraseña
        $contrasenaHashed = password_hash($contrasena, PASSWORD_DEFAULT);

        // Asignar valores predeterminados
        $estado = 'activo';
        $tipoDocumento = 'cedula de ciudadania';

        // Preparar la sentencia
        $stmt = $conexion->prepare("INSERT INTO usuario (identificacion, tipoDocumento, rol, nombre, apellido, telefono, direccion, correo, contraseña, estado, preguntaSeguridad, respuestaSeguridad) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }

        $stmt->bind_param("ssssssssssss", $identificacion, $tipoDocumento, $rol, $nombre, $apellido, $telefono, $direccion, $correo, $contrasenaHashed, $estado, $preguntaSeguridad, $respuestaSeguridad);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            echo "<script>alert('Registro exitoso');</script>";
        } else {
            echo "<script>alert('Error al guardar');</script>";
        }

        // Cerrar la sentencia
        $stmt->close();
    }

    // Cerrar la conexión
    $conexion->close();
    ?>
</body>

</html>