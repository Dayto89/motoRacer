<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

$conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// ID de la factura obtenida desde la sesión
$factura_id = $_SESSION["factura_id"] ?? null;
if (!$factura_id) {
    die("No se encontró ninguna factura para mostrar.");
}

// --------------------------------------------------
// 1) Obtener los datos directamente desde la tabla factura
// --------------------------------------------------
$sql = "
    SELECT 
        f.codigo,
        f.fechaGeneracion,
        f.nombreUsuario,
        f.apellidoUsuario,
        f.nombreCliente,
        f.apellidoCliente,
        f.telefonoCliente,
        f.identificacionCliente,
        f.precioTotal,
        f.cambio,
        f.productos_resumen
    FROM factura f
    WHERE f.codigo = ?
";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $factura_id);
$stmt->execute();
$resultado = $stmt->get_result();
$factura = $resultado->fetch_assoc();
// Decodificamos el JSON de productos
$detalleProductos = json_decode($factura['productos_resumen'], true);

// En caso de que algo falle, aseguramos un array
if (!is_array($detalleProductos)) {
    $detalleProductos = [];
}
$stmt->close();

if (!$factura) {
    die("La factura solicitada no existe.");
}


// --------------------------------------------------
// 3) Obtener los métodos de pago asociados
// --------------------------------------------------
$sqlPago = "
    SELECT 
        metodoPago, 
        monto 
    FROM factura_metodo_pago 
    WHERE Factura_codigo = ?
";
$stmt = $conexion->prepare($sqlPago);
$stmt->bind_param("i", $factura_id);
$stmt->execute();
$metodos_pago = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Cálculos de impuestos y base
$totalBruto    = $factura['precioTotal'];
$ivaPorcentaje = 19;
$base          = $totalBruto / (1 + ($ivaPorcentaje / 100));
$impuesto      = $totalBruto - $base;
$cambio        = $factura['cambio'];

date_default_timezone_set('America/Bogota');
include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura #<?php echo $factura['codigo']; ?></title>
    <link rel="stylesheet" href="../css/recibo.css">
    <link rel="stylesheet" href="../css/alertas.css">
    <link rel="stylesheet" href="../componentes/header.css">
    <script src="../js/header.js"></script>
    <script defer src="/js/index.js"></script>
    <style>
        /* Configuración de impresión para impresora de tickets */
        @page {
            size: 80mm auto;
            margin: 5mm;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .factura {
                    max-height: none !important;
    overflow: visible !important;
            }

            .factura,
            .factura * {
                visibility: visible;
            }

            .acciones {
                display: none;
            }

            .factura {
                position: absolute;
                top: 0;
                left: 30%;
                width: 120mm;
                /* Ancho de ticket estándar */
                zoom: 0.7;
                /* Escala para ajustar contenido */
                /* sin transform, usa zoom para impresión */
            }
        }

        /* Estilos básicos para botones */
        .btn-accion {
            position: absolute;
            margin: 5px;
            padding: 8px 12px;
            border: none;
            background-color: rgba(83, 109, 254, 0);
            color: #fff;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
            left: 30%;
            top: 0%;
        }
    </style>
</head>

