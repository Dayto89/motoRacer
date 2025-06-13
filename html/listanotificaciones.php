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

// justo tras conectar a BD
$allQ = "SELECT id,mensaje,descripcion,fecha,leida FROM notificaciones n";
if (!empty($filtros)) $allQ .= " WHERE " . implode(' OR ', $filtros);
$allRes = mysqli_query($conexion, $allQ);
$allData = mysqli_fetch_all($allRes, MYSQLI_ASSOC);


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
  <script>
    function eliminarNotificacion(id) {
      if (!confirm('¿Eliminar esta notificación?')) return;
      fetch('delete_notificacion.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            id
          })
        })
        .then(r => r.json())
        .then(resp => {
          if (resp.success) location.reload();
          else alert('No se pudo eliminar');
        });
    }
  </script>
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
      display: none;
    }

    .pagination-dinamica {
      display: flex;
      justify-content: center;
      margin-top: 23px;
      gap: 12px;
      font-family: arial;
      font-size: 11px;
    }

    .pagination-dinamica button {
      padding: 8px 12px;
      background-color: #f0f0f0;
      border: 1px solid #ccc;
      text-decoration: none;
      color: #333;
      border-radius: 4px;
      transition: background-color 0.3s;
      cursor: pointer;
    }

    .pagination-dinamica button:hover {
      background-color: rgb(158, 146, 209);
    }

    .pagination-dinamica button.active {
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

    #notificacionesTable tbody tr:hover,
    #NotificacionesTable tbody tr:hover td {
      background-color: rgba(0, 123, 255, 0.15);
    }
  </style>
</head>

