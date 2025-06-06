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

// ---------------------------------------------------
// 1) FILTROS (fechas, búsqueda en el servidor, paginación)
// ---------------------------------------------------
$filtros = [];

if (!empty($_GET['fecha_desde']) && !empty($_GET['fecha_hasta'])) {
  $fecha_desde = mysqli_real_escape_string($conexion, $_GET['fecha_desde']) . " 00:00:00";
  $fecha_hasta = mysqli_real_escape_string($conexion, $_GET['fecha_hasta']) . " 23:59:59";
  $filtros[] = "f.fechaGeneracion BETWEEN '$fecha_desde' AND '$fecha_hasta'";
}

$busqueda = isset($_GET['busqueda']) ? mysqli_real_escape_string($conexion, $_GET['busqueda']) : '';
$criterios = isset($_GET['criterios']) && is_array($_GET['criterios']) ? $_GET['criterios'] : [];
if (!empty($busqueda)) {
  $condiciones = [];
  if (!empty($criterios)) {
    foreach ($criterios as $criterio) {
      $criterio = mysqli_real_escape_string($conexion, $criterio);
      switch ($criterio) {
        case 'codigo':
          $condiciones[] = "f.codigo = '$busqueda'";
          break;
        case 'fechaGeneracion':
          $condiciones[] = "f.fechaGeneracion LIKE '%$busqueda%'";
          break;
        case 'metodoPago':
          $condiciones[] = "EXISTS (
                              SELECT 1 
                                FROM factura_metodo_pago tmp 
                               WHERE tmp.Factura_codigo = f.codigo 
                                 AND tmp.metodoPago = '$busqueda'
                            )";
          break;
        case 'cliente':
          $condiciones[] = "(f.nombreCliente LIKE '%$busqueda%' OR f.apellidoCliente LIKE '%$busqueda%')";
          break;
        case 'vendedor':
          $condiciones[] = "(f.nombreUsuario LIKE '%$busqueda%' OR f.apellidoUsuario LIKE '%$busqueda%')";
          break;
        case 'precioTotal':
          $condiciones[] = "f.precioTotal = '$busqueda'";
          break;
      }
    }
    $filtros[] = '(' . implode(' OR ', $condiciones) . ')';
  } else {
    // Búsqueda global si no hay criterios marcados
    $general = [
      "f.codigo = '$busqueda'",
      "f.precioTotal = '$busqueda'",
      "(f.nombreCliente LIKE '%$busqueda%' OR f.apellidoCliente LIKE '%$busqueda%')",
      "(f.nombreUsuario LIKE '%$busqueda%' OR f.apellidoUsuario LIKE '%$busqueda%')",
      "EXISTS (
         SELECT 1 
           FROM factura_metodo_pago tmp 
          WHERE tmp.Factura_codigo = f.codigo 
            AND tmp.metodoPago = '$busqueda'
        )"
    ];
    $filtros[] = '(' . implode(' OR ', $general) . ')';
  }
}

// PAGINACIÓN PHP
$registros_por_pagina = 10;
$pagina_actual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Contar total de filas
$sql_count = "
  SELECT COUNT(DISTINCT f.codigo) AS total
    FROM factura f
    LEFT JOIN factura_metodo_pago m ON m.Factura_codigo = f.codigo
";
if (!empty($filtros)) {
  $sql_count .= " WHERE " . implode(' AND ', $filtros);
}
$result_count = mysqli_query($conexion, $sql_count);
$total_filas = mysqli_fetch_assoc($result_count)['total'];
$total_paginas = ceil($total_filas / $registros_por_pagina);

// Consulta principal
$sql = "
  SELECT 
    f.codigo,
    f.fechaGeneracion,
    f.Usuario_identificacion, 
    f.nombreUsuario,
    f.apellidoUsuario,
    f.Cliente_codigo,
    f.nombreCliente,
    f.apellidoCliente,
    f.telefonoCliente,
    f.identificacionCliente,
    f.cambio,
    f.precioTotal,
    GROUP_CONCAT(DISTINCT m.metodoPago SEPARATOR ', ') AS metodoPago
  FROM factura f
  LEFT JOIN factura_metodo_pago m ON m.Factura_codigo = f.codigo
";
if (!empty($filtros)) {
  $sql .= " WHERE " . implode(' AND ', $filtros);
}
$sql .= "
  GROUP BY 
    f.codigo,
    f.fechaGeneracion,
    f.Usuario_identificacion,
    f.Cliente_codigo,
    f.precioTotal,
    f.nombreUsuario,
    f.apellidoUsuario,
    f.nombreCliente,
    f.apellidoCliente,
    f.telefonoCliente,
    f.identificacionCliente
  ORDER BY f.fechaGeneracion DESC
  LIMIT $registros_por_pagina
  OFFSET $offset
