<?php
session_start();
date_default_timezone_set('America/Bogota');
// Mostrar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Autorización
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

// Conexión y rutas
$dbHost   = 'localhost';
$dbName   = 'inventariomotoracer';
$dbUser   = 'root';
$dbPass   = '';

// Directorio de backups, relativo a este includes/
$backupDir = dirname(__DIR__) . '/backups/';

// Asegura existencia
if (!is_dir($backupDir) && !mkdir($backupDir, 0755, true)) {
    http_response_code(500);
    echo json_encode([
      'success' => false,
      'message' => "No se pudo crear directorio de backups en $backupDir"
    ]);
    exit;
}


// Nombres de archivo
$timestamp = date('Ymd_His');
$sqlFile   = "{$backupDir}{$dbName}_{$timestamp}.sql";
$zipFile   = "{$backupDir}{$dbName}_{$timestamp}.zip";

// Ruta a mysqldump (usa forward‑slashes que PHP entiende bien)
$mysqldump = 'C:/xampp/mysql/bin/mysqldump.exe';

// Construcción del comando usando -u y -p"" para password (aquí vacío)
$dumpCommand = sprintf(
    '"%s" -u %s -p"%s" -h %s %s > "%s" 2>&1',
    $mysqldump,
    $dbUser,
    $dbPass,
    $dbHost,
    $dbName,
    $sqlFile
);

// Ejecutar el comando
exec($dumpCommand, $output, $returnVar);

// Depuración completa si algo falla
if ($returnVar !== 0) {
    http_response_code(500);
    echo json_encode([
        'success'    => false,
        'message'    => 'Error al exportar la base de datos.',
        'returnCode' => $returnVar,
        'command'    => $dumpCommand,
        'debug'      => $output
    ]);
    exit;
}

// Crear ZIP
$zip = new ZipArchive();
if ($zip->open($zipFile, ZipArchive::CREATE) !== true) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'No se pudo crear el ZIP.']);
    exit;
}
$zip->addFile($sqlFile, basename($sqlFile));
$zip->close();

// Opcional: eliminar .sql
unlink($sqlFile);

// Responder JSON
echo json_encode([
    'success'  => true,
    'filename' => basename($zipFile),
    'size'     => filesize($zipFile),
    'date'     => date('Y-m-d H:i:s'),
]);