<body>
  <?php
  // Justo después de tu conexión y filtros:
  $allQ = "SELECT id,mensaje,descripcion,fecha,leida FROM notificaciones n";
  if (!empty($filtros)) $allQ .= " WHERE " . implode(' OR ', $filtros);
  $allRes = mysqli_query($conexion, $allQ);
  $allData = mysqli_fetch_all($allRes, MYSQLI_ASSOC);
  ?>
  <script>
    const allData = <?php echo json_encode($allData, JSON_HEX_TAG | JSON_HEX_APOS); ?>;
  </script>
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
          <form id="filterForm">
            <!-- Fecha desde/hasta -->
            <div class="form-group">
              <label for="filterFrom">Desde:</label>
              <input type="date" id="filterFrom" name="filterFrom">
            </div>
            <div class="form-group">
              <label for="filterTo">Hasta:</label>
              <input type="date" id="filterTo" name="filterTo">
            </div>
            <!-- Estado -->
            <div class="form-group">
              <label for="filterState">Estado:</label>
              <select id="filterState" name="filterState">
                <option value="all">Todas</option>
                <option value="read">Leídas</option>
                <option value="unread">No leídas</option>
              </select>
            </div>
            <div class="form-group">
              <button type="button" id="clearFilters" class="filter-button">Limpiar Filtros</button>
            </div>
          </form>
        </div>
      </details>
      </form>
      <input type="text" id="searchRealtime" name="valor" placeholder="Ingrese el valor a buscar">
      <!-- Botón para eliminar seleccionados -->
      <button id="delete-selected" class="btn btn-danger" style="display: none;">
        <i class="fa-solid fa-trash"></i>
      </button>
    </div>
    <div style="margin-bottom: 25px;margin-left: 74%;size: 50%;font-family:Arial;">
      <a href="exportar_notificaciones_excel.php" class="boton-accion marcarL"> <i class="fas fa-file-excel icon-color"></i><label> Exportar a Excel</label></a>
      <a href="exportar_notificaciones_pdf.php" class="boton-accion marcarN"><i class="fa-solid fa-file-pdf icon-color"></i><label> Exportar a PDF</label></a>
    </div>

    <table id="notificacionesTable">
      <thead>
        <tr>
          <th data-col="0" data-type="string">Mensaje<span class="sort-arrow"></span></th>
          <th data-col="1" data-type="string">Descripción<span class="sort-arrow"></span></th>
          <th data-col="2" data-type="string">Fecha<span class="sort-arrow"></span></th>
          <th data-col="3" data-type="string">Estado<span class="sort-arrow"></span></th>
          <th data-col="4" data-type="none">Acción</th>
          <th data-col="5" data-type="none" class="acciones-multiples">
            <input type="checkbox" id="select-all">
          </th>
        </tr>
      </thead>
      <tbody>
        <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
          <tr>
            <td><?= htmlspecialchars($fila["mensaje"]) ?></td>
            <td><?= htmlspecialchars($fila["descripcion"]) ?></td>
            <td><?= htmlspecialchars($fila["fecha"]) ?></td>
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
            <td></td>
            <td>

            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <div id="jsPagination" class="pagination-dinamica"></div>
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

  <script>
    // 2) NORMALIZACIÓN: esto se ejecuta solo UNA VEZ
    allData.forEach(r => {
      // convierte "0"/"1" en booleano false/true
      r.leida = (String(r.leida) === "1");
    });
    document.addEventListener('DOMContentLoaded', () => {


      const inputText = document.getElementById('searchRealtime');
      const btnClear    = document.getElementById('clearFilters');
      const dateFrom = document.getElementById('filterFrom');
      const dateTo = document.getElementById('filterTo');
      const selectState = document.getElementById('filterState');

      const rowsPerPage = 7;
      let currentPage = 1;
      let filteredData = [...allData];

      const tableBody = document.querySelector('#notificacionesTable tbody');
      const paginationContainer = document.getElementById('jsPagination');
      const inputBusqueda = document.getElementById('searchRealtime');
      const headers = document.querySelectorAll('#notificacionesTable thead th');


      function applyFilters() {
        const q = inputText.value.trim().toLowerCase();
        const from = dateFrom.value;
        const to = dateTo.value;
        const state = selectState.value;

        filteredData = allData.filter(item => {
          // Texto
          const txtMatch = [item.mensaje, item.descripcion, item.fecha]
            .some(f => f.toLowerCase().includes(q));
          if (!txtMatch) return false;

          // Estado
          if (state === 'read' && !item.leida) return false;
          if (state === 'unread' && item.leida) return false;

          // Fecha
          if (from && !to) {
            if (item.fecha !== from) return false;
          } else if (from && to) {
            if (item.fecha < from || item.fecha > to) return false;
          }
          return true;
        });

        currentPage = 1;
        renderTable();
      }

      inputText.addEventListener('input', applyFilters);
      dateFrom.addEventListener('input', applyFilters);
      dateTo.addEventListener('input', applyFilters);
      selectState.addEventListener('change', applyFilters);

      btnClear.addEventListener('click', () => {
        // 1) Vaciamos todos los inputs
        inputText.value = '';
        dateFrom.value = '';
        dateTo.value = '';
        selectState.value = 'all';

        // 2) Volvemos a filtrar (mostrará todo)
        applyFilters();
      });

      // Render tabla
      function renderTable() {
        const start = (currentPage - 1) * rowsPerPage;
        const pageData = filteredData.slice(start, start + rowsPerPage);

        tableBody.innerHTML = '';
        pageData.forEach(row => {
          const tr = document.createElement('tr');

          ['mensaje', 'descripcion', 'fecha'].forEach(f => {
            const td = document.createElement('td');
            td.textContent = row[f];
            tr.appendChild(td);
          });

          // 4) Aquí ya solo va la lógica de creación de botón
          const tdEstado = document.createElement('td');
          const btnEstado = document.createElement('button');
          btnEstado.classList.add('boton-accion', 'marcar-toggle');
          btnEstado.dataset.id = row.id;

          if (row.leida) {
            btnEstado.textContent = 'Marcar No Leída';
            btnEstado.dataset.accion = 'marcar_no_leida';
            btnEstado.classList.add('marcarN');
          } else {
            btnEstado.textContent = 'Marcar Leída';
            btnEstado.dataset.accion = 'marcar_leida';
            btnEstado.classList.add('marcarL');
          }
          tdEstado.appendChild(btnEstado);
          tr.appendChild(tdEstado);

          // Acciones (usa exactamente tu HTML)
          const tdAcc = document.createElement('td');
          tdAcc.innerHTML = `
                         <button class="delete-button" onclick="eliminarNotificacion('${row.id}')"><i class="fa-solid fa-trash"></i></button>`;
          tr.appendChild(tdAcc);
          // Checkbox
          const tdChk = document.createElement('td');
          tdChk.innerHTML = `<input type="checkbox" class="select-item" value="${row.id}">`;
          tr.appendChild(tdChk);

          tableBody.appendChild(tr);
        });
        renderPaginationControls();
      }
      // Controles de paginación
      function renderPaginationControls() {
        paginationContainer.innerHTML = '';
        const totalPages = Math.ceil(filteredData.length / rowsPerPage);
        if (totalPages <= 1) return;

        const btn = (txt, pg) => {
          const b = document.createElement('button');
          b.textContent = txt;
          if (pg === currentPage) b.classList.add('active');
          b.onclick = () => {
            currentPage = pg;
            renderTable();
          };
          return b;
        };

        paginationContainer.append(btn('«', 1), btn('‹', Math.max(1, currentPage - 1)));

        let start = Math.max(1, currentPage - 2),
          end = Math.min(totalPages, currentPage + 2);
        if (start > 1) paginationContainer.append(Object.assign(document.createElement('span'), {
          textContent: '…'
        }));
        for (let i = start; i <= end; i++) paginationContainer.append(btn(i, i));
        if (end < totalPages) paginationContainer.append(Object.assign(document.createElement('span'), {
          textContent: '…'
        }));

        paginationContainer.append(btn('›', Math.min(totalPages, currentPage + 1)), btn('»', totalPages));
      }

      // Búsqueda en tiempo real (global)
      inputBusqueda.addEventListener('input', () => {
        const q = inputBusqueda.value.trim().toLowerCase();
        filteredData = allData.filter(r =>
          Object.values(r).some(v =>
            String(v).toLowerCase().includes(q)
          )
        );
        currentPage = 1;
        renderTable();
      });

      // Ordenamiento por click en <th>
      const sortStates = {};
      headers.forEach((th, idx) => {
        const type = th.dataset.type;
        if (!type || type === 'none') return;
        th.style.cursor = 'pointer';
        sortStates[idx] = true;
        th.onclick = () => {
          sortStates[idx] = !sortStates[idx];
          const asc = sortStates[idx];
          filteredData.sort((a, b) => {
            let va = a[Object.keys(a)[idx]].toLowerCase();
            let vb = b[Object.keys(b)[idx]].toLowerCase();
            if (type === 'number') {
              va = +va;
              vb = +vb;
            }
            return (va < vb ? -1 : va > vb ? 1 : 0) * (asc ? 1 : -1);
          });
          // Actualiza flechas
          headers.forEach(h => {
            const sp = h.querySelector('.sort-arrow');
            if (sp) sp.textContent = '';
          });
          th.querySelector('.sort-arrow').textContent = asc ? '▲' : '▼';
          renderTable();
        };
      });

      // Arranca
      renderTable();

      const selectAllChk = document.getElementById('select-all');
      const deleteBtn = document.getElementById('delete-selected');
      const table = document.getElementById('notificacionesTable');

      // Function to actualizar visibilidad del botón
      function updateDeleteButton() {
        const selectedCount = table.querySelectorAll('.select-item:checked').length;
        deleteBtn.style.display = (selectedCount > 1) ? 'inline-block' : 'none';
      }

      // Evento “Seleccionar todos”
      selectAllChk.addEventListener('change', () => {
        const checked = selectAllChk.checked;
        table.querySelectorAll('.select-item').forEach(chk => {
          chk.checked = checked;
        });
        updateDeleteButton();
      });

      // Eventos en cada checkbox individual
      table.querySelectorAll('.select-item').forEach(chk => {
        chk.addEventListener('change', () => {
          // Si alguno queda sin marcar, desmarcar el global
          if (!chk.checked) selectAllChk.checked = false;
          // Si todos están marcados, marcar el global
          else if ([...table.querySelectorAll('.select-item')].every(c => c.checked)) {
            selectAllChk.checked = true;
          }
          updateDeleteButton();
        });
      });

      // Acción “Eliminar Seleccionados”
      deleteBtn.addEventListener('click', () => {
        const ids = [...table.querySelectorAll('.select-item:checked')]
          .map(c => c.value);
        if (!ids.length) return;
        if (!confirm(`¿Seguro que deseas eliminar ${ids.length} notificaciones?`)) return;
        // Envío por fetch a PHP (delete_multiple.php)
        fetch('delete_multiple_notificaciones.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              ids
            })
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) location.reload();
            else alert('Error al eliminar');
          });
      });

      table.addEventListener('click', e => {

        const btn = e.target.closest('.marcar-toggle');
        if (!btn) return;

        const id = btn.dataset.id;
        const accion = btn.dataset.accion;
        btn.disabled = true;

        fetch('toggle_estado_notificacion.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              id,
              accion
            })
          })
          .then(r => r.json())
          .then(resp => {
            console.log(resp);

            if (resp.success) {
              // Actualiza el propio botón sin recarga
              if (accion === 'marcar_leida') {
                btn.textContent = 'Marcar No Leída';
                btn.dataset.accion = 'marcar_no_leida';
                btn.classList.replace('marcarL', 'marcarN');
              } else {
                btn.textContent = 'Marcar Leída';
                btn.dataset.accion = 'marcar_leida';
                btn.classList.replace('marcarN', 'marcarL');
              }
            } else {
              alert('No se pudo cambiar el estado');
            }
          })
          .finally(() => btn.disabled = false);
      });
      applyFilters();

    });
  </script>

</body>

</html>