<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Proveedor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/actualizarproducto.css"> <!-- MISMO CSS -->
    <link rel="stylesheet" href="../componentes/header.css">
    <link rel="stylesheet" href="../componentes/header.html">
    <script src="/js/index.js"></script>
</head>

<body>

<div id="menu"></div>

    <div id="actualizarProveedor" class="form-section">
        <h1>Actualizar Proveedor</h1>

        <div class="container">  <!-- Agregar el contenedor -->
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
                            <button type="submit" id="eliminar" name="eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este proveedor?');">Eliminar</button>
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
            echo "<script>alert('Proveedor actualizado correctamente');</script>";
        }

        if (isset($_POST['eliminar'])) {
            $nit = $_POST['selectProveedor'];

            if (!empty($nit)) {
                $eliminar = "DELETE FROM proveedor WHERE nit='$nit'";
                mysqli_query($conexion, $eliminar);
                echo "<script>alert('Proveedor eliminado correctamente'); window.location.href='actualizarproveedor.php';</script>";
            }
        }

        mysqli_close($conexion);
    }
    ?>

</body>

</html>
