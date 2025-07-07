<?php
session_start();
header('Content-Type: application/json');

// Leer JSON de entrada
$input = json_decode(file_get_contents('php://input'), true);
$ids   = array_filter($input['ids'] ?? [], fn($v) => filter_var($v, FILTER_VALIDATE_INT)!==false);
if (count($ids) === 0) {
    echo json_encode(['success'=>false,'message'=>'No se recibieron IDs válidos.']);
    exit;
}

$mysqli = new mysqli('localhost','root','','inventariomotoracer');
if ($mysqli->connect_errno) {
    echo json_encode(['success'=>false,'message'=>'Error de conexión.']);
    exit;
}

// Construye el placeholder y tipos
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$types = str_repeat('i', count($ids));

$sql  = "UPDATE notificaciones 
         SET leida = 1 
         WHERE id IN ($placeholders)";
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    echo json_encode(['success'=>false,'message'=>'Error al preparar consulta: '.$mysqli->error]);
    exit;
}

// Bind dinámico y ejecución
$stmt->bind_param($types, ...array_values($ids));
$stmt->execute();

echo json_encode([
  'success' => true,
  'updated' => $stmt->affected_rows
]);

$stmt->close();
$mysqli->close();
