<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);
ini_set('error_log', 'C:\xampp\htdocs\php_errors.log'); // Windows

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

if (isset($data['codigos']) && is_array($data['codigos'])) {
    // Limpiar y formatear códigos correctamente para la consulta SQL
    $codigos = "'" . implode("','", array_map(function($codigo) use ($conexion) {
        return mysqli_real_escape_string($conexion, trim($codigo));
    }, $data['codigos'])) . "'";
    
    // Consulta para eliminar
    $query = "DELETE FROM producto WHERE codigo1 IN ($codigos)";

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
