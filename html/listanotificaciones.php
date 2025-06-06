<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.php");
  exit();
}

// require_once $_SERVER['DOCUMENT_ROOT'] . '../html/verificar_permisos.php';

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
  die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

// Búsqueda
$busqueda = "";
$busqueda_param = "%";

if (isset($_GET['busqueda'])) {
  $busqueda = $_GET['busqueda'];
  $busqueda_param = "%" . $busqueda . "%";
}

// Marcar como leída o no leída
if (isset($_POST['accion']) && isset($_POST['id'])) {
  $id = (int) $_POST['id'];
  $accion = $_POST['accion'];

  if ($accion === 'marcar_leida') {
    $stmt = $conexion->prepare("UPDATE notificaciones SET leida = 1 WHERE id = ?");
  } elseif ($accion === 'marcar_no_leida') {
    $stmt = $conexion->prepare("UPDATE notificaciones SET leida = 0 WHERE id = ?");
  }

  if (isset($stmt)) {
    $stmt->bind_param('i', $id);
    $stmt->execute();
  }
  // Redirigir para evitar reenvío de formulario
  header("Location: listanotificaciones.php");
  exit();
}

// Calcular total de resultados
$sql_total = "SELECT COUNT(*) AS total FROM notificaciones WHERE mensaje LIKE ?";
$stmt_total = mysqli_prepare($conexion, $sql_total);
mysqli_stmt_bind_param($stmt_total, "s", $busqueda_param);
mysqli_stmt_execute($stmt_total);
$result_total = mysqli_stmt_get_result($stmt_total);
$fila_total = mysqli_fetch_assoc($result_total);
$total_resultados = $fila_total['total'];

// Paginación
$por_pagina = 10;
$total_paginas = ceil($total_resultados / $por_pagina);

$pagina_actual = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$pagina_actual = max(1, min($total_paginas, $pagina_actual));
$offset = ($pagina_actual - 1) * $por_pagina;

