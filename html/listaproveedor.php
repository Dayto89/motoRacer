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

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

$consulta = "SELECT * FROM proveedor WHERE 
    nit LIKE ? OR 
    nombre LIKE ? OR 
    telefono LIKE ? OR 
    direccion LIKE ? OR 
    correo LIKE ? OR 
    estado LIKE ?";

$stmt = mysqli_prepare($conexion, $consulta);
$busqueda_param = "%$busqueda%";
mysqli_stmt_bind_param($stmt, "ssssss", $busqueda_param, $busqueda_param, $busqueda_param, $busqueda_param, $busqueda_param, $busqueda_param);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
if (!$resultado) {
  die("No se pudo ejecutar la consulta: " . mysqli_error($conexion));
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inventario</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="../css/listaproveedor.css" />
  <link rel="stylesheet" href="../componentes/header.css">
  <link rel="stylesheet" href="../componentes/header.php">
  <script src="../js/header.js"></script>
  <script src="/js/index.js"></script>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap");
  </style>
</head>

<body>
  <!-- Aquí se cargará el header -->
  <div class="sidebar">
        <div id="menu"></div>
    </div>


  <!--Barra de búsqueda fija con efecto deslizante -->
  <div class="search-bar">
    <form method="GET" action="listaproveedor.php">
      <button class="search-icon" type="submit" aria-label="Buscar" title="Buscar">
        <i class="bx bx-search-alt-2 icon"></i>
      </button>
      <input class="form-control" type="text" name="busqueda" placeholder="Buscar">
    </form>

  </div>

  <!-- Contenido principal -->
  <div class="main-content">
    

    <!-- Sección del Inventario -->

    <div id="inventario" class="form-section">
      <h1>Proveedores</h1>
      <table>
        <thead>
          <tr>
            <th>Nit</th>
            <th>Nombre</th>
            <th>Telefono</th>
            <th>Dirección</th>
            <th>Correo</th>
            <th>Estado</th>

          </tr>
        </thead>
        <tbody>
          <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
              <td><?= $fila["nit"] ?? 'N/A'; ?></td>
              <td><?= $fila["nombre"] ?? 'N/A'; ?></td>
              <td><?= $fila["telefono"] ?? 'N/A'; ?></td>
              <td><?= $fila["direccion"] ?? 'N/A'; ?></td>
              <td><?= $fila["correo"] ?? 'N/A'; ?></td>
              <td><?= $fila["estado"] ?? 'N/A'; ?></td> 
            </tr>
          <?php } ?>
        </tbody>

      </table>
    </div>
  </div>
</body>

</html>