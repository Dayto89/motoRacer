<?php
require_once '../vendor/autoload.php'; // Asegúrate de tener PhpSpreadsheet instalado

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezados
$encabezados = ['Mensaje', 'Fecha', 'Estado'];
$columnas = ['A', 'B', 'C'];

foreach ($encabezados as $i => $titulo) {
    $columna = $columnas[$i];
    $sheet->setCellValue("{$columna}1", $titulo);
}

// Consulta única
$resultado = mysqli_query($conexion, "SELECT DISTINCT mensaje, fecha, leida FROM notificaciones ORDER BY fecha DESC");
$fila = 2;

while ($row = mysqli_fetch_assoc($resultado)) {
    $sheet->setCellValue('A' . $fila, $row['mensaje']);
    $sheet->setCellValue('B' . $fila, $row['fecha']);
    $sheet->setCellValue('C' . $fila, $row['leida'] ? 'Leída' : 'No leída');
    $fila++;
}

// Aplicar formato
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => 'FF000000'],
        ],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
    ],
];

// Estilo para encabezados
$headerStyle = [
    'font' => [
        'bold' => true,
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FFCCCCCC',
        ],
    ],
];

$sheet->getStyle('A1:C1')->applyFromArray($headerStyle);
$sheet->getStyle('A1:C' . ($fila - 1))->applyFromArray($styleArray);

// Autoajustar ancho de columnas
foreach ($columnas as $columna) {
    $sheet->getColumnDimension($columna)->setAutoSize(true);
}

// Agregar filtro
$sheet->setAutoFilter("A1:C" . ($fila - 1));

// Descargar archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="notificaciones.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
?>
