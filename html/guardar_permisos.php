<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.php");
  exit();
}

$conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
if ($conexion->connect_error) {
  die("No se pudo conectar a la base de datos: " . $conexion->connect_error);
}

$id_usuario = $_POST['identificacion'];
$permisos = $_POST['permisos'];

// Primero, desactivar todos los permisos para este usuario
$sqlDesactivar = "UPDATE accesos SET permitido = 0 WHERE id_usuario = ?";
$stmtDesactivar = $conexion->prepare($sqlDesactivar);
$stmtDesactivar->bind_param("i", $id_usuario);
$stmtDesactivar->execute();
$stmtDesactivar->close();

// Luego, activar solo los permisos seleccionados
foreach ($permisos as $permiso) {
  list($seccion, $subseccion) = explode('_', $permiso);
  $subseccion = str_replace('_', ' ', $subseccion);

  $sqlActivar = "UPDATE accesos SET permitido = 1 WHERE id_usuario = ? AND seccion = ? AND sub_seccion = ?";
  $stmtActivar = $conexion->prepare($sqlActivar);
  $stmtActivar->bind_param("iss", $id_usuario, $seccion, $subseccion);
  $stmtActivar->execute();
  $stmtActivar->close();
}

echo "Permisos actualizados correctamente";
?>