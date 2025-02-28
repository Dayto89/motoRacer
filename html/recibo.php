<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');

if (!$conexion) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

// Traer información de cliente del archivo factura.php

    $cliente = $_SESSION['cliente'];
    $vendedor = $_SESSION['vendedor'];
    $productos = $_SESSION['productos'];




?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <style>
        /* Ejemplo de estilo para un recibo/tirilla de 80mm de ancho */
        body {
            font-family: Arial, sans-serif;
            width: 80mm; /* Ancho típico de rollo de impresora térmica */
            margin: 0 auto;
        }

        h1, h2, h3, p {
            margin: 0;
            padding: 0;
        }

        .factura {
            border: 1px dashed #000;
            padding: 10px;
        }

        .factura-header, .factura-footer {
            text-align: center;
            margin-bottom: 10px;
        }

        .factura-datos-cliente {
            margin-bottom: 10px;
        }

        .factura-productos table {
            width: 100%;
            border-collapse: collapse;
        }

        .factura-productos th,
        .factura-productos td {
            text-align: left;
            padding: 4px;
            border-bottom: 1px solid #ccc;
        }

        .factura-total {
            text-align: right;
            margin-top: 10px;
            font-size: 1.2em;
        }

        /* Estilos de impresión (opcional) */
        @media print {
            /* Quita bordes, margenes, etc. para optimizar la impresión */
            body {
                margin: 0;
            }
            .factura {
                border: none;
            }
        }
    </style>
</head>
<body>
    <div class="factura">
        <div class="factura-header">
            <h2>Motoracer</h2>
            <p>Fecha: <?php echo date('d/m/Y H:i'); ?></p>
        </div>

        <div class="factura-datos-cliente">
            <strong>Cliente:</strong> 
            <?php echo $cliente['nombre'] . ' ' . $cliente['apellido']; ?><br>
            <strong>Teléfono:</strong> <?php echo $cliente['telefono']; ?><br>
            <strong>Dirección:</strong> <?php echo $cliente['direccion']; ?><br>
        </div>

        <div class="factura-datos-vendedor">
            <strong>Vendedor:</strong> 
            <?php echo $vendedor['nombre'] . ' ' . $vendedor['apellido']; ?>
        </div>

        <hr>

        <div class="factura-productos">
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cant</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($productos as $prod) {
                        $subtotal = $prod['cantidad'] * $prod['precio'];
                        $total += $subtotal;
                        echo "<tr>
                                <td>{$prod['nombre']}</td>
                                <td>{$prod['cantidad']}</td>
                                <td>$" . number_format($prod['precio'], 0) . "</td>
                                <td>$" . number_format($subtotal, 0) . "</td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="factura-total">
            <strong>Total: $<?php echo number_format($total, 0); ?></strong>
        </div>

        <div class="factura-footer">
            <p>¡Gracias por su compra!</p>
        </div>
    </div>
</body>
</html>
