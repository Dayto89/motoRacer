<?php
$mensaje = null;

if ($_POST) {
    $correo = $_POST['correo'];
    $conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $stmt = $conexion->prepare("SELECT * FROM usuario WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $codigo = rand(100000, 999999);

        $stmt = $conexion->prepare("UPDATE usuario SET codigo_recuperacion = ? WHERE correo = ?");
        $stmt->bind_param("ss", $codigo, $correo);
        $stmt->execute();

        require '../includes/enviar_correo_mailjet.php';
        $enviado = enviarCodigo($correo, $codigo);

        if ($enviado) {
            $mensaje = "codigo_enviado";
        } else {
            $mensaje = "error_envio";
        }
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Recuperar contraseña</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <link rel="stylesheet" href="/css/olvidar.css">
    <link rel="stylesheet" href="../css/alertas.css">
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

        <h1>ENVIAR CORREO</h1>

    <form method="POST">
        <label>Correo registrado:</label>
        <input type="email" name="correo" required>
        <div class="button_container">
                <button type="submit" name="restablecer" class="boton">Enviar Codigo</button>


        </form>
    </div>
   
    </form>

    <script>
        const mensaje = "<?php echo $mensaje; ?>";
        if (mensaje === "codigo_enviado") {
            Swal.fire({
            title: '<span class="titulo-alerta confirmacion">Correo Enviado</span>',
            html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/moto.png" alt="Confirmacion" class="moto">
                    </div>
                    <p>Revisa tu correo electrónico para recuperar tu contraseña.</p>
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
        })
        .then(() => {
                window.location.href = "verificar_codigo.php?correo=<?php echo $_POST['correo']; ?>";
            });
        } else if (mensaje === "error_envio") {
            Swal.fire({
            title: '<span class="titulo-alerta error">Error</span>',
            html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/llave.png" alt="Error" class="llave">
                    </div>
                    <p>No se pudo enviar el correo, intenta nuevamente</p>
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
        } else if (mensaje === "correo_no_encontrado") {
            Swal.fire({
            title: '<span class="titulo-alerta error">Error</span>',
            html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/llave.png" alt="Error" class="llave">
                    </div>
                    <p>Correo no registrado.</p>
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
    </script>


</body>

</html>