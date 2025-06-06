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
// 1) FILTROS (fechas y criterios de búsqueda)       //
// ---------------------------------------------------
$filtros = [];

// (A) Lectura y sanitización de fechas
$fecha_desde_input = isset($_GET['fecha_desde']) ? trim($_GET['fecha_desde']) : '';
$fecha_hasta_input = isset($_GET['fecha_hasta']) ? trim($_GET['fecha_hasta']) : '';
if (!empty($fecha_desde_input) || !empty($fecha_hasta_input)) {
  if (!empty($fecha_desde_input) && !empty($fecha_hasta_input)) {
    $fecha_desde = mysqli_real_escape_string($conexion, $fecha_desde_input) . " 00:00:00";
    $fecha_hasta = mysqli_real_escape_string($conexion, $fecha_hasta_input) . " 23:59:59";
    $filtros[] = "f.fechaGeneracion BETWEEN '$fecha_desde' AND '$fecha_hasta'";
  } elseif (!empty($fecha_desde_input)) {
    $fecha_desde = mysqli_real_escape_string($conexion, $fecha_desde_input) . " 00:00:00";
    $filtros[] = "f.fechaGeneracion >= '$fecha_desde'";
  } else {
    $fecha_hasta = mysqli_real_escape_string($conexion, $fecha_hasta_input) . " 23:59:59";
    $filtros[] = "f.fechaGeneracion <= '$fecha_hasta'";
  }
}

// (B) Lectura de criterios de búsqueda
$criterios = isset($_GET['criterios']) && is_array($_GET['criterios']) ? $_GET['criterios'] : [];

// ---------------------------------------------------
// 2) CONSULTA PRINCIPAL: traemos **TODOS** los datos //
//    (sin LIMIT ni OFFSET) para pasarlos a JS        //
// ---------------------------------------------------
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
    f.activo,
    f.observacion,
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
    f.identificacionCliente,
    f.activo,
    f.observacion
  ORDER BY f.fechaGeneracion DESC
";

$resultado = mysqli_query($conexion, $sql);
if (!$resultado) {
  die("No se pudo ejecutar la consulta: " . mysqli_error($conexion));
}

// Recorrer todos los resultados en un array PHP
$todosLosDatos = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    $todosLosDatos[] = $fila;
}

// ELIMINAR FACTURA (igual que antes)
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

