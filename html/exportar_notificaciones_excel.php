<?php
require_once '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Crear hoja
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Altura para logo y cabecera
$sheet->getRowDimension(1)->setRowHeight(25);
$sheet->getRowDimension(2)->setRowHeight(25);
$sheet->getRowDimension(3)->setRowHeight(20);

// Insertar logo
$drawing = new Drawing();
$drawing->setName('Logo Moto Racer');
$drawing->setDescription('Logo');
$drawing->setPath(__DIR__ . '/../imagenes/logo.webp'); // Ajusta ruta
$drawing->setHeight(80);
$drawing->setOffsetX(50);
$drawing->setOffsetY(10);
$drawing->setCoordinates('B1'); // Más a la derecha si hay pocas columnas
$drawing->setWorksheet($sheet);

// Encabezado corporativo
$sheet->mergeCells('A1:C1');
$sheet->setCellValue('A1', 'Moto Racer S.A.S.');
$sheet->mergeCells('A2:C2');
$sheet->setCellValue('A2', 'Calle 40 N 6 - 50, Ciudad, Yopal');
$sheet->mergeCells('A3:C3');
$sheet->setCellValue('A3', 'Tel: 3102572023   •   contacto@motoracer.com.co');

$sheet->getStyle('A1:C4')->applyFromArray([
    'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '3C89BE'],
    ],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER],
]);

// Encabezados
$encabezados = ['Mensaje', 'Fecha', 'Estado'];
$columnas = ['A', 'B', 'C'];

$sheet->fromArray($encabezados, null, 'A5');

$sheet->getStyle('A5:C5')->applyFromArray([
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '3C89BE']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
]);

// Datos
$resultado = mysqli_query($conexion, "SELECT DISTINCT mensaje, fecha, leida FROM notificaciones ORDER BY fecha DESC");
$fila = 6;

while ($row = mysqli_fetch_assoc($resultado)) {
    $sheet->setCellValue('A' . $fila, $row['mensaje']);
    $sheet->setCellValue('B' . $fila, $row['fecha']);
    $sheet->setCellValue('C' . $fila, $row['leida'] ? 'Leída' : 'No leída');
    $fila++;
}

// Bordes y estilos generales
$sheet->getStyle("A5:C" . ($fila - 1))->applyFromArray([
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '999999']]],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
]);

// Autoajuste
foreach ($columnas as $columna) {
    $sheet->getColumnDimension($columna)->setAutoSize(true);
}

// Filtro
$sheet->setAutoFilter("A5:C" . ($fila - 1));

// Descargar
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="notificaciones_' . date('Ymd_His') . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
