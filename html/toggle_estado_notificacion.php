<?php
session_start();
header('Content-Type: application/json');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// 1) Control de sesión
if (!isset($_SESSION['usuario_id'])) {
  http_response_code(403);
  echo json_encode(['success'=>false,'msg'=>'No autorizado']);
  exit;
}

// 2) Leer JSON
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

// 3) Validación
$id     = isset($data['id'])     ? (int)$data['id']     : 0;
$accion = isset($data['accion']) ? $data['accion']       : '';
if ($id <= 0 || !in_array($accion, ['marcar_leida','marcar_no_leida'])) {
  echo json_encode(['success'=>false,'msg'=>'Parámetros inválidos','data'=>$data]);
  exit;
}

// 4) Conexión
$mysqli = new mysqli('localhost','root','','inventariomotoracer');
if ($mysqli->connect_errno) {
  echo json_encode(['success'=>false,'msg'=>'Error conexión','error'=>$mysqli->connect_error]);
  exit;
}

// 5) UPDATE y chequeo de filas
$valor = ($accion === 'marcar_leida') ? 1 : 0;
$stmt = $mysqli->prepare("UPDATE notificaciones SET leida = ? WHERE id = ?");
$stmt->bind_param('ii', $valor, $id);
$stmt->execute();

$response = [
  'success'       => true,
  'mensaje'       => 'Ejecutado',
  'filas_afectadas' => $stmt->affected_rows
];

echo json_encode($response);
