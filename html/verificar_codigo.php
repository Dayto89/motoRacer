<?php
session_start();
$mensaje = $_SESSION['mensaje'] ?? null;
unset($_SESSION['mensaje']);


if (isset($_GET['correo'])) {
    $_SESSION['correo_recuperacion'] = $_GET['correo'];
}

$correo = $_SESSION['correo_recuperacion'] ?? '';

if ($_POST) {
    $correo = $_POST['correo'];
    $codigo_ingresado = $_POST['codigo'];

    $conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $stmt = $conexion->prepare("SELECT * FROM usuario WHERE correo = ? AND codigo_recuperacion = ?");
    $stmt->bind_param("ss", $correo, $codigo_ingresado);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $_SESSION['correo'] = $correo;  // ← Establecer la sesión para el paso siguiente
        header("Location: ../html/resetear.php");
        exit;
    } else {
        $_SESSION['mensaje'] = "codigo_incorrecto";
        header("Location: verificar_codigo.php");
        exit;
    }
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Verificar Codigo</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <link rel="stylesheet" href="/css/verificar.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        <h1>VERIFICAR CODIGO</h1>

        <form method="post">
            <input type="hidden" name="correo" value="<?php echo htmlspecialchars($correo); ?>">
            <label>Código de recuperación:</label>
            <input type="text" name="codigo" required>
            <div class="button_container">
                <button type="submit" name="restablecer" class="boton">Verificar</button>



        </form>
    </div>


    <script>
        const mensaje = "<?php echo $mensaje; ?>";
        if (mensaje === "codigo_incorrecto") {
            Swal.fire({
                title: '<span class="titulo-alerta error">Error</span>',
                html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/llave.png" alt="Error" class="llave">
                    </div>
                    <p>Código incorrecto.</p>
                </div>
            `,
                background: 'hsl(0deg 0% 100% / 76%)',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#007bff',
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    container: 'fondo-oscuro'
                }
            });
        }

        if (window.history.replaceState) {
            const url = new URL(window.location.href);
            url.searchParams.delete("correo");
            const newUrl = url.pathname + (url.searchParams.toString() ? '?' + url.searchParams.toString() : '');
            window.history.replaceState({}, document.title, newUrl);
        }
    </script>
</body>

</html>