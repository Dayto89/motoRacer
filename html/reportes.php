<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.php");
  exit();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '../html/verificar_permisos.php';

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) die("Error BD: " . mysqli_connect_error());

// 1) Construcción de filtros
$filtros = [];
if (!empty($_GET['fecha_desde']) && !empty($_GET['fecha_hasta'])) {
  $d = mysqli_real_escape_string($conexion, $_GET['fecha_desde']) . ' 00:00:00';
  $h = mysqli_real_escape_string($conexion, $_GET['fecha_hasta']) . ' 23:59:59';
  $filtros[] = "f.fechaGeneracion BETWEEN '$d' AND '$h'";
}
if (!empty($_GET['busqueda'])) {
  $b = mysqli_real_escape_string($conexion, $_GET['busqueda']);
  $filtros[] = "(
        f.codigo LIKE '%$b%' OR
        f.nombreUsuario LIKE '%$b%' OR f.apellidoUsuario LIKE '%$b%' OR
        f.nombreCliente LIKE '%$b%' OR f.apellidoCliente LIKE '%$b%' OR
        f.Cliente_codigo LIKE '%$b%' OR
        f.precioTotal LIKE '%$b%' OR
        EXISTS(
          SELECT 1 FROM factura_metodo_pago mp
          WHERE mp.Factura_codigo = f.codigo
            AND mp.metodoPago LIKE '%$b%'
        )
    )";
}
$where = $filtros ? ' WHERE ' . implode(' AND ', $filtros) : '';

// 2) Datos completos para JS (sin paginar)
$jsQ = "SELECT
    f.codigo,
    f.fechaGeneracion,
    f.nombreUsuario,
    f.apellidoUsuario,
    f.nombreCliente,
    f.apellidoCliente,
    f.Cliente_codigo,
    f.cambio,
    f.precioTotal,
    f.activo,
    f.observacion,
    GROUP_CONCAT(DISTINCT m.metodoPago SEPARATOR ', ') AS metodoPago
  FROM factura f
  LEFT JOIN factura_metodo_pago m ON m.Factura_codigo = f.codigo
  $where
  GROUP BY
    f.codigo, f.fechaGeneracion,
    f.nombreUsuario, f.apellidoUsuario,
    f.nombreCliente, f.apellidoCliente,
    f.Cliente_codigo, f.cambio,
    f.precioTotal, f.activo, f.observacion";
$jsData = mysqli_fetch_all(mysqli_query($conexion, $jsQ), MYSQLI_ASSOC);

// 3) Paginación PHP
$perPage = 7;
$page    = max(1, (int)($_GET['pagina'] ?? 1));
$offset  = ($page - 1) * $perPage;
$countQ  = "SELECT COUNT(DISTINCT f.codigo) AS total
  FROM factura f
  LEFT JOIN factura_metodo_pago m ON m.Factura_codigo = f.codigo
  $where";
$total   = mysqli_fetch_assoc(mysqli_query($conexion, $countQ))['total'];
$totalPg = ceil($total / $perPage);

// 4) Consulta paginada
$sql = "SELECT
    f.codigo,
    f.fechaGeneracion,
    CONCAT(f.nombreUsuario,' ',f.apellidoUsuario) AS usuario,
    CONCAT(f.nombreCliente,' ',f.apellidoCliente) AS cliente,
    f.Cliente_codigo,
    f.cambio,
    f.precioTotal,
    f.activo,
    f.observacion,
    GROUP_CONCAT(DISTINCT m.metodoPago SEPARATOR ', ') AS metodoPago
  FROM factura f
  LEFT JOIN factura_metodo_pago m ON m.Factura_codigo = f.codigo
  $where
  GROUP BY
    f.codigo, f.fechaGeneracion, usuario, cliente,
    f.Cliente_codigo, f.cambio, f.precioTotal, f.activo, f.observacion
  LIMIT $perPage OFFSET $offset";
