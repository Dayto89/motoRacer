<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["success" => false, "message" => "Sesión no iniciada"]);
    exit();
}

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');

if (!$conexion) {
    echo json_encode(["success" => false, "message" => "Error de conexión: " . mysqli_connect_error()]);
    exit();
}

// Recibir los datos del formulario

$codigo2 = $_POST['codigo2'];
$nombre = $_POST['nombre'];
$precio1 = $_POST['precio1'];
$precio2 = $_POST['precio2'];
$precio3 = $_POST['precio3'];
$cantidad = $_POST['cantidad'];
$descripcion = $_POST['descripcion'];
$categoria = $_POST['categoria'];
$marca = $_POST['marca'];
$unidadmedida = $_POST['unidadmedida'];
$ubicacion = $_POST['ubicacion'];
$proveedor = $_POST['proveedor'];

// Actualizar el producto en la base de datos
$consulta = "UPDATE producto SET 
  codigo2 = '$codigo2', 
  nombre = '$nombre', 
  precio1 = '$precio1', 
  precio2 = '$precio2', 
  precio3 = '$precio3', 
  cantidad = '$cantidad', 
  descripcion = '$descripcion', 
  categoria = '$categoria', 
  marca = '$marca', 
  unidadmedida = '$unidadmedida', 
  ubicacion = '$ubicacion', 
  proveedor = '$proveedor' 
  WHERE codigo1 = '$codigo'";

if (mysqli_query($conexion, $consulta)) {
    echo json_encode(["success" => true, "message" => "Producto actualizado correctamente."]);
} else {
    echo json_encode(["success" => false, "message" => "Error al actualizar: " . mysqli_error($conexion)]);
}

mysqli_close($conexion);
?>