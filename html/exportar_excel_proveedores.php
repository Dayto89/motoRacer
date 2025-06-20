<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

require '../vendor/autoload.php';

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

// Construir filtros (opcional)…
$filtros = [];
if (!empty($_GET['criterios']) && isset($_GET['valor'])) {
    $valor = mysqli_real_escape_string($conexion, $_GET['valor']);
    foreach ($_GET['criterios'] as $c) {
        $c = mysqli_real_escape_string($conexion, $c);
        $filtros[] = match($c) {
            'nit'       => "p.nit LIKE '%$valor%'",
            'nombre'    => "p.nombre LIKE '%$valor%'",
            'telefono'  => "p.telefono LIKE '%$valor%'",
            'direccion' => "p.direccion LIKE '%$valor%'",
            'correo'    => "p.correo LIKE '%$valor%'",
            default     => null
        };
    }
}

// Consulta principal
$sql = "SELECT nit, nombre, telefono, direccion, correo FROM proveedor p";
if ($filtros) {
    $sql .= " WHERE " . implode(' OR ', array_filter($filtros));
}
$res = mysqli_query($conexion, $sql);
if (!$res) {
    die("Error en consulta: " . mysqli_error($conexion));
}

// Crear el spreadsheet y la hoja activa
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->getColumnDimension('A')->setWidth(25);

// ——— Reservar espacio para logo y datos de empresa ———
$sheet->getRowDimension(1)->setRowHeight(25); // fila para el logo
$sheet->getRowDimension(2)->setRowHeight(25);
$sheet->getRowDimension(3)->setRowHeight(20);
$sheet->getRowDimension(4)->setRowHeight(20);
$sheet->getRowDimension(5)->setRowHeight(15);
$sheet->getRowDimension(6)->setRowHeight(15);
$sheet->getRowDimension(7)->setRowHeight(20);

// ——— Insertar logo de la empresa ———
$drawing = new Drawing();
$drawing->setName('Logo Moto Racer');
$drawing->setDescription('Logo Moto Racer');
$drawing->setPath(__DIR__ . '/../imagenes/logo.webp');  // Ajusta ruta
$drawing->setHeight(100);
$drawing->setOffsetX(50);
$drawing->setOffsetY(10);
$drawing->setCoordinates('E1');
$drawing->setWorksheet($sheet);

// ——— Bloque de datos de la empresa con color de fondo ———
$sheet->mergeCells('A1:A1');
$sheet->setCellValue('A1', 'Moto Racer.');
$sheet->mergeCells('A2:A2');
$sheet->setCellValue('A2', 'Calle 40 N 6 - 50, Ciudad, Yopal');
$sheet->mergeCells('A3:E3');
$sheet->setCellValue('A3', 'Tel: 3102572023   •   contacto@motoracer.com.co');

$sheet->getStyle('A1:E4')->applyFromArray([
    'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb'=>'FFFFFF']],
    'fill' => [
        'fillType'   => Fill::FILL_SOLID,
        'startColor' => ['rgb'=>'3c89be'], // verde muy suave
    ],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER],
]);

// ——— Definir en qué fila empieza la tabla ———
$startRow = 5;

// Encabezados de la tabla de proveedores
$headers = ['NIT', 'Nombre', 'Teléfono', 'Dirección', 'Correo'];
$sheet->fromArray($headers, null, "A{$startRow}");

// Estilo para los encabezados
$sheet->getStyle("A{$startRow}:E{$startRow}")->applyFromArray([
    'font' => ['bold' => true, 'color' => ['rgb'=>'FFFFFF'], 'size'=>12],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb'=>'3c89be']],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color'=>['rgb'=>'2E7D32']]],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
]);
$sheet->getRowDimension($startRow)->setRowHeight(22);

// Volcar los datos de la consulta
$row = $startRow + 1;
while ($prov = mysqli_fetch_assoc($res)) {
    $sheet->setCellValue("A{$row}", $prov['nit']);
    $sheet->setCellValue("B{$row}", $prov['nombre']);
    $sheet->setCellValue("C{$row}", $prov['telefono']);
    $sheet->setCellValue("D{$row}", $prov['direccion']);
    $sheet->setCellValue("E{$row}", $prov['correo']);
    $row++;
}

// Ajustar ancho de columnas y bordes de todo el rango
foreach (range('A', 'E') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}
$sheet->getStyle("A{$startRow}:E" . ($row - 1))
      ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('CCCCCC');

// Enviar el archivo al navegador
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Proveedores.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
