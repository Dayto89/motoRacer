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

// --------------------------------------------------
// 1) Consulta para obtener los datos de facturas, usando los campos internos en factura
// --------------------------------------------------
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
    LEFT JOIN 
        factura_metodo_pago m ON m.Factura_codigo = f.codigo
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
    ORDER BY 
        f.fechaGeneracion DESC
";

$resultado = mysqli_query($conexion, $consulta);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// --------------------------------------------------
// 2) Creamos y configuramos la hoja de cálculo
// --------------------------------------------------
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// 2.1) Definir encabezados en la primera fila
$encabezados = [
    'A1' => 'Código',
    'B1' => 'Fecha Generación',
    'C1' => 'Vendedor',
    'D1' => 'Cliente',
    'E1' => 'Teléfono Cliente',
    'F1' => 'Cédula Cliente',
    'G1' => 'Total',
    'H1' => 'Método(s) de Pago'
];
// Colocar valores de encabezado
foreach ($encabezados as $celda => $texto) {
    $sheet->setCellValue($celda, $texto);
}

// 2.2) Estilos para encabezados (fila 1)
$styleEncabezado = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'],
        'size' => 12
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '4CAF50']
    ],
    'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical'   => Alignment::VERTICAL_CENTER,
    ],
];
// Aplicar estilo de encabezado desde A1 hasta H1
$sheet->getStyle('A1:H1')->applyFromArray($styleEncabezado);

// --------------------------------------------------
// 3) Insertar cada registro de la consulta en filas sucesivas
// --------------------------------------------------
$filaExcel = 2; // comenzamos en la fila 2
while ($fila = mysqli_fetch_assoc($resultado)) {
    // Columna A: Código
    $sheet->setCellValue('A' . $filaExcel, $fila['codigo'] ?? 'N/A');
    // Columna B: Fecha Generación
    $sheet->setCellValue('B' . $filaExcel, $fila['fechaGeneracion'] ?? 'N/A');
    // Columna C: Vendedor (nombreUsuario + apellidoUsuario)
    $nombreVendedor = trim(($fila['nombreUsuario'] ?? '') . ' ' . ($fila['apellidoUsuario'] ?? ''));
    $sheet->setCellValue('C' . $filaExcel, $nombreVendedor !== '' ? $nombreVendedor : 'N/A');
    // Columna D: Cliente (nombreCliente + apellidoCliente)
    $nombreCliente = trim(($fila['nombreCliente'] ?? '') . ' ' . ($fila['apellidoCliente'] ?? ''));
    $sheet->setCellValue('D' . $filaExcel, $nombreCliente !== '' ? $nombreCliente : 'N/A');
    // Columna E: Teléfono Cliente
    $sheet->setCellValue('E' . $filaExcel, $fila['telefonoCliente'] ?? 'N/A');
    // Columna F: Cédula Cliente
    $sheet->setCellValue('F' . $filaExcel, $fila['identificacionCliente'] ?? 'N/A');
    // Columna G: Total
    $sheet->setCellValue('G' . $filaExcel, $fila['precioTotal'] !== null ? number_format($fila['precioTotal']) : '0');
    // Columna H: Método(s) de Pago
    $sheet->setCellValue('H' . $filaExcel, $fila['metodoPago'] ?? 'N/A');

    $filaExcel++;
}

// --------------------------------------------------
// 4) Ajuste automático de ancho de columnas (A–H)
// --------------------------------------------------
foreach (range('A', 'H') as $columna) {
    $sheet->getColumnDimension($columna)->setAutoSize(true);
}

// --------------------------------------------------
// 5) Aplicar bordes a todo el rango de datos (incluyendo encabezado)
// --------------------------------------------------
$ultimaFila = $filaExcel - 1;
$rangoTotal = 'A1:H' . $ultimaFila;
$sheet->getStyle($rangoTotal)
      ->getBorders()
      ->getAllBorders()
      ->setBorderStyle(Border::BORDER_THIN);

// --------------------------------------------------
// 6) Centrar verticalmente todas las celdas del rango
// --------------------------------------------------
$sheet->getStyle($rangoTotal)
      ->getAlignment()
      ->setVertical(Alignment::VERTICAL_CENTER);

// --------------------------------------------------
// 7) Enviar headers para descargar el archivo Excel
// --------------------------------------------------
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte_Facturas.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
