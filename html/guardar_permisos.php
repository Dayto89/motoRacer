<?php 
session_start();

$conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');

if ($conexion->connect_error) {
  die("No se pudo conectar a la base de datos: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $identificacion = $_POST['identificacion'];
  $permisos = $_POST['permisos'] ?? [];

  // Recorremos los permisos enviados
  foreach ($permisos as $permiso => $valor) {
      $permitido = $valor == "1" ? 1 : 0;

      // Verificamos si ya existe el permiso en la BD
      $query = "SELECT COUNT(*) as existe FROM permisos WHERE usuario_id = ? AND permiso = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("is", $identificacion, $permiso);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();

      if ($row['existe'] > 0) {
          // Si ya existe, actualizamos
          $query = "UPDATE permisos SET permitido = ? WHERE usuario_id = ? AND permiso = ?";
          $stmt = $conn->prepare($query);
          $stmt->bind_param("iis", $permitido, $identificacion, $permiso);
      } else {
          // Si no existe, insertamos
          $query = "INSERT INTO permisos (usuario_id, permiso, permitido) VALUES (?, ?, ?)";
          $stmt = $conn->prepare($query);
          $stmt->bind_param("isi", $identificacion, $permiso, $permitido);
      }
      $stmt->execute();
  }

  echo "Permisos actualizados correctamente";
} else {
  echo "Método no permitido";
}
?>

