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
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Consulta para obtener datos de inventario
$consulta = "
    SELECT 
        p.`codigo1`,
        p.`codigo2`,
        p.nombre,
        p.iva,
        p.`precio1`,
        p.`precio2`,
        p.`precio3`,
        p.cantidad,
        c.nombre AS categoria,
        m.nombre AS marca,
        u.nombre AS unidadmedida,
        ub.nombre AS ubicacion,
        pr.nombre AS proveedor
    FROM 
        producto p
    LEFT JOIN categoria c    ON p.Categoria_codigo    = c.codigo
    LEFT JOIN marca m        ON p.Marca_codigo        = m.codigo
    LEFT JOIN unidadmedida u ON p.UnidadMedida_codigo = u.codigo
    LEFT JOIN ubicacion ub   ON p.Ubicacion_codigo    = ub.codigo
    LEFT JOIN proveedor pr   ON p.proveedor_nit       = pr.nit
";
$resultado = mysqli_query($conexion, $consulta);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Crear spreadsheet y hoja activa
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// ——— Ajustes de ancho y alto para logo y cabecera ———
$sheet->getColumnDimension('A')->setWidth(25);
foreach (range(1, 7) as $r) {
    switch ($r) {
        case 1: $sheet->getRowDimension($r)->setRowHeight(25); break;
        case 2: $sheet->getRowDimension($r)->setRowHeight(25);  break;
        case 3: $sheet->getRowDimension($r)->setRowHeight(20);  break;
        default: $sheet->getRowDimension($r)->setRowHeight(15);
    }
}

// ——— Insertar logo ———
$drawing = new Drawing();
$drawing->setName('Logo Moto Racer');
$drawing->setDescription('Logo Moto Racer');
$drawing->setPath(__DIR__ . '/../imagenes/logo.webp'); // Ajusta según tu ruta
$drawing->setHeight(80);
$drawing->setOffsetX(10);
$drawing->setOffsetY(10);
$drawing->setCoordinates('L1');
$drawing->setWorksheet($sheet);

// ——— Bloque de datos de empresa coloreado ———
$sheet->mergeCells('A1:M1');
$sheet->setCellValue('A1', 'Moto Racer.');
$sheet->mergeCells('A2:M2');
$sheet->setCellValue('A2', 'Calle 40 N 6 - 50, Ciudad, Yopal');
$sheet->mergeCells('A3:M3');
$sheet->setCellValue('A3', 'Tel: 3102572023   •   contacto@motoracer.com.co');

$sheet->getStyle('A1:M4')->applyFromArray([
    'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb'=>'FFFFFF']],
    'fill' => [
        'fillType'   => Fill::FILL_SOLID,
        'startColor' => ['rgb'=>'3C89BE'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_LEFT,
        'vertical'   => Alignment::VERTICAL_CENTER
    ],
]);

// ——— Definir fila de inicio de la tabla ———
$startRow = 5;

// Encabezados de la tabla de inventario
$encabezados = [
    'Código', 'Código 2', 'Nombre', 'IVA', 'Precio 1', 'Precio 2', 
    'Precio 3', 'Cantidad', 'Categoría', 'Marca', 'Unidad', 'Ubicación', 'Proveedor'
];
$sheet->fromArray($encabezados, null, "A{$startRow}");

// Estilo de los encabezados
$sheet->getStyle("A{$startRow}:M{$startRow}")->applyFromArray([
    'font' => ['bold' => true, 'color' => ['rgb'=>'FFFFFF'], 'size'=>12],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb'=>'3C89BE']],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color'=>['rgb'=>'2E7D32']]],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical'   => Alignment::VERTICAL_CENTER
    ],
]);
$sheet->getRowDimension($startRow)->setRowHeight(22);

// Volcar datos a partir de la fila siguiente
$row = $startRow + 1;
while ($fila = mysqli_fetch_assoc($resultado)) {
    $sheet->setCellValue("A{$row}", $fila['codigo1']      ?? 'N/A');
    $sheet->setCellValue("B{$row}", $fila['codigo2']      ?? 'N/A');
    $sheet->setCellValue("C{$row}", $fila['nombre']       ?? 'N/A');
    $sheet->setCellValue("D{$row}", $fila['iva']          ?? 'N/A');
    $sheet->setCellValue("E{$row}", $fila['precio1']      ?? 'N/A');
    $sheet->setCellValue("F{$row}", $fila['precio2']      ?? 'N/A');
    $sheet->setCellValue("G{$row}", $fila['precio3']      ?? 'N/A');
    $sheet->setCellValue("H{$row}", $fila['cantidad']     ?? 'N/A');
    $sheet->setCellValue("I{$row}", $fila['categoria']    ?? 'N/A');
    $sheet->setCellValue("J{$row}", $fila['marca']        ?? 'N/A');
    $sheet->setCellValue("K{$row}", $fila['unidadmedida'] ?? 'N/A');
    $sheet->setCellValue("L{$row}", $fila['ubicacion']    ?? 'N/A');
    $sheet->setCellValue("M{$row}", $fila['proveedor']    ?? 'N/A');
    $row++;
}

// Autoajustar columnas y aplicar bordes ligeros al rango de datos
foreach (range('A', 'M') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}
$sheet->getStyle("A{$startRow}:M" . ($row - 1))
      ->getBorders()->getAllBorders()
      ->setBorderStyle(Border::BORDER_THIN)
      ->getColor()->setRGB('CCCCCC');

// Enviar el Excel al navegador
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Inventario.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
