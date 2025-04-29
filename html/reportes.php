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

// Inicializar el arreglo de filtros
$filtros = [];

// Manejar filtro de fechas

if (!empty($_GET['fecha_desde']) && !empty($_GET['fecha_hasta'])) {
  $fecha_desde = mysqli_real_escape_string($conexion, $_GET['fecha_desde']) . " 00:00:00";
  $fecha_hasta = mysqli_real_escape_string($conexion, $_GET['fecha_hasta']) . " 23:59:59";
  $filtros[] = "f.fechaGeneracion BETWEEN '$fecha_desde' AND '$fecha_hasta'";
}

// Manejar búsqueda general y criterios
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
          $condiciones[] = "EXISTS (SELECT 1 FROM factura_metodo_pago tmp WHERE tmp.Factura_codigo = f.codigo AND tmp.metodoPago = '$busqueda')";
          break;
        case 'cliente':
          $condiciones[] = "(c.nombre LIKE '%$busqueda%' OR c.apellido LIKE '%$busqueda%')";
          break;
        case 'vendedor':
          $condiciones[] = "(n.nombre LIKE '%$busqueda%' OR n.apellido LIKE '%$busqueda%')";
          break;
        case 'precioTotal':
          $condiciones[] = "f.precioTotal = '$busqueda'";
          break;
      }
    }
    $filtros[] = '(' . implode(' OR ', $condiciones) . ')';
  } else {
    $general = [
      "f.codigo = '$busqueda'",
      "f.Cliente_codigo = '$busqueda'",
      "f.precioTotal = '$busqueda'",
      "(c.nombre LIKE '%$busqueda%' OR c.apellido LIKE '%$busqueda%')",
      "(n.nombre LIKE '%$busqueda%' OR n.apellido LIKE '%$busqueda%')",
      "EXISTS (SELECT 1 FROM factura_metodo_pago tmp WHERE tmp.Factura_codigo = f.codigo AND tmp.metodoPago = '$busqueda')"
    ];
    $filtros[] = '(' . implode(' OR ', $general) . ')';
  }
}

// PAGINACIÓN
$registros_por_pagina = 10;
$pagina_actual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Consulta para contar total de resultados
$sql_count = "SELECT COUNT(DISTINCT f.codigo) AS total
FROM factura f
LEFT JOIN factura_metodo_pago m ON m.Factura_codigo = f.codigo
LEFT JOIN cliente c ON c.codigo = f.Cliente_codigo
LEFT JOIN usuario n ON n.identificacion = f.Usuario_identificacion";
if (!empty($filtros)) {
  $sql_count .= " WHERE " . implode(' AND ', $filtros);
}
$result_count = mysqli_query($conexion, $sql_count);
$total_filas = mysqli_fetch_assoc($result_count)['total'];
$total_paginas = ceil($total_filas / $registros_por_pagina);

// Consulta principal con filtros, agrupación y paginación
$sql = "SELECT 
  f.codigo,
  f.fechaGeneracion,
  f.Usuario_identificacion,
  f.Cliente_codigo,
  f.precioTotal,
  c.nombre AS cliente_nombre,
  c.apellido AS cliente_apellido,
  n.nombre AS usuario_nombre,
  n.apellido AS usuario_apellido,
  GROUP_CONCAT(DISTINCT m.metodoPago SEPARATOR ', ') AS metodoPago
FROM factura f
LEFT JOIN factura_metodo_pago m ON m.Factura_codigo = f.codigo
LEFT JOIN cliente c ON c.codigo = f.Cliente_codigo
LEFT JOIN usuario n ON n.identificacion = f.Usuario_identificacion";
if (!empty($filtros)) {
  $sql .= " WHERE " . implode(' AND ', $filtros);
}
$sql .= " GROUP BY 
  f.codigo,
  f.fechaGeneracion,
  f.Usuario_identificacion,
  f.Cliente_codigo,
  f.precioTotal,
  c.nombre,
  c.apellido,
  n.nombre,
  n.apellido
LIMIT $registros_por_pagina OFFSET $offset";

