<?php
$mensaje = null;
$correo = $_GET['correo'] ?? '';

if ($_POST) {
    $correo = $_POST['correo'];
    $codigo_ingresado = $_POST['codigo'];

    $conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');

    // Evita SQL Injection (mejor aún con prepared statements)
    $correo = $conexion->real_escape_string($correo);
    $codigo_ingresado = $conexion->real_escape_string($codigo_ingresado);

    $result = $conexion->query("SELECT * FROM usuario WHERE correo='$correo' AND codigo_recuperacion='$codigo_ingresado'");

    if ($result && $result->num_rows > 0) {
        // Código correcto, redirige al formulario para cambiar contraseña
        header("Location: ../html/resetear.php?correo=$correo");
        exit;
    } else {
        $mensaje = "codigo_incorrecto";
    }

    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificar Código</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<form method="post">
    <input type="hidden" name="correo" value="<?php echo htmlspecialchars($correo); ?>">
    <label>Código de recuperación:</label>
    <input type="text" name="codigo" required>
    <button type="submit">Verificar</button>
</form>

<script>
    const mensaje = "<?php echo $mensaje; ?>";
    if (mensaje === "codigo_incorrecto") {
        Swal.fire("Error", "Código incorrecto", "error");
    }
</script>
</body>
</html>