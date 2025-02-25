<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_POST) {
    if (isset($_POST['verificar'])) {
        // Conectar a la base de datos
        $conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Datos del formulario
        $usuario = $_POST['usuario'];
        $preguntaSeguridad = $_POST['preguntaSeguridad'];
        $respuestaSeguridad = $_POST['respuestaSeguridad'];

        // Verificar la respuesta de seguridad
        $sql = "SELECT * FROM usuario WHERE identificacion='$usuario' AND preguntaSeguridad='$preguntaSeguridad' AND respuestaSeguridad='$respuestaSeguridad'";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            header("Location: ../html/resetear.php?usuario=$usuario");
            exit();
        } else {
            echo "<script>alert('Respuesta incorrecta. Inténtelo de nuevo.');</script>";
        }

        $conexion->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <link rel="stylesheet" href="/css/olvidar.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
</head>

<body>
    <div class="container">
        <img src="../imagenes/motoracer.png" alt="Fondo" class="fondo">
        <img src="../imagenes/LOGO.png" alt="Logo" class="logo_inicio"
            style="filter: drop-shadow(0 0 0.5rem rgb(255, 255, 255))">
        <div class="barra"></div>

        <h1>VERIFICACIÓN</h1>
        <form name="formulario_recuperar" method="post" action="">

            <div class="campo1"><label for="usuario">Usuario: </label><input type="text" name="usuario" id="usuario">
            </div>
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

            <div class="campo1">
                <label for="preguntaSeguridad">Pregunta de Seguridad:</label>
                <select name="preguntaSeguridad" id="preguntaSeguridad" required>
                    <option value="">Seleccione una pregunta de seguridad</option>
                    <?php if (!empty($opciones)) { ?>
                        <?php foreach ($opciones as $opcion) { ?>
                            <option value="<?php echo $opcion; ?>">
                                <?php echo $opcion; ?>
                            </option>
                        <?php } ?>
                    <?php } ?>
                </select><br>
            </div>
            <div class="campo1">
                <label for="respuestaSeguridad">Respuesta:</label>
                <input type="text" name="respuestaSeguridad" id="respuestaSeguridad" required>
            </div>


            <div class="button_container">
                <button type="submit" name="verificar" class="boton">Verificar Respuesta</button>
                <a href="../index.php" class="botonn">Inicio</a>
            </div>

        </form>
    </div>
</body>

</html>