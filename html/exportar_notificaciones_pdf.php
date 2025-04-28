<?php
require('../fpdf/fpdf.php'); // Asegúrate de tener bien la ruta hacia fpdf.php

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

class PDF extends FPDF
{
    function Header()
    {
        // Título
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Lista de Notificaciones', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer()
    {
        // Número de página
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Crear PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Encabezados
$pdf->SetFillColor(200, 200, 200); // Color de fondo gris claro
$pdf->Cell(90, 10, 'Mensaje', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Fecha', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Estado', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);

// Consulta eliminando repetidos
$resultado = mysqli_query($conexion, "SELECT DISTINCT mensaje, fecha, leida FROM notificaciones ORDER BY fecha DESC");

while ($row = mysqli_fetch_assoc($resultado)) {
    $estado = $row['leida'] ? 'Leída' : 'No leída';

    $pdf->Cell(90, 8, mb_convert_encoding($row['mensaje'], 'ISO-8859-1', 'UTF-8'), 1);
    $pdf->Cell(50, 8, $row['fecha'], 1, 0, 'C');
    $pdf->Cell(40, 8, $estado, 1, 1, 'C');
}


// Salida del PDF
$pdf->Output('D', 'notificaciones.pdf');
?>
