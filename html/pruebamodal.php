<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}
$mensaje = null;

include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Proveedor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <link rel="stylesheet" href="../css/actualizarproveedor.css"> <!-- MISMO CSS -->
    <link rel="stylesheet" href="../componentes/header.css">
    <link rel="stylesheet" href="../componentes/header.php">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/header.js"></script>
    <script src="/js/index.js"></script>
</head>

<body>

    <div id="menu"></div>

    <div id="actualizarProveedor" class="form-section">
        <h1>Actualizar Proveedor</h1>

        <div class="container"> <!-- Agregar el contenedor -->
            <form id="update-provider-form" method="POST" action="">
                <div class="form-grid">
                    <div class="campo">
                        <label for="selectProveedor">Seleccionar Proveedor:</label>
                        <select id="selectProveedor" name="selectProveedor" onchange="this.form.submit()">
                            <option value="">Selecciona un proveedor</option>
                            <?php
                            $conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");
                            $consulta = "SELECT nit, nombre FROM proveedor";
                            $resultado = mysqli_query($conexion, $consulta);

                            $nitSeleccionado = isset($_POST['selectProveedor']) ? $_POST['selectProveedor'] : '';

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
                            <button type="submit" id="eliminar" name="eliminar">Eliminar</button>
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
            $mensaje = 'proveedor_actualizado';
        } else {
            $mensaje = 'error_actualizar';
        }
    }

    if (isset($_POST['confirmar_eliminar'])) {
        $nit = $_POST['selectProveedor'];

        if (!empty($nit)) {
            $eliminar = "DELETE FROM proveedor WHERE nit='$nit'";
            mysqli_query($conexion, $eliminar);
            $mensaje = 'proveedor_eliminado';
        } else {
            $mensaje = 'error_eliminar';
        }
    }


    mysqli_close($conexion);
    ?>
    <Script>
        const mensaje = "<?php echo $mensaje; ?>";

        if (mensaje === "proveedor_actualizado") {
            Swal.fire({
                title: '<span class="titulo-alerta confirmacion">Proveedor Actualizado</span>',
                html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/moto.png" alt="Advertencia" class="moto">
                    </div>
                    <p>El proveedor se actualizó correctamente.</p>
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
        } else if (mensaje === "error_actualizar") {
            Swal.fire({
                title: '<span class="titulo-alerta error">Error</span>',
                html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/llave.png" alt="Error" class="llave">
                    </div>
                    <p>Error al actualizar el proveedor.</p>
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
        } else if (mensaje === "proveedor_eliminado") {
            Swal.fire({
                title: '<span class="titulo-alerta confirmacion">Proveedor Eliminado</span>',
                html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/moto.png" alt="Confirmación" class="moto">
                    </div>
                    <p>El proveedor se eliminó correctamente.</p>
                </div>
            `,
                background: '#ffffffdb',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#28a745',
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    container: 'fondo-oscuro'
                }
            });
        } else if (mensaje === "error_eliminar") {
            Swal.fire({
                title: '<span class="titulo-alerta error">Error</span>',
                html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/llave.png" alt="Error" class="llave">
                    </div>
                    <p>Error al eliminar el proveedor.</p>
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

        document.addEventListener("DOMContentLoaded", function() {
            const btnEliminar = document.getElementById("eliminar");

            if (btnEliminar) {
                btnEliminar.addEventListener("click", function(event) {
                    event.preventDefault();

                    Swal.fire({
                        title: '<span class="titulo-alerta advertencia">¿Está seguro?</span>',
                        html: `
                        <div class="custom-alert">
                            <div class="contenedor-imagen">
                                <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                            </div>
                            <p>Esta acción eliminará el proveedor.<br>¿Desea continuar?</p>
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
                            // Crear un formulario oculto para enviar la eliminación
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '';

                            const inputProveedor = document.createElement('input');
                            inputProveedor.type = 'hidden';
                            inputProveedor.name = 'selectProveedor';
                            inputProveedor.value = document.getElementById('selectProveedor').value;

                            const inputConfirm = document.createElement('input');
                            inputConfirm.type = 'hidden';
                            inputConfirm.name = 'confirmar_eliminar';
                            inputConfirm.value = '1';

                            form.appendChild(inputProveedor);
                            form.appendChild(inputConfirm);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            }
        });
    </Script>
</body>

</html>