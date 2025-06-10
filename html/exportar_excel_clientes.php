<?php
// exportClientes.php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);
error_log(__DIR__ . '/php_errors.log');

// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

// Cabeceras para forzar descarga CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=clientes_' . date('Ymd_His') . '.csv');

// Query todos los clientes
$query = "SELECT codigo, identificacion, nombre, apellido, telefono, correo FROM cliente";
$res   = mysqli_query($conexion, $query);

if (!$res) {
    die("Error al obtener datos: " . mysqli_error($conexion));
}

// Abrimos la salida “virtual”
$out = fopen('php://output', 'w');
// Escribimos fila de encabezados
fputcsv($out, ['Codigo','Identificacion','Nombre','Apellido','Telefono','Correo']);

// Recorremos los resultados y volcamos al CSV
while ($row = mysqli_fetch_assoc($res)) {
    fputcsv($out, [
        $row['codigo'],
        $row['identificacion'],
        $row['nombre'],
        $row['apellido'],
        $row['telefono'],
        $row['correo']
    ]);
}

fclose($out);
exit;
