<?php
// Iniciar el buffer de salida para capturar cualquier salida no deseada
ob_start();

require('../fpdf/fpdf.php'); // Asegúrate de que la ruta a FPDF es correcta
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

// Recuperar factura_id de la sesión
$factura_id = $_SESSION["factura_id"] ?? null;
if (!$factura_id) {
    die("Error: Factura ID no encontrado en la sesión.");
}

// --------------------------------------------------
// 1) Obtener datos de la factura directamente de la tabla `factura`
// --------------------------------------------------
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
      f.fechaGeneracion
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
$stmt->close();

// Asignar variables para usar en el PDF
$nombreVendedor    = $facturaData['nombreUsuario'];
$apellidoVendedor  = $facturaData['apellidoUsuario'];
$nombreCliente     = $facturaData['nombreCliente'];
$apellidoCliente   = $facturaData['apellidoCliente'];
$telefonoCliente   = $facturaData['telefonoCliente'];
$identCliente      = $facturaData['identificacionCliente'];
$totalBrutoStored  = $facturaData['precioTotal'];
$cambioStored      = $facturaData['cambio'];
$fechaGeneracion   = $facturaData['fechaGeneracion'];

// --------------------------------------------------
// 2) Obtener productos de la factura
// --------------------------------------------------
$productos = [];
$totalBrutoCalc = 0;
$sqlProd = "
    SELECT pf.cantidad, pf.precioUnitario, p.nombre 
      FROM producto_factura pf
      JOIN producto p ON pf.Producto_codigo = p.codigo1
     WHERE pf.Factura_codigo = ?
";
$stmt = $conexion->prepare($sqlProd);
$stmt->bind_param("i", $factura_id);
$stmt->execute();
$resultadoProductos = $stmt->get_result();
if ($resultadoProductos->num_rows === 0) {
    die("No se encontraron productos para esta factura.");
}
while ($fila = $resultadoProductos->fetch_assoc()) {
    $productos[] = $fila;
    $totalBrutoCalc += $fila['cantidad'] * $fila['precioUnitario'];
}
$stmt->close();

// Si prefieres usar el total guardado en la tabla, puedes reemplazar $totalBrutoCalc por $totalBrutoStored
$totalBruto = $totalBrutoCalc; 

// Cálculo de impuestos
$ivaPorcentaje = 19;
$base     = $totalBruto / (1 + ($ivaPorcentaje / 100));
$impuesto = $totalBruto - $base;
$cambio   = $cambioStored; // si preferimos el cambio guardado

// --------------------------------------------------
// 3) Obtener métodos de pago asociados (si así lo deseas)
// --------------------------------------------------
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

// --------------------------------------------------
// 4) Crear el PDF
// --------------------------------------------------
$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Encabezado
$pdf->Image('../imagenes/LOGO.png', 10, 10, 30);
$pdf->Cell(0, 10, 'Factura', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 8, "Fecha: " . date('d/m/Y H:i', strtotime($fechaGeneracion)), 0, 1, 'R');
$pdf->Ln(5);

// Datos del Cliente (tomados directamente de la factura)
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 8, utf8_decode("Cliente: $nombreCliente $apellidoCliente"), 0, 1);
$pdf->Cell(0, 8, "Telefono: $telefonoCliente", 0, 1);
$pdf->Cell(0, 8, "C.C/NIT: $identCliente", 0, 1);
$pdf->Ln(5);

// Datos del Vendedor (tomados directamente de la factura)
$pdf->Cell(0, 8, utf8_decode("Vendedor: $nombreVendedor $apellidoVendedor"), 0, 1);
$pdf->Ln(5);

// Tabla de Productos
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 8, "Cantidad", 1, 0, 'C');
$pdf->Cell(50, 8, "Producto", 1, 0, 'C');
$pdf->Cell(40, 8, "Vr. Unitario", 1, 0, 'C');
$pdf->Cell(40, 8, "Subtotal", 1, 1, 'C');

$pdf->SetFont('Arial', '', 10);
foreach ($productos as $prod) {
    $cantidad = $prod['cantidad'];
    $precio   = $prod['precioUnitario'] ?? 0;
    $subtotal = $cantidad * $precio;
    $nombreProducto = $prod['nombre'];

    // 1) Envolver el nombre de producto si es muy largo.
    //    Máximo 25 caracteres por línea (aprox.). Ajusta según tu fuente/tamaño.
    $wrappedName = wordwrap(utf8_decode($nombreProducto), 25, "\n", true);
    $numLines    = substr_count($wrappedName, "\n") + 1;
    $rowHeight   = 8 * $numLines;

    // 2) Imprimir celda "Cantidad"
    $yAntes = $pdf->GetY();
    $xAntes = $pdf->GetX();
    $pdf->Cell(30, $rowHeight, $cantidad, 1, 0, 'C');

    // 3) Celda "Producto" con MultiCell
    $pdf->SetXY($xAntes + 30, $yAntes);
    $pdf->MultiCell(50, 8, $wrappedName, 1, 'L');

    // 4) Posicionar para imprimir "Vr. Unitario" y "Subtotal"
    $pdf->SetXY($xAntes + 30 + 50, $yAntes);
    $pdf->Cell(40, $rowHeight, '$' . number_format($precio), 1, 0, 'R');
    $pdf->Cell(40, $rowHeight, '$' . number_format($subtotal), 1, 1, 'R');
}

// --------------------------------------------------
// 5) Totales e impuestos
// --------------------------------------------------
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 8, "Base imponible: $" . number_format($base, 2), 0, 1, 'R');
$pdf->Cell(0, 8, "IVA ($ivaPorcentaje%): $" . number_format($impuesto, 2), 0, 1, 'R');
$pdf->Cell(0, 8, "Total a pagar: $" . number_format($totalBruto), 0, 1, 'R');
$pdf->Cell(0, 8, "Cambio: $" . number_format($cambio), 0, 1, 'R');

// Si deseas listar métodos de pago, descomenta este bloque:

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

// Limpiar el búfer de salida y descargar el PDF
ob_end_clean();
$pdf->Output('D', 'Factura.pdf');
