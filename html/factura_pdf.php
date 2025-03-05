<?php
require('../fpdf/fpdf.php'); // Asegúrate de que la ruta es correcta
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
$codigo = 123; // Este código debería recibirse por GET o POST
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
$consulta = "SELECT * FROM ventas WHERE cliente_codigo = '$codigo'";
$resultado = mysqli_query($conexion, $consulta);

while ($fila = mysqli_fetch_assoc($resultado)) {
    $productos[] = $fila;
    $totalBruto += $fila['cantidad'] * $fila['precio'];
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

// Tabla de Productos
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 10, "Cantidad", 1);
$pdf->Cell(50, 10, "Producto", 1);
$pdf->Cell(40, 10, "Vr. Unitario", 1);
$pdf->Cell(40, 10, "Subtotal", 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
foreach ($productos as $prod) {
    $subtotal = $prod['cantidad'] * $prod['precio'];
    $pdf->Cell(30, 10, $prod['cantidad'], 1);
    $pdf->Cell(50, 10, $prod['nombre'], 1);
    $pdf->Cell(40, 10, '$' . number_format($prod['precio'], 2), 1);
    $pdf->Cell(40, 10, '$' . number_format($subtotal, 2), 1);
    $pdf->Ln();
}

// Totales
$pdf->Ln(5);
$pdf->Cell(100, 10, "Subtotal: $" . number_format($base, 2), 0, 1);
$pdf->Cell(100, 10, "IVA ($ivaPorcentaje%): $" . number_format($impuesto, 2), 0, 1);
$pdf->Cell(100, 10, "Total a pagar: $" . number_format($totalBruto, 2), 0, 1);

// Descargar el PDF
$pdf->Output('D', 'Factura.pdf');
?>