$resultado = mysqli_query($conexion, $sql) or die("Error consulta: " . mysqli_error($conexion));


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['factura_id'])) {
  $_SESSION['factura_id'] = $_POST['factura_id'];
  header("Location: recibo.php");
  exit();
}

// PAGINACIÓN
$por_pagina = 6;
$pagina_actual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$offset = ($pagina_actual - 1) * $por_pagina;

// Conteo total con filtros
$sql_count = "SELECT COUNT(*) AS total FROM proveedor p
 WHERE 1=1";
if (!empty($filtros)) {
  $sql_count .= " AND (" . implode(' OR ', $filtros) . ")";
}
$res_count = mysqli_query($conexion, $sql_count);
$row_count = mysqli_fetch_assoc($res_count);
$total_reg = $row_count['total'];
$total_paginas = ceil($total_reg / $por_pagina);

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
  <link rel="stylesheet" href="../css/alertas.css">
  <link rel="stylesheet" href="../componentes/header.css">
  <link rel="stylesheet" href="../componentes/header.php">
  <script src="../js/header.js"></script>
  <script src="/js/index.js"></script>
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    /* ocultar sólo la paginación estática de PHP */
    .pagination {
      display: none;
    }

    /* estilos para la paginación dinámica (reutiliza los tuyos) */
    .pagination-dinamica {
      display: flex;
      justify-content: center;
      margin-top: 20px;
      gap: 5px;
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

    .pagination-dinamica button:hover:not(.active) {
      background-color: rgb(158, 146, 209);
    }

    .pagination-dinamica button.active {
      background-color: #007bff;
      color: white;
      font-weight: bold;
      pointer-events: none;
      border-color: #007bff;
    }

    /* hover sobre filas */
    #facturaTable tbody tr:hover,
    #facturaTable tbody tr:hover td {
      background-color: rgba(0, 123, 255, 0.15);
    }
  </style>
</head>

