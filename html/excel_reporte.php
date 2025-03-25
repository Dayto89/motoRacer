<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

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
        f.codigo,
        f.fechaGeneracion,
        f.Usuario_identificacion,
        f.Cliente_codigo,
        f.precioTotal,
        c.nombre AS cliente_nombre,
        c.apellido AS cliente_apellido,
        n.nombre AS usuario_nombre,
        n.apellido AS usuario_apellido,
        GROUP_CONCAT(m.metodoPago SEPARATOR ', ') AS metodoPago
    FROM 
        factura f
    LEFT JOIN 
        factura_metodo_pago m ON m.Factura_codigo = f.codigo
    LEFT JOIN
        cliente c ON c.codigo = f.Cliente_codigo
    LEFT JOIN
       usuario n ON n.identificacion = f.Usuario_identificacion
    GROUP BY 
        f.codigo, f.fechaGeneracion, f.Usuario_identificacion, f.Cliente_codigo, f.precioTotal,         c.nombre, 
        c.apellido, 
        n.nombre, 
        n.apellido 
";

$resultado = mysqli_query($conexion, $consulta);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Crear hoja de Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezados
$encabezados = ['Código', 'Fecha Generacion', 'Usuario Identificacion', 'Cliente Codigo', 'Precio Total'];
$sheet->fromArray($encabezados, NULL, 'A1');

// Estilos para encabezados
$styleEncabezado = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
];
$sheet->getStyle('A1:E1')->applyFromArray($styleEncabezado);

// Insertar datos desde la base de datos
$filaExcel = 2; // Empieza en la fila 2
while ($fila = mysqli_fetch_assoc($resultado)) {
    $sheet->setCellValue('A' . $filaExcel, $fila['codigo'] ?? 'N/A');
    $sheet->setCellValue('B' . $filaExcel, $fila['fechaGeneracion'] ?? 'N/A');
    $sheet->setCellValue('C' . $filaExcel, ($fila['usuario_nombre'] ?? 'N/A') . ' ' . ($fila['usuario_apellido'] ?? 'N/A'));
    $sheet->setCellValue('D' . $filaExcel, ($fila['cliente_nombre'] ?? 'N/A') . ' ' . ($fila['cliente_apellido'] ?? 'N/A'));

    $sheet->setCellValue('E' . $filaExcel, $fila['precioTotal'] ?? 'N/A');

    $filaExcel++;
}

// Ajuste automático de ancho de columnas
foreach (range('A', 'E') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Bordes para todo el contenido
$sheet->getStyle('A1:E' . ($filaExcel - 1))
    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

// Descargar el archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Inventario.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
