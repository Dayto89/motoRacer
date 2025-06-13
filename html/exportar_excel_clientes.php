<?php
require '../vendor/autoload.php'; // Asegúrate de que esto esté bien ubicado según tu estructura

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

// Consulta los datos
$query = "SELECT codigo, identificacion, nombre, apellido, telefono, correo FROM cliente";
$res = mysqli_query($conexion, $query);
if (!$res) {
    die("Error al obtener datos: " . mysqli_error($conexion));
}

// Crear el Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Títulos
$headers = ['Codigo', 'Identificación', 'Nombre', 'Apellido', 'Teléfono', 'Correo'];
$sheet->fromArray($headers, null, 'A1');

// Estilo de encabezado
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF']
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '4CAF50'] 
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
];

$sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

// Agregar los datos desde fila 2
$rowNum = 2;
while ($row = mysqli_fetch_assoc($res)) {
    $sheet->fromArray(array_values($row), null, 'A' . $rowNum);
    $rowNum++;
}

// Aplicar bordes a todo el contenido
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
];
$sheet->getStyle('A1:F' . ($rowNum - 1))->applyFromArray($styleArray);

// Auto ajustar ancho de columnas
foreach (range('A', 'F') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Cabeceras para descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="clientes_' . date('Ymd_His') . '.xlsx"');
header('Cache-Control: max-age=0');

// Exportar
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