<body>
  <?php include 'boton-ayuda.php'; ?>
  <div id="menu"></div>
  <div class="ubica">Factura / Reportes</div>

    <div class="container-general">
    </div>
  <div class="main-content">
    <h1>Reportes</h1>
    <div class="filter-bar">
      <div class="barra-superior">
        <button id="filtros-btn" class="filter-button">Mostrar Filtros</button>
        <input type="text" id="barraReportes" name="valor" placeholder="Ingrese el reporte a buscar">
        <div class="export-button">
          <form action="excel_reporte.php" method="post">
            <button type="submit" class="icon-button" aria-label="Exportar a Excel" title="Exportar a Excel">

              <!-- Agregar este botón junto al botón de exportar -->
              <i class="fas fa-file-excel"></i>
              <label> Exportar a Excel</label>
            </button>
          </form>
        </div>
      </div>
      <div id="filtros-popup" class="filtros-popup">
        <div class="filtros-container">
          <div class="filter-options">
            <form id="filterForm">
              <!-- Fecha desde/hasta -->
              <div class="form-group">
                <label>Desde: <input type="date" id="fDesde" style="font-family: Arial, Helvetica, sans-serif;     height: 26px; border-radius:10px;border:none; padding: 5px;"></label>
              </div>
              <!-- Fecha hasta -->
              <div class="form-group">
                <label>Hasta: <input type="date" id="fHasta" style="font-family: Arial, Helvetica, sans-serif;    height: 26px; border-radius:10px;border:none; padding: 5px;"></label>
              </div>
              <!-- Estado activo/inactivo -->
              <div class="form-group">
                <label>Estado:
                  <select id="fActivo" style="  height: 26px; border-radius:10px;border:none; padding: 5px;">
                    <option value="all">Todos</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                  </select>
                </label>
              </div>
              <div class="form-group">
                <label for="fPago">Método Pago:</label>
                <select id="fPago" name="fPago" style="  height: 26px; border-radius:10px;border:none; padding: 5px;">
                  <option value="all">Todos</option>
                  <option value="tarjeta">Tarjeta</option>
                  <option value="efectivo">Efectivo</option>
                  <option value="transferencia">Transferencia</option>
                </select>
              </div>
              <!-- Botón limpiar -->
              <div class="form-group">
                <button type="button" id="btnClear">Limpiar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php
    // Justo después de tu conexión y filtros:
    $allQ = "SELECT
    f.codigo,
    f.fechaGeneracion,
    f.nombreUsuario,
    f.apellidoUsuario,
    f.nombreCliente,
    f.apellidoCliente,
    f.Cliente_codigo,
    f.cambio,
    f.precioTotal,
    f.activo,
    f.observacion,
    GROUP_CONCAT(DISTINCT m.metodoPago SEPARATOR ', ') AS metodoPago
  FROM factura f
  LEFT JOIN factura_metodo_pago m ON m.Factura_codigo = f.codigo
  " . ($where ? "WHERE $where" : "") . "
  GROUP BY
    f.codigo, f.fechaGeneracion,
    f.nombreUsuario, f.apellidoUsuario,
    f.nombreCliente, f.apellidoCliente,
    f.Cliente_codigo, f.cambio,
    f.precioTotal, f.activo, f.observacion";
    $allRes  = mysqli_query($conexion, $allQ);
    $allData = mysqli_fetch_all($allRes, MYSQLI_ASSOC);
    ?>
    <script>
      // json_encode una sola vez
      const allData = <?php echo json_encode($allData, JSON_HEX_TAG | JSON_HEX_APOS); ?>;
    </script>

    <div class="table-wrapper">
      <?php if (mysqli_num_rows($resultado) > 0): ?>
        <table id="facturaTable">
          <thead>
            <tr>
              <th>Código</th>
              <th data-col="1" data-type="string">Fecha<span class="sort-arrow"></span></th>
              <th data-col="2" data-type="string">Usuario<span class="sort-arrow"></span></th>
              <th data-col="3" data-type="string">Cliente<span class="sort-arrow"></span></th>
              <th data-col="4" data-type="string">Cliente ID<span class="sort-arrow"></span></th>
              <th data-col="5" data-type="number">Total<span class="sort-arrow"></span></th>
              <th data-col="6" data-type="string">Activo<span class="sort-arrow"></span></th>
              <th data-col="7" data-type="string">Observación<span class="sort-arrow"></span></th>
              <th data-col="8" data-type="string">Método Pago<span class="sort-arrow"></span></th>
              <th data-col="9" data-type="none">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($fila = mysqli_fetch_assoc($resultado)) : ?>
              <tr>
                <td><?= htmlspecialchars($fila['codigo']) ?></td>
                <td><?= htmlspecialchars($fila['fechaGeneracion']) ?></td>
                <!-- Para usuario y cliente ya tienes la concatenación en el SELECT paginado: -->
                <td><?= htmlspecialchars($fila['usuario']) ?></td>
                <td><?= htmlspecialchars($fila['cliente']) ?></td>
                <td><?= htmlspecialchars($fila['Cliente_codigo']) ?></td>
                <td><?= number_format($fila['precioTotal'], 2) ?></td>
                <td><?= htmlspecialchars($fila['activo']) ?></td>
                <td><?= htmlspecialchars($fila['observacion']) ?></td>
                <td><?= htmlspecialchars($fila['metodoPago']) ?></td>
                <td>
                  <form method="POST"><input name="factura_id" type="hidden" value="<?= $fila['codigo'] ?>">
                    <button class="recibo-button"><i class="bx bx-search-alt"></i></button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <div id="jsPagination" class="pagination-dinamica"></div>
      <?php else: ?>
        <p>No se encontraron resultados con los criterios seleccionados.</p>
      <?php endif; ?>
    </div>
  </div>


  <div class="userContainer">
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
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', () => {

      // Referencias
      const inpDesde = document.getElementById('fDesde');
      const inpHasta = document.getElementById('fHasta');
      const selActivo = document.getElementById('fActivo');
      const selPago = document.getElementById('fPago');

      const btnClear = document.getElementById('btnClear');


      // Configuración
      const rowsPerPage = 9;
      let currentPage = 1;
      let filteredData = [...allData];
      console.log("filteredData tras input:", filteredData);

      // Selectores
      const tableBody = document.querySelector('#facturaTable tbody');
      const pagination = document.getElementById('jsPagination');
      const searchInput = document.getElementById('barraReportes');
      const headers = document.querySelectorAll('#facturaTable thead th');



      // 1) Define campos, con objetos composite para unir nombre+apellido
      const fields = [
        'codigo',
        'fechaGeneracion',
        {
          composite: ['nombreUsuario', 'apellidoUsuario']
        },

        {
          composite: ['nombreCliente', 'apellidoCliente']
        },
        'Cliente_codigo',
        'precioTotal',
        'activo',
        'observacion',
        'metodoPago'
      ];

      async function cambiarEstado(codigo, nuevoEstado, observacion) {
        const res = await fetch('../html/actualizar_estado_factura.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            codigo,
            activo: nuevoEstado,
            observacion
          })
        });
        const data = await res.json();
        if (!data.success) throw new Error(data.error || 'Falló actualización');
      }
      //cambios de estado
      async function manejarCambioEstado(btn) {
        const codigo = btn.dataset.codigo;
        const esActivo = btn.dataset.estado === '1';

        try {
          let nuevoEstado, observacion = '';

          if (esActivo) {
            const {
              value: obs,
              isConfirmed
            } = await Swal.fire({
              title: '<span class="titulo-alerta confirmacion">¿Por qué se desactiva la factura?</span>',
              html: `
        <div class="custom-alert">
          <textarea
            id="swal-input-obs"
            class="swal2-textarea"
            placeholder="Escribe tu observación..."
          ></textarea>
        </div>
      `,
              showCancelButton: true,
              confirmButtonText: 'Desactivar',
              cancelButtonText: 'Cancelar',
              customClass: {
                popup: "custom-alert",
                confirmButton: "btn-eliminar",
                cancelButton: "btn-cancelar",
                container: 'fondo-oscuro'
              },



              preConfirm: () => {
                const v = document.getElementById('swal-input-obs').value.trim();
                if (!v) Swal.showValidationMessage('La observación no puede estar vacía');
                return v;
              }

            });
            if (!isConfirmed) return;
            observacion = obs;
            nuevoEstado = 0;

          } else {
            const {
              isConfirmed
            } = await Swal.fire({
              title: '<span class="titulo-alerta error">Activar factura</span>',
              html: `
        <div class="custom-alert">
          <div class="contenedor-imagen">
            <img src="../imagenes/tornillo.png" alt="tornillo" class="tornillo">
          </div>
          <p>¿Seguro que quieres activar esta factura?</p>
        </div>
      `,
              background: '#ffffffdb',
              showCancelButton: true,
              confirmButtonText: 'Activar',
              cancelButtonText: "Cancelar",
              customClass: {
                popup: "custom-alert",
                confirmButton: 'btn-aceptar', // Clase personalizada para el botón de confirmación
                cancelButton: "btn-eliminar", // Clase personalizada para el botón de cancelar
                container: 'fondo-oscuro'
              }
            });
            if (!isConfirmed) return;
            nuevoEstado = 1;
          }



          // Enviamos el AJAX
          const resp = await fetch('../html/actualizar_estado_factura.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              codigo,
              activo: nuevoEstado,
              observacion
            })
          });
          const data = await resp.json();

          if (!data.success) {
            return Swal.fire('Error', data.error || 'No se pudo actualizar', 'error');
          }

          // **** Aquí actualizamos el DOM ****
          // 1) Cambiamos el botón
          btn.dataset.estado = String(nuevoEstado);
          if (nuevoEstado === 1) {
            btn.innerHTML = 'Activo';
            btn.classList.remove('inactivo');
            btn.classList.add('activo');
          } else {
            btn.innerHTML = 'Inactivo';
            btn.classList.remove('activo');
            btn.classList.add('inactivo');
          }

          // 2) Actualizamos la celda de observación
          //   - Suponiendo que la celda de observación es la 8ª (índice 7)
          //     fila: [0: código, …, 5: total, 6: Estado, 7: Observación, 8: Método, 9: Acciones]
          const fila = btn.closest('tr');
          const celdaObs = fila.cells[7];
          celdaObs.textContent = nuevoEstado === 0 ? observacion : '';

          // — Feedback al usuario con tu diseño — 
          Swal.fire({
            title: `<span class="titulo-alerta error">${esActivo ? 'Desactivada' : 'Activada'}</span>`,
            html: `
    <div class="custom-alert">
      <div class="contenedor-imagen">
        <img src="../imagenes/moto.png" alt="moto" class="moto">
      </div>
      <p>${esActivo
        ? 'Se guardó tu observación.'
        : 'Se borró la observación.'}
      </p>
    </div>
  `,
            confirmButtonText: 'Aceptar',
            customClass: {
              popup: 'swal2-border-radius',
              confirmButton: 'btn-aceptar',
              container: 'fondo-oscuro'
            }
          });

        } catch (e) {
          console.error(e);
          Swal.fire('Error', 'Algo falló en la comunicación', 'error');
        }
      }

      // 1) Delegación de clicks sobre .btn-estado
      tableBody.addEventListener('click', e => {
        const btn = e.target.closest('.btn-estado');
        if (!btn) return;
        // Aquí caerá en tu SweetAlert
        console.log('Botón clicado:', btn.dataset.codigo, btn.dataset.estado);
        manejarCambioEstado(btn);
      });


      // 1) Reemplaza tu renderTable por esto:
      function renderTable() {
        const start = (currentPage - 1) * rowsPerPage;
        const slice = filteredData.slice(start, start + rowsPerPage);

        tableBody.innerHTML = ''; // borramos filas viejas

        slice.forEach(row => {
          const obs = row.observacion || '';
          // Construyo el HTML del botón con sus data- atributos:
          const estadoClass = row.activo === '1' ? 'activo' : 'inactivo';
          const estadoTexto = row.activo === '1' ? 'Activo' : 'Inactivo';

          const btnEstado = `
  <button type="button" 
          class="btn-estado ${estadoClass}" 
          data-codigo="${row.codigo}" 
          data-estado="${row.activo}">
    ${estadoTexto}
  </button>`;

          // Genero toda la fila de una sola vez:
          const filaHTML = `
      <tr>
        <td>${row.codigo}</td>
        <td>${row.fechaGeneracion}</td>
        <td>${row.nombreUsuario} ${row.apellidoUsuario}</td>
        <td>${row.nombreCliente} ${row.apellidoCliente}</td>
        <td>${row.Cliente_codigo}</td>
        <td>${Number(row.precioTotal).toFixed(2)}</td>
        <td>${btnEstado}</td>
        <td>${obs}</td>
        <td>${row.metodoPago}</td>
        <td>
          <form method="POST">
            <input type="hidden" name="factura_id" value="${row.codigo}">
            <button type="submit" class="recibo-button">
              <i class='bx bx-search-alt'></i>
            </button>
          </form>
        </td>
      </tr>`;

          tableBody.insertAdjacentHTML('beforeend', filaHTML);
        });

        renderPaginationControls();
      }


      // 3) Paginación dinámica
      function renderPaginationControls() {
        pagination.innerHTML = '';
        const totalPages = Math.ceil(filteredData.length / rowsPerPage);
        if (totalPages <= 1) return;

        const makeBtn = (txt, pg) => {
          const btn = document.createElement('button');
          btn.textContent = txt;
          if (pg === currentPage) btn.classList.add('active');
          btn.addEventListener('click', () => {
            currentPage = pg;
            renderTable();
          });
          return btn;
        };

        pagination.append(makeBtn('« Primera', 1), makeBtn('‹ Anterior', Math.max(1, currentPage - 1)));

        let start = Math.max(1, currentPage - 2),
          end = Math.min(totalPages, currentPage + 2);

        if (start > 1) pagination.append(Object.assign(document.createElement('span'), {
          textContent: '…'
        }));
        for (let i = start; i <= end; i++) pagination.append(makeBtn(i, i));
        if (end < totalPages) pagination.append(Object.assign(document.createElement('span'), {
          textContent: '…'
        }));

        pagination.append(makeBtn('Siguiente›', Math.min(totalPages, currentPage + 1)),
          makeBtn('Última »', totalPages));
      }

      // 4) Búsqueda en tiempo real (filtra en todos los campos, incluidos composite)
      searchInput.addEventListener('input', () => {
        const q = searchInput.value.trim().toLowerCase();
        filteredData = allData.filter(row =>
          fields.some((fld, idx) => {
            const th = headers[idx];
            const type = th.dataset.type;
            if (!type || type === 'none') return false;
            // Ahora getFieldValue ya devuelve siempre string:
            return getFieldValue(row, fields[idx]).includes(q);
          })
        );
        currentPage = 1;
        renderTable();
      });

      function applyFilters() {
        const desde = inpDesde.value;
        const hasta = inpHasta.value;
        const act = selActivo.value; // "all", "1", "0"
        const pago = selPago.value;


        filteredData = allData.filter(item => {
          // — Fecha
          if (desde && !hasta) {
            if (item.fechaGeneracion.substring(0, 10) !== desde) return false;
          } else if (desde && hasta) {
            const f = item.fechaGeneracion.substring(0, 10);
            if (f < desde || f > hasta) return false;
          }
          // — Activo
          if (act !== 'all' && String(item.activo) !== act) return false;
          // — Método de pago
          if (pago !== 'all') {
            // normalizamos a minúsculas y protegemos nulos
            const mp = (item.metodoPago || '').toLowerCase();

            // si el filtro es “tarjeta”, buscamos tarjeta|crédito|débito
            let terms;
            if (pago === 'tarjeta') {
              terms = ['tarjeta', 'credito', 'debito'];
            } else {
              terms = [pago];
            }

            // construimos una expresión para cualquiera de los términos
            const re = new RegExp(`\\b(${ terms.join('|') })\\b`, 'i');
            if (!re.test(mp)) return false;
          }

          return true;
        });

        currentPage = 1;
        renderTable();
      }

      // Listeners
      [inpDesde, inpHasta].forEach(i => i.addEventListener('input', applyFilters));
      selActivo.addEventListener('change', applyFilters);
      selPago.addEventListener('change', applyFilters);



      // Limpiar filtros
      btnClear.addEventListener('click', () => {
        inpDesde.value = '';
        inpHasta.value = '';
        selActivo.value = 'all';
        selPago.value = 'all';

        applyFilters();
      });

      // Arranque
      applyFilters();

      // Helper: obtiene valor (string o number) listo para comparar
      function getFieldValue(obj, fld) {
        let val;
        if (typeof fld === 'string') {
          val = obj[fld];
        } else {
          val = fld.composite.map(k => obj[k]).join(' ');
        }
        // Normalizamos a cadena y pasamos a minúsculas:
        return String(val ?? '').toLowerCase();
      }



      // 2) Renderiza la tabla según filteredData y currentPage



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

      // 6) Inicializa


      renderTable();
    });

    //FILTROS POPUP
    document.getElementById('filtros-btn').onclick = function() {
      document.getElementById('filtros-popup').classList.toggle('active');
    };
    // Cierra el popup al hacer clic fuera
    document.addEventListener('click', function(event) {
      const popup = document.getElementById('filtros-popup');
      const btn = document.getElementById('filtros-btn');
      if (popup.classList.contains('active') && !popup.contains(event.target) && event.target !== btn) {
        popup.classList.remove('active');
      }
    });
  </script>
</body>

</html>