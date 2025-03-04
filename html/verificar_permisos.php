<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.php");
  exit();
}

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');

if (!$conexion) {
  die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

function tiene_permiso($usuario_id, $permiso_id) {
  global $conexion;
  $query = "SELECT COUNT(*) AS count FROM usuario_permiso WHERE usuario_id = $usuario_id AND permiso_id = $permiso_id";
  $resultado = mysqli_query($conexion, $query);
  $fila = mysqli_fetch_assoc($resultado);
  return $fila['count'] > 0;
}
?>