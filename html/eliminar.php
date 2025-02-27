<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    die("Acceso denegado");
}

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

$id = $_POST['id'];
$query = "DELETE FROM producto WHERE id = $id";
mysqli_query($conexion, $query);
echo "Producto eliminado correctamente";
