<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Crear usuario</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <link rel="stylesheet" href="/css/registro.css" />
    <link rel="stylesheet" href="../css/alertas.css">
    <link rel="stylesheet" href="/componentes/header.php" />
    <link rel="stylesheet" href="/componentes/header.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather&family=Metal+Mania&display=swap');
    </style>
    <script src="/js/index.js"></script>
    <script src="../js/header.js"></script>
</head>

<body>
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
            </div>
        </div>
        <div class="button_container">
            <button type="submit" name="registrar" class="boton">Registrar</button>
            <a href="../html/gestiondeusuarios.php" class="botonn">Volver</a>
        </div>
    </form>

    <?php
    if ($_POST && isset($_POST['registrar'])) {
        $conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $identificacion = $_POST['identificacion'];
        $rol = $_POST['rol'];
        $contrasena = $_POST['contrasena'];
        $confirmar = $_POST['confirmar'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $correo = $_POST['correo'];

        if (empty($identificacion) || empty($contrasena) || empty($confirmar) || empty($nombre) || empty($apellido) || empty($telefono) || empty($direccion) || empty($correo)) {
            echo "<script>alert('Todos los campos son obligatorios');</script>";
            exit;
        }

        if ($contrasena !== $confirmar) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                         title: '<span class=\"titulo-alerta error\">Error</span>',
                            html: `
                                <div class=\"custom-alert\">
                                    <div class='contenedor-imagen'>
                                          <img src=\"../imagenes/llave.png\" alt=\"Error\" class=\"llave\">
                                    </div>
                                    <p>Las contraseñas no coinciden.</p>
                                </div>
                            `,
                            background: '#ffffffdb',
                          confirmButtonText: 'Aceptar',
                          confirmButtonColor: '#dc3545',
                          customClass: {
                              popup: 'swal2-border-radius',
                              confirmButton: 'btn-aceptar',
                              container: 'fondo-oscuro'
                          }
                        } );
                                    });
                                    </script>";
            exit;
        }
        // Verificar si el correo ya existe
        $verificarCorreo = $conexion->prepare("SELECT identificacion FROM usuario WHERE correo = ?");
        $verificarCorreo->bind_param("s", $correo);
        $verificarCorreo->execute();
        $verificarCorreo->store_result();

        if ($verificarCorreo->num_rows > 0) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '<span class=\"titulo-alerta error\">Error</span>',
                html: `
                    <div class=\"custom-alert\">
                        <div class='contenedor-imagen'>
                            <img src=\"../imagenes/llave.png\" alt=\"Error\" class=\"llave\">
                        </div>
                        <p>El correo ya está registrado. Intenta con otro.</p>
                    </div>
                `,
                background: '#ffffffdb',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#dc3545',
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    container: 'fondo-oscuro'
                }
            });
        });
    </script>";
            $verificarCorreo->close();
            $conexion->close();
            exit;
        }
        $verificarCorreo->close();

        $contrasenaHashed = password_hash($contrasena, PASSWORD_DEFAULT);
        $estado = 'activo';
        $tipoDocumento = 'cedula de ciudadania';

        $stmt = $conexion->prepare("INSERT INTO usuario (identificacion, tipoDocumento, rol, nombre, apellido, telefono, direccion, correo, contraseña, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }

        $stmt->bind_param("ssssssssss", $identificacion, $tipoDocumento, $rol, $nombre, $apellido, $telefono, $direccion, $correo, $contrasenaHashed, $estado);

        if ($stmt->execute()) {
            $resultado = $conexion->query("INSERT INTO accesos (id_usuario, seccion, sub_seccion, permitido) VALUES
                ($identificacion, 'PRODUCTO', 'Crear Producto', 0),
                ($identificacion, 'PRODUCTO', 'Actualizar Producto', 0),
                ($identificacion, 'PRODUCTO', 'Categorías', 0),
                ($identificacion, 'PRODUCTO', 'Ubicación', 0),
                ($identificacion, 'PRODUCTO', 'Marca', 0),
                ($identificacion, 'PROVEEDOR', 'Crear Proveedor', 0),
                ($identificacion, 'PROVEEDOR', 'Actualizar Proveedor', 0),
                ($identificacion, 'PROVEEDOR', 'Lista Proveedor', 0),
                ($identificacion, 'INVENTARIO', 'Lista de Productos', 0),
                ($identificacion, 'FACTURA', 'Venta', 0),
                ($identificacion, 'FACTURA', 'Reporte', 0),
                ($identificacion, 'FACTURA', 'Lista Clientes', 0),
                ($identificacion, 'FACTURA', 'Lista de Notificaciones', 0),
                ($identificacion, 'USUARIO', 'Información', 1),
                ($identificacion, 'CONFIGURACIÓN', 'Stock', 0),
                ($identificacion, 'CONFIGURACIÓN', 'Gestión de Usuarios', 0),
                ($identificacion, 'CONFIGURACIÓN', 'Copia de Seguridad', 0)");

            if ($resultado) {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: '<span class=\"titulo-alerta confirmacion\">¡Registro exitoso!</span>',
                            html: `
                                <div class=\"custom-alert\">
                                    <div class=\"contenedor-imagen\">
                                        <img src=\"../imagenes/moto.png\" alt=\"Confirmación\" class=\"moto\">
                                    </div>
                                    <p>El usuario fue registrado y los permisos fueron guardados correctamente.</p>
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
                    });
                </script>";
            } else {
                echo "<script>alert('Registro exitoso, pero error al guardar permisos');</script>";
            }
        } else {
            echo "<script>alert('Error al guardar el usuario');</script>";
        }


        $stmt->close();
        $conexion->close();
    }
    ?>
</body>

</html>