<?php
require('../fpdf/tfpdf.php'); // Ajusta la ruta si es necesario

// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
mysqli_set_charset($conexion, 'utf8mb4');

class PDF extends tFPDF
{
    function Header()
    {
        // Cargar la fuente DejaVuSans
        $this->AddFont('DejaVuSans', '', 'DejaVuSans.php');
        $this->AddFont('DejaVuSans', 'B', 'DejaVuSans-Bold.php');
        $this->Cell(0, 10, 'Lista de Notificaciones', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('DejaVuSans', '', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    // Calcula cuántas líneas caben en ancho w
    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb-1] == "\n") $nb--;
        $sep = -1; $i = 0; $j = 0; $l = 0; $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++; $sep = -1; $j = $i; $l = 0; $nl++; continue;
            }
            if ($c == ' ') $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) $i++;
                } else {
                    $i = $sep + 1;
                }
                $sep = -1; $j = $i; $l = 0; $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }

    // Salto de página si no cabe h
    function CheckPageBreak($h)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->AddFont('DejaVuSans', '', 'DejaVuSans.php');
$pdf->SetFont('DejaVuSans', 'B', 'DejaVuSans-Bold.php'); // Usar negrita si está disponible

// Encabezados
$pdf->SetFillColor(200, 200, 200);
$pdf->Cell(90, 10, 'Mensaje', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Fecha', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Estado', 1, 1, 'C', true);

$pdf->SetFont('DejaVuSans', '', 10);

$resultado = mysqli_query(
    $conexion,
    "SELECT DISTINCT mensaje, fecha, leida
     FROM notificaciones
     ORDER BY fecha DESC"
);

while ($row = mysqli_fetch_assoc($resultado)) {
    $mensaje = $row['mensaje'];
    $fecha = $row['fecha'];
    $estado = $row['leida'] ? 'Leída' : 'No leída';

    $nb = $pdf->NbLines(90, $mensaje);
    $h = 8 * $nb;

    $pdf->CheckPageBreak($h);

    $x = $pdf->GetX();
    $y = $pdf->GetY();

    $pdf->MultiCell(90, 8, $mensaje, 1);
    $pdf->SetXY($x + 90, $y);
    $pdf->Cell(50, $h, $fecha, 1, 0, 'C');
    $pdf->Cell(40, $h, $estado, 1, 1, 'C');
}

$pdf->Output('D', 'notificaciones.pdf');
exit;
?>