// REDIRECCIÓN A RECIBO (igual que antes)
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
  <script src="../js/header.js"></script>
  <script src="/js/index.js"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
  </style>

  <!-- =============================== -->
  <!-- 4) ESTILOS ADICIONALES (inline)    -->
  <!-- =============================== -->
  <style>
    /* Resaltado de fila seleccionada */
    #reportTable tbody tr.selected {
      background-color: rgba(0, 123, 255, 0.15);
    }
    #reportTable tbody tr.selected td {
      background-color: rgba(0, 123, 255, 0.15);
    }

    /* Cursor pointer en encabezados, para indicar que son clicables */
    #reportTable th {
      cursor: pointer;
      position: relative;
      user-select: none;
    }

    /* Flecha de ordenamiento en cada <th> */
    .sort-arrow {
      margin-left: 5px;
      font-size: 0.8em;
      display: inline-block;
      width: 0.8em;
      text-align: center;
    }

    /* Botón para "Activo/Inactivo" */
    .btn-activo {
      padding: 4px 8px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 0.85em;
    }
    .btn-activo.activo {
      background-color: #28a745;
      color: white;
    }
    .btn-activo.inactivo {
      background-color: #dc3545;
      color: white;
    }

    /* Estilos básicos para paginación (se generará dinámicamente) */
    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 20px;
      gap: 5px;
      flex-wrap: wrap;
    }
    .pagination button {
      padding: 6px 10px;
      background-color: #f0f0f0;
      border: 1px solid #ccc;
      color: #333;
      border-radius: 4px;
      cursor: pointer;
      font-size: 0.9em;
    }
    .pagination button:hover:not(.active) {
      background-color: rgb(158, 146, 209);
    }
    .pagination button.active {
      background-color: #007bff;
      color: white;
      font-weight: bold;
      pointer-events: none;
      border-color: #007bff;
    }

    /* Estilos para la barra de búsqueda externa */
    .search-bar-container {
      margin-bottom: 15px;
      text-align: right; /* la colocamos a la derecha */
    }
    .search-bar-container input[type="text"] {
      width: 250px;
      padding: 6px 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
  </style>
</head>

<body>
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
          <!-- Formulario de filtros: fechas + criterios -->
          <form id="formFiltros" method="GET" action="../html/reportes.php" class="search-form">
            <div class="criteria-group">
              <label>
                <input type="checkbox" name="criterios[]" value="codigo"
                       <?php echo in_array('codigo', $criterios) ? 'checked' : ''; ?>>
                Código
              </label>
              <label>
                <input type="checkbox" name="criterios[]" value="fechaGeneracion"
                       <?php echo in_array('fechaGeneracion', $criterios) ? 'checked' : ''; ?>>
                Fecha
              </label>
              <label>
                <input type="checkbox" name="criterios[]" value="metodoPago"
                       <?php echo in_array('metodoPago', $criterios) ? 'checked' : ''; ?>>
                Método pago
              </label>
              <label>
                <input type="checkbox" name="criterios[]" value="vendedor"
                       <?php echo in_array('vendedor', $criterios) ? 'checked' : ''; ?>>
                Vendedor
              </label>
              <label>
                <input type="checkbox" name="criterios[]" value="cliente"
                       <?php echo in_array('cliente', $criterios) ? 'checked' : ''; ?>>
                Cliente
              </label>
              <label>
                <input type="checkbox" name="criterios[]" value="precioTotal"
                       <?php echo in_array('precioTotal', $criterios) ? 'checked' : ''; ?>>
                Total
              </label>
              <label>
                <input type="checkbox" name="criterios[]" value="activo"
                       <?php echo in_array('activo', $criterios) ? 'checked' : ''; ?>>
                Activo
              </label>
              <label>
                <input type="checkbox" name="criterios[]" value="observacion"
                       <?php echo in_array('observacion', $criterios) ? 'checked' : ''; ?>>
                Observación
              </label>
            </div>

            <div class="date-filters">
              <label>
                Desde: <input type="date" name="fecha_desde"
                              value="<?php echo htmlspecialchars($fecha_desde_input); ?>">
              </label>
              <label>
                Hasta: <input type="date" name="fecha_hasta"
                              value="<?php echo htmlspecialchars($fecha_hasta_input); ?>">
              </label>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 10px;">
              Aplicar filtros
            </button>
          </form>
        </div>
      </details>

      <!-- == BARRA DE BÚSQUEDA EXTERNA == -->
      <div class="search-bar-container">
        <form onsubmit="return false;">
          <input id="barraReportes" type="text"
                 placeholder="Buscar en resultados..."
                 autocomplete="off">
        </form>
      </div>

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
      <table id="reportTable">
        <thead>
          <tr>
            <th data-col="0" data-type="number">
              Código<span class="sort-arrow"></span>
            </th>
            <th data-col="1" data-type="string">
              Fecha<span class="sort-arrow"></span>
            </th>
            <th data-col="2" data-type="string">
              Método de Pago<span class="sort-arrow"></span>
            </th>
            <th data-col="3" data-type="string">
              Vendedor<span class="sort-arrow"></span>
            </th>
            <th data-col="4" data-type="string">
              Cliente<span class="sort-arrow"></span>
            </th>
            <th data-col="5" data-type="string">
              Teléfono<span class="sort-arrow"></span>
            </th>
            <th data-col="6" data-type="string">
              Cédula Cliente<span class="sort-arrow"></span>
            </th>
            <th data-col="7" data-type="number">
              Total<span class="sort-arrow"></span>
            </th>
            <th data-col="8" data-type="string">
              Activo<span class="sort-arrow"></span>
            </th>
            <th data-col="9" data-type="string">
              Observación<span class="sort-arrow"></span>
            </th>
            <th data-col="10" data-type="none">
              Acciones
            </th>
          </tr>
        </thead>
        <tbody>
          <!-- Se llenará dinámicamente con JavaScript -->
        </tbody>
      </table>
    </div>

    <!-- =============================== -->
    <!-- 8) Contenedor para paginación JS -->
    <!-- =============================== -->
    <div id="paginationContainer" class="pagination"></div>

    <!-- =============================== -->
    <!-- 9) Código JavaScript para manejar -->
    <!--      - carga de datos             -->
    <!--      - filtrado en tiempo real     -->
    <!--      - ordenamiento por columnas   -->
    <!--      - paginación dinámica         -->
    <!--      - toggle de 'activo' vía AJAX -->
    <!-- =============================== -->
    <script>
      // 1) Convertimos el array PHP $todosLosDatos a un array JS
      const allData = <?php echo json_encode($todosLosDatos, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;

      // 2) Variables de estado
      let filteredData = [...allData]; // comienza idéntico a allData
      const rowsPerPage = 10;
      let currentPage = 1;
      const tableBody = document.querySelector('#reportTable tbody');
      const paginationContainer = document.getElementById('paginationContainer');
      const inputBusqueda = document.getElementById('barraReportes');

      // 3) Función para obtener valor “limpio” de un campo según criterio de filtro
      function getFieldValue(rowObj, criterion) {
        switch(criterion) {
          case 'codigo':
            return rowObj.codigo.toString().toLowerCase();
          case 'fechaGeneracion':
            return rowObj.fechaGeneracion.toLowerCase();
          case 'metodoPago':
            return (rowObj.metodoPago || '').toLowerCase();
          case 'vendedor':
            return (rowObj.nombreUsuario + ' ' + rowObj.apellidoUsuario).toLowerCase();
          case 'cliente':
            return (rowObj.nombreCliente + ' ' + rowObj.apellidoCliente).toLowerCase();
          case 'telefonoCliente':
            return (rowObj.telefonoCliente || '').toLowerCase();
          case 'identificacionCliente':
            return (rowObj.identificacionCliente || '').toLowerCase();
          case 'precioTotal':
            return rowObj.precioTotal.toString().toLowerCase();
          case 'activo':
            return (rowObj.activo ? 'activo' : 'inactivo').toLowerCase();
          case 'observacion':
            return (rowObj.observacion || '').toLowerCase();
          default:
            return '';
        }
      }

      // 4) Función para ordenar `filteredData` según índice de columna
      function getCellValueForSort(rowObj, colIndex) {
        switch(colIndex) {
          case 0: return parseInt(rowObj.codigo) || 0;
          case 1: return rowObj.fechaGeneracion.toLowerCase();
          case 2: return (rowObj.metodoPago || '').toLowerCase();
          case 3: return (rowObj.nombreUsuario + ' ' + rowObj.apellidoUsuario).toLowerCase();
          case 4: return (rowObj.nombreCliente + ' ' + rowObj.apellidoCliente).toLowerCase();
          case 5: return (rowObj.telefonoCliente || '').toLowerCase();
          case 6: return (rowObj.identificacionCliente || '').toLowerCase();
          case 7: return parseFloat(rowObj.precioTotal) || 0;
          case 8: return (rowObj.activo ? 'activo' : 'inactivo').toLowerCase();
          case 9: return (rowObj.observacion || '').toLowerCase();
          default: return '';
        }
      }
      function sortData(colIndex, asc = true) {
        filteredData.sort((a, b) => {
          const valA = getCellValueForSort(a, colIndex);
          const valB = getCellValueForSort(b, colIndex);
          if (valA < valB) return asc ? -1 : 1;
          if (valA > valB) return asc ? 1 : -1;
          return 0;
        });
      }

      // 5) Función que pinta las filas de la página actual en <tbody>
      function renderTable() {
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const pageData = filteredData.slice(start, end);

        tableBody.innerHTML = '';
        pageData.forEach((rowObj, index) => {
          const tr = document.createElement('tr');

          // 1) Código
          let td = document.createElement('td');
          td.textContent = rowObj.codigo;
          tr.appendChild(td);

          // 2) Fecha
          td = document.createElement('td');
          td.textContent = rowObj.fechaGeneracion;
          tr.appendChild(td);

          // 3) Método de Pago
          td = document.createElement('td');
          td.textContent = rowObj.metodoPago;
          tr.appendChild(td);

          // 4) Vendedor
          td = document.createElement('td');
          td.textContent = rowObj.nombreUsuario + ' ' + rowObj.apellidoUsuario;
          tr.appendChild(td);

          // 5) Cliente
          td = document.createElement('td');
          td.textContent = rowObj.nombreCliente + ' ' + rowObj.apellidoCliente;
          tr.appendChild(td);

          // 6) Teléfono
          td = document.createElement('td');
          td.textContent = rowObj.telefonoCliente;
          tr.appendChild(td);

          // 7) Cédula Cliente
          td = document.createElement('td');
          td.textContent = rowObj.identificacionCliente;
          tr.appendChild(td);

          // 8) Total
          td = document.createElement('td');
          td.textContent = Number(rowObj.precioTotal).toLocaleString();
          tr.appendChild(td);

          // 9) Activo como botón
          td = document.createElement('td');
          const btnActivo = document.createElement('button');
          btnActivo.textContent = rowObj.activo ? 'Activo' : 'Inactivo';
          btnActivo.classList.add('btn-activo');
          btnActivo.classList.add(rowObj.activo ? 'activo' : 'inactivo');
          btnActivo.addEventListener('click', () => {
            toggleActivo(rowObj.codigo, rowObj.activo ? 0 : 1, btnActivo, rowObj);
          });
          td.appendChild(btnActivo);
          tr.appendChild(td);

          // 10) Observación
          td = document.createElement('td');
          td.textContent = rowObj.observacion || '';
          tr.appendChild(td);

          // 11) Acciones (ver recibo)
          td = document.createElement('td');
          td.classList.add('acciones');
          const form = document.createElement('form');
          form.method = 'POST';
          const hidden = document.createElement('input');
          hidden.type = 'hidden';
          hidden.name = 'factura_id';
          hidden.value = rowObj.codigo;
          form.appendChild(hidden);
          const btn = document.createElement('button');
          btn.type = 'submit';
          btn.className = 'recibo-button';
          btn.title = 'Ver recibo';
          btn.innerHTML = "<i class='bx bx-search-alt' style='color:#fffbfb'></i>";
          form.appendChild(btn);
          td.appendChild(form);
          tr.appendChild(td);

          // Resaltar fila al clic
          tr.addEventListener('click', () => {
            tr.classList.toggle('selected');
          });

          tableBody.appendChild(tr);
        });

        renderPaginationControls();
      }

      // 6) Función para generar controles de paginación en #paginationContainer
      function renderPaginationControls() {
        paginationContainer.innerHTML = '';
        const totalPages = Math.ceil(filteredData.length / rowsPerPage);
        if (totalPages <= 1) return;

        // Botón “« Primera”
        const btnFirst = document.createElement('button');
        btnFirst.textContent = '« Primera';
        btnFirst.disabled = (currentPage === 1);
        btnFirst.addEventListener('click', () => {
          currentPage = 1;
          renderTable();
        });
        if (currentPage === 1) btnFirst.classList.add('active');
        paginationContainer.appendChild(btnFirst);

        // Botón “‹ Anterior”
        const btnPrev = document.createElement('button');
        btnPrev.textContent = '‹ Anterior';
        btnPrev.disabled = (currentPage === 1);
        btnPrev.addEventListener('click', () => {
          if (currentPage > 1) currentPage--;
          renderTable();
        });
        if (currentPage === 1) btnPrev.classList.add('active');
        paginationContainer.appendChild(btnPrev);

        // Botones de páginas (hasta 5 alrededor de currentPage)
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, currentPage + 2);
        if (currentPage <= 2) {
          endPage = Math.min(5, totalPages);
        }
        if (currentPage >= totalPages - 1) {
          startPage = Math.max(1, totalPages - 4);
        }

        if (startPage > 1) {
          const ellipsis = document.createElement('button');
          ellipsis.textContent = '…';
          ellipsis.disabled = true;
          paginationContainer.appendChild(ellipsis);
        }

        for (let i = startPage; i <= endPage; i++) {
          const btnPage = document.createElement('button');
          btnPage.textContent = i;
          if (i === currentPage) btnPage.classList.add('active');
          btnPage.addEventListener('click', () => {
            currentPage = i;
            renderTable();
          });
          paginationContainer.appendChild(btnPage);
        }

        if (endPage < totalPages) {
          const ellipsis2 = document.createElement('button');
          ellipsis2.textContent = '…';
          ellipsis2.disabled = true;
          paginationContainer.appendChild(ellipsis2);
        }

        // Botón “Siguiente ›”
        const btnNext = document.createElement('button');
        btnNext.textContent = 'Siguiente ›';
        btnNext.disabled = (currentPage === totalPages);
        btnNext.addEventListener('click', () => {
          if (currentPage < totalPages) currentPage++;
          renderTable();
        });
        if (currentPage === totalPages) btnNext.classList.add('active');
        paginationContainer.appendChild(btnNext);

        // Botón “Última »”
        const btnLast = document.createElement('button');
        btnLast.textContent = 'Última »';
        btnLast.disabled = (currentPage === totalPages);
        btnLast.addEventListener('click', () => {
          currentPage = totalPages;
          renderTable();
        });
        if (currentPage === totalPages) btnLast.classList.add('active');
        paginationContainer.appendChild(btnLast);
      }

      // 7) Función de filtrado en tiempo real, respetando criterios seleccionados
      function applyFilter() {
        const query = inputBusqueda.value.trim().toLowerCase();
        // Obtenemos los criterios marcados en el formulario de filtros
        const checkedBoxes = document.querySelectorAll('input[name="criterios[]"]:checked');
        const selectedCriteria = Array.from(checkedBoxes).map(cb => cb.value);

        if (query === '') {
          // Si no hay texto, volvemos a todos los datos
          filteredData = [...allData];
        } else if (selectedCriteria.length === 0) {
          // Si ningún criterio está marcado, búsqueda "global"
          filteredData = allData.filter(row => {
            const composite = 
              row.codigo + ' ' +
              row.fechaGeneracion + ' ' +
              row.metodoPago + ' ' +
              row.nombreUsuario + ' ' +
              row.apellidoUsuario + ' ' +
              row.nombreCliente + ' ' +
              row.apellidoCliente + ' ' +
              row.telefonoCliente + ' ' +
              row.identificacionCliente + ' ' +
              row.precioTotal + ' ' +
              (row.activo ? 'activo' : 'inactivo') + ' ' +
              row.observacion;
            return composite.toString().toLowerCase().includes(query);
          });
        } else {
          // Si hay uno o más criterios, buscamos solo en esos campos
          filteredData = allData.filter(row => {
            for (const crit of selectedCriteria) {
              const fieldValue = getFieldValue(row, crit);
              if (fieldValue.includes(query)) {
                return true;
              }
            }
            return false;
          });
        }

        currentPage = 1;
        renderTable();
      }

      // 8) Control de ordenamiento en encabezados (igual que antes, pero sobre filteredData)
      const thead = document.querySelector('#reportTable thead');
      const sortStates = {};

      thead.querySelectorAll('th').forEach(th => {
        const colIndex = parseInt(th.getAttribute('data-col'), 10);
        const type = th.getAttribute('data-type');
        if (!type || type === 'none') return;

        sortStates[colIndex] = true;

        th.addEventListener('click', () => {
          sortStates[colIndex] = !sortStates[colIndex];
          sortData(colIndex, sortStates[colIndex]);

          thead.querySelectorAll('th .sort-arrow').forEach(span => {
            span.textContent = '';
          });
          const arrowSpan = th.querySelector('.sort-arrow');
          arrowSpan.textContent = sortStates[colIndex] ? '▲' : '▼';

          renderTable();
        });
      });

      // 9) Función para cambiar el estado "activo" vía AJAX
      function toggleActivo(codigo, nuevoEstado, btn, rowObj) {
        fetch('toggle_activo.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `codigo=${encodeURIComponent(codigo)}&nuevo_estado=${encodeURIComponent(nuevoEstado)}`
        })
        .then(resp => resp.json())
        .then(data => {
          if (data.success) {
            // Actualizamos el texto y la clase del botón
            rowObj.activo = (data.nuevo_estado == 1);
            btn.textContent = rowObj.activo ? 'Activo' : 'Inactivo';
            btn.classList.toggle('activo', rowObj.activo);
            btn.classList.toggle('inactivo', !rowObj.activo);
          } else {
            Swal.fire("Error", data.error || "No se pudo cambiar el estado", "error");
          }
        })
        .catch(err => {
          console.error(err);
          Swal.fire("Error", "Error al conectar con el servidor", "error");
        });
      }

      // 10) Configurar “input” para filtrado en tiempo real (con debounce)
      let debounceTimeout = null;
      inputBusqueda.addEventListener('input', () => {
        if (debounceTimeout) clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
          applyFilter();
        }, 300);
      });

      // 11) Al cargar la página, pintamos todo por primera vez
      document.addEventListener('DOMContentLoaded', () => {
        renderTable();
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
