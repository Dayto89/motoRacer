<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
if (!empty($_SESSION['usuario_id']) && in_array($_SERVER['REQUEST_METHOD'], ['POST'])) {
    $payload = json_decode(file_get_contents('php://input'), true);
    if (empty($payload['codigo']) || !isset($payload['activo'])) {
        echo json_encode(['success'=>false,'error'=>'Faltan datos']);
        exit;
    }

    // Conexión
    $mysqli = new mysqli('localhost','root','','inventariomotoracer');
    if ($mysqli->connect_errno) {
        echo json_encode(['success'=>false,'error'=>'Error BD']);
        exit;
    }

    // Sanitizar
    $codigo      = $mysqli->real_escape_string($payload['codigo']);
    $nuevoEstado = $payload['activo'] ? 1 : 0;
    // Si lo activas, borras la observación
    $observacion = $nuevoEstado
         ? ''
         : $mysqli->real_escape_string(trim($payload['observacion'] ?? ''));

    // Prepared statement
    $stmt = $mysqli->prepare(
      "UPDATE factura 
         SET activo = ?, observacion = ? 
       WHERE codigo = ?"
    );
    $stmt->bind_param('iss', $nuevoEstado, $observacion, $codigo);
    if ($stmt->execute()) {
        echo json_encode(['success'=>true]);
    } else {
        echo json_encode(['success'=>false,'error'=>$stmt->error]);
    }
    $stmt->close();
    $mysqli->close();
} else {
    echo json_encode(['success'=>false,'error'=>'No autorizado']);
}
