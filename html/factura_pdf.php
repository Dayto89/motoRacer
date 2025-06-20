<?php
ob_start();
require('../fpdf/fpdf.php');
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
if ($conexion->connect_error) {
    die("No se pudo conectar a la base de datos: " . $conexion->connect_error);
}

$factura_id = $_SESSION["factura_id"] ?? null;
if (!$factura_id) {
    die("Error: Factura ID no encontrado en la sesión.");
}

// Subclase para personalizar pie de página
class PDF extends FPDF {
    function Footer() {
        $this->SetY(-20);
        $this->SetFont('Arial', 'I', 9);
        $this->SetTextColor(100);
        $empresa = "Moto Racer. | NIT: 74182332-1 | Calle 40 #6 - 50, Yopal | Tel: 3004401797";
        $this->Cell(0, 10, utf8_decode($empresa), 0, 0, 'C');
    }
}

// Obtener datos de la factura
$sqlf = "
    SELECT 
      f.nombreUsuario,
      f.apellidoUsuario,
      f.nombreCliente,
      f.apellidoCliente,
      f.telefonoCliente,
      f.identificacionCliente,
      f.precioTotal,
      f.cambio,
      f.fechaGeneracion,
      f.productos_resumen
    FROM factura f
    WHERE f.codigo = ?
";
$stmt = $conexion->prepare($sqlf);
$stmt->bind_param("i", $factura_id);
$stmt->execute();
$resultadoFactura = $stmt->get_result();
if ($resultadoFactura->num_rows === 0) {
    die("Factura no encontrada.");
}
$facturaData = $resultadoFactura->fetch_assoc();
$productosJson = $facturaData['productos_resumen'];
$productos = json_decode($productosJson, true);
if (!is_array($productos)) {
    die("Error: el campo productos_resumen no contiene un JSON válido.");
}
$stmt->close();

$nombreVendedor    = $facturaData['nombreUsuario'];
$apellidoVendedor  = $facturaData['apellidoUsuario'];
$nombreCliente     = $facturaData['nombreCliente'];
$apellidoCliente   = $facturaData['apellidoCliente'];
$telefonoCliente   = $facturaData['telefonoCliente'];
$identCliente      = $facturaData['identificacionCliente'];
$totalBrutoStored  = $facturaData['precioTotal'];
$cambioStored      = $facturaData['cambio'];
$fechaGeneracion   = $facturaData['fechaGeneracion'];

$totalBruto = 0;
foreach ($productos as $p) {
    $totalBruto += $p['cantidad'] * $p['precio'];
}

$ivaPorcentaje = 19;
$base     = $totalBruto / (1 + ($ivaPorcentaje / 100));
$impuesto = $totalBruto - $base;
$cambio   = $cambioStored;

// Métodos de pago
$metodos_pago = [];
$sqlPago = "SELECT metodoPago, monto FROM factura_metodo_pago WHERE Factura_codigo = ?";
$stmt = $conexion->prepare($sqlPago);
$stmt->bind_param("i", $factura_id);
$stmt->execute();
$resultadoPagos = $stmt->get_result();
while ($fila = $resultadoPagos->fetch_assoc()) {
    $metodos_pago[] = $fila;
}
$stmt->close();

// Crear el PDF
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Encabezado
$pdf->Image('../imagenes/LOGO.png', 10, 10, 30);
$pdf->Cell(0, 10, 'Factura', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 8, "Fecha: " . date('d/m/Y H:i', strtotime($fechaGeneracion)), 0, 1, 'R');
$pdf->Ln(5);

// Datos del cliente
$pdf->Cell(0, 8, utf8_decode("Cliente: $nombreCliente $apellidoCliente"), 0, 1);
$pdf->Cell(0, 8, "Telefono: $telefonoCliente", 0, 1);
$pdf->Cell(0, 8, "C.C/NIT: $identCliente", 0, 1);
$pdf->Ln(5);

// Vendedor
$pdf->Cell(0, 8, utf8_decode("Vendedor: $nombreVendedor $apellidoVendedor"), 0, 1);
$pdf->Ln(5);

// Tabla productos
$wCant = 30;
$wProd = 70;
$wUnit = 40;
$wSub  = 40;

$pdf->SetFont('Arial','B',10);
$pdf->Cell($wCant,8,'Cantidad',1,0,'C');
$pdf->Cell($wProd,8,'Producto',1,0,'C');
$pdf->Cell($wUnit,8,'Vr. Unitario',1,0,'C');
$pdf->Cell($wSub, 8,'Subtotal',1,1,'C');

$pdf->SetFont('Arial','',10);
foreach($productos as $prod){
    $raw = $prod['nombre'];
    $parts = preg_split('/\s*–/', $raw);
    $nameClean = trim($parts[0]);

    $cant   = $prod['cantidad'];
    $precio = $prod['precio'];
    $subt   = $cant * $precio;

    $wrapped = wordwrap(utf8_decode($nameClean), 30, "\n", true);
    $lines   = substr_count($wrapped,"\n")+1;
    $hRow    = 6 * $lines;
    $x = $pdf->GetX();
    $y = $pdf->GetY();

    $pdf->Cell($wCant, $hRow, $cant, 1, 0, 'C');
    $pdf->SetXY($x+$wCant, $y);
    $pdf->MultiCell($wProd, $hRow/$lines, $wrapped, 1, 'L');
    $pdf->SetXY($x+$wCant+$wProd,$y);
    $pdf->Cell($wUnit, $hRow, '$'.number_format($precio,2), 1, 0, 'R');
    $pdf->Cell($wSub,  $hRow, '$'.number_format($subt,2),   1, 1, 'R');
    $pdf->SetXY($x, $y+$hRow);
}

// Totales
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 8, "Base imponible: $" . number_format($base, 2), 0, 1, 'R');
$pdf->Cell(0, 8, "IVA ($ivaPorcentaje%): $" . number_format($impuesto, 2), 0, 1, 'R');
$pdf->Cell(0, 8, "Total a pagar: $" . number_format($totalBruto), 0, 1, 'R');
$pdf->Cell(0, 8, "Cambio: $" . number_format($cambio), 0, 1, 'R');

// Métodos de pago
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, "Metodos de Pago:", 0, 1);
$pdf->SetFont('Arial', '', 10);
foreach ($metodos_pago as $m) {
    $pdf->Cell(60, 6, $m['metodoPago'], 0, 0);
    $pdf->Cell(0, 6, '$' . number_format($m['monto'], 2), 0, 1, 'R');
}

$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 12);
$pdf->Cell(0, 8, utf8_decode("¡Gracias por su compra!"), 0, 1, 'C');

// Descargar PDF
ob_end_clean();
$pdf->Output('D', 'Factura.pdf');
?>
