<?php
// Iniciar el buffer de salida para capturar cualquier salida no deseada
ob_start();

require('../fpdf/fpdf.php'); // Asegúrate de que la ruta es correcta
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

$id = $_SESSION['usuario_id'];
$conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');

if ($conexion->connect_error) {
    die("No se pudo conectar a la base de datos: " . $conexion->connect_error);
}

// Recuperar factura_id de la sesión
$factura_id = $_SESSION["factura_id"] ?? null;
if (!$factura_id) {
    die("Error: Factura ID no encontrado en la sesión.");
}

$codigo = $_SESSION["cliente_id"] ?? null;
if (!$codigo) {
    die("Error: Código de cliente no encontrado en la sesión.");
}

// Datos del vendedor
$consulta = "SELECT * FROM usuario WHERE identificacion = ?";
$stmt = $conexion->prepare($consulta);
$stmt->bind_param("s", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("Vendedor no encontrado.");
}
$usuario = $resultado->fetch_assoc();
$nombre = $usuario['nombre'];
$apellido = $usuario['apellido'];

// Datos del cliente
$consulta = "SELECT * FROM cliente WHERE codigo = ?";
$stmt = $conexion->prepare($consulta);
$stmt->bind_param("s", $codigo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("Cliente no encontrado.");
}
$cliente = $resultado->fetch_assoc();
$nombreCliente = $cliente['nombre'];
$apellidoCliente = $cliente['apellido'];
$telefono = $cliente['telefono'];
$identificacion = $cliente['codigo'];

// Obtener productos de la factura
$productos = [];
$totalBruto = 0;
$consulta = "SELECT pf.cantidad, pf.precioUnitario, p.nombre 
             FROM producto_factura pf
             JOIN producto p ON pf.Producto_codigo = p.codigo1
             WHERE pf.Factura_codigo = ?";
$stmt = $conexion->prepare($consulta);
$stmt->bind_param("i", $factura_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("No se encontraron productos para esta factura.");
}

while ($fila = $resultado->fetch_assoc()) {
    $productos[] = $fila;
    $totalBruto += $fila['cantidad'] * $fila['precioUnitario'];
}

// Cálculo de impuestos
$ivaPorcentaje = 19;
$base = $totalBruto / (1 + ($ivaPorcentaje / 100));
$impuesto = $totalBruto - $base;

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Encabezado
$pdf->Image('../imagenes/LOGO.png', 10, 10, 30);
$pdf->Cell(190, 10, 'Factura', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 10, "Fecha: " . date('d/m/Y H:i'), 0, 1, 'R');
$pdf->Ln(5);

// Datos del Cliente
$pdf->Cell(100, 10, "Cliente: $nombreCliente $apellidoCliente", 0, 1);
$pdf->Cell(100, 10, "Telefono: $telefono", 0, 1);
$pdf->Cell(100, 10, "C.C/NIT: $identificacion", 0, 1);
$pdf->Ln(5);

// Datos del Vendedor
$pdf->Cell(100, 10, "Vendedor: $nombre $apellido", 0, 1);
$pdf->Ln(5);

// Tabla de Productos
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 10, "Cantidad", 1);
$pdf->Cell(50, 10, "Producto", 1);
$pdf->Cell(40, 10, "Vr. Unitario", 1);
$pdf->Cell(40, 10, "Subtotal", 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
foreach ($productos as $prod) {
    $precio = $prod['precioUnitario'] ?? 0; // Usar 0 si el precio es null
    $subtotal = $prod['cantidad'] * $precio;
    $pdf->Cell(30, 10, $prod['cantidad'], 1);
    $pdf->Cell(50, 10, $prod['nombre'], 1);
    $pdf->Cell(40, 10, '$' . number_format($precio, 2), 1);
    $pdf->Cell(40, 10, '$' . number_format($subtotal, 2), 1);
    $pdf->Ln();
}

// Totales
$pdf->Ln(5);
$pdf->Cell(100, 10, "Subtotal: $" . number_format($base, 2), 0, 1);
$pdf->Cell(100, 10, "IVA ($ivaPorcentaje%): $" . number_format($impuesto, 2), 0, 1);
$pdf->Cell(100, 10, "Total a pagar: $" . number_format($totalBruto, 2), 0, 1);

// Mensaje de agradecimiento (corregido)
$pdf->Ln(10);
$pdf->Cell(190, 10, iconv('UTF-8', 'ISO-8859-1', "¡Gracias por su compra!"), 0, 1, 'C');

// Limpiar el búfer de salida y descargar el PDF
ob_end_clean(); // Limpiar el búfer de salida
$pdf->Output('D', 'Factura.pdf');
?>