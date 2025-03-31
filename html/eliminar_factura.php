<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);
ini_set('error_log', 'C:\xampp\htdocs\php_errors.log');

session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.php");
  exit();
}


$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
  die(json_encode(["success" => false, "error" => "Conexión fallida: " . mysqli_connect_error()]));
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['codigos']) && is_array($data['codigos'])) {
    $codigos = "'" . implode("','", array_map(function($codigo) use ($conexion) {
        return mysqli_real_escape_string($conexion, trim($codigo));
    }, $data['codigos'])) . "'";

    $error = null;

    // Eliminar métodos de pago
    $query = "DELETE FROM factura_metodo_pago WHERE Factura_codigo IN ($codigos)";
    if (!mysqli_query($conexion, $query)) {
        $error = mysqli_error($conexion);
    }

    // Eliminar productos de factura si no hay error
    if (!$error) {
        $query = "DELETE FROM producto_factura WHERE Factura_codigo IN ($codigos)";
        if (!mysqli_query($conexion, $query)) {
            $error = mysqli_error($conexion);
        }
    }

    // Eliminar factura principal si no hay error
    if (!$error) {
        $query = "DELETE FROM factura WHERE codigo IN ($codigos)";
        if (!mysqli_query($conexion, $query)) {
            $error = mysqli_error($conexion);
        }
    }

    if ($error) {
        echo json_encode(["success" => false, "error" => $error]);
    } else {
        echo json_encode(["success" => true]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Códigos no válidos."]);
}

mysqli_close($conexion);
?>