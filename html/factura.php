<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="stylesheet" href="../css/factura.css">
    <link rel="stylesheet" href="../componentes/header.css">
    <link rel="stylesheet" href="../componentes/header.html">

    <style>
        /* Estilos para la breadcrumb */
        .breadcrumb {
            list-style: none;
            display: flex;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            font-size: 16px;
            margin: 15px 0;
        }

        .breadcrumb li {
            display: inline;
            margin-right: 10px;
        }

        .breadcrumb li a {
            text-decoration: none;
            color: #007bff;
        }

        .breadcrumb li a:hover {
            text-decoration: underline;
        }

        .breadcrumb .active {
            color: #6c757d;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Barra lateral izquierda (Menú) -->
    <div class="sidebar">
        <div id="menu"></div>
    </div>

    <!-- Contenedor principal -->
    <div class="main">
        <!-- Barra superior -->
        <div class="topbar">
            <input type="text" id="search" placeholder="Buscar por Producto, Referencia o Código">
        </div>

        <!-- Breadcrumb (Migas de pan) -->
        <ul class="breadcrumb">
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
                    echo "<li><a class='brand'>" . htmlspecialchars($fila['nombre']) . "</a></li>";
                }
            } else {
                echo "<script>alert('No hay marcas en la base de datos');</script>";
            }

            $stmt->close();
            mysqli_close($conexion);
            ?>
        </ul>

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
                                    <span class='product-id'>" . htmlspecialchars($fila['codigo1']) . "</span>
                                    <button class='more-btn'>⋮</button>
                                </div>
                                <p class='product-name'>" . htmlspecialchars($fila['nombre']) . "</p>
                                <p class='product-code'>" . htmlspecialchars($fila['precio2']) . "</p>
                                <p class='product-price'>$" . number_format($fila['precio3'], 2) . "</p>
                                <button class='favorite-btn'>⭐</button>
                            </div>";
                }
            } else {
                echo "<script>alert('No hay productos en la base de datos');</script>";
            }

            mysqli_close($conexion);
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