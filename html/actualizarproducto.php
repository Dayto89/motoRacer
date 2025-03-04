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
    <title>Actualizar Producto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/actualizarproducto.css">
    <link rel="stylesheet" href="/componentes/header.html">
    <link rel="stylesheet" href="../componentes/header.css">

    <script src="/js/index.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
</head>

<body>

    <!-- Aquí se cargará el header -->
    <div id="menu"></div>

    <!-- Sección para Actualizar Producto -->
    <div id="actualizarProducto" class="form-section">
        <h1>Actualizar Producto</h1>

        <!-- Contenedor principal -->
        <div class="container">

            <form id="update-product-form" method="POST" action="">
                <div class="form-grid">

                    <div class="campo">
                        <label for="selectProducto">Seleccionar Producto:</label>
                        <select id="selectProducto" name="selectProducto" onchange="this.form.submit()">
                            <option value="">Selecciona un producto</option>
                            <?php
                            $conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");
                            $consulta = "SELECT codigo1, nombre FROM producto";
                            $resultado = mysqli_query($conexion, $consulta);

                            // Retener el valor seleccionado
                            $codigoSeleccionado = isset($_POST['selectProducto']) ? $_POST['selectProducto'] : '';

                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $selected = ($fila['codigo1'] == $codigoSeleccionado) ? 'selected' : '';
                                echo "<option value='" . $fila['codigo1'] . "' $selected>" . $fila['nombre'] . "</option>";
                            }

                            mysqli_close($conexion);
                            ?>
                        </select>
                    </div>

                    <?php
                    if (!empty($codigoSeleccionado)) {
                        $conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");
                        $consulta = "SELECT * FROM producto WHERE codigo1 = '$codigoSeleccionado'";
                        $resultado = mysqli_query($conexion, $consulta);

                        if ($fila = mysqli_fetch_assoc($resultado)) {
                            $codigo1 = $fila['codigo1'];
                            $codigo2 = $fila['codigo2'];
                            $nombre = $fila['nombre'];
                            $iva = $fila['iva'];
                            $precio1 = $fila['precio1'];
                            $precio2 = $fila['precio2'];
                            $precio3 = $fila['precio3'];
                            $cantidad = $fila['cantidad'];
                            $descripcion = $fila['descripcion'];
                        }

                        /* consulta datos de categoria, marca, unidad de medida, ubicacion y proveedor */
                        $marcas = $conexion->query("SELECT codigo, nombre FROM marca");
                        $categorias = $conexion->query("SELECT codigo, nombre FROM categoria");
                        $proveedores = $conexion->query("SELECT nit, nombre FROM proveedor");
                        $ubicaciones = $conexion->query("SELECT codigo, nombre FROM ubicacion");
                        $unidades = $conexion->query("SELECT codigo, nombre FROM unidadmedida");
                    }
                    ?>
                    <div class="campo">
                        <label for="codigo1">Código 1:</label>
                        <input type="text" id="codigo1" name="codigo1" value="<?php echo isset($codigo1) ? $codigo1 : ''; ?>" required><br>
                    </div>
                    <div class="campo">
                        <label for="codigo2">Código 2:</label>
                        <input type="text" id="codigo2" name="codigo2" value="<?php echo isset($codigo2) ? $codigo2 : ''; ?>" required><br>
                    </div>
                    <div class="campo">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo isset($nombre) ? $nombre : ''; ?>" required><br>
                    </div>

                    <div class="campo">
                        <label for="iva">IVA:</label>
                        <input type="number" id="iva" name="iva" value="<?php echo isset($iva) ? $iva : ''; ?>" required><br>
                    </div>

                    <div class="campo">
                        <label for="precio1">Precio 1:</label>
                        <input type="number" id="precio1" name="precio1" value="<?php echo isset($precio1) ? $precio1 : ''; ?>" required><br>
                    </div>

                    <div class="campo">
                        <label for="precio2">Precio 2:</label>
                        <input type="number" id="precio2" name="precio2" value="<?php echo isset($precio2) ? $precio2 : ''; ?>"><br>
                    </div>

                    <div class="campo">
                        <label for="precio3">Precio 3:</label>
                        <input type="number" id="precio3" name="precio3" value="<?php echo isset($precio3) ? $precio3 : ''; ?>"><br>
                    </div>

                    <div class="campo">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" id="cantidad" name="cantidad" value="<?php echo isset($cantidad) ? $cantidad : ''; ?>" required><br>
                    </div>

                    <div class="campo">
                        <label for="descripcion">Descripción:</label>
                        <input type="text" id="descripcion" name="descripcion" value="<?php echo isset($descripcion) ? $descripcion : ''; ?>"><br>
                    </div>

                    <div class="campo">
                        <label for="categoria">Categoría:</label>
                        <select name="categoria" id="categoria" required>
                            <option value="">Seleccione una categoría</option>
                            <?php while ($filaCategoria = $categorias->fetch_assoc()) {
                                $selected = ($filaCategoria['codigo'] == $fila['Categoria_codigo']) ? 'selected' : ''; ?>
                                <option value="<?php echo $filaCategoria['codigo']; ?>" <?php echo $selected; ?>>
                                    <?php echo $filaCategoria['nombre']; ?>
                                </option>
                            <?php } ?>
                        </select><br>
                    </div>

                    <div class="campo">
                        <label for="marca">Marca:</label>
                        <select name="marca" id="marca" required>
                            <option value="">Seleccione una marca</option>
                            <?php while ($filaMarca = $marcas->fetch_assoc()) {
                                $selected = ($filaMarca['codigo'] == $fila['Marca_codigo']) ? 'selected' : ''; ?>
                                <option value="<?php echo $filaMarca['codigo']; ?>" <?php echo $selected; ?>>
                                    <?php echo $filaMarca['nombre']; ?>
                                </option>
                            <?php } ?>
                        </select><br>
                    </div>

                    <div class="campo">
                        <label for="unidadMedida">Unidad de Medida:</label>
                        <select name="unidadMedida" id="unidadMedida" required>
                            <option value="">Seleccione una unidad de medida</option>
                            <?php while ($filaUnidad = $unidades->fetch_assoc()) {
                                $selected = ($filaUnidad['codigo'] == $fila['UnidadMedida_codigo']) ? 'selected' : ''; ?>
                                <option value="<?php echo $filaUnidad['codigo']; ?>" <?php echo $selected; ?>>
                                    <?php echo $filaUnidad['nombre']; ?>
                                </option>
                            <?php } ?>
                        </select><br>
                    </div>

                    <div class="campo">
                        <label for="ubicacion">Ubicación:</label>
                        <select name="ubicacion" id="ubicacion" required>
                            <option value="">Seleccione una ubicación</option>
                            <?php while ($filaUbicacion = $ubicaciones->fetch_assoc()) {
                                $selected = ($filaUbicacion['codigo'] == $fila['Ubicacion_codigo']) ? 'selected' : ''; ?>
                                <option value="<?php echo $filaUbicacion['codigo']; ?>" <?php echo $selected; ?>>
                                    <?php echo $filaUbicacion['nombre']; ?>
                                </option>
                            <?php } ?>
                        </select><br>
                    </div>

                    <div class="campo">
                        <label for="proveedor">Proveedor:</label>
                        <select name="proveedor" id="proveedor" required>
                            <option value="">Seleccione un proveedor</option>
                            <?php while ($filaProveedor = $proveedores->fetch_assoc()) {
                                $selected = ($filaProveedor['nit'] == $fila['proveedor_nit']) ? 'selected' : ''; ?>
                                <option value="<?php echo $filaProveedor['nit']; ?>" <?php echo $selected; ?>>
                                    <?php echo $filaProveedor['nombre']; ?>
                                </option>
                            <?php } ?>
                        </select><br>
                    </div>


                    <div class="button-container">
                        <div class="boton">
                            <button type="submit" name="guardar">Guardar</button>
                            <button type="submit" id="eliminar" name="eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">Eliminar</button>
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
            $codigo = $_POST['selectProducto'];
            $nombre = $_POST['nombre'];
            $iva = $_POST['iva'];
            $precio1 = $_POST['precio1'];
            $precio2 = $_POST['precio2'];
            $precio3 = $_POST['precio3'];
            $cantidad = $_POST['cantidad'];
            $descripcion = $_POST['descripcion'];
            $categoria = $_POST['categoria'];
            $marca = $_POST['marca'];
            $unidadMedida = $_POST['unidadMedida'];
            $ubicacion = $_POST['ubicacion'];
            $proveedor = $_POST['proveedor'];

            $actualizar = "UPDATE producto SET 
                        nombre='$nombre', iva='$iva', precio1='$precio1', precio2='$precio2', precio3='$precio3', 
                        cantidad='$cantidad', descripcion='$descripcion', 
                        Categoria_codigo='$categoria', Marca_codigo='$marca', 
                        UnidadMedida_codigo='$unidadMedida', Ubicacion_codigo='$ubicacion', 
                        proveedor_nit='$proveedor' 
                      WHERE codigo1='$codigo'";

            mysqli_query($conexion, $actualizar);
            echo "<script>alert('Producto actualizado correctamente');</script>";
        }

        if (isset($_POST['eliminar'])) {
            $codigo = $_POST['selectProducto'];

            if (!empty($codigo)) {
                $eliminar = "DELETE FROM producto WHERE codigo1='$codigo'";
                mysqli_query($conexion, $eliminar);
                echo "<script>alert('Producto eliminado correctamente'); window.location.href='actualizarproducto.php';</script>";
            }
        }

        mysqli_close($conexion);
    }
    ?>
</body>

</html>