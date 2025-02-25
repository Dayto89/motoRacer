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

// Eliminar usuario
if ($_POST && isset($_POST['eliminar'])) {
  $id = mysqli_real_escape_string($conexion, $_POST['id']);

  $query = "DELETE FROM usuario WHERE identificacion = '$id'";
  $resultado = mysqli_query($conexion, $query);

  echo json_encode(["success" => $resultado]);
  exit();
}

// Obtener lista de permisos
if ($_POST && isset($_POST['lista'])) {
  $id = mysqli_real_escape_string($conexion, $_POST['id']);

  $query = "SELECT * FROM permiso WHERE usuario_id = '$id'";
  $resultado = mysqli_query($conexion, $query);

  $permisos = [];
  while ($fila = mysqli_fetch_assoc($resultado)) {
    $permisos[] = $fila;
  }

  echo json_encode($permisos);
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Usuarios</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="/css/gestionusuario.css">
  <link rel="stylesheet" href="/componentes/header.css">
  <link
    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
    rel="stylesheet" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
  </style>
  <script src="/js/index.js"></script>
</head>

<body>
  <!-- Aquí se cargará el header -->
  <div id="menu"></div>

  <div id="gestionusuario" class="form-section">
    <h1>Gestión Usuarios</h1>

    <div class="container">
      <table class="user-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          
          <?php
          $conn = new mysqli('localhost', 'root', '', 'inventariomotoracer');
          $sql = "SELECT * FROM usuario";
          $result = $conn->query($sql);
          $contador = 0; // Contador para alternar colores

          while ($row = $result->fetch_assoc()) {
            // Alterna clases según el contador
            $claseFila = ($contador % 2 == 0) ? 'row-ocre' : 'row-gray';

            echo "<tr class='$claseFila'>
            <td>" . $row['identificacion'] . "</td>
            <td>" . $row['nombre'] . "</td>
            <td>" . $row['apellido'] . "</td>
            <td>
              <button class='btn-permissions'  id='lista' data-id='" . $row['identificacion'] . "'>Permisos</button>
                <button class='btn-delete' id='eliminar' data-id='" . $row['identificacion'] . "'>Eliminar</button>
            </td>
          </tr>";
            $contador++;
          }
          ?>
</div>
</div>
<button class='btn-registro' onclick="location.href='../html/registro.php'"> <i class='bx bx-plus bx-tada'></i>Registrar nuevo usuario</button>
</body>

</html>