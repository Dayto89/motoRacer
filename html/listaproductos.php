<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);
ini_set('error_log', 'C:\xampp\htdocs\php_errors.log'); // Windows
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

// ——————————————————————————————————————————————————————————
// 1) TRAER TODOS LOS PRODUCTOS (sin FILTROS ni PAGINACIÓN) 
// ——————————————————————————————————————————————————————————
$consulta = "SELECT 
  p.codigo1,
  p.codigo2, 
  p.nombre, 
  p.precio1, 
  p.precio2, 
  p.precio3, 
  p.cantidad, 
  p.Categoria_codigo    AS categoria_id,
  c.nombre              AS categoria,
  p.Marca_codigo        AS marca_id,
  m.nombre              AS marca,
  p.UnidadMedida_codigo AS unidad_id,
  u.nombre              AS unidadmedida,
  p.Ubicacion_codigo    AS ubicacion_id,
  ub.nombre             AS ubicacion,
  p.proveedor_nit       AS proveedor_id,
  pr.nombre             AS proveedor
FROM producto p
LEFT JOIN categoria c ON p.Categoria_codigo = c.codigo
LEFT JOIN marca m ON p.Marca_codigo = m.codigo
LEFT JOIN unidadmedida u ON p.UnidadMedida_codigo = u.codigo
LEFT JOIN ubicacion ub ON p.Ubicacion_codigo = ub.codigo
LEFT JOIN proveedor pr ON p.proveedor_nit = pr.nit
ORDER BY p.nombre ASC";

$resultado = mysqli_query($conexion, $consulta);
if (!$resultado) {
  die("Error en consulta: " . mysqli_error($conexion));
}

// Construimos un array PHP con TODAS las filas
$todosLosDatos = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
  $todosLosDatos[] = $fila;
}

// ——————————————————————————————————————————————————————————
// 2) ACTUALIZAR (POST) Y ELIMINAR (AJAX) SIN CAMBIOS
// ——————————————————————————————————————————————————————————

