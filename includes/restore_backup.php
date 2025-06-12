<?php
session_start();
date_default_timezone_set('America/Bogota');
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
  http_response_code(401);
  echo json_encode(['success'=>false,'message'=>'No autorizado']);
  exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$file = basename($data['file']);
$sqlFile = __DIR__ . '/../backups/' . $file;

if (!file_exists($sqlFile)) {
  http_response_code(404);
  echo json_encode(['success'=>false,'message'=>'Backup no encontrado']);
  exit;
}

// Configura tu conexión MySQL
$dbHost = 'localhost';
$dbName = 'inventariomotoracer';
$dbUser = 'root';
$dbPass = '';

// Ejecuta restauración vía comando (requiere mysqldump/mysql en PATH)
$mysqlExe = 'C:\\xampp\\mysql\\bin\\mysql.exe';
$cmd = "\"{$mysqlExe}\" "
     . "--default-character-set=utf8mb4 "
     . "-u {$dbUser}"
     . ($dbPass!==''? " -p\"{$dbPass}\"" : "")
     . " -h {$dbHost} {$dbName} < \"{$sqlFile}\" 2>&1";

exec($cmd, $output, $code);
if ($code !== 0) {
  http_response_code(500);
  echo json_encode([
    'success'=>false,
    'message'=>'Error al restaurar la base de datos.',
    'debug'=> $output
  ]);
  exit;
}

echo json_encode(['success'=>true,'message'=>"Backup {$file} restaurado."]);