// Consultar notificaciones
$consulta = "SELECT id, mensaje, descripcion, fecha, leida FROM notificaciones WHERE mensaje LIKE ? ORDER BY fecha DESC LIMIT ? OFFSET ?";
$stmt = mysqli_prepare($conexion, $consulta);
mysqli_stmt_bind_param($stmt, "sii", $busqueda_param, $por_pagina, $offset);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Notificaciones</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
  <link rel="stylesheet" href="../css/listanotificaciones.css">
  <link rel="stylesheet" href="../css/alertas.css">
  <link rel="stylesheet" href="../componentes/header.css">
  <link rel="stylesheet" href="../componentes/header.php">
  <script src="../js/header.js"></script>
  <script src="/js/index.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');

    .boton-accion {
      padding: 5px 10px;
      margin: 2px;
      background-color: #6c757d;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 0.9em;
    }

    .boton-accion:hover {
      background-color: #5a6268;
    }

    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 20px;
      gap: 5px;
      font-size: 11px;
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
      background-color: rgb(158, 146, 209);
    }

    .pagination a.active {
      background-color: #007bff;
      color: white;
      font-weight: bold;
      pointer-events: none;
      border-color: #007bff;
      text-shadow: none;
    }

    .marcarN {
      background-color: rgb(128, 0, 0);
    }

    .marcarN:hover {
      background-color: rgb(255, 0, 0);
    }

    .marcarL {
      background-color: rgb(11, 128, 0);
    }

    .marcarL:hover {
      background-color: rgb(15, 184, 0);
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <div id="menu"></div>
  </div>



  <div class="main-content">

      <h1>Notificaciones</h1>
      <div class="filter-bar">
            <!-- Filtros adaptados -->
            <details class="filter-dropdown">
                <summary class="filter-button">Filtrar</summary>
                <div class="filter-options">
                    <form method="GET" action="../html/listanotificaciones.php" class="search-form">
                        <div class="criteria-group">
                            <label><input type="checkbox" name="criterios[]" value="codigo"> Fecha</label>
                            <label><input type="checkbox" name="criterios[]" value="identificacion">Nombre</label>
                            <label><input type="checkbox" name="criterios[]" value="nombre">Estado</label>
                            <label><input type="checkbox" name="criterios[]" value="apellido">Stock</label>
                </div>
            </details>
            <input class="form-control" type="text" name="valor" placeholder="Ingrese el valor a buscar">
            <button class="search-button" type="submit">Buscar</button>
            </form>
        </div>
      <div style="margin-bottom: 25px;margin-left: 74%;size: 50%;font-family:Arial;">
        <a href="exportar_notificaciones_excel.php" class="boton-accion marcarL"> <i class="fas fa-file-excel icon-color"></i><label> Exportar a Excel</label></a>
        <a href="exportar_notificaciones_pdf.php" class="boton-accion marcarN"><i class="fa-solid fa-file-pdf icon-color"></i><label> Exportar a PDF</label></a>
      </div>

      <table>
        <thead>
          <tr>
            <th>Mensaje</th>
            <th>Descripción</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
              <td><?= htmlspecialchars($fila["mensaje"]) ?></td>
              <td><?= htmlspecialchars($fila["descripcion"]) ?></td>
              <td><?= htmlspecialchars($fila["fecha"]) ?></td>
              <td><?= $fila["leida"] ? "Leída" : "No leída"; ?></td>
              <td>
                <form method="POST" action="listanotificaciones.php" style="display:inline;">
                  <input type="hidden" name="id" value="<?= $fila['id'] ?>">
                  <?php if ($fila["leida"]) { ?>
                    <input type="hidden" name="accion" value="marcar_no_leida">
                    <button class="boton-accion marcarN" type="submit">Marcar No Leída</button>
                  <?php } else { ?>
                    <input type="hidden" name="accion" value="marcar_leida">
                    <button class="boton-accion marcarL" type="submit">Marcar Leída</button>
                  <?php } ?>
                </form>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

      <!-- Paginación -->
      <?php if ($total_paginas > 1): ?>
        <div class="pagination">
          <?php
          $base_params = $_GET;
          ?>
          <!-- Primera -->
          <?php
          $base_params['pagina'] = 1;
          $url = '?' . http_build_query($base_params);
          ?>
          <a href="<?= $url ?>">« Primera</a>

          <!-- Anterior -->
          <?php if ($pagina_actual > 1): ?>
            <?php
            $base_params['pagina'] = $pagina_actual - 1;
            $url = '?' . http_build_query($base_params);
            ?>
            <a href="<?= $url ?>">‹ Anterior</a>
          <?php endif; ?>

          <?php
          $start = max(1, $pagina_actual - 2);
          $end   = min($total_paginas, $pagina_actual + 2);

          if ($start > 1) {
            echo '<span class="ellips">…</span>';
          }

          for ($i = $start; $i <= $end; $i++):
            $base_params['pagina'] = $i;
            $url = '?' . http_build_query($base_params);
          ?>
            <a href="<?= $url ?>" class="<?= $i == $pagina_actual ? 'active' : '' ?>">
              <?= $i ?>
            </a>
          <?php endfor;

          if ($end < $total_paginas) {
            echo '<span class="ellips">…</span>';
          }
          ?>

          <!-- Siguiente -->
          <?php if ($pagina_actual < $total_paginas): ?>
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
      <div class="userInfo">
        <!-- Nombre y apellido del usuario y rol -->
        <!-- Consultar datos del usuario -->
        <?php
        $conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
        $id_usuario = $_SESSION['usuario_id'];
        $sqlUsuario = "SELECT nombre, apellido, rol, foto FROM usuario WHERE identificacion = ?";
        $stmtUsuario = $conexion->prepare($sqlUsuario);
        $stmtUsuario->bind_param("i", $id_usuario);
        $stmtUsuario->execute();
        $resultUsuario = $stmtUsuario->get_result();
        $rowUsuario = $resultUsuario->fetch_assoc();
        $nombreUsuario = $rowUsuario['nombre'];
        $apellidoUsuario = $rowUsuario['apellido'];
        $rol = $rowUsuario['rol'];
        $foto = $rowUsuario['foto'];
        $stmtUsuario->close();
        ?>
        <p class="nombre"><?php echo $nombreUsuario; ?> <?php echo $apellidoUsuario; ?></p>
        <p class="rol">Rol: <?php echo $rol; ?></p>

    </div>
    <div class="profilePic">
        <?php if (!empty($rowUsuario['foto'])): ?>
            <img id="profilePic" src="data:image/jpeg;base64,<?php echo base64_encode($foto); ?>" alt="Usuario">
        <?php else: ?>
            <img id="profilePic" src="../imagenes/icono.jpg" alt="Usuario por defecto">
        <?php endif; ?>
    </div>

</body>

</html>