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
        f.cambio
    FROM factura f
    WHERE f.codigo = ?
";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $factura_id);
$stmt->execute();
$resultado = $stmt->get_result();
$factura = $resultado->fetch_assoc();
$stmt->close();

if (!$factura) {
    die("La factura solicitada no existe.");
}

// --------------------------------------------------
// 2) Obtener los productos asociados a esta factura
// --------------------------------------------------
$sqlProd = "
    SELECT 
        pf.cantidad, 
        pf.precioUnitario, 
        p.nombre AS nombreProducto 
    FROM producto_factura pf
    JOIN producto p ON pf.Producto_codigo = p.codigo1
    WHERE pf.Factura_codigo = ?
";
$stmt = $conexion->prepare($sqlProd);
$stmt->bind_param("i", $factura_id);
$stmt->execute();
$productos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

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
</head>

<body>
    <div class="sidebar">
        <div id="menu"></div>
    </div>

    <form class="form-descarga" action="factura_pdf.php" method="post" target="_blank">
        <!-- Mandamos el código de factura para generar PDF -->
        <input type="hidden" name="factura_id" value="<?php echo $factura['codigo']; ?>">
        <button type="submit" class="btn-descargar">
            <animated-icons
                src="https://animatedicons.co/get-icon?name=Pdf&style=minimalistic&token=d5afb04f-d10f-4540-bf0a-27e0b4e06ce8"
                trigger="loop"
                attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#FF0000FF","background":"#FFFFFF"}}'
                height="120"
                width="120">
            </animated-icons>
        </button>
        <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    </form>

    <!-- >>> Botón para descargar como imagen <<< -->
    <button id="btnDescargarImagen" class="btn-descargar-imagen">
        Descargar como Imagen
    </button>

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
                    <?php foreach ($productos as $prod): ?>
                        <tr>
                            <td><?php echo $prod['cantidad']; ?></td>
                            <td>$<?php echo number_format($prod['precioUnitario']); ?></td>
                            <td><?php echo $prod['nombreProducto']; ?></td>
                            <td>$<?php echo number_format($prod['cantidad'] * $prod['precioUnitario']); ?></td>
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



    <div class="userInfo">
        <!-- Nombre y apellido del usuario y rol -->
        <?php
        $conexion2 = new mysqli('localhost', 'root', '', 'inventariomotoracer');
        $id_usuario = $_SESSION['usuario_id'];
        $sqlUsuario = "SELECT nombre, apellido, rol, foto FROM usuario WHERE identificacion = ?";
        $stmtUsuario = $conexion2->prepare($sqlUsuario);
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
  document.getElementById('btnDescargarImagen').addEventListener('click', () => {
    // 1) Seleccionamos el elemento completo de la factura
    const nodoFactura = document.querySelector('.factura');
    if (!nodoFactura) {
      alert('No se encontró el elemento .factura');
      return;
    }

    // 2) Obtenemos sus dimensiones “reales” (incluso si está fuera de pantalla):
    const width  = nodoFactura.scrollWidth;
    const height = nodoFactura.scrollHeight;

    // 3) Opciones para html2canvas: explicitamos width/height
    html2canvas(nodoFactura, {
      width:          width,
      height:         height,
      scale:          2,              // aumenta resolución
      backgroundColor:'#ffffff',      // fondo blanco
    }).then(canvas => {
      // 4) Convertimos el canvas a Blob y forzamos la descarga
      canvas.toBlob(blob => {
        const link = document.createElement('a');
        link.download = `factura_${Date.now()}.png`;
        link.href = URL.createObjectURL(blob);
        link.click();
        URL.revokeObjectURL(link.href);
      }, 'image/png');
    }).catch(err => {
      console.error('Error generando la imagen:', err);
      alert('Ocurrió un problema al generar la imagen.');
    });
  });
</script>

</body>

</html>