<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  http_response_code(403);
  echo json_encode(['success' => false, 'msg' => 'No autorizado']);
  exit;
}
$data = json_decode(file_get_contents('php://input'), true);
if (empty($data['ids']) || !is_array($data['ids'])) {
  echo json_encode(['success' => false, 'msg' => 'Datos inválidos']);
  exit;
}

$ids = array_map('intval', $data['ids']);
$in  = implode(',', $ids);

$mysqli = new mysqli('localhost','root','','inventariomotoracer');
if ($mysqli->connect_errno) {
  echo json_encode(['success'=>false,'msg'=>'Error BD']);
  exit;
}

$sql = "DELETE FROM notificaciones WHERE id IN ($in)";
if ($mysqli->query($sql)) {
  echo json_encode(['success'=>true]);
} else {
  echo json_encode(['success'=>false,'msg'=>$mysqli->error]);
}
$mysqli->close();
