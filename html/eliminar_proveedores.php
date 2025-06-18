<?php
// eliminar_proveedores.php
header('Content-Type: application/json; charset=UTF-8');
ini_set('display_errors', 1);
ini_set('log_errors',   1);
error_reporting(E_ALL);
ini_set('error_log',    'C:\xampp\htdocs\php_errors.log');

session_start();
if (!empty($_SESSION['usuario_id']) === false) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit;
}

// Conexión
$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (mysqli_connect_errno()) {
    http_response_code(500);
    echo json_encode([
      "success" => false,
      "error"   => "Error de conexión: " . mysqli_connect_error()
    ]);
    exit;
}

// Leer JSON
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['nits']) || !is_array($data['nits']) || count($data['nits']) === 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'No se recibieron NITs válidos.']);
    exit;
}
// Para depurar en el log:
error_log("Llegaron NITs a eliminar: " . print_r($data['nits'], true));

// Preparar DELETE con placeholders
$placeholders = implode(',', array_fill(0, count($data['nits']), '?'));
$sql = "DELETE FROM proveedor WHERE nit IN ($placeholders)";
$stmt = mysqli_prepare($conexion, $sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Error al preparar la consulta: ' . mysqli_error($conexion)]);
    exit;
}

// Bind dinámico
$types = str_repeat('s', count($data['nits']));
$params = array_map(fn($v) => trim($v), $data['nits']);
mysqli_stmt_bind_param($stmt, $types, ...$params);

// Ejecutar
if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => mysqli_stmt_error($stmt)]);
    exit;
}

// Éxito
echo json_encode(['success' => true]);
exit;
