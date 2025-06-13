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

// Conexión
$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Construir filtros (opcional, si deseas exportar la misma vista filtrada)
$filtros = [];
if (!empty($_GET['criterios']) && isset($_GET['valor'])) {
    $valor = mysqli_real_escape_string($conexion, $_GET['valor']);
    foreach ($_GET['criterios'] as $c) {
        $c = mysqli_real_escape_string($conexion, $c);
        $filtros[] = match($c) {
            'nit' => "p.nit LIKE '%$valor%'",
            'nombre' => "p.nombre LIKE '%$valor%'",
            'telefono' => "p.telefono LIKE '%$valor%'",
            'direccion' => "p.direccion LIKE '%$valor%'",
            'correo' => "p.correo LIKE '%$valor%'",
            default => null
        };
    }
}

// Consulta principal
$sql = "SELECT nit, nombre, telefono, direccion, correo FROM proveedor";
if ($filtros) {
    $sql .= " WHERE " . implode(' OR ', array_filter($filtros));
}
$res = mysqli_query($conexion, $sql);
if (!$res) {
    die("Error en consulta: " . mysqli_error($conexion));
}

// Crear spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezados
$headers = ['NIT', 'Nombre', 'Teléfono', 'Dirección', 'Correo'];
$sheet->fromArray($headers, null, 'A1');

// Estilos encabezado
$style = [
    'font' => ['bold' => true, 'color' => ['rgb'=>'FFFFFF'], 'size'=>12],
    'fill' => ['fillType'=>Fill::FILL_SOLID, 'startColor'=>['rgb'=>'4CAF50']],
    'borders' => ['allBorders'=>['borderStyle'=>Border::BORDER_THIN]],
    'alignment' => ['horizontal'=>Alignment::HORIZONTAL_CENTER]
];
$sheet->getStyle('A1:E1')->applyFromArray($style);

// Volcar datos
$row = 2;
while ($prov = mysqli_fetch_assoc($res)) {
    $sheet->setCellValue("A{$row}", $prov['nit']);
    $sheet->setCellValue("B{$row}", $prov['nombre']);
    $sheet->setCellValue("C{$row}", $prov['telefono']);
    $sheet->setCellValue("D{$row}", $prov['direccion']);
    $sheet->setCellValue("E{$row}", $prov['correo']);
    $row++;
}

// Auto-width y bordes
foreach (range('A', 'E') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}
$sheet->getStyle("A1:E".($row-1))
      ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

// Enviar al navegador
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Proveedores.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
