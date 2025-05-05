<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '../html/verificar_permisos.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';

// Si hay un proveedor guardado en sesión, úsalo como seleccionado
$nitSeleccionado = isset($_SESSION['proveedor_guardado']) ? $_SESSION['proveedor_guardado'] : (isset($_POST['selectProveedor']) ? $_POST['selectProveedor'] : '');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Proveedor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/actualizarproducto.css">
    <link rel="stylesheet" href="../componentes/header.css">
    <script src="../js/header.js"></script>
    <script src="/js/index.js"></script>
</head>

<body>

    <div id="menu"></div>

    <div id="actualizarProveedor" class="form-section">
        <h1>Actualizar Proveedor</h1>

        <div class="container">
            <form id="update-provider-form" method="POST" action="actualizarproveedor.php">
                <div class="form-grid">
                    <div class="campo">
                        <label for="selectProveedor">Seleccionar Proveedor:</label>
                        <select id="selectProveedor" name="selectProveedor" onchange="this.form.submit()">
                            <option value="">Selecciona un proveedor</option>
                            <?php
                            $conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");
                            $consulta = "SELECT nit, nombre FROM proveedor";
                            $resultado = mysqli_query($conexion, $consulta);

                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $selected = ($fila['nit'] == $nitSeleccionado) ? 'selected' : '';
                                echo "<option value='" . $fila['nit'] . "' $selected>" . $fila['nombre'] . "</option>";
                            }

                            mysqli_close($conexion);
                            ?>
                        </select>
                    </div>

                    <?php
                    if (!empty($nitSeleccionado)) {
                        $conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");
                        $consulta = "SELECT * FROM proveedor WHERE nit = '$nitSeleccionado'";
                        $resultado = mysqli_query($conexion, $consulta);

                        if ($fila = mysqli_fetch_assoc($resultado)) {
                            $nombre = $fila['nombre'];
                            $telefono = $fila['telefono'];
                            $direccion = $fila['direccion'];
                            $correo = $fila['correo'];
                            $estado = $fila['estado'];
                        }
                    }
                    ?>

                    <div class="campo">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo isset($nombre) ? $nombre : ''; ?>" required>
                    </div>

                    <div class="campo">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" value="<?php echo isset($telefono) ? $telefono : ''; ?>" required>
                    </div>

                    <div class="campo">
                        <label for="direccion">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" value="<?php echo isset($direccion) ? $direccion : ''; ?>" required>
                    </div>

                    <div class="campo">
                        <label for="correo">Correo:</label>
                        <input type="email" id="correo" name="correo" value="<?php echo isset($correo) ? $correo : ''; ?>" required>
                    </div>

                    <div class="campo">
                        <label for="estado">Estado:</label>
                        <input type="text" id="estado" name="estado" value="<?php echo isset($estado) ? $estado : ''; ?>" required>
                    </div>

                    <div class="button-container">
                        <div class="boton">
                            <button type="submit" name="guardar">Guardar</button>
                            <button type="button" id="eliminar" name="eliminar">Eliminar</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");

        if (isset($_POST['guardar'])) {
            $nit = $_POST['selectProveedor'];
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            $correo = $_POST['correo'];
            $estado = $_POST['estado'];

            $actualizar = "UPDATE proveedor SET 
                        nombre='$nombre', telefono='$telefono', direccion='$direccion', 
                        correo='$correo', estado='$estado'
                      WHERE nit='$nit'";

            mysqli_query($conexion, $actualizar);

            // Guardar proveedor seleccionado en la sesión
            $_SESSION['proveedor_guardado'] = $nit;

            echo "<script>
Swal.fire({
    title: '<span class=\"titulo-alerta confirmacion\">Éxito</span>',
    html: `
        <div class=\"custom-alert\">
            <div class=\"contenedor-imagen\">
                <img src=\"../imagenes/moto.png\" alt=\"Éxito\" class=\"moto\">
            </div>
            <p>Proveedor actualizado correctamente.</p>
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
}).then(() => {
    window.location.href = 'actualizarproveedor.php';
});
</script>";
        }

        if (isset($_POST['eliminar'])) {
            $nit = $_POST['selectProveedor'];

            if (!empty($nit)) {
                try {
                    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                    $eliminar = "DELETE FROM proveedor WHERE nit='$nit'";
                    mysqli_query($conexion, $eliminar);
                    unset($_SESSION['proveedor_guardado']); // Limpiar proveedor seleccionado

                    echo "<script>
                    Swal.fire({
                        title: '<span class=\"titulo-alerta confirmacion\">Éxito</span>',
                        html: `
                            <div class=\"custom-alert\">
                                <div class=\"contenedor-imagen\">
                                    <img src=\"../imagenes/moto.png\" alt=\"Éxito\" class=\"moto\">
                                </div>
                                <p>Proveedor eliminado correctamente.</p>
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
                    }).then(() => {
                        window.location.href = 'actualizarproveedor.php';
                    });
                    </script>";
                } catch (mysqli_sql_exception $e) {
                    echo "<script>
                    Swal.fire({
                        title: '<span class=\"titulo-alerta error\">Error</span>',
                        html: `
                            <div class=\"custom-alert\">
                                <div class=\"contenedor-imagen\">
                                    <img src=\"../imagenes/llave.png\" alt=\"Error\" class=\"llave\">
                                </div>
                                <p>No se puede eliminar este proveedor porque tiene productos relacionados.</p>
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
                    </script>";
                }
            }
        }

        mysqli_close($conexion);
    }
    ?>

    <script>
        document.getElementById('eliminar').addEventListener('click', function() {
            Swal.fire({
                title: '<span class="titulo-alerta advertencia">¿Estás seguro?</span>',
                html: `
                    <div class="custom-alert">
                        <div class="contenedor-imagen">
                            <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                        </div>
                        <p>¿Estás seguro de que deseas eliminar este proveedor?</p>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                background: '#ffffffdb',
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    cancelButton: 'btn-cancelar',
                    container: 'fondo-oscuro'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('update-provider-form');
                    const eliminarInput = document.createElement('input');
                    eliminarInput.type = 'hidden';
                    eliminarInput.name = 'eliminar';
                    form.appendChild(eliminarInput);
                    form.submit();
                }
            });
        });
    </script>

</body>

</html>