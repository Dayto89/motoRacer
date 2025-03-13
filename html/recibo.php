<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

$id = $_SESSION['usuario_id'];

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

// Datos del vendedor
$consulta = "SELECT * FROM usuario WHERE identificacion = $id";
$resultado = mysqli_query($conexion, $consulta);
if ($resultado) {
    $usuario = $resultado->fetch_assoc();
    $nombre = $usuario['nombre'];
    $apellido = $usuario['apellido'];
}

// Datos del cliente
$codigo = 123; // Debes recibir este valor desde un formulario
$consulta = "SELECT * FROM cliente WHERE codigo = '$codigo'";
$resultado = mysqli_query($conexion, $consulta);
if ($resultado) {
    $cliente = $resultado->fetch_assoc();
    $nombreCliente = $cliente['nombre'];
    $apellidoCliente = $cliente['apellido'];
    $telefono = $cliente['telefono'];
    $identificacion = $cliente['codigo'];
}

// Obtener productos de la factura

$productos = [];
$totalBruto = 0;

while ($fila = mysqli_fetch_assoc($resultado)) {
    $productos[] = $fila;
    $totalBruto += $fila['cantidad'] * $fila['precio'];
}

// Cálculo de impuestos
$ivaPorcentaje = 19;
$base = $totalBruto / (1 + ($ivaPorcentaje / 100));
$impuesto = $totalBruto - $base;

date_default_timezone_set('America/Bogota');
  
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <link rel="stylesheet" href="../css/recibo.css">
    <link rel="stylesheet" href="../componentes/header.css">
    <link rel="stylesheet" href="../componentes/header.php">
    <script src="../js/header.js"></script>
    <script defer src="../js/index.js"></script>
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
  width="120"
></animated-icons></button>
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
        <strong>Fecha generación: </strong> <?php echo date('d/m/Y H:i'); ?><br>

        <div class="factura-datos-cliente">
            <strong>Cliente:</strong> <?php echo $nombreCliente . ' ' . $apellidoCliente; ?><br>
            <strong>Teléfono:</strong> <?php echo $telefono; ?><br>
            <strong>C.C / NIT:</strong> <?php echo $identificacion; ?><br>
        </div>

        <div class="factura-datos-vendedor">
            <strong>Vendedor:</strong> <?php echo $nombre . ' ' . $apellido; ?><br>
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
                    <?php foreach ($productos as $prod):
                        $subtotal = $prod['cantidad'] * $prod['precio']; ?>
                        <tr>
                            <td><?php echo $prod['cantidad']; ?></td>
                            <td>$<?php echo number_format($prod['precio'], 0); ?></td>
                            <td><?php echo $prod['nombre']; ?></td>
                            <td>$<?php echo number_format($subtotal, 0); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <hr>
        <h4>Impuestos</h4>
<table width="100%" cellspacing="0" cellpadding="5" style="border-collapse: collapse; text-align: left;">
    <tr>
        <th style="border-bottom: 2px solid black;">ID</th>
        <th style="border-bottom: 2px solid black;">A</th>
    </tr>
    <tr>
        <td>%</td>
        <td>19%</td>
    </tr>
    <tr>
        <td>Base Impuesto</td>
        <td>$0.00</td>
    </tr>
</table>
<hr>

<th style="border-bottom: 2px solid black;">Pago</th>
    </tr>
    </table>
    
    <table width="100%" cellspacing="0" cellpadding="5" style="border-collapse: collapse; text-align: left;">
    <tr>
        <th style="border-bottom: 2px solid black;">Método</th>
        <th style="border-bottom: 2px solid black;">Valor</th>
    </tr>
    <tr>
        <td style="border-bottom: 1px solid black;">Efectivo</td>
        <td style="border-bottom: 1px solid black;">$0.00</td>
    </tr>
    <tr>
        <td style="border-bottom: 1px solid black;">Tarjeta</td>
        <td style="border-bottom: 1px solid black;">$0.00</td>
    </tr>
    <tr>
        <td style=>Transferencia</td>
        <td style=>$0.00</td>
    </tr>
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