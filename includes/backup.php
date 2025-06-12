<?php
session_start();
date_default_timezone_set('America/Bogota');
// Habilitar reporte completo de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Verifica que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

// Parámetros de conexión y rutas
$dbHost   = 'localhost';
$dbName   = 'inventariomotoracer';
$dbUser   = 'root';
$dbPass   = '';
$backupDir = __DIR__ . '/../backups/';

// Asegura que exista el directorio
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
}

// Nombre de archivo con timestamp
$timestamp = date('Ymd_His');
$sqlFile   = "{$backupDir}{$dbName}_{$timestamp}.sql";
$zipFile   = "{$backupDir}{$dbName}_{$timestamp}.zip";

// Comando mysqldump
$dumpCommand = sprintf(
    'mysqldump --user=%s --password=%s --host=%s %s > %s',
    escapeshellarg($dbUser),
    escapeshellarg($dbPass),
    escapeshellarg($dbHost),
    escapeshellarg($dbName),
    escapeshellarg($sqlFile)
);

// Ejecuta mysqldump
exec($dumpCommand, $output, $returnVar);
if ($returnVar !== 0) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al exportar la base de datos.']);
    exit;
}

// Empaqueta el .sql en un ZIP
$zip = new ZipArchive();
if ($zip->open($zipFile, ZipArchive::CREATE) !== true) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'No se pudo crear el ZIP.']);
    exit;
}
$zip->addFile($sqlFile, basename($sqlFile));
$zip->close();

// Borra el .sql si sólo quieres el ZIP, o déjalo si quieres ambos
unlink($sqlFile);

// Devuelve JSON de éxito
echo json_encode([
    'success' => true,
    'filename' => basename($zipFile),
    'size'     => filesize($zipFile),
    'date'     => date('Y-m-d H:i:s'),
]);
