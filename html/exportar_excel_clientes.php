<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// Conexión
$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

// Consulta
$query = "SELECT codigo, identificacion, nombre, apellido, telefono, correo FROM cliente";
$res = mysqli_query($conexion, $query);
if (!$res) {
    die("Error al obtener datos: " . mysqli_error($conexion));
}

// Crear hoja de cálculo
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Ajustar alto de filas para cabecera y espacio
$sheet->getRowDimension(1)->setRowHeight(25);
$sheet->getRowDimension(2)->setRowHeight(25);
$sheet->getRowDimension(3)->setRowHeight(20);
$sheet->getRowDimension(4)->setRowHeight(20);

// Insertar logo
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setDescription('Logo de Moto Racer');
$drawing->setPath(__DIR__ . '/../imagenes/logo.webp'); // Ajusta la ruta
$drawing->setHeight(80);
$drawing->setOffsetX(50);
$drawing->setOffsetY(10);
$drawing->setCoordinates('F1');
$drawing->setWorksheet($sheet);

// Información de la empresa
$sheet->mergeCells('A1:F1');
$sheet->setCellValue('A1', 'Moto Racer.');
$sheet->mergeCells('A2:F2');
$sheet->setCellValue('A2', 'Calle 40 N 6 - 50, Ciudad, Yopal');
$sheet->mergeCells('A3:F3');
$sheet->setCellValue('A3', 'Tel: 3102572023   •   contacto@motoracer.com.co');

$sheet->getStyle('A1:F4')->applyFromArray([
    'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => [
        'fillType'   => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '3C89BE'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_LEFT,
        'vertical'   => Alignment::VERTICAL_CENTER,
    ],
]);

// Encabezado de tabla (fila 5)
$headers = ['Código', 'Identificación', 'Nombre', 'Apellido', 'Teléfono', 'Correo'];
$sheet->fromArray($headers, null, 'A5');

// Estilo de encabezado
$sheet->getStyle('A5:F5')->applyFromArray([
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '3C89BE']],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '2E7D32']]],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
]);

// Insertar datos desde fila 6
$rowNum = 6;
while ($row = mysqli_fetch_assoc($res)) {
    $sheet->setCellValue('A' . $rowNum, $row['codigo']);
    $sheet->setCellValue('B' . $rowNum, $row['identificacion']);
    $sheet->setCellValue('C' . $rowNum, $row['nombre']);
    $sheet->setCellValue('D' . $rowNum, $row['apellido']);
    $sheet->setCellValue('E' . $rowNum, $row['telefono']);
    $sheet->setCellValue('F' . $rowNum, $row['correo']);
    $rowNum++;
}

// Bordes para todo el contenido de la tabla
$sheet->getStyle('A5:F' . ($rowNum - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('CCCCCC');

// Autoajustar columnas
foreach (range('A', 'F') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Exportar
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="clientes_' . date('Ymd_His') . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