<body>
    <div id="menu"></div>
    <?php include '../html/boton-ayuda.php'; ?>
    <nav class="barra-navegacion">
        <div class="ubica"> Factura / Recibo </div>
        <div class="userContainer">
            <div class="userInfo">
                <!-- Nombre y apellido del usuario y rol -->
                <!-- Consultar datos del usuario -->
                <?php
                $conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
                $id_usuario = $_SESSION['usuario_id'];
                $sqlUsuario = "SELECT nombre, apellido, rol, foto FROM usuario WHERE identificacion = ?";
                $stmtUsuario = $conexion->prepare($sqlUsuario);
                $stmtUsuario->bind_param("i", $id_usuario);
                $stmtUsuario->execute();
                $resultUsuario = $stmtUsuario->get_result();
                $rowUsuario = $resultUsuario->fetch_assoc();
                $nombreUsuario = $rowUsuario['nombre'];
                $apellidoUsuario = $rowUsuario['apellido'];
                $rol = $rowUsuario['rol'];
                $foto = $rowUsuario['foto'];
                $stmtUsuario->close();
                ?>
                <p class="nombre"><?php echo $nombreUsuario; ?> <?php echo $apellidoUsuario; ?></p>
                <p class="rol">Rol: <?php echo $rol; ?></p>

            </div>
            <div class="profilePic">
                <?php if (!empty($rowUsuario['foto'])): ?>
                    <img id="profilePic" src="data:image/jpeg;base64,<?php echo base64_encode($foto); ?>" alt="Usuario">
                <?php else: ?>
                    <img id="profilePic" src="../imagenes/icono.jpg" alt="Usuario por defecto">
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Botón para imprimir -->
    <button id="btnImprimir" class="btn-accion" title="Imprimir">
        <i class='bx bx-printer'></i><label for="btnImprimir"> Imprimir</label>
    </button>

    <form class="form-descarga" action="factura_pdf.php" method="post" target="_blank" title="Descargar Factura">
        <!-- Mandamos el código de factura para generar PDF -->
        <input type="hidden" name="factura_id" value="<?php echo $factura['codigo']; ?>">
        <button type="submit" class="btn-descargar">
            <i class="fa-solid fa-file-pdf icon-color"></i><label> Exportar a PDF</label>
        </button>
        <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    </form>
    <div class="factura">
        <div class="factura-header">
            <img src="../imagenes/LOGO.png" alt="Logo Empresa">
            <h2>HECTOR LEONARDO LÓPEZ CIPRIAN</h2>
            <strong>NIT: 74182332-1</strong><br>
            <strong>Dir.: CALLE 40 BIS 6 50</strong><br>
            <strong>Yopal - Tel: 3107877527</strong>
        </div>
        <hr>

        <strong>Fecha generación:</strong>
        <?php echo date('d/m/Y H:i', strtotime($factura['fechaGeneracion'])); ?><br>

        <div class="factura-datos-cliente">
            <strong>Cliente:</strong>
            <?php echo $factura['nombreCliente'] . ' ' . $factura['apellidoCliente']; ?><br>
            <strong>Teléfono:</strong>
            <?php echo $factura['telefonoCliente']; ?><br>
            <strong>C.C / NIT:</strong>
            <?php echo $factura['identificacionCliente']; ?><br>
        </div>

        <div class="factura-datos-vendedor">
            <strong>Vendedor:</strong>
            <?php echo $factura['nombreUsuario'] . ' ' . $factura['apellidoUsuario']; ?><br>
        </div>

        <hr>

        <div class="factura-productos">
            <table>
                <thead>
                    <tr>
                        <th>Cant</th>
                        <th>Vr. Unit</th>
                        <th>Producto</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detalleProductos as $prod): ?>
                        <tr>
                            <td><?php echo $prod['cantidad']; ?></td>
                            <td>$<?php echo number_format($prod['precio']); ?></td>
                            <td><?php echo htmlspecialchars($prod['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                $<?php
                                    echo number_format(
                                        $prod['cantidad'] * $prod['precio'],
                                        2
                                    );
                                    ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <hr>

        <h4>Impuestos</h4>
        <table width="100%" cellspacing="0" cellpadding="5" style="border-collapse: collapse; text-align: left;">
            <tr>
                <th>%</th>
                <th>19%</th>
            </tr>
            <tr>
                <td>Base Imponible</td>
                <td>$<?php echo number_format($base, 2); ?></td>
            </tr>
            <tr>
                <td>IVA</td>
                <td>$<?php echo number_format($impuesto, 2); ?></td>
            </tr>
        </table>

        <hr>

        <h4>Pago</h4>
        <table width="100%" cellspacing="0" cellpadding="5" style="border-collapse: collapse; text-align: left;">
            <tr>
                <th>Método</th>
                <th>Valor</th>
            </tr>
            <?php foreach ($metodos_pago as $metodo): ?>
                <tr>
                    <td><?php echo $metodo['metodoPago']; ?></td>
                    <td>$<?php echo number_format($metodo['monto']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <hr>

        <div class="factura-total">
            <strong>Total bruto (base):</strong> $<?php echo number_format($base, 2); ?><br>
            <strong>IVA <?php echo $ivaPorcentaje; ?>%:</strong> $<?php echo number_format($impuesto, 2); ?><br>
            <strong>Cambio:</strong> $<?php echo number_format($cambio); ?><br>
            <strong>Total a pagar:</strong> $<?php echo number_format($totalBruto); ?>
        </div>

        <div class="factura-footer">
            <p>¡Gracias por su compra!</p>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        // Agregar funcionalidad al botón Imprimir
        document.getElementById('btnImprimir').addEventListener('click', () => {
            window.print();
        });
    </script>

</body>

</html>