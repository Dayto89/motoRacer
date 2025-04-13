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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Proveedor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
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
                        mysqli_close($conexion);
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
                            <?php if (!empty($nitSeleccionado)): ?>
                                <button type="submit" id="guardar" name="guardar">Guardar</button>
                                <button type="button" id="eliminar" onclick="confirmarEliminacion()">Eliminar</button>
                            <?php else: ?>
                                <p style="color:red; margin-top: 10px;">Selecciona un proveedor para editar o eliminar.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");

        if (isset($_POST['guardar']) && !empty($_POST['selectProveedor'])) {
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
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: '<span class=\"titulo-alerta confirmacion\">Éxito</span>',
                        html: `
                            <div class=\"custom-alert\">
                                <div class=\"contenedor-imagen\">
                                    <img src=\"../imagenes/moto.png\" alt=\"Confirmación\" class=\"moto\">
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
                    });
                });</script>";
        }

        if (isset($_POST['eliminar']) && !empty($_POST['selectProveedor'])) {
            $nit = $_POST['selectProveedor'];

            $eliminar = "DELETE FROM proveedor WHERE nit='$nit'";
            mysqli_query($conexion, $eliminar);
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: '<span class=\"titulo-alerta confirmacion\">Proveedor Eliminado</span>',
                        html: `
                            <div class=\"custom-alert\">
                                <div class=\"contenedor-imagen\">
                                    <img src=\"../imagenes/moto.png\" alt=\"Confirmación\" class=\"moto\">
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
                    }).then(() => {
                        window.location.href = 'actualizarproveedor.php';
                    });
                });
                </script>";
        }

        mysqli_close($conexion);
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmarEliminacion() {
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
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '';

                    const inputNit = document.createElement('input');
                    inputNit.type = 'hidden';
                    inputNit.name = 'selectProveedor';
                    inputNit.value = document.getElementById('selectProveedor').value;

                    const inputEliminar = document.createElement('input');
                    inputEliminar.type = 'hidden';
                    inputEliminar.name = 'eliminar';
                    inputEliminar.value = '1';

                    form.appendChild(inputNit);
                    form.appendChild(inputEliminar);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>
