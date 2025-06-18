<?php
header('Content-Type: application/json; charset=UTF-8');
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);
ini_set('error_log', 'C:\xampp\htdocs\php_errors.log'); // Ruta del log en Windows

session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.php");
  exit();
}

// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
  die(json_encode(["success" => false, "error" => "No se pudo conectar a la base de datos: " . mysqli_connect_error()]));
}

// Leer datos enviados desde JavaScript
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['nits']) && is_array($data['nits'])) {
    // Limpiar y escapar cada NIT
    $nits = "'" . implode("','", array_map(function($codigo) use ($conexion) {
        return mysqli_real_escape_string($conexion, trim($codigo));
    }, $data['nits'])) . "'";

    // Consulta para eliminar
    $query = "DELETE FROM proveedor WHERE nit IN ($nits)";

    if (mysqli_query($conexion, $query)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => mysqli_error($conexion)]);
    }
} else {
    echo json_encode(["success" => false, "error" => "No se recibieron códigos válidos."]);
}

// Cerrar la conexión
mysqli_close($conexion);
?>
