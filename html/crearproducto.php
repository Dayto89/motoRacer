<?php

//Almacenar informacion producto en la base de datos

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');

if (!$conexion) {
    die("alert('No se pudo conectar a la base de datos');");
};

$marcas = $conexion->query("SELECT codigo, nombre FROM marca");
$categorias = $conexion->query("SELECT codigo, nombre FROM categoria");
$proveedores = $conexion->query("SELECT nit, nombre FROM proveedor");
$ubicaciones = $conexion->query("SELECT codigo, nombre FROM ubicacion");
$unidades = $conexion->query("SELECT codigo, nombre FROM unidadmedida");

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Crear Producto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/producto.css">
    <link rel="stylesheet" href="/componentes/header.html">
    <link rel="stylesheet" href="/componentes/header.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
</head>

<body>

    <!-- Aquí se cargará el header -->
    <div id="menu"></div>

    <!-- Sección para Crear Producto -->
    <div id="crearProducto" class="form-section">
        <h1>Crear Producto</h1>

        <!-- Contenedor principal -->
        <div class="container">

            <form id="product-form" method="POST" action="">


                <div class="campo">
                    <label for="codigo">Código:</label>
                    <input type="text" id="codigo" name="codigo" required><br>
                </div>
                <div class="campo">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required><br>
                </div>

                <div class="campo">
                    <label for="iva">IVA:</label>
                    <input type="number" id="iva" name="iva" required><br>
                </div>

                <div class="campo">
                    <label for="precio1">Precio 1:</label>
                    <input type="number" id="precio1" name="precio1" required><br>
                </div>

                <div class="campo">
                    <label for="precio2">Precio 2:</label>
                    <input type="number" id="precio2" name="precio2"><br>
                </div>

                <div class="campo">
                    <label for="precio3">Precio 3:</label>
                    <input type="number" id="precio3" name="precio3"><br>
                </div>

                <div class="campo">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" required><br>
                </div>


                <div class="campo">
                    <label for="categoria">Categoria:</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Seleccione una categoría</option>
                        <?php while ($fila = $categorias->fetch_assoc()) { ?>
                            <option value="<?php echo $fila['codigo']; ?>">
                                <?php echo $fila['nombre']; ?>
                            </option>
                        <?php } ?>
                    </select><br>
                </div>
                <div class="campo">
                    <label for="marca">Marca:</label>
                    <select name="marca" id="marca" required>
                        <option value="">Seleccione una marca</option>
                        <?php while ($fila = $marcas->fetch_assoc()) { ?>
                            <option value="<?php echo $fila['codigo']; ?>">
                                <?php echo $fila['nombre']; ?>
                            </option>
                        <?php } ?>
                    </select><br>
                </div>
                <div class="campo">
                    <label for="unidadMedida">Unidad de Medida:</label>
                    <select name="unidadMedida" id="unidadMedida" required>
                        <option value="">Seleccione una unidad de medida</option>
                        <?php while ($fila = $unidades->fetch_assoc()) { ?>
                            <option value="<?php echo $fila['codigo']; ?>">
                                <?php echo $fila['nombre']; ?>
                            </option>
                        <?php } ?>
                    </select><br>
                </div>
                <div class="campo">
                    <label for="ubicacion">Ubicación:</label>
                    <select name="ubicacion" id="ubicacion" required>
                        <option value="">Seleccione una ubicación</option>
                        <?php while ($fila = $ubicaciones->fetch_assoc()) { ?>
                            <option value="<?php echo $fila['codigo']; ?>">
                                <?php echo $fila['nombre']; ?>
                            </option>
                        <?php } ?>
                    </select><br>
                </div>

                <div class="campo">
                    <label for="proveedor">Proveedor:</label>
                    <select name="proveedor" id="proveedor" required>
                        <option value="">Seleccione un proveedor</option>
                        <?php while ($fila = $proveedores->fetch_assoc()) { ?>
                            <option value="<?php echo $fila['nit']; ?>">
                                <?php echo $fila['nombre']; ?>
                            </option>
                        <?php } ?>
                    </select><br>
                </div>
                <div class="campo descrip">
                    <label for="descripcion">Descripción:</label>
                    <input type="text" id="descripcion" name="descripcion"><br>
                </div>
                <div class="button-container">
                    <div class="boton">
                        <button type="button" onclick="openModal()">Guardar</button>
                    </div>
                </div>

                <!-- Modal de confirmación -->
                <div id="modalConfirm" class="modal hidden">
                    <div class="modal-content">
                        <h2 id="modalTitle">Confirmación</h2>
                        <p id="modalMessage">¿Estás seguro de que quieres guardar los cambios?</p>
                        <div id="modalButtons" class="modal-buttons">
                            <button class="btn-cancel" onclick="closeModal()">Cancelar</button>
                            <button class="btn-confirm" onclick="">Guardar</button>
                        </div>
                    </div>
                </div>
                <!-- Modal de error -->
                <div id="modalError" class="modal hidden">
                    <div class="modal-content">
                        <h2 id="modalErrorTitle">¡Error!</h2>
                        <p id="modalErrorMessage">Por favor, completa todos los campos.</p>
                    </div>
                </div>

                <!-- Modal de éxito -->
                <div id="modalSuccess" class="modal hidden">
                    <div class="modal-content">
                        <h2 id="modalSuccessTitle">¡Éxito!</h2>
                        <p id="modalSuccessMessage">¡Producto agregado correctamente!</p>
                        <button class="btn-ok" onclick="okButtonClicked()">Ok</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <script src="/js/index.js"></script>

    <?php

    if ($_POST) {
        if (!$conexion) {
            die("<script>alert('No se pudo conectar a la base de datos');</script>");
        };
        $codigo = $_POST['codigo'];
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

        $query = "INSERT INTO producto (codigo, nombre, iva, precio1, precio2, precio3, cantidad, descripcion, Categoria_codigo, Marca_codigo, UnidadMedida_codigo, Ubicacion_codigo, proveedor_nit) VALUES ('$codigo', '$nombre', '$iva', '$precio1', '$precio2', '$precio3', '$cantidad', '$descripcion', '$categoria', '$marca', '$unidadMedida', '$ubicacion', '$proveedor')";

        echo $query;

        $resultado = mysqli_query($conexion, $query);

        if (!$resultado) {
            echo "<script>console.log('Error al agregar el producto: " . mysqli_error($conexion) . "');</script>";
        }
    }

    ?>

</body>

</html>