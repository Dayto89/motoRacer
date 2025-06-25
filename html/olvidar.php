<?php
$mensaje = null;
$correo_enviado_a = ''; // Variable para guardar el correo en caso de éxito

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);

    if (empty($correo)) {
        $mensaje = 'campos_vacios';
    } else {
        $conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');

        if ($conexion->connect_error) {
            // En un entorno de producción, sería mejor loguear el error que mostrarlo.
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->prepare("SELECT * FROM usuario WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $codigo = rand(100000, 999999);

            $stmt_update = $conexion->prepare("UPDATE usuario SET codigo_recuperacion = ? WHERE correo = ?");
            $stmt_update->bind_param("ss", $codigo, $correo);
            $stmt_update->execute();

            // Incluir el script para enviar correo
            require '../includes/enviar_correo_mailjet.php';
            $enviado = enviarCodigo($correo, $codigo);

            if ($enviado) {
                $mensaje = "codigo_enviado";
                $correo_enviado_a = $correo; // Guardamos el correo para la redirección
            } else {
                $mensaje = "error_envio";
            }
            $stmt_update->close();
        } else {
            $mensaje = "correo_no_encontrado";
        }

        $stmt->close();
        $conexion->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Moto Racer</title>
    
    <link rel="stylesheet" href="../css/olvidar.css">
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
            <h1>RECUPERAR CONTRASEÑA</h1>
            
            <form name="formulario" method="post" action="">
                <div class="input-wrapper">
                    <i class='bx bx-envelope'></i>
                    <input type="email" placeholder="Correo Electrónico" name="correo" required />
                </div>
                
                <button type="submit" class="boton">Enviar Código</button>
                
                <div class="container_boton">
                    <a href="../index.php" class="boton boton-secundario">Volver al Inicio</a>
                </div>
            </form>
        </div>

    </div>

    <script>
        const mensaje = "<?php echo $mensaje; ?>";

        if (mensaje) { // Solo ejecutar si el mensaje no está vacío
            let config = {
                background: '#ffffffdb',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#007bff',
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    container: 'fondo-oscuro'
                }
            };

            if (mensaje === "codigo_enviado") {
                config.title = '<span class="titulo-alerta confirmacion">Correo Enviado</span>';
                config.html = `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/moto.png" alt="Confirmacion" class="moto">
                    </div>
                    <p>Revisa tu correo electrónico para obtener el código de recuperación.</p>
                </div>`;
                Swal.fire(config).then(() => {
                    // Redirigir a la página de verificación con el correo en la URL
                    window.location.href = `verificar_codigo.php?correo=<?php echo urlencode($correo_enviado_a); ?>`;
                });
            } else {
                if (mensaje === "error_envio") {
                    config.title = '<span class="titulo-alerta error">Error</span>';
                    config.html = `
                    <div class="custom-alert">
                        <div class="contenedor-imagen"><img src="../imagenes/llave.png" alt="Error" class="llave"></div>
                        <p>No se pudo enviar el correo. Intenta nuevamente.</p>
                    </div>`;
                } else if (mensaje === "correo_no_encontrado") {
                    config.title = '<span class="titulo-alerta error">Error</span>';
                    config.html = `
                    <div class="custom-alert">
                        <div class="contenedor-imagen"><img src="../imagenes/llave.png" alt="Error" class="llave"></div>
                        <p>El correo electrónico no se encuentra registrado.</p>
                    </div>`;
                } else if (mensaje === "campos_vacios") {
                    config.title = '<span class="titulo-alerta advertencia">Advertencia</span>';
                    config.html = `
                    <div class="custom-alert">
                        <div class="contenedor-imagen"><img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo"></div>
                        <p>Por favor, ingresa tu correo electrónico.</p>
                    </div>`;
                }
                Swal.fire(config);
            }
        }
    </script>
</body>
</html>