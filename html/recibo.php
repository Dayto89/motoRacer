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



// ID de la factura (recibida por GET o POST)
$factura_id = $_SESSION["factura_id"] ?? null;

// Obtener los datos de la factura
$sql = "SELECT f.*, u.nombre AS nombreVendedor, u.apellido AS apellidoVendedor, 
               c.nombre AS nombreCliente, c.apellido AS apellidoCliente, c.telefono, c.codigo
        FROM factura f
        JOIN usuario u ON f.Usuario_identificacion = u.identificacion
        JOIN cliente c ON f.Cliente_codigo = c.codigo
        WHERE f.codigo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $factura_id);
$stmt->execute();
$resultado = $stmt->get_result();
$factura = $resultado->fetch_assoc();

$_SESSION['cliente_id'] = $factura['Cliente_codigo'];
echo "Cliente ID asignado a la sesión: " . $_SESSION['cliente_id']; // Depuración
// Asignar factura_id a la sesión
$_SESSION['factura_id'] = $factura_id;
echo "Factura ID asignado: " . $_SESSION['factura_id']; // Depuración

// Obtener los productos de la factura
$sql = "SELECT pf.cantidad, pf.precioUnitario, p.nombre 
        FROM producto_factura pf
        JOIN producto p ON pf.Producto_codigo = p.codigo1
        WHERE pf.Factura_codigo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $factura_id);
$stmt->execute();
$productos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Obtener los métodos de pago
$sql = "SELECT metodoPago, monto FROM factura_metodo_pago WHERE Factura_codigo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $factura_id);
$stmt->execute();
$metodos_pago = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$totalBruto = $factura['precioTotal'];
$ivaPorcentaje = 19;
$base = $totalBruto / (1 + ($ivaPorcentaje / 100));
$impuesto = $totalBruto - $base;

date_default_timezone_set('America/Bogota');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <link rel="stylesheet" href="../css/recibo.css">
    <link rel="stylesheet" href="../componentes/header.css">
    <script src="../js/header.js"></script>
    <script defer src="/js/index.js"></script>
</head>
<body>
<div class="sidebar">
        <div id="menu"></div>
    </div>
    <form class="form-descarga" action="factura_pdf.php" method="post" target="_blank">
        <input type="hidden" name="codigo_cliente" value="<?php echo $codigo; ?>">
        <button type="submit" class="btn-descargar"><animated-icons
                src="https://animatedicons.co/get-icon?name=Pdf&style=minimalistic&token=d5afb04f-d10f-4540-bf0a-27e0b4e06ce8"
                trigger="click"
                attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#FF0000FF","background":"#FFFFFF"}}'
                height="120"
                width="120"></animated-icons></button>
        <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>

    </form>
    <div class="factura">
        <div class="factura-header">
            <img src="../imagenes/LOGO.png" alt="">
            <h2>HECTOR LEONARDO LÓPEZ CIPRIAN</h2>
            <strong>NIT: 74182332-1</strong><br>
            <strong>Dir.: CALLE 40 BIS 6 50</strong><br>
            <strong>Yopal - Tel: 3107877527</strong>
        </div>
        <hr>
        <strong>Fecha generación: </strong> <?php echo date('d/m/Y H:i', strtotime($factura['fechaGeneracion'])); ?><br>

        <div class="factura-datos-cliente">
            <strong>Cliente:</strong> <?php echo $factura['nombreCliente'] . ' ' . $factura['apellidoCliente']; ?><br>
            <strong>Teléfono:</strong> <?php echo $factura['telefono']; ?><br>
            <strong>C.C / NIT:</strong> <?php echo $factura['codigo']; ?><br>
        </div>

        <div class="factura-datos-vendedor">
            <strong>Vendedor:</strong> <?php echo $factura['nombreVendedor'] . ' ' . $factura['apellidoVendedor']; ?><br>
        </div>

        <hr>

        <div class="factura-productos">
            <table>
                <thead>
                    <tr>
                        <th>Cant</th>
                        <th>Vr.Unit</th>
                        <th>Producto</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $prod): ?>
                        <tr>
                            <td><?php echo $prod['cantidad']; ?></td>
                            <td>$<?php echo number_format($prod['precioUnitario'], 2); ?></td>
                            <td><?php echo $prod['nombre']; ?></td>
                            <td>$<?php echo number_format($prod['cantidad'] * $prod['precioUnitario'], 2); ?></td>
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
                    <td>$<?php echo number_format($metodo['monto'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <hr>

        <div class="factura-total">
            <strong>Total bruto: $<?php echo number_format($base, 2); ?></strong><br>
            <strong>IVA <?php echo $ivaPorcentaje; ?>%: $<?php echo number_format($impuesto, 2); ?></strong><br>
            <strong>Total a pagar: $<?php echo number_format($totalBruto, 2); ?></strong>
        </div>

        <div class="factura-footer">
            <p>¡Gracias por su compra!</p>
        </div>
    </div>

</body>
</html>