// Actualización desde el modal (igual que antes)
if (isset($_POST['codigo1'])) {
  $codigo1 = mysqli_real_escape_string($conexion, $_POST['codigo1']);
  $codigo2 = mysqli_real_escape_string($conexion, $_POST['codigo2']);
  $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
  $precio1 = mysqli_real_escape_string($conexion, $_POST['precio1']);
  $precio2 = mysqli_real_escape_string($conexion, $_POST['precio2']);
  $precio3 = mysqli_real_escape_string($conexion, $_POST['precio3']);
  $cantidad = mysqli_real_escape_string($conexion, $_POST['cantidad']);
  $categoria = mysqli_real_escape_string($conexion, $_POST['categoria-id']);
  $marca = mysqli_real_escape_string($conexion, $_POST['marca-id']);
  $unidadmedida = mysqli_real_escape_string($conexion, $_POST['unidadmedida-id']);
  $ubicacion = mysqli_real_escape_string($conexion, $_POST['ubicacion-id']);
  $proveedor = mysqli_real_escape_string($conexion, $_POST['proveedor-id']);

  $consulta_update = "UPDATE producto SET 
        codigo1 = '$codigo1', 
        codigo2 = '$codigo2', 
        nombre = '$nombre', 
        precio1 = '$precio1', 
        precio2 = '$precio2', 
        precio3 = '$precio3', 
        cantidad = '$cantidad', 
        Categoria_codigo = '$categoria', 
        Marca_codigo = '$marca', 
        UnidadMedida_codigo = '$unidadmedida', 
        Ubicacion_codigo = '$ubicacion', 
        Proveedor_nit = '$proveedor' 
        WHERE codigo1 = '$codigo1'";
  if (mysqli_query($conexion, $consulta_update)) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
              document.addEventListener('DOMContentLoaded', function() {
                  Swal.fire({
                      title: '<span class=\"titulo-alerta confirmacion\">Éxito</span>',
                      html: \`
                          <div class='alerta'>
                              <div class='contenedor-imagen'>
                                  <img src='../imagenes/moto.png' alt=\"Éxito\" class='moto'>
                              </div>
                              <p>Los datos se actualizaron con éxito.</p>
                          </div>
                      \`,
                      background: '#ffffffdb',
                      confirmButtonText: 'Aceptar',
                      confirmButtonColor: '#007bff',
                      customClass: {
                        popup: 'swal2-border-radius',
                        confirmButton: 'btn-aceptar',
                        container: 'fondo-oscuro'
                      }
                  }).then(() => {
                      window.location.href = 'listaproductos.php'; 
                  });
              });
          </script>";
  } else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              title: '<span class=\"titulo-alerta error\">Error</span>',
              html: \`
                <div class=\"custom-alert\">
                  <div class=\"contenedor-imagen\">
                    <img src=\"../imagenes/llave.png\" alt=\"Error\" class=\"llave\">
                  </div>
                  <p>Error al actualizar los datos.</p>
                </div>
              \`,
              background: '#ffffffdb',
              confirmButtonText: 'Aceptar',
              confirmButtonColor: '#dc3545',
              customClass: {
                popup: 'swal2-border-radius',
                confirmButton: 'btn-aceptar',
                container: 'fondo-oscuro'
              }
            });
          });
        </script>";
  }
}

// Eliminación individual por AJAX (igual que antes)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'], $_POST['codigo'])) {
  header('Content-Type: application/json');

  if (!$conexion) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión']);
    exit;
  }

  $codigo = $_POST['codigo'];
  $stmt = $conexion->prepare("DELETE FROM producto WHERE codigo1 = ?");
  $stmt->bind_param("s", $codigo);

  if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
    exit;
  }

  if ($stmt->affected_rows === 0) {
    echo json_encode(['success' => false, 'error' => 'Producto no encontrado']);
    exit;
  }

  echo json_encode(['success' => true]);
  exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

  <title>Inventario</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
  <link rel="stylesheet" href="../css/inventario.css" />
  <link rel="stylesheet" href="../css/alertas.css">
  <link rel="stylesheet" href="../componentes/header.css">
  <script src="../js/header.js"></script>
  <script src="/js/index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .required::after {
      content: " *";
      color: red;
    }

    /* ------------------------------------------------- */
    /* Estilos para filtrado/ordenamiento/resaltado     */
    /* ------------------------------------------------- */
    /* Resaltado de fila seleccionada */
    /* #productTable table tbody tr.selected {
  background-color: rgba(0, 123, 255, 0.15);
}
#productTable tbody tr.selected td {
  background-color: rgba(0, 123, 255, 0.15);
} */

    #productTable tbody tr:hover,
    #productTable tbody tr:hover td {
      background-color: rgba(0, 123, 255, 0.15);
    }


    /* Cursor pointer en encabezados para indicar que son clicables */
    table th {
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

    /* Input para búsqueda en tiempo real */
    #searchRealtime {
      width: 200px;
      padding: 5px 8px;
      margin-bottom: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    /* Botón eliminar múltiple */
    #delete-selected {
      margin-left: 10px;
    }

    /* Estilos básicos para paginación dinámica */
    .pagination-dinamica {
      display: flex;
      justify-content: center;
      margin-top: 23px;
      gap: 12px;
      font-family: arial;
      font-size: 11px;
    }

    .pagination-dinamica button {
      padding: 6px 10px;
      background-color: #f0f0f0;
      border: 1px solid #ccc;
      color: #333;
      border-radius: 4px;
      cursor: pointer;
      font-size: 0.9em;
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
  </style>
</head>

<body>
  <div class="sidebar">
    <div id="menu"></div>
  </div>
  <div class="main-content">
    <h1>Inventario</h1>

    <!-- ============================== -->
    <!-- 6) FILTROS / BÚSQUEDA CLIENTE  -->
    <!-- ============================== -->
    <div class="filter-bar">
      <details class="filter-dropdown">
        <summary class="filter-button">Filtrar</summary>
        <div class="filter-options">
          <!-- Checkboxes para el filtrado JS (sin “Descripción”) -->
          <div class="criteria-group">
            <label><input type="checkbox" name="criteriosJS[]" value="codigo1"> Código</label>
            <label><input type="checkbox" name="criteriosJS[]" value="codigo2"> Código 2</label>
            <label><input type="checkbox" name="criteriosJS[]" value="nombre"> Nombre</label>
            <label><input type="checkbox" name="criteriosJS[]" value="precio1"> Precio 1</label>
            <label><input type="checkbox" name="criteriosJS[]" value="precio2"> Precio 2</label>
            <label><input type="checkbox" name="criteriosJS[]" value="precio3"> Precio 3</label>
            <label><input type="checkbox" name="criteriosJS[]" value="categoria"> Categoría</label>
            <label><input type="checkbox" name="criteriosJS[]" value="marca"> Marca</label>
            <label><input type="checkbox" name="criteriosJS[]" value="ubicacion"> Clase</label>
            <label><input type="checkbox" name="criteriosJS[]" value="proveedor"> Proveedor</label>
          </div>
        </div>
      </details>

      <!-- Caja de búsqueda en tiempo real (cliente) -->
      <input type="text" id="searchRealtime" placeholder="Buscar en resultados..." autocomplete="off">

      <!-- Botón exportar a Excel (agregado de nuevo) -->
      <div class="export-button" style="margin-left: 15px;">
        <form action="exportar_excel.php" method="post">
          <button type="submit" class="icon-button" aria-label="Exportar a Excel" title="Exportar a Excel">
            <i class="fas fa-file-excel"></i>
            <label> Exportar a Excel</label>
          </button>
        </form>
      </div>


    </div>

    <div class="table-wrapper">
      <table id="productTable">
        <thead>
          <tr>
            <th>Código</th>
            <th data-col="1" data-type="string">Código 2<span class="sort-arrow"></span></th>
            <th data-col="2" data-type="string">Nombre<span class="sort-arrow"></span></th>
            <th data-col="3" data-type="number">Precio 1<span class="sort-arrow"></span></th>
            <th data-col="4" data-type="number">Precio 2<span class="sort-arrow"></span></th>
            <th data-col="5" data-type="number">Precio 3<span class="sort-arrow"></span></th>
            <th data-col="6" data-type="number">Cantidad<span class="sort-arrow"></span></th>
            <th data-col="7" data-type="string">Categoría<span class="sort-arrow"></span></th>
            <th data-col="8" data-type="string">Marca<span class="sort-arrow"></span></th>
            <th data-col="9" data-type="string">Clase<span class="sort-arrow"></span></th>
            <th data-col="10" data-type="string">Ubicación<span class="sort-arrow"></span></th>
            <th data-col="11" data-type="string">Proveedor<span class="sort-arrow"></span></th>
            <th data-col="12" data-type="none">Acciones</th>
            <th data-col="13" data-type="none" class="acciones-multiples">
              <!-- Botón para eliminar seleccionados -->
              <button id="delete-selected" class="btn btn-danger" style="display: none;">
                <i class="fa-solid fa-trash"></i>
              </button>
            </th>
          </tr>
        </thead>
        <tbody>
          <!-- Se llenará dinámicamente con JavaScript -->
        </tbody>
      </table>
    </div>

    <!-- Paginación Dinámica (cliente) -->
    <div id="paginationContainer" class="pagination-dinamica"></div>
  </div>

  <!-- Modal de edición (igual que antes) -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <span class="close">
        <i class="fa-solid fa-x"></i>
      </span>

      <h2>Editar Producto</h2>
      <form id="editForm" method="post">
        <input type="hidden" id="editCodigo1" name="codigo1">
        <div class="campo">
          <label for="editCodigo1Visible">Código:</label>
          <input type="text" id="editCodigo1Visible" disabled>
        </div>
        <div class="campo">
          <label for="editCodigo2">Código 2:</label>
          <input type="text" id="editCodigo2" name="codigo2"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>
        <div class="campo">
          <label class="required" for="editNombre">Nombre:</label>
          <input type="text" id="editNombre" name="nombre">
        </div>
        <div class="campo">
          <label class="required" for="editPrecio1">Precio 1:</label>
          <input type="text" id="editPrecio1" name="precio1"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>
        <div class="campo">
          <label class="required" for="editPrecio2">Precio 2:</label>
          <input type="text" id="editPrecio2" name="precio2"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>
        <div class="campo">
          <label class="required" for="editPrecio3">Precio 3:</label>
          <input type="text" id="editPrecio3" name="precio3"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>
        <div class="campo">
          <label class="required" for="editCantidad">Cantidad:</label>
          <input type="text" id="editCantidad" name="cantidad"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>
        <div class="campo">
          <label class="required" for="editCategoria">Categoría:</label>
          <select name="categoria-id" id="editCategoria" required>
            <option value="">Seleccione una categoría</option>
            <?php
            $conexion2 = mysqli_connect("localhost", "root", "", "inventariomotoracer");
            if (!$conexion2) {
              die("Error de conexión: " . mysqli_connect_error());
            }
            $consultaCategorias = "SELECT codigo, nombre FROM categoria";
            $resultadoCategorias = mysqli_query($conexion2, $consultaCategorias);
            while ($filaCategoria = mysqli_fetch_assoc($resultadoCategorias)) {
              echo "<option value='" . htmlspecialchars($filaCategoria['codigo']) . "'>" . htmlspecialchars($filaCategoria['nombre']) . "</option>";
            }
            mysqli_close($conexion2);
            ?>
          </select>
        </div>
        <div class="campo">
          <label class="required" for="editMarca">Marca:</label>
          <select name="marca-id" id="editMarca" required>
            <option value="">Seleccione una marca</option>
            <?php
            $conexion2 = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
            $consultaMarcas = "SELECT codigo, nombre FROM marca";
            $resultadoMarcas = mysqli_query($conexion2, $consultaMarcas);
            while ($filaMarca = mysqli_fetch_assoc($resultadoMarcas)) {
              echo "<option value='" . htmlspecialchars($filaMarca['codigo']) . "'>" . htmlspecialchars($filaMarca['nombre']) . "</option>";
            }
            mysqli_close($conexion2);
            ?>
          </select>
        </div>
        <div class="campo">
          <label class="required" for="editUnidadMedida">Clase:</label>
          <select name="unidadmedida-id" id="editUnidadMedida" required>
            <option value="">Seleccione una medida</option>
            <?php
            $conexion2 = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
            $consultaUnidadesMedidas = "SELECT codigo, nombre FROM unidadmedida";
            $resultadoUnidadesMedidas = mysqli_query($conexion2, $consultaUnidadesMedidas);
            while ($filaUnidadMedida = mysqli_fetch_assoc($resultadoUnidadesMedidas)) {
              echo "<option value='" . htmlspecialchars($filaUnidadMedida['codigo']) . "'>" . htmlspecialchars($filaUnidadMedida['nombre']) . "</option>";
            }
            mysqli_close($conexion2);
            ?>
          </select>
        </div>
        <div class="campo">
          <label class="required" for="editUbicacion">Ubicación:</label>
          <select name="ubicacion-id" id="editUbicacion" required>
            <option value="">Seleccione una ubicación</option>
            <?php
            $conexion2 = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
            $consultaUbicaciones = "SELECT codigo, nombre FROM ubicacion";
            $resultadoUbicaciones = mysqli_query($conexion2, $consultaUbicaciones);
            while ($filaUbicacion = mysqli_fetch_assoc($resultadoUbicaciones)) {
              echo "<option value='" . htmlspecialchars($filaUbicacion['codigo']) . "'>" . htmlspecialchars($filaUbicacion['nombre']) . "</option>";
            }
            mysqli_close($conexion2);
            ?>
          </select>
        </div>
        <div class="campo">
          <label class="required" for="editProveedor">Proveedor:</label>
          <select name="proveedor-id" id="editProveedor" required>
            <option value="">Seleccione un proveedor</option>
            <?php
            $conexion2 = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
            $consultaProveedores = "SELECT nit, nombre FROM proveedor";
            $resultadoProveedores = mysqli_query($conexion2, $consultaProveedores);
            while ($filaProveedor = mysqli_fetch_assoc($resultadoProveedores)) {
              echo "<option value='" . htmlspecialchars($filaProveedor['nit']) . "'>" . htmlspecialchars($filaProveedor['nombre']) . "</option>";
            }
            mysqli_close($conexion2);
            ?>
          </select>
        </div>
        <div class="modal-boton">
          <button type="submit" id="modal-boton">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </div>

  <!-- —————————————————————————————————————————————————————————— -->
  <!-- 3) SCRIPT DE JAVASCRIPT: paginación / filtrado / ordenamiento -->
  <!-- —————————————————————————————————————————————————————————— -->
  <script>
    // Convertimos el array PHP $todosLosDatos a JSON para JS
    const allData = <?php echo json_encode($todosLosDatos, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;

    // Variables de estado para paginación y filtrado
    let filteredData = [...allData];
    const rowsPerPage = 7;
    let currentPage = 1;

    const tableBody = document.querySelector('#productTable tbody');
    const paginationContainer = document.getElementById('paginationContainer');
    const inputBusqueda = document.getElementById('searchRealtime');

    // Devuelve el valor “limpio” de una fila según criterio
    function getFieldValue(rowObj, criterion) {
      switch (criterion) {
        case 'codigo1':
          return rowObj.codigo1.toString().toLowerCase();
        case 'codigo2':
          return rowObj.codigo2.toString().toLowerCase();
        case 'nombre':
          return rowObj.nombre.toLowerCase();
        case 'precio1':
          return rowObj.precio1.toString().toLowerCase();
        case 'precio2':
          return rowObj.precio2.toString().toLowerCase();
        case 'precio3':
          return rowObj.precio3.toString().toLowerCase();
        case 'categoria':
          return rowObj.categoria.toLowerCase();
        case 'marca':
          return rowObj.marca.toLowerCase();
        case 'ubicacion':
          return rowObj.ubicacion.toLowerCase();
        case 'proveedor':
          return rowObj.proveedor.toLowerCase();
        default:
          return '';
      }
    }

    // Función para ordenar filteredData por columna
    function getCellValueForSort(rowObj, colIndex) {
      switch (colIndex) {
        case 0:
          return rowObj.codigo1.toLowerCase();
        case 1:
          return rowObj.codigo2.toLowerCase();
        case 2:
          return rowObj.nombre.toLowerCase();
        case 3:
          return parseFloat(rowObj.precio1) || 0;
        case 4:
          return parseFloat(rowObj.precio2) || 0;
        case 5:
          return parseFloat(rowObj.precio3) || 0;
        case 6:
          return parseFloat(rowObj.cantidad) || 0;
        case 7:
          return rowObj.descripcion.toLowerCase();
        case 8:
          return rowObj.categoria.toLowerCase();
        case 9:
          return rowObj.marca.toLowerCase();
        case 10:
          return rowObj.unidadmedida.toLowerCase();
        case 11:
          return rowObj.ubicacion.toLowerCase();
        case 12:
          return rowObj.proveedor.toLowerCase();
        default:
          return '';
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

    // Renderiza la tabla según página actual
    function renderTable() {
      const start = (currentPage - 1) * rowsPerPage;
      const end = start + rowsPerPage;
      const pageData = filteredData.slice(start, end);

      tableBody.innerHTML = '';
      pageData.forEach(rowObj => {
        const tr = document.createElement('tr');

        // 1) Código
        let td = document.createElement('td');
        td.textContent = rowObj.codigo1;
        tr.appendChild(td);

        // 2) Código 2
        td = document.createElement('td');
        td.textContent = rowObj.codigo2;
        tr.appendChild(td);

        // 3) Nombre
        td = document.createElement('td');
        td.textContent = rowObj.nombre;
        tr.appendChild(td);

        // 5) Precio 1
        td = document.createElement('td');
        td.textContent = rowObj.precio1;
        tr.appendChild(td);

        // 6) Precio 2
        td = document.createElement('td');
        td.textContent = rowObj.precio2;
        tr.appendChild(td);

        // 7) Precio 3
        td = document.createElement('td');
        td.textContent = rowObj.precio3;
        tr.appendChild(td);

        // 8) Cantidad
        td = document.createElement('td');
        td.textContent = rowObj.cantidad;
        tr.appendChild(td);

        // 10) Categoría
        td = document.createElement('td');
        td.textContent = rowObj.categoria;
        td.setAttribute('data-categoria-id', rowObj.categoria_id);
        tr.appendChild(td);

        // 11) Marca
        td = document.createElement('td');
        td.textContent = rowObj.marca;
        td.setAttribute('data-marca-id', rowObj.marca_id);
        tr.appendChild(td);

        // 12) Clase (unidadmedida)
        td = document.createElement('td');
        td.textContent = rowObj.unidadmedida;
        td.setAttribute('data-unidadmedida-id', rowObj.unidad_id);
        tr.appendChild(td);

        // 13) Ubicación
        td = document.createElement('td');
        td.textContent = rowObj.ubicacion;
        td.setAttribute('data-ubicacion-id', rowObj.ubicacion_id);
        tr.appendChild(td);

        // 14) Proveedor
        td = document.createElement('td');
        td.textContent = rowObj.proveedor;
        td.setAttribute('data-proveedor-id', rowObj.proveedor_id);
        tr.appendChild(td);

        // 15) Acciones (editar / eliminar individual)
        td = document.createElement('td');
        td.classList.add('acciones');
        // Botón editar
        const btnEdit = document.createElement('button');
        btnEdit.className = 'edit-button';
        btnEdit.setAttribute('data-id', rowObj.codigo1);
        btnEdit.innerHTML = "<i class='fa-solid fa-pen-to-square'></i>";
        td.appendChild(btnEdit);
        // Botón eliminar
        const btnDelete = document.createElement('button');
        btnDelete.className = 'delete-button';
        btnDelete.setAttribute('onclick', `eliminarProducto('${rowObj.codigo1}')`);
        btnDelete.innerHTML = "<i class='fa-solid fa-trash'></i>";
        td.appendChild(btnDelete);
        tr.appendChild(td);

        // 16) Checkbox selección múltiple
        td = document.createElement('td');
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.className = 'select-product';
        checkbox.value = rowObj.codigo1;
        td.appendChild(checkbox);
        tr.appendChild(td);

        // Resaltar fila al clic
        //tr.addEventListener('click', () => {
        // tr.classList.toggle('selected');
        //});

        tableBody.appendChild(tr);
      });

      renderPaginationControls();
      attachEditButtonListeners();
      attachCheckboxListeners();
    }

    // Renderiza los botones de paginación
    function renderPaginationControls() {
      paginationContainer.innerHTML = '';
      const totalPages = Math.ceil(filteredData.length / rowsPerPage);
      if (totalPages <= 1) return;

      // « Primera
      const btnFirst = document.createElement('button');
      btnFirst.textContent = '« Primera';
      btnFirst.disabled = (currentPage === 1);
      btnFirst.addEventListener('click', () => {
        currentPage = 1;
        renderTable();
      });
      if (currentPage === 1) btnFirst.classList.add('active');
      paginationContainer.appendChild(btnFirst);

      // ‹ Anterior
      const btnPrev = document.createElement('button');
      btnPrev.textContent = '‹ Anterior';
      btnPrev.disabled = (currentPage === 1);
      btnPrev.addEventListener('click', () => {
        if (currentPage > 1) currentPage--;
        renderTable();
      });
      if (currentPage === 1) btnPrev.classList.add('active');
      paginationContainer.appendChild(btnPrev);

      // Números de página (hasta 5 alrededor)
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

      // Siguiente ›
      const btnNext = document.createElement('button');
      btnNext.textContent = 'Siguiente ›';
      btnNext.disabled = (currentPage === totalPages);
      btnNext.addEventListener('click', () => {
        if (currentPage < totalPages) currentPage++;
        renderTable();
      });
      if (currentPage === totalPages) btnNext.classList.add('active');
      paginationContainer.appendChild(btnNext);

      // Última »
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

    // Filtrado en tiempo real según criterios marcados
    function applyFilter() {
      const query = inputBusqueda.value.trim().toLowerCase();
      // Tomamos los checkboxes marcados
      const checkedBoxes = document.querySelectorAll('input[name="criteriosJS[]"]:checked');
      const selectedCriteria = Array.from(checkedBoxes).map(cb => cb.value);

      if (query === '') {
        filteredData = [...allData];
      } else if (selectedCriteria.length === 0) {
        // Búsqueda global en todas las columnas si no hay criterios
        filteredData = allData.filter(row => {
          const composite =
            row.codigo1 + ' ' +
            row.codigo2 + ' ' +
            row.nombre + ' ' +
            row.precio1 + ' ' +
            row.precio2 + ' ' +
            row.precio3 + ' ' +
            row.cantidad + ' ' +
            row.categoria + ' ' +
            row.marca + ' ' +
            row.unidadmedida + ' ' +
            row.ubicacion + ' ' +
            row.proveedor;
          return composite.toString().toLowerCase().includes(query);
        });
      } else {
        // Si hay criterios, buscamos solo en esos campos
        filteredData = allData.filter(row => {
          return selectedCriteria.some(crit => {
            const fieldValue = getFieldValue(row, crit);
            return fieldValue.includes(query);
          });
        });
      }

      currentPage = 1;
      renderTable();
    }

    // ============================================================
    // 4) ORDENAMIENTO POR COLUMNAS: clic en <th>
    // ============================================================
    document.addEventListener('DOMContentLoaded', function() {
      const thead = document.querySelector('#productTable thead');
      const sortStates = {};

      thead.querySelectorAll('th').forEach(th => {
        const colIndex = parseInt(th.getAttribute('data-col'), 10);
        const type = th.getAttribute('data-type');
        if (!type || type === 'none') return;

        sortStates[colIndex] = true; // ascendente inicial

        th.addEventListener('click', () => {
          sortStates[colIndex] = !sortStates[colIndex];
          sortData(colIndex, sortStates[colIndex]);

          // Limpiar flechas de otros encabezados
          thead.querySelectorAll('th .sort-arrow').forEach(span => {
            span.textContent = '';
          });
          // Poner flecha en el clicado
          th.querySelector('.sort-arrow').textContent = sortStates[colIndex] ? '▲' : '▼';

          renderTable();
        });
      });
    });

    // ============================================================
    // 5) RESALTADO DE FILA: listener en cada <tr>
    // ============================================================
    //function attachRowHighlightListeners() {
    //  const rows = document.querySelectorAll('#productTable tbody tr');
    //  rows.forEach(row => {
    //    row.addEventListener('click', () => {
    //      row.classList.toggle('selected');
    //    });
    //  });
    //}

    // ============================================================
    // 6) SELECCIÓN MÚLTIPLE: activar botón Eliminar Múltiple
    // ============================================================
    function attachCheckboxListeners() {
      // Recolectamos checkboxes y botón de cabecera
      const checkboxes = document.querySelectorAll(".select-product");
      const deleteBtn = document.getElementById("delete-selected");

      // Cada vez que cambie cualquier checkbox, actualizamos visibilidad
      checkboxes.forEach(cb => {
        cb.addEventListener("change", toggleDeleteButtonVisibility);
      });

      // Inicializamos estado al cargar
      toggleDeleteButtonVisibility();

      // Al hacer clic en eliminar seleccionados...
      deleteBtn.addEventListener("click", () => {
        const selected = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);
        if (selected.length < 2) return; // redundante, pero seguro

        Swal.fire({
          title: '<span class="titulo-alerta advertencia">¿Eliminar seleccionados?</span>',
          html: `<p>Se eliminarán ${selected.length} productos.</p>`,
          showCancelButton: true,
          confirmButtonText: "Sí, eliminar",
          cancelButtonText: "Cancelar",
          customClass: {
            popup: "custom-alert",
            confirmButton: "btn-eliminar",
            cancelButton: "btn-cancelar"
          }
        }).then(result => {
          if (!result.isConfirmed) return;
          // tu fetch a eliminar_productos.php con { codigos: selected }
          fetch("eliminar_productos.php", {
              method: "POST",
              headers: {
                "Content-Type": "application/json"
              },
              body: JSON.stringify({
                codigos: selected
              })
            })
            .then(r => r.json())
            .then(data => {
              if (data.success) {
                Swal.fire("Eliminados", `${selected.length} productos eliminados.`, "success")
                  .then(() => location.reload());
              } else {
                Swal.fire("Error", data.error || "No se pudo eliminar.", "error");
              }
            })
            .catch(() => Swal.fire("Error", "Fallo comunicación.", "error"));
        });
      });
    }

    function toggleDeleteButtonVisibility() {
      const checkedCount = document.querySelectorAll(".select-product:checked").length;
      const deleteBtn = document.getElementById("delete-selected");
      // Mostramos solo si hay 2 o más
      deleteBtn.style.display = checkedCount >= 2 ? "inline-block" : "none";
    }

    // ============================================================
    // 7) MÓDULO DE EDICIÓN: adjuntar listeners a botones editar
    // ============================================================
    function attachEditButtonListeners() {
      const editButtons = document.querySelectorAll('.edit-button');
      const modal = document.getElementById('editModal');
      const closeModal = modal.querySelector('.close');

      editButtons.forEach(button => {
        button.addEventListener('click', function(e) {
          // Evitamos que el clic en el botón lance el toggle de resaltado
          e.stopPropagation();

          const row = this.closest('tr');
          document.getElementById('editCodigo1').value = row.cells[0].innerText.trim();
          document.getElementById('editCodigo1Visible').value = row.cells[0].innerText.trim();
          document.getElementById('editCodigo2').value = row.cells[1].innerText.trim();
          document.getElementById('editNombre').value = row.cells[2].innerText.trim();
          document.getElementById('editPrecio1').value = row.cells[3].innerText.trim();
          document.getElementById('editPrecio2').value = row.cells[4].innerText.trim();
          document.getElementById('editPrecio3').value = row.cells[5].innerText.trim();
          document.getElementById('editCantidad').value = row.cells[6].innerText.trim();
          document.getElementById('editCategoria').value = row.cells[7].getAttribute('data-categoria-id');
          document.getElementById('editMarca').value = row.cells[8].getAttribute('data-marca-id');
          document.getElementById('editUnidadMedida').value = row.cells[9].getAttribute('data-unidadmedida-id');
          document.getElementById('editUbicacion').value = row.cells[10].getAttribute('data-ubicacion-id');
          document.getElementById('editProveedor').value = row.cells[11].getAttribute('data-proveedor-id');
          modal.style.display = 'block';
        });
      });

      closeModal.addEventListener('click', function() {
        modal.style.display = 'none';
      });
    }

    // ============================================================
    // 8) ELIMINACIÓN INDIVIDUAL: SweetAlert2 + AJAX
    // ============================================================
    function eliminarProducto(codigo) {
      Swal.fire({
        title: '<span class="titulo-alerta advertencia">¿Estás Seguro?</span>',
        html: `
            <div class="custom-alert">
                <div class="contenedor-imagen">
                    <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                </div>
                <p>¿Quieres eliminar el producto <strong>${codigo}</strong>?</p>
            </div>
        `,
        background: '#ffffffdb',
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
        customClass: {
          popup: "custom-alert",
          confirmButton: "btn-eliminar",
          cancelButton: "btn-cancelar",
          container: 'fondo-oscuro'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          fetch('listaproductos.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              },
              body: `eliminar=1&codigo=${encodeURIComponent(codigo)}`
            })
            .then(response => {
              if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
              return response.json();
            })
            .then(data => {
              if (data.success) {
                Swal.fire({
                  title: '<span class="titulo-alerta confirmacion">Producto Eliminado</span>',
                  html: `
                            <div class="custom-alert">
                                <div class="contenedor-imagen">
                                    <img src="../imagenes/moto.png" alt="Confirmación" class="moto">
                                </div>
                                 <p>El producto <strong>${codigo}</strong> ha sido eliminado correctamente.</p>
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

    // ============================================================
    // 9) CERRAR DROPDOWN SI SE HACE CLIC FUERA
    // ============================================================
    document.addEventListener('click', function(event) {
      const filterDropdown = document.querySelector('.filter-dropdown');
      if (filterDropdown.hasAttribute('open') && !filterDropdown.contains(event.target)) {
        filterDropdown.removeAttribute('open');
      }
    });

    // ============================================================
    // 10) INICIALIZACIÓN: aplicamos ordenamiento, filtrado y paginación
    // ============================================================
    document.addEventListener('DOMContentLoaded', function() {
      // Al cargar, pintamos la primera página
      renderTable();

      // Al escribir en el input de búsqueda en tiempo real
      inputBusqueda.addEventListener('input', function() {
        applyFilter();
      });
    });
    /*ANIMACIONES*/ 
    
  </script>

  <div class="userInfo">
    <?php
    $conexion2 = new mysqli('localhost', 'root', '', 'inventariomotoracer');
    $id_usuario = $_SESSION['usuario_id'];
    $sqlUsuario = "SELECT nombre, apellido, rol, foto FROM usuario WHERE identificacion = ?";
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
</body>

</html>