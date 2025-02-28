<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    exit("Acceso denegado.");
}

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Leer la solicitud JSON
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["codigo1"])) {
    exit("Código de producto no proporcionado.");
}

$id = mysqli_real_escape_string($conexion, $data["codigo1"]);
$eliminar = "DELETE FROM producto WHERE codigo1='$id'";

if (mysqli_query($conexion, $eliminar)) {
    echo "Producto eliminado correctamente.";
} else {
    echo "Error al eliminar: " . mysqli_error($conexion);
}
?>
