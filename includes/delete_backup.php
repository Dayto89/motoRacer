<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['usuario_id'])) {
  http_response_code(401);
  echo json_encode(['success'=>false,'message'=>'No autorizado']);
  exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$file = basename($data['file']);  // basename para evitar traversal
$path = __DIR__ . '/../backups/' . $file;

if (!file_exists($path)) {
  http_response_code(404);
  echo json_encode(['success'=>false,'message'=>"Archivo no encontrado"]);
  exit;
}

if (!unlink($path)) {
  http_response_code(500);
  echo json_encode(['success'=>false,'message'=>"No se pudo eliminar {$file}"]);
  exit;
}

echo json_encode(['success'=>true,'message'=>"{$file} eliminado correctamente"]);
