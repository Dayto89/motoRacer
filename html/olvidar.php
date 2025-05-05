<?php
$mensaje = null;

if ($_POST) {
    $correo = $_POST['correo'];
    $conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');

    $stmt = $conexion->prepare("SELECT * FROM usuario WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $codigo = rand(100000, 999999);

        $stmt = $conexion->prepare("UPDATE usuario SET codigo_recuperacion = ? WHERE correo = ?");
        $stmt->bind_param("ss", $codigo, $correo);
        $stmt->execute();

        // Aquí integras tu API de Mailjet
        require '../includes/enviar_correo_mailjet.php'; // Usa aquí tu código de envío
        enviarCodigo($correo, $codigo); // Debes tener una función así en ese archivo

        $mensaje = "codigo_enviado";
    } else {
        $mensaje = "correo_no_encontrado";
    }
    $conexion->close();
}
?>

<!-- HTML para mostrar formulario -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <form method="POST">
        <label>Correo registrado:</label>
        <input type="email" name="correo" required>
        <button type="submit">Enviar código</button>
    </form>

    <script>
        const mensaje = "<?php echo $mensaje; ?>";
        if (mensaje === "codigo_enviado") {
            Swal.fire("Éxito", "Revisa tu correo electrónico", "success").then(() => {
                window.location.href = "verificar_codigo.php?correo=<?php echo $_POST['correo']; ?>";
            });
        } else if (mensaje === "correo_no_encontrado") {
            Swal.fire("Error", "Correo no registrado", "error");
        }
    </script>
</body>
</html>