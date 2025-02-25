<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');

if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Consulta para obtener datos
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
        p.descripcion,
        c.nombre AS categoria,
        m.nombre AS marca,
        u.nombre AS unidadmedida,
        ub.nombre AS ubicacion,
        pr.nombre AS proveedor
    FROM 
        producto p
    LEFT JOIN 
        categoria c ON p.Categoria_codigo = c.codigo
    LEFT JOIN 
        marca m ON p.Marca_codigo = m.codigo
    LEFT JOIN 
        unidadmedida u ON p.UnidadMedida_codigo = u.codigo
    LEFT JOIN 
        ubicacion ub ON p.Ubicacion_codigo = ub.codigo
    LEFT JOIN 
        proveedor pr ON p.proveedor_nit = pr.nit
";

$resultado = mysqli_query($conexion, $consulta);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Crear hoja de Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezados
$encabezados = ['Código', 'Código 2', 'Nombre', 'IVA', 'Precio 1', 'Precio 2', 'Precio 3', 'Cantidad', 'Descripción', 'Categoría', 'Marca', 'Unidad Medida', 'Ubicación', 'Proveedor'];
$sheet->fromArray($encabezados, NULL, 'A1');

// Estilos para encabezados
$styleEncabezado = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
];
$sheet->getStyle('A1:N1')->applyFromArray($styleEncabezado);

// Insertar datos desde la base de datos
$filaExcel = 2; // Empieza en la fila 2
while ($fila = mysqli_fetch_assoc($resultado)) {
    $sheet->setCellValue('A' . $filaExcel, $fila['codigo1'] ?? 'N/A');
    $sheet->setCellValue('B' . $filaExcel, $fila['codigo2'] ?? 'N/A');
    $sheet->setCellValue('C' . $filaExcel, $fila['nombre'] ?? 'N/A');
    $sheet->setCellValue('D' . $filaExcel, $fila['iva'] ?? 'N/A');
    $sheet->setCellValue('E' . $filaExcel, $fila['precio1'] ?? 'N/A');
    $sheet->setCellValue('F' . $filaExcel, $fila['precio2'] ?? 'N/A');
    $sheet->setCellValue('G' . $filaExcel, $fila['precio3'] ?? 'N/A');
    $sheet->setCellValue('H' . $filaExcel, $fila['cantidad'] ?? 'N/A');
    $sheet->setCellValue('I' . $filaExcel, $fila['descripcion'] ?? 'N/A');
    $sheet->setCellValue('J' . $filaExcel, $fila['categoria'] ?? 'N/A');
    $sheet->setCellValue('K' . $filaExcel, $fila['marca'] ?? 'N/A');
    $sheet->setCellValue('L' . $filaExcel, $fila['unidadmedida'] ?? 'N/A');
    $sheet->setCellValue('M' . $filaExcel, $fila['ubicacion'] ?? 'N/A');
    $sheet->setCellValue('N' . $filaExcel, $fila['proveedor'] ?? 'N/A');
    $filaExcel++;
}

// Ajuste automático de ancho de columnas
foreach (range('A', 'N') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Bordes para todo el contenido
$sheet->getStyle('A1:N' . ($filaExcel - 1))
    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

// Descargar el archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Inventario.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
