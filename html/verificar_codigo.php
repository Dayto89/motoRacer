<?php
session_start();
// Se obtiene el mensaje de la sesión si existe (ej. 'codigo_incorrecto')
$mensaje = $_SESSION['mensaje'] ?? null;
// Se limpia el mensaje para que no se muestre de nuevo al recargar
unset($_SESSION['mensaje']);

// Si el correo viene como parámetro GET (desde la página anterior), se guarda en la sesión.
if (isset($_GET['correo'])) {
    $_SESSION['correo_recuperacion'] = $_GET['correo'];
}

// Se obtiene el correo desde la sesión para usarlo en el formulario.
$correo = $_SESSION['correo_recuperacion'] ?? '';

// Proceso del formulario al ser enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo_post = $_POST['correo'];
    $codigo_ingresado = $_POST['codigo'];

    $conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $stmt = $conexion->prepare("SELECT * FROM usuario WHERE correo = ? AND codigo_recuperacion = ?");
    $stmt->bind_param("ss", $correo_post, $codigo_ingresado);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // Código correcto: se guarda el correo para el siguiente paso y se redirige
        $_SESSION['correo_para_resetear'] = $correo_post;
        unset($_SESSION['correo_recuperacion']); // Limpiamos la sesión anterior
        header("Location: ../html/resetear.php");
        exit;
    } else {
        // Código incorrecto: se establece un mensaje de error y se recarga la página
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
    <title>Verificar Código - Moto Racer</title>
    
    <link rel="stylesheet" href="../css/verificar.css">
    <link rel="stylesheet" href="../css/alertas.css">
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container">
        
        <div class="login-panel panel-logo">
            <img src="../imagenes/LOGO.png" alt="Logo Moto Racer" class="logo_inicio">
        </div>

        <div class="login-panel panel-form">
            <h1>VERIFICAR CÓDIGO</h1>
            
            <form name="formulario" method="post" action="">
                <input type="hidden" name="correo" value="<?php echo htmlspecialchars($correo); ?>">
                
                <div class="input-wrapper">
                    <i class='bx bx-key'></i>
                    <input type="text" placeholder="Código de Verificación" name="codigo" required oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                </div>
                
                <button type="submit" class="boton">Verificar Código</button>
                
                <div class="container_boton">
                    <a href="olvidar.php" class="boton boton-secundario">Volver</a>
                </div>
            </form>
        </div>

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
                    <p>El código ingresado es incorrecto.</p>
                </div>
                `,
                background: '#ffffffdb',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#007bff',
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    container: 'fondo-oscuro'
                }
            });
        }

        // Limpia el parámetro 'correo' de la URL para evitar reenvíos accidentales
        if (window.history.replaceState) {
            const url = new URL(window.location.href);
            url.searchParams.delete("correo");
            const newUrl = url.pathname + url.search;
            window.history.replaceState({ path: newUrl }, '', newUrl);
        }
    </script>
</body>
</html>