$resultado = mysqli_query($conexion, $sql);
if (!$resultado) {
  die("No se pudo ejecutar la consulta: " . mysqli_error($conexion));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'], $_POST['codigo'])) {
  header('Content-Type: application/json');
  $response = ['success' => false, 'error' => ''];

  try {
    $codigo = $_POST['codigo'];

    // Iniciar transacción
    mysqli_begin_transaction($conexion);

    // 1. Eliminar método de pago
    $stmt1 = $conexion->prepare("DELETE FROM factura_metodo_pago WHERE Factura_codigo = ?");
    $stmt1->bind_param("i", $codigo);
    if (!$stmt1->execute()) {
      throw new Exception("Error en metodo_pago: " . $stmt1->error);
    }

    // 2. Eliminar productos de la factura
    $stmt2 = $conexion->prepare("DELETE FROM producto_factura WHERE Factura_codigo = ?");
    $stmt2->bind_param("i", $codigo);
    if (!$stmt2->execute()) {
      throw new Exception("Error en producto_factura: " . $stmt2->error);
    }

    // 3. Eliminar la factura principal
    $stmt3 = $conexion->prepare("DELETE FROM factura WHERE codigo = ?");
    $stmt3->bind_param("i", $codigo);
    if (!$stmt3->execute()) {
      throw new Exception("Error en factura: " . $stmt3->error);
    }

    // Confirmar cambios si todo fue bien
    mysqli_commit($conexion);
    $response['success'] = true;
  } catch (Exception $e) {
    // Revertir cambios en caso de error
    mysqli_rollback($conexion);
    $response['error'] = $e->getMessage();
  } finally {
    // Cerrar statements
    if (isset($stmt1)) $stmt1->close();
    if (isset($stmt2)) $stmt2->close();
    if (isset($stmt3)) $stmt3->close();
  }

  echo json_encode($response);
  exit;
}

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
  <link rel="preload" as="image" href="https://animatedicons.co/get-icon?name=delete&style=minimalistic&token=c1352b7b-2e14-4124-b8fd-a064d7e44225">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="../css/reporte.css" />
  <link rel="stylesheet" href="../componentes/header.css">
  <link rel="stylesheet" href="../componentes/header.php">
  <script src="../js/header.js"></script>
  <script src="/js/index.js"></script>
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
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
<script>
  function eliminarFactura(codigo) {
    Swal.fire({
        title: '<span class="titulo-alerta advertencia">¿Estas Seguro?</span>',
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
    confirmButtonColor: '#dc3545', // Rojo para botón eliminar
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
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `eliminar=1&codigo=${encodeURIComponent(codigo)}`
        })
        .then(response => {
          if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
          return response.json();
        })
        .then(data => {
          if (data.success) {
            Swal.fire({
                title: '<span class="titulo-alerta confirmacion">Exito</span>',
              html: `
                <div class="custom-alert">
                  <div class="contenedor-imagen">
                    <img src="../imagenes/moto.png" alt="Confirmacion" class="moto">
                  </div>
                  <p>La factura <strong>${codigo}</strong> ha sido eliminado correctamente.</p>
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


  </script>
  <div class="sidebar">
    <div id="menu"></div>
  </div>
  <div class="main-content">
    <h1>Reportes</h1>
    <div class="filter-bar">
      <form method="GET" action="../html/reportes.php" class="search-form"> <!-- Form único que envía todo -->
        <details class="filter-dropdown">
          <summary class="filter-button">Filtrar</summary>
          <div class="filter-options">
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

        <!-- Barra de búsqueda principal -->
        <div class="search-container">
          <input style="width: 650px" id="barraReportes" type="text"
            name="busqueda"
            placeholder="Buscar..."
            value="<?= htmlspecialchars($_GET['busqueda'] ?? '') ?>">
          <button type="submit" class="search-button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </form>
      <div class="export-button">
        <form action="excel_reporte.php" method="post">
          <button type="submit" class="icon-button" aria-label="Exportar a Excel" title="Exportar a Excel">

            <!-- Agregar este botón junto al botón de exportar -->
            <i class="fas fa-file-excel"></i>
            <label> Exportar a Excel</label>
          </button>
        </form>

        <button id="delete-selected" class="btn btn-danger" style="display: none;">
          <i class="fa-solid fa-trash"></i>
        </button>


      </div>

    </div>

    <?php if (mysqli_num_rows($resultado) > 0): ?>
      <table>
        <thead>
          <tr>
            <th>Código</th>
            <th>Fecha</th>
            <th>Método de Pago</th>
            <th>Vendedor</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Acciones</th>
            <th><input type="checkbox" id="select-all"></th>
          </tr>
        </thead>
        <tbody>
          <?php while ($fila = mysqli_fetch_assoc($resultado)) : ?>
            <tr>
              <td><?php echo $fila['codigo']; ?></td>
              <td><?php echo $fila['fechaGeneracion']; ?></td>
              <td><?php echo $fila['metodoPago']; ?></td>
              <td><?php echo $fila['usuario_nombre'] . " " . $fila['usuario_apellido']; ?></td>
              <td><?php echo $fila['cliente_nombre'] . " " . $fila['cliente_apellido']; ?></td>
              <td><?php echo number_format($fila['precioTotal'], 2); ?></td>
              <td class="acciones">
                <button class="delete-button" onclick="eliminarFactura('<?= $fila['codigo'] ?>')"><i class="fa-solid fa-trash" style='color:#fffbfb'></i></button>
                <form method="POST">
                  <input type="hidden" name="factura_id" value="<?php echo $fila['codigo']; ?>">
                  <button type="submit" class="recibo-button">
                    <i class='bx bx-search-alt' style='color:#fffbfb'></i>
                  </button>
                </form>
              </td>
              <td>
                <input type="checkbox" class="select-product" value="<?= $fila['codigo'] ?>">
              </td> <!-- Checkbox agregado -->
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No se encontraron resultados con los criterios seleccionados.</p>
    <?php endif; ?>


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
        <?php if ($pagina_actual > 1): ?>
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
          echo '<span class="ellips" style="color:white">…</span>';
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
          echo '<span class="ellips" style="color:white">…</span>';
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
    <script>
      // funcion de los checkboxes
      document.getElementById("select-all").addEventListener("change", function() {
        let checkboxes = document.querySelectorAll(".select-product");
        checkboxes.forEach(checkbox => {
          checkbox.checked = this.checked;
        });
      });

      document.addEventListener("DOMContentLoaded", function() {
        let selectAllCheckbox = document.getElementById("select-all");
        let checkboxes = document.querySelectorAll(".select-product");
        let deleteButton = document.getElementById("delete-selected");

        function toggleDeleteButton() {
          let anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
          deleteButton.style.display = anyChecked ? "inline-block" : "none";
        }

        selectAllCheckbox.addEventListener("change", function() {
          checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
          });
          toggleDeleteButton();
        });

        checkboxes.forEach(checkbox => {
          checkbox.addEventListener("change", toggleDeleteButton);
        });

        deleteButton.addEventListener("click", function() {
          let selectedCodes = Array.from(checkboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value.trim()); // Limpiar espacios en blanco

            if (selectedCodes.length === 0) {
  Swal.fire({
    title: "Advertencia",
    html: `
      <div class="alerta">
        <div class="contenedor-imagen">
          <img src="../imagenes/advertencia.png" class="tornillo">
        </div>
        <p>Selecciona al menos una factura para eliminar.</p>
      </div>
    `,
    confirmButtonText: "Aceptar",
    customClass: {
      confirmButton: "btn-aceptar",
      popup: "custom-alert"
    }
  });
  return;
}

Swal.fire({
    title: '<span class="titulo-alerta advertencia">¿Estas Seguro?</span>',
  html: `
    <div class="custom-alert">
      <div class="contenedor-imagen">
        <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
      </div>
      <p>¿Quieres eliminar <strong>${selectedCodes.length}</strong> factura(s)?</p>
    </div>
  `,
  background: '#ffffffdb',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar',
    confirmButtonColor: '#dc3545', // Rojo para botón eliminar
    customClass: {
        popup: 'swal2-border-radius',
        confirmButton: 'btn-eliminar',
        cancelButton: 'btn-cancelar',
        container: 'fondo-oscuro'
    }
}).then((result) => {
  if (result.isConfirmed) {
    console.log("Enviando códigos a eliminar:", selectedCodes);

    fetch("../html/eliminar_factura.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        codigos: selectedCodes
      })
    })
      .then(response => response.json())
      .then(data => {
        console.log("Respuesta del servidor:", data);
        if (data.success) {
          Swal.fire({
            title: '<span class="titulo-alerta confirmacion">FActuras Elimindas</span>',
            html: `
              <div class="custom-alert">
                <div class="contenedor-imagen">
                  <img src="../imagenes/moto.png" alt="Confirmacion" class="moto">
                </div>
                <p>Las facturas fueron eliminadas correctamente.</p>
              </div>
            `,
            confirmButtonText: "Aceptar",
            customClass: {
              confirmButton: "btn-aceptar",
              popup: "custom-alert"
            }
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire("Error", data.error || "No se pudo completar la eliminación", "error");
        }
      })
      .catch(error => {
        console.error("Error en la solicitud:", error);
        Swal.fire("Error", "Error en la comunicación con el servidor.", "error");
      });
  }
});
});
});

      
    </script>
</body>

</html>