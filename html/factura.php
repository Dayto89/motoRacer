<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="stylesheet" href="../css/factura.css">
    <link rel="stylesheet" href="../componentes/header.css">
    <link rel="stylesheet" href="../componentes/header.html">
    
</head>
<body>

<div id="menu"></div>


    <!-- Contenedor principal -->
    <div class="main">
        <!-- Barra superior -->
        <div class="topbar">
            
            <input type="text" id="search" placeholder="Buscar por Producto, Referencia o Código">
        </div>

        <!-- Lista de marcas -->
        <div class="brands">
            <div class="brand-list">
                <?php
                    $conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");

                    if (!$conexion) {
                        die("Error en la conexión: " . mysqli_connect_error());
                    }
                    $stmt = $conexion->prepare("SELECT * FROM categoria");
                    $stmt->execute();
                    $resultado = $stmt->get_result();

                    if ($resultado->num_rows > 0) {
                        while ($fila = $resultado->fetch_assoc()) {
                            echo "<button class='brand'>" . $fila['nombre'] . "</button>";
                        }
                    } else {
                        echo "<script>alert('No hay marcas en la base de datos');</script>";
                        mysqli_close($conexion);
                    }
                ?>
            </div>
        </div>

        <!-- Lista de productos -->
        <div class="products">
            <?php
                $conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");
                $consulta = "SELECT * FROM producto";
                $resultado = mysqli_query($conexion, $consulta);

                if ($resultado->num_rows > 0) {
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<div class='card'>
                                <div class='card-header'>
                                    <span class='product-id'>{$fila['codigo1']}</span>
                                    <button class='more-btn'>⋮</button>
                                </div>
                                <p class='product-name'>{$fila['nombre']}</p>
                                <p class='product-code'>{$fila['precio2']}</p>
                                <p class='product-price'>$" . number_format($fila['precio3'], 2) . "</p>
                                <button class='favorite-btn'>⭐</button>
                            </div>";
                    }
                } else {
                    echo "<script>alert('No hay productos en la base de datos');</script>";
                    mysqli_close($conexion);
                }
            ?>
        </div>
    </div>

    <!-- Barra lateral derecha -->
    <div class="sidebar-right">
        <h3>Resumen</h3>
        <div class="total">
            <span>Total:</span>
            <span id="total-price">$0.00</span>
        </div>
        <button class="btn pay-btn">Cobrar</button>
    </div>
    <script src="../js/index.js"></script>
    <script src="../js/factura.js"></script>
</body>
</html>