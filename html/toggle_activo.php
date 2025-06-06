<?php
// toggle_activo.php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("HTTP/1.1 403 Forbidden");
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['codigo']) || !isset($_POST['nuevo_estado'])) {
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(['success' => false, 'error' => 'Parámetros inválidos']);
    exit();
}

$codigo    = (int) $_POST['codigo'];
$nuevoEst  = ($_POST['nuevo_estado'] === '1') ? 1 : 0; // 1 = activo, 0 = inactivo

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode(['success' => false, 'error' => 'Error de conexión: ' . mysqli_connect_error()]);
    exit();
}

// Actualizamos el campo `activo` en la tabla factura
$stmt = $conexion->prepare("UPDATE factura SET activo = ? WHERE codigo = ?");
$stmt->bind_param("ii", $nuevoEst, $codigo);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'nuevo_estado' => $nuevoEst]);
} else {
    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conexion->close();
