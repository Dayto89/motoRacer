<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.php");
  exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '../html/verificar_permisos.php';

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');

if (!$conexion) {
  die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

$busqueda = "";
$busqueda_param = "%";

if (isset($_GET['busqueda'])) {
  $busqueda = $_GET['busqueda'];
  $busqueda_param = "%" . $busqueda . "%";
}

// Calcular total de resultados
$sql_total = "SELECT COUNT(*) AS total FROM proveedor WHERE 
    nit LIKE ? OR 
    nombre LIKE ? OR 
    telefono LIKE ? OR 
    direccion LIKE ? OR 
    correo LIKE ? OR 
    estado LIKE ?";
$stmt_total = mysqli_prepare($conexion, $sql_total);
mysqli_stmt_bind_param($stmt_total, "ssssss", $busqueda_param, $busqueda_param, $busqueda_param, $busqueda_param, $busqueda_param, $busqueda_param);
mysqli_stmt_execute($stmt_total);
$result_total = mysqli_stmt_get_result($stmt_total);
$fila_total = mysqli_fetch_assoc($result_total);
$total_resultados = $fila_total['total'];

// Paginación
$por_pagina = 15;
$total_paginas = ceil($total_resultados / $por_pagina);

$pagina_actual = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$pagina_actual = max(1, min($total_paginas, $pagina_actual));
$offset = ($pagina_actual - 1) * $por_pagina;


$consulta = "SELECT * FROM proveedor WHERE 
    nit LIKE ? OR 
    nombre LIKE ? OR 
    telefono LIKE ? OR 
    direccion LIKE ? OR 
    correo LIKE ? OR 
    estado LIKE ?
    LIMIT ? OFFSET ?";
$stmt = mysqli_prepare($conexion, $consulta);
mysqli_stmt_bind_param($stmt, "ssssssii", $busqueda_param, $busqueda_param, $busqueda_param, $busqueda_param, $busqueda_param, $busqueda_param, $por_pagina, $offset);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
if (!$resultado) {
  die("No se pudo ejecutar la consulta: " . mysqli_error($conexion));
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';

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
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
  <link rel="stylesheet" href="../css/listaproveedor.css" />
  <link rel="stylesheet" href="../componentes/header.css">
  <link rel="stylesheet" href="../componentes/header.php">
  <script src="../js/header.js"></script>
  <script src="/js/index.js"></script>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap");

    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 20px;
      gap: 5px;
    }

    .pagination a {
      padding: 8px 12px;
      background-color: #f0f0f0;
      border: 1px solid #ccc;
      text-decoration: none;
      color: #333;
      border-radius: 4px;
      transition: background-color 0.3s;
      text-shadow: none;
    }

    .pagination a:hover {
      background-color:rgb(158, 146, 209);
    }

    .pagination a.active {
      background-color: #007bff;
      color: white;
      font-weight: bold;
      pointer-events: none;
      border-color: #007bff;
      text-shadow: none;
      
    }
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
      <!-- Enlaces de paginación -->

      <?php if ($total_paginas > 1): ?>
    <div class="pagination">
      <?php
        // Construir query base conservando filtros
        $base_params = $_GET;
      ?>
      <!-- Primera -->
      <?php
        $base_params['pagina'] = 1;
        $url = '?' . http_build_query($base_params);
      ?>
      <a href="<?= $url ?>">« Primera</a>

      <!-- Anterior -->
      <?php if($pagina_actual > 1): ?>
        <?php
          $base_params['pagina'] = $pagina_actual - 1;
          $url = '?' . http_build_query($base_params);
        ?>
        <a href="<?= $url ?>">‹ Anterior</a>
      <?php endif; ?>

      <?php
        // Rango de páginas: dos antes y dos después
        $start = max(1, $pagina_actual - 2);
        $end   = min($total_paginas, $pagina_actual + 2);

        // Si hay hueco antes, muestra ellipsis
        if ($start > 1) {
          echo '<span class="ellips">…</span>';
        }

        // Botones de páginas
        for ($i = $start; $i <= $end; $i++):
          $base_params['pagina'] = $i;
          $url = '?' . http_build_query($base_params);
      ?>
          <a href="<?= $url ?>"
             class="<?= $i == $pagina_actual ? 'active' : '' ?>">
            <?= $i ?>
          </a>
      <?php endfor;

        // Si hay hueco después, muestra ellipsis
        if ($end < $total_paginas) {
          echo '<span class="ellips">…</span>';
        }
      ?>

      <!-- Siguiente -->
      <?php if($pagina_actual < $total_paginas): ?>
        <?php
          $base_params['pagina'] = $pagina_actual + 1;
          $url = '?' . http_build_query($base_params);
        ?>
        <a href="<?= $url ?>">Siguiente ›</a>
      <?php endif; ?>

      <!-- Última -->
      <?php
        $base_params['pagina'] = $total_paginas;
        $url = '?' . http_build_query($base_params);
      ?>
      <a href="<?= $url ?>">Última »</a>
    </div>
  <?php endif; ?>
    </div>
  </div>
</body>

</html>