";

$resultado = mysqli_query($conexion, $sql);
if (!$resultado) {
  die("No se pudo ejecutar la consulta: " . mysqli_error($conexion));
}

// ELIMINAR FACTURA (vía AJAX/SweetAlert)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'], $_POST['codigo'])) {
  header('Content-Type: application/json');
  $response = ['success' => false, 'error' => ''];
  try {
    $codigo = $_POST['codigo'];
    mysqli_begin_transaction($conexion);

    // 1) Eliminar métodos de pago
    $stmt1 = $conexion->prepare("DELETE FROM factura_metodo_pago WHERE Factura_codigo = ?");
    $stmt1->bind_param("i", $codigo);
    if (!$stmt1->execute()) throw new Exception("Error en tabla factura_metodo_pago: " . $stmt1->error);

    // 2) Eliminar productos de la factura
    $stmt2 = $conexion->prepare("DELETE FROM producto_factura WHERE Factura_codigo = ?");
    $stmt2->bind_param("i", $codigo);
    if (!$stmt2->execute()) throw new Exception("Error en tabla producto_factura: " . $stmt2->error);

    // 3) Eliminar la factura en sí
    $stmt3 = $conexion->prepare("DELETE FROM factura WHERE codigo = ?");
    $stmt3->bind_param("i", $codigo);
    if (!$stmt3->execute()) throw new Exception("Error en tabla factura: " . $stmt3->error);

    mysqli_commit($conexion);
    $response['success'] = true;
  } catch (Exception $e) {
    mysqli_rollback($conexion);
    $response['error'] = $e->getMessage();
  } finally {
    if (isset($stmt1)) $stmt1->close();
    if (isset($stmt2)) $stmt2->close();
    if (isset($stmt3)) $stmt3->close();
  }
  echo json_encode($response);
  exit;
}

// REDIRECCIÓN A RECIBO (cuando hagan POST de factura_id)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['factura_id'])) {
  $_SESSION['factura_id'] = $_POST['factura_id'];
  header("Location: recibo.php");
  exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reportes</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">

  <!-- =============================== -->
  <!-- 1) CSS Propios y Fuentes         -->
  <!-- =============================== -->
  <link rel="stylesheet" href="../css/reporte.css" />
  <link rel="stylesheet" href="../css/alertas.css">
  <link rel="stylesheet" href="../componentes/header.css">

  <!-- =============================== -->
  <!-- 2) SweetAlert2 (CDN)              -->
  <!-- =============================== -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- =============================== -->
  <!-- 3) Otros JS (header, index, iconos) -->
  <!-- =============================== -->
  <script src="../js/header.js"></script>
  <script src="/js/index.js"></script>
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>

  <!-- =============================== -->
  <!-- 4) ESTILOS ADICIONALES (inline)    -->
  <!--    - Para resaltar fila “.selected” -->
  <!--    - Cursor pointer en <th>        -->
  <!-- =============================== -->
  <style>
    /* Cuando una fila tenga la clase “selected”, la pintamos de un color suave */
    #reportTable tbody tr.selected {
      background-color: rgba(0, 123, 255, 0.15);
    }
    #reportTable tbody tr.selected td {
      background-color: rgba(0, 123, 255, 0.15);
    }
    /* Cambiar cursor a mano sobre encabezados para indicar que son clicables */
    #reportTable th {
      cursor: pointer;
    }

    /* Paginación (si prefieres usarla) */
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
    }
  </style>
</head>

