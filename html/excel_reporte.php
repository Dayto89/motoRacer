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

// 1) Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// 2) Consulta para obtener datos de facturas
$consulta = "
    SELECT 
        f.codigo,
        f.fechaGeneracion,
        f.nombreUsuario,
        f.apellidoUsuario,
        f.nombreCliente,
        f.apellidoCliente,
        f.telefonoCliente,
        f.identificacionCliente,
        f.precioTotal,
        GROUP_CONCAT(DISTINCT m.metodoPago SEPARATOR ', ') AS metodoPago
    FROM 
        factura f
    LEFT JOIN factura_metodo_pago m ON m.Factura_codigo = f.codigo
    GROUP BY 
        f.codigo,
        f.fechaGeneracion,
        f.nombreUsuario,
        f.apellidoUsuario,
        f.nombreCliente,
        f.apellidoCliente,
        f.telefonoCliente,
        f.identificacionCliente,
        f.precioTotal
    ORDER BY f.fechaGeneracion DESC
";
$resultado = mysqli_query($conexion, $consulta);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// 3) Crear y configurar la hoja de cálculo
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// ——— Ajustes de ancho de columnas ———
// Columna A más ancha para logo si fuera necesario
$sheet->getColumnDimension('A')->setWidth(25);
// Columna I reservada para el logo (aunque no contenga datos de tabla)
$sheet->getColumnDimension('I')->setWidth(25);

// ——— Reservar espacio en filas 1–4 ———
$sheet->getRowDimension(1)->setRowHeight(25);
$sheet->getRowDimension(2)->setRowHeight(25);
$sheet->getRowDimension(3)->setRowHeight(20);
$sheet->getRowDimension(4)->setRowHeight(20);

// ——— Insertar logo de la empresa en I1 ———
$drawing = new Drawing();
$drawing->setName('Logo Moto Racer');
$drawing->setDescription('Logo Moto Racer');
$drawing->setPath(__DIR__ . '/../imagenes/logo.webp'); // Ajusta la ruta
$drawing->setHeight(80);
$drawing->setOffsetX(50);
$drawing->setOffsetY(10);
$drawing->setCoordinates('H1');
$drawing->setWorksheet($sheet);

// ——— Bloque de datos de la empresa ———
$sheet->mergeCells('A1:H1');
$sheet->setCellValue('A1', 'Moto Racer.');
$sheet->mergeCells('A2:H2');
$sheet->setCellValue('A2', 'Calle 40 N 6 - 50, Ciudad, Yopal');
$sheet->mergeCells('A3:H3');
$sheet->setCellValue('A3', 'Tel: 3102572023   •   contacto@motoracer.com.co');

$sheet->getStyle('A1:H4')->applyFromArray([
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

// 4) Definir fila de inicio de la tabla (dejamos fila 4 como separador)
$startRow = 5;

// 5) Encabezados de la tabla de facturas
$headers = [
    'Código', 'Fecha Generación', 'Vendedor',
    'Cliente', 'Teléfono Cliente', 'Cédula Cliente',
    'Total', 'Método(s) de Pago'
];
$sheet->fromArray($headers, null, "A{$startRow}");

// 5.1) Estilo para los encabezados
$sheet->getStyle("A{$startRow}:H{$startRow}")->applyFromArray([
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '3C89BE']],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '2E7D32']]],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical'   => Alignment::VERTICAL_CENTER,
    ],
]);
$sheet->getRowDimension($startRow)->setRowHeight(22);

// 6) Volcar datos de la consulta a partir de la fila siguiente
$row = $startRow + 1;
while ($fila = mysqli_fetch_assoc($resultado)) {
    $sheet->setCellValue("A{$row}", $fila['codigo']                ?? 'N/A');
    $sheet->setCellValue("B{$row}", $fila['fechaGeneracion']       ?? 'N/A');
    $sheet->setCellValue("C{$row}", trim(($fila['nombreUsuario']   ?? '') . ' ' . ($fila['apellidoUsuario'] ?? '')) ?: 'N/A');
    $sheet->setCellValue("D{$row}", trim(($fila['nombreCliente']   ?? '') . ' ' . ($fila['apellidoCliente'] ?? '')) ?: 'N/A');
    $sheet->setCellValue("E{$row}", $fila['telefonoCliente']      ?? 'N/A');
    $sheet->setCellValue("F{$row}", $fila['identificacionCliente']?? 'N/A');
    $sheet->setCellValue("G{$row}", $fila['precioTotal'] !== null ? number_format($fila['precioTotal']) : '0');
    $sheet->setCellValue("H{$row}", $fila['metodoPago']            ?? 'N/A');
    $row++;
}

// 7) Autoajustar columnas A–H y aplicar bordes ligeros a todo el rango
foreach (range('A', 'H') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}
$lastRow = $row - 1;
$sheet->getStyle("A{$startRow}:H{$lastRow}")
      ->getBorders()->getAllBorders()
      ->setBorderStyle(Border::BORDER_THIN)
      ->getColor()->setRGB('CCCCCC');

// 8) Centrar verticalmente todos los datos
$sheet->getStyle("A1:H{$lastRow}")
      ->getAlignment()
      ->setVertical(Alignment::VERTICAL_CENTER);

// 9) Descargar el archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte_Facturas.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
