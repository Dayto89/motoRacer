<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/producto.css">
    <link rel="stylesheet" href="/componentes/header.html">
    <link rel="stylesheet" href="/componentes/header.css">
    <script src="/js/index.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
</head>

<body>

    <!-- Aquí se cargará el header -->
    <div id="menu"></div>
    <!--Barra de búsqueda fija con efecto deslizante -->
    <div class="search-bar">
        <form class="d-flex" role="search">
            <button class="search-icon" type="submit" aria-label="Buscar" title="Buscar">
                <i class='bx bx-search-alt-2 icon'></i>
            </button>
            <input class="form-control" type="search" placeholder="Buscar">
        </form>
    </div>



    <!-- Sección para Actualizar Producto -->
    <div id="actualizarProducto" class="form-section">
        <h1>Actualizar Producto</h1>
        <form id="update-product-form">
            <div class="campo">
                <label for="selectProducto">Seleccionar Producto:</label>
                <select id="selectProducto" name="selectProducto">
                    <option value="">Selecciona un producto</option>
                    <?php
                    $conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");
                    $consulta = "SELECT codigo, nombre FROM producto";
                    $resultado = mysqli_query($conexion, $consulta);
                    $info = "";
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<option value='" . $fila['codigo'] . "'>" . $fila['nombre'] . "</option>";
                    }

                    mysqli_close($conexion);
                    ?>
                </select>
            </div>

            <div class="campo">
                <label for="nombre">Nombre:</label>
                <?php
                if (isset($_POST['nombre'])) {
                    echo "<input type='text' id='nombre' name='nombre' value='" . $_POST['nombre'] . "' required><br>";
                } else {
                    echo "<input type='text' id='nombre' name='nombre' required><br>";
                }
                ?>
            </div>

            <div class="campo">
                <label for="precio1">Precio 1:</label>
                <?php
                if (isset($_POST['precio1'])) {
                    echo "<input type='number' id='precio1' name='precio1' value='" . $_POST['precio1'] . "' required><br>";
                } else {
                    echo "<input type='number' id='precio1' name='precio1' required><br>";
                }
                ?>
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
            <div class="campo descrip">
                <label for="descripcion">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion"><br>
            </div>

            <div class="campo">
                <label for="nombre">Categoria:</label>
                <input type="text" id="nombre" name="nombre" required><br>
            </div>
            <div class="campo">
                <label for="nombre">Marca:</label>
                <input type="text" id="nombre" name="nombre" required><br>
            </div>
            <div class="campo">
                <label for="ubicacion">Ubicación:</label>
                <input type="text" id="ubicacion" name="ubicacion"><br>
            </div>

            <div class="campo">
                <label for="txtProveedor">Proveedor:</label>
                <input type="text" id="txtProveedor" name="proveedor"><br>
            </div>

            <div class="button-container">
                <div class="boton">
                    <button type="submit">Guardar</button>
                </div>
            </div>

        </form>

    </div>
    </div>

</body>

</html>