<body>
  <!-- =============================== -->
  <!-- 5) SCRIPT DE ELIMINAR FACTURA     -->
  <!--    (SweetAlert2 + AJAX)            -->
  <!-- =============================== -->
  <script>
    function eliminarFactura(codigo) {
      Swal.fire({
        title: '<span class="titulo-alerta advertencia">¿Estás Seguro?</span>',
        html: `
          <div class="custom-alert">
            <div class="contenedor-imagen">
              <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
            </div>
            <p>¿Quieres eliminar la factura <strong>${codigo}</strong> y todos sus datos asociados?</p>
          </div>
        `,
        background: '#ffffffdb',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc3545',
        customClass: {
          popup: 'swal2-border-radius',
          confirmButton: 'btn-eliminar',
          cancelButton: 'btn-cancelar',
          container: 'fondo-oscuro'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          fetch('../html/reportes.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `eliminar=1&codigo=${encodeURIComponent(codigo)}`
          })
          .then(response => {
            if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
            return response.json();
          })
          .then(data => {
            if (data.success) {
              Swal.fire({
                title: '<span class="titulo-alerta confirmacion">Éxito</span>',
                html: `
                  <div class="custom-alert">
                    <div class="contenedor-imagen">
                      <img src="../imagenes/moto.png" alt="Confirmación" class="moto">
                    </div>
                    <p>La factura <strong>${codigo}</strong> ha sido eliminada correctamente.</p>
                  </div>
                `,
                background: '#ffffffdb',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#007bff',
                customClass: {
                  popup: 'swal2-border-radius',
                  confirmButton: 'btn-aceptar',
                  container: 'fondo-oscuro'
                }
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire("Error", data.error || "No se pudo completar la eliminación", "error");
            }
          })
          .catch(error => {
            console.error('Error:', error);
            Swal.fire("Error", "Error al conectar con el servidor", "error");
          });
        }
      });
    }
  </script>

  <div class="sidebar">
    <div id="menu"></div>
  </div>

  <div class="main-content">
    <h1>Reportes</h1>

    <!-- =============================== -->
    <!-- 6) FILTROS / BÚSQUEDA            -->
    <!-- =============================== -->
    <div class="filter-bar">
      <details class="filter-dropdown">
        <summary class="filter-button">Filtrar</summary>
        <div class="filter-options">
          <form method="GET" action="../html/reportes.php" class="search-form">
            <div class="criteria-group">
              <label><input type="checkbox" name="criterios[]" value="codigo"> Código</label>
              <label><input type="checkbox" name="criterios[]" value="fechaGeneracion"> Fecha</label>
              <label><input type="checkbox" name="criterios[]" value="metodoPago"> Método pago</label>
              <label><input type="checkbox" name="criterios[]" value="vendedor"> Vendedor</label>
              <label><input type="checkbox" name="criterios[]" value="cliente"> Cliente</label>
              <label><input type="checkbox" name="criterios[]" value="precioTotal"> Total</label>
            </div>
            <div class="date-filters">
              <label>Desde: <input type="date" name="fecha_desde"></label>
              <label>Hasta: <input type="date" name="fecha_hasta"></label>
            </div>
        </div>
      </details>

      <!-- Campo de búsqueda en tiempo real: eliminamos su envío automático -->
      <form onsubmit="return false;">
        <input id="barraReportes" type="text"
               placeholder="Buscar en resultados..."
               autocomplete="off">
      </form>

      <div class="export-button">
        <form action="excel_reporte.php" method="post">
          <button type="submit" class="icon-button" aria-label="Exportar a Excel" title="Exportar a Excel">
            <i class="fas fa-file-excel"></i>
            <label> Exportar a Excel</label>
          </button>
        </form>

        <button id="delete-selected" class="btn btn-danger" style="display: none;">
          <i class="fa-solid fa-trash"></i>
        </button>
      </div>
    </div>

    <!-- =============================== -->
    <!-- 7) TABLA con id="reportTable"     -->
    <!-- =============================== -->
    <div class="table-wrapper">
      <?php if (mysqli_num_rows($resultado) > 0): ?>
        <table id="reportTable">
          <thead>
            <tr>
              <th data-col="0" data-type="number">Código</th>
              <th data-col="1" data-type="string">Fecha</th>
              <th data-col="2" data-type="string">Método de Pago</th>
              <th data-col="3" data-type="string">Vendedor</th>
              <th data-col="4" data-type="string">Cliente</th>
              <th data-col="5" data-type="string">Teléfono</th>
              <th data-col="6" data-type="string">Cédula Cliente</th>
              <th data-col="7" data-type="number">Total</th>
              <th data-col="8" data-type="none">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($fila = mysqli_fetch_assoc($resultado)) : ?>
              <tr>
                <td><?php echo $fila['codigo']; ?></td>
                <td><?php echo $fila['fechaGeneracion']; ?></td>
                <td><?php echo $fila['metodoPago']; ?></td>
                <td><?php echo $fila['nombreUsuario'] . " " . $fila['apellidoUsuario']; ?></td>
                <td><?php echo $fila['nombreCliente'] . " " . $fila['apellidoCliente']; ?></td>
                <td><?php echo $fila['telefonoCliente']; ?></td>
                <td><?php echo $fila['identificacionCliente']; ?></td>
                <td><?php echo number_format($fila['precioTotal']); ?></td>
                <td class="acciones">
                  <form method="POST">
                    <input type="hidden" name="factura_id" value="<?php echo $fila['codigo']; ?>">
                    <button type="submit" class="recibo-button" title="Ver recibo">
                      <i class='bx bx-search-alt' style='color:#fffbfb'></i>
                    </button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>No se encontraron resultados con los criterios seleccionados.</p>
      <?php endif; ?>
    </div>

    <!-- =============================== -->
    <!-- 8) PAGINACIÓN PHP (opcional)      -->
    <!-- =============================== -->
    <?php if ($total_paginas > 1): ?>
      <div class="pagination">
        <?php
        $base_params = $_GET;
        // Primera página
        $base_params['pagina'] = 1;
        $url = '?' . http_build_query($base_params);
        ?>
        <a href="<?= $url ?>">« Primera</a>

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
          echo '<span class="ellips" style="color:white">…</span>';
        }
        for ($i = $start; $i <= $end; $i++):
          $base_params['pagina'] = $i;
          $url = '?' . http_build_query($base_params);
        ?>
          <a href="<?= $url ?>"
             class="<?= $i == $pagina_actual ? 'active' : '' ?>">
            <?= $i ?>
          </a>
        <?php endfor;
        if ($end < $total_paginas) {
          echo '<span class="ellips" style="color:white">…</span>';
        }
        ?>

        <?php if ($pagina_actual < $total_paginas): ?>
          <?php
          $base_params['pagina'] = $pagina_actual + 1;
          $url = '?' . http_build_query($base_params);
          ?>
          <a href="<?= $url ?>">Siguiente ›</a>
        <?php endif; ?>

        <?php
        $base_params['pagina'] = $total_paginas;
        $url = '?' . http_build_query($base_params);
        ?>
        <a href="<?= $url ?>">Última »</a>
      </div>
    <?php endif; ?>

    <!-- =============================== -->
    <!-- 9) SCRIPT PARA ORDENAR, RESALTAR Y FILTRAR -->
    <!-- =============================== -->
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const table = document.getElementById('reportTable');
        if (!table) return;

        const thead = table.querySelector('thead');
        const tbody = table.querySelector('tbody');

        // 1) Función para obtener el valor "limpio" de una celda según tipo
        function getCellValue(row, colIndex, type) {
          const cellText = row.children[colIndex].textContent.trim();
          if (type === 'number') {
            // Convertir texto a número (quitando comas/puntos)
            return parseFloat(cellText.replace(/[.,]/g, '')) || 0;
          }
          if (type === 'string') {
            return cellText.toLowerCase();
          }
          return cellText;
        }

        // 2) Función para ordenar por columna
        function sortColumn(colIndex, type, asc = true) {
          const rowsArray = Array.from(tbody.querySelectorAll('tr'));
          rowsArray.sort(function (a, b) {
            const valA = getCellValue(a, colIndex, type);
            const valB = getCellValue(b, colIndex, type);
            if (valA < valB) return asc ? -1 : 1;
            if (valA > valB) return asc ? 1 : -1;
            return 0;
          });
          // Volver a insertar las filas en el orden correcto
          rowsArray.forEach(row => tbody.appendChild(row));
        }

        // 3) Control de orden ascendente/descendente
        const sortStates = {}; // { 0: true, 1: false, ... }

        // 4) Asociar clic a cada <th> ordenable
        thead.querySelectorAll('th').forEach(function (th) {
          const colIndex = parseInt(th.getAttribute('data-col'), 10);
          const type = th.getAttribute('data-type');
          if (!type || type === 'none') return; // no es ordenable

          sortStates[colIndex] = true; // inicial = ascendente
          th.addEventListener('click', function () {
            sortStates[colIndex] = !sortStates[colIndex]; // alternar
            sortColumn(colIndex, type, sortStates[colIndex]);
          });
        });

        // 5) Asociar clic a cada fila para resaltar
        tbody.querySelectorAll('tr').forEach(function (row) {
          row.addEventListener('click', function () {
            row.classList.toggle('selected');
          });
        });

        // 6) BÚSQUEDA EN TIEMPO REAL: filtrar filas a medida que el usuario escribe
        const inputBusqueda = document.getElementById('barraReportes');
        inputBusqueda.addEventListener('input', function () {
          const query = inputBusqueda.value.trim().toLowerCase();
          const allRows = tbody.querySelectorAll('tr');

          allRows.forEach(row => {
            const cells = Array.from(row.children);
            // Concatenamos el texto de todas las celdas para comparar
            const rowText = cells.map(td => td.textContent.trim().toLowerCase()).join(' ');
            if (rowText.indexOf(query) > -1) {
              row.style.display = ''; // mostrar
            } else {
              row.style.display = 'none'; // ocultar
            }
          });
        });
      });
    </script>

    <!-- =============================== -->
    <!-- 10) DATOS USUARIO (Nombre, Rol, Foto) -->
    <!-- =============================== -->
    <div class="userInfo">
      <?php
      $conexion2 = new mysqli('localhost', 'root', '', 'inventariomotoracer');
      $id_usuario = $_SESSION['usuario_id'];
      $sqlUsuario = "SELECT nombre, apellido, rol, foto 
                       FROM usuario 
                      WHERE identificacion = ?";
      $stmtUsuario = $conexion2->prepare($sqlUsuario);
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

  </div>
</body>
</html>
