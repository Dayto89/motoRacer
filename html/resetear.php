<?php
session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: ../index.php");
    exit;
}
$mensaje = null;  // Variable para almacenar el estado del mensaje

if ($_POST) {
    // Código para restablecer la contraseña
    $correo = $_SESSION['correo'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    if ($nueva_contrasena === $confirmar_contrasena) {
        $nueva_contrasena_hashed = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

        // Conectar a la base de datos
        $conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');

        // Actualizar la contraseña en la base de datos
        $sql = "UPDATE usuario SET contraseña='$nueva_contrasena_hashed', codigo_recuperacion=NULL WHERE correo='$correo'";
        if ($conexion->query($sql) === TRUE) {
            $mensaje = 'exito_restablecer_contrasena';
            session_unset();
            session_destroy();
        } else {
            $mensaje = 'error_restablecer_contrasena';
        }

        $conexion->close();
    } else {
        $mensaje = 'sin_coincidencia_contrasenas';
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Restablecer Contraseña</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <link rel="stylesheet" href="/css/resetear.css">
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

        <h1>RESTABLECER CONTRASEÑA</h1>
        <form name="formulario" method="post" action="">

            <div class="campo"><label for="nueva_contrasena">Nueva Contraseña:</label>
                <input type="password" name="nueva_contrasena" id="nueva_contrasena" required>
            </div>
            <div class="campo"> <label for="confirmar_contrasena">Confirmar Nueva Contraseña:</label>
                <input type="password" name="confirmar_contrasena" id="confirmar_contrasena" required>
            </div>


            <div class="button_container">
                <button type="submit" name="restablecer" class="boton">Restablecer Contraseña</button>
                


        </form>
    </div>

    <script>
        //llamar la variable mensaje y alertas

        const mensaje = "<?php echo $mensaje; ?>";

        if (mensaje === "exito_restablecer_contrasena") {
            Swal.fire({
                    title: '<span class="titulo-alerta confirmacion">Éxito</span>',
                    html: `
            <div class="custom-alert">
                <div class="contenedor-imagen">
                    <img src="../imagenes/moto.png" alt="Confirmacion" class="moto">
                </div>
                <p>Contraseña actualizada exitosamente.</p>
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
                    window.location.href = '../index.php';
                });
        } else if (mensaje === "error_restablecer_contrasena") {
            Swal.fire({
                title: '<span class="titulo-alerta error">Error</span>',
                html: `
            <div class="custom-alert">
                <div class="contenedor-imagen">
                    <img src="../imagenes/llave.png" alt="Error" class="llave">
                </div>
                <p>Error al actualizar la contraseña.</p>
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
        } else if (mensaje === "sin_coincidencia_contrasenas") {
            Swal.fire({
                title: '<span class="titulo-alerta error">Error</span>',
                html: `
            <div class="custom-alert">
                <div class="contenedor-imagen">
                    <img src="../imagenes/llave.png" alt="Error" class="llave">
                </div>
                <p>Las contraseñas no coinciden. Inténtelo de nuevo.</p>
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