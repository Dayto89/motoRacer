<?php
// exportar_notificaciones_pdf.php
// ---------------------------------------
// ¡OJO! No debe haber nada (ni espacios) antes de este tag.

// 1) Incluir FPDF “normal”
require('../fpdf/fpdf.php');

// 2) Conexión a la base de datos
$conexion = mysqli_connect('localhost','root','','inventariomotoracer');
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
mysqli_set_charset($conexion, 'utf8mb4');

// 3) Creamos una subclase para poder acceder a CurrentFont
class PDF extends FPDF
{
    // Calcula cuántas líneas caben en un ancho dado
    public function NbLines($w, $txt)
    {
        $cw = $this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1; $i = 0; $j = 0; $l = 0; $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++; $sep = -1; $j = $i; $l = 0; $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
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

    // Añade página si la altura h no cabe en la página actual
    public function CheckPageBreak($h)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage();
        }
    }
}

// 4) Inicializamos el PDF
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode('Lista de Notificaciones'), 0, 1, 'C');
$pdf->Ln(5);

// 5) Encabezados de la tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(200, 200, 200);
$alto = 8;
$pdf->Cell(90, $alto, utf8_decode('Mensaje'), 1, 0, 'C', true);
$pdf->Cell(50, $alto, utf8_decode('Fecha'),   1, 0, 'C', true);
$pdf->Cell(40, $alto, utf8_decode('Estado'),  1, 1, 'C', true);
$pdf->Ln(2);

// 6) Recogemos los registros de la base
$result = mysqli_query($conexion,
    "SELECT DISTINCT mensaje, fecha, leida
     FROM notificaciones
     ORDER BY fecha DESC"
);

// 7) Pintamos cada fila
$pdf->SetFont('Arial', '', 10);
while ($row = mysqli_fetch_assoc($result)) {
    $mensaje = $row['mensaje'];
    $fecha   = $row['fecha'];
    $estado  = $row['leida'] ? 'Leída' : 'No leída';

    // calculamos altura necesaria
    $nl = $pdf->NbLines(90, $mensaje);
    $h  = $alto * $nl;
    $pdf->CheckPageBreak($h);

    // coordenadas iniciales
    $x = $pdf->GetX();
    $y = $pdf->GetY();

    // celda de mensaje multiline
    $pdf->MultiCell(90, $alto, utf8_decode($mensaje), 1);

    // volvemos a la misma línea, desplazados en X
    $pdf->SetXY($x + 90, $y);
    $pdf->Cell(50, $h, utf8_decode($fecha),  1, 0, 'C');
    $pdf->Cell(40, $h, utf8_decode($estado), 1, 1, 'C');
}

// 8) Forzar descarga
$pdf->Output('D', 'notificaciones.pdf');
exit;
?>
