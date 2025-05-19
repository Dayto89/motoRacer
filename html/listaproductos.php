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

// Construcción de filtros
$filtros = [];
$valor = isset($_GET['valor']) ? mysqli_real_escape_string($conexion, $_GET['valor']) : '';
$criterios = isset($_GET['criterios']) && is_array($_GET['criterios']) ? $_GET['criterios'] : [];

if (!empty($valor) && !empty($criterios)) {
  foreach ($criterios as $criterio) {
    $c = mysqli_real_escape_string($conexion, $criterio);
    switch ($c) {
      case 'codigo':
        $filtros[] = "p.codigo1 LIKE '%$valor%'";
        break;
      case 'codigo2':
        $filtros[] = "p.codigo2 LIKE '%$valor%'";
        break;
      case 'nombre':
        $filtros[] = "p.nombre LIKE '%$valor%'";
        break;
      case 'precio1':
        $filtros[] = "p.precio1 LIKE '%$valor%'";
        break;
      case 'precio2':
        $filtros[] = "p.precio2 LIKE '%$valor%'";
        break;
      case 'precio3':
        $filtros[] = "p.precio3 LIKE '%$valor%'";
        break;
      case 'categoria':
        $filtros[] = "c.nombre LIKE '%$valor%'";
        break;
      case 'marca':
        $filtros[] = "m.nombre LIKE '%$valor%'";
        break;
      case 'ubicacion':
        $filtros[] = "ub.nombre LIKE '%$valor%'";
        break;
      case 'proveedor':
        $filtros[] = "pr.nombre LIKE '%$valor%'";
        break;
    }
  }
}

// PAGINACIÓN
$por_pagina = 7;
$pagina_actual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$offset = ($pagina_actual - 1) * $por_pagina;

// Conteo total con filtros
$sql_count = "SELECT COUNT(*) AS total FROM producto p
LEFT JOIN categoria c ON p.Categoria_codigo = c.codigo
LEFT JOIN marca m ON p.Marca_codigo = m.codigo
LEFT JOIN unidadmedida u ON p.UnidadMedida_codigo = u.codigo
LEFT JOIN ubicacion ub ON p.Ubicacion_codigo = ub.codigo
LEFT JOIN proveedor pr ON p.proveedor_nit = pr.nit WHERE 1=1";
if (!empty($filtros)) {
  $sql_count .= " AND (" . implode(' OR ', $filtros) . ")";
}
$res_count = mysqli_query($conexion, $sql_count);
$row_count = mysqli_fetch_assoc($res_count);
$total_reg = $row_count['total'];
$total_paginas = ceil($total_reg / $por_pagina);

// Consulta principal con LIMIT
$consulta = "SELECT 
  p.codigo1,
  p.codigo2, 
  p.nombre, 
  p.iva,
  p.precio1, 
  p.precio2, 
  p.precio3, 
  p.cantidad, 
  p.descripcion,
  p.Categoria_codigo    AS categoria_id,
  c.nombre              AS categoria,
  p.Marca_codigo        AS marca_id,
  m.nombre              AS marca,
  p.UnidadMedida_codigo AS unidad_id,
  u.nombre              AS unidadmedida,
  p.Ubicacion_codigo    AS ubicacion_id,
  ub.nombre             AS ubicacion,
  p.proveedor_nit       AS proveedor_id,
  pr.nombre             AS proveedor,
  c.nombre AS categoria, 
  m.nombre AS marca, 
  u.nombre AS unidadmedida,
  ub.nombre AS ubicacion, 
  pr.nombre AS proveedor
FROM producto p
LEFT JOIN categoria c ON p.Categoria_codigo = c.codigo
LEFT JOIN marca m ON p.Marca_codigo = m.codigo
LEFT JOIN unidadmedida u ON p.UnidadMedida_codigo = u.codigo
LEFT JOIN ubicacion ub ON p.Ubicacion_codigo = ub.codigo
LEFT JOIN proveedor pr ON p.proveedor_nit = pr.nit
WHERE 1=1";
if (!empty($filtros)) {
  $consulta .= " AND (" . implode(' OR ', $filtros) . ")";
}
$consulta .= " LIMIT $por_pagina OFFSET $offset";

$resultado = mysqli_query($conexion, $consulta);
if (!$resultado) {
  die("Error en consulta: " . mysqli_error($conexion));
}

// Actualización de datos del modal
if (isset($_POST['codigo1'])) {
  // Se reciben y se escapan las variables
  $codigo1 = mysqli_real_escape_string($conexion, $_POST['codigo1']);
  $codigo2 = mysqli_real_escape_string($conexion, $_POST['codigo2']);
  $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
  $precio1 = mysqli_real_escape_string($conexion, $_POST['precio1']);
  $precio2 = mysqli_real_escape_string($conexion, $_POST['precio2']);
  $precio3 = mysqli_real_escape_string($conexion, $_POST['precio3']);
  $cantidad = mysqli_real_escape_string($conexion, $_POST['cantidad']);
  $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
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
        descripcion = '$descripcion', 
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
                      html: `
                          <div class='alerta'>
                              <div class='contenedor-imagen'>
                                  <img src='../imagenes/moto.png' alt=\"Éxito\" class='moto'>
                              </div>
                              <p>Los datos se actualizaron con éxito.</p>
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
                      window.location.href = 'listaproductos.php'; // Redirige después de cerrar el alert
                  });
              });
          </script>";
  } else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                        title: '<span class=\"titulo-alerta error\">Error</span>',
                        html: `
                            <div class=\"custom-alert\">
                                <div class=\"contenedor-imagen\">
                                    <img src=\"../imagenes/llave.png\" alt=\"Error\" class=\"llave\">
                                </div>
                                <p>Error al actulizar los datos/p>
                            </div>
                        `,
                        background: '#ffffffdb',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#dc3545',
                        customClass: {
                            popup: 'swal2-border-radius',
                            confirmButton: 'btn-aceptar',
                            container: 'fondo-oscuro'
                        }
                    });
                    </script>";
  }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'], $_POST['codigo'])) {
  header('Content-Type: application/json');

  // Debug: Registrar el código recibido
  error_log("Código recibido: " . $_POST['codigo']);

  if (!$conexion) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión']);
    exit;
  }

  $codigo = $_POST['codigo'];
  $stmt = $conexion->prepare("DELETE FROM producto WHERE codigo1 = ?");
  $stmt->bind_param("s", $codigo);

  if (!$stmt->execute()) {
    error_log("Error SQL: " . $stmt->error); // Registrar el error
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
  <link rel="stylesheet" href="../componentes/header.php">
  <script src="../js/header.js"></script>
  <script src="/js/index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 23px;
      gap: 12px;
      font-family: arial;
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
  <div class="sidebar">
    <div id="menu"></div>
  </div>
  <div class="main-content">
    <h1>Inventario</h1>
    <div class="filter-bar">
      <details class="filter-dropdown">
        <summary class="filter-button">Filtrar</summary>
        <div class="filter-options">
          <form method="GET" action="../html/listaproductosPrueba.php" class="search-form">
            <div class="criteria-group">
              <label><input type="checkbox" name="criterios[]" value="codigo"> Código</label>
              <label><input type="checkbox" name="criterios[]" value="codigo2"> Código 2</label>
              <label><input type="checkbox" name="criterios[]" value="nombre"> Nombre</label>
              <label><input type="checkbox" name="criterios[]" value="precio1"> Precio 1</label>
              <label><input type="checkbox" name="criterios[]" value="precio2"> Precio 2</label>
              <label><input type="checkbox" name="criterios[]" value="precio3"> Precio 3</label>
              <label><input type="checkbox" name="criterios[]" value="categoria"> Categoría</label>
              <label><input type="checkbox" name="criterios[]" value="marca"> Marca</label>
              <label><input type="checkbox" name="criterios[]" value="ubicacion"> Ubicación</label>
              <label><input type="checkbox" name="criterios[]" value="proveedor"> Proveedor</label>
            </div>

        </div>
      </details>
      <input class="form-control" type="text" name="valor" placeholder="Ingrese el valor a buscar">
      <button class="search-button" type="submit">Buscar</button>
      </form>
      <div class="export-button">
        <form action="exportar_excel.php" method="post">
          <button type="submit" class="icon-button" aria-label="Exportar a Excel" title="Exportar a Excel">
            <i class="fas fa-file-excel"></i>
            <label> Exportar a Excel</label>
          </button>
        </form>

      </div>

      <button id="delete-selected" class="btn btn-danger" style="display: none;"><i class="fa-solid fa-trash"></i></button>


    </div>
    <div class="table-wrapper">
      <?php if (mysqli_num_rows($resultado) > 0): ?>
        <table>
          <thead>
            <tr>
              <th>Código</th>
              <th>Código 2</th>
              <th>Nombre</th>
              <th>Iva</th>
              <th>Precio 1</th>
              <th>Precio 2</th>
              <th>Precio 3</th>
              <th>Cantidad</th>
              <th>Descripción</th>
              <th>Categoría</th>
              <th>Marca</th>
              <th>Unidad Medida</th>
              <th>Ubicación</th>
              <th>Proveedor</th>
              <th> Acciones</th>
              <th><input type="checkbox" id="select-all"></th>

            </tr>
          </thead>
          <tbody>
            <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
              <tr>
                <td><?= htmlspecialchars($fila['codigo1']) ?></td>
                <td><?= htmlspecialchars($fila['codigo2']) ?></td>
                <td><?= htmlspecialchars($fila['nombre']) ?></td>
                <td><?= htmlspecialchars($fila['iva']) ?></td>
                <td><?= htmlspecialchars($fila['precio1']) ?></td>
                <td><?= htmlspecialchars($fila['precio2']) ?></td>
                <td><?= htmlspecialchars($fila['precio3']) ?></td>
                <td><?= htmlspecialchars($fila['cantidad']) ?></td>
                <td><?= htmlspecialchars($fila['descripcion']) ?></td>
                <td data-categoria-id="<?= htmlspecialchars($fila['categoria_id']) ?>">
                  <?= htmlspecialchars($fila['categoria']) ?>
                </td>
                <td data-marca-id="<?= htmlspecialchars($fila['marca_id']) ?>">
                  <?= htmlspecialchars($fila['marca']) ?>
                </td>
                <td data-unidadmedida-id="<?= htmlspecialchars($fila['unidad_id']) ?>">
                  <?= htmlspecialchars($fila['unidadmedida']) ?>
                </td>
                <td data-ubicacion-id="<?= htmlspecialchars($fila['ubicacion_id']) ?>">
                  <?= htmlspecialchars($fila['ubicacion']) ?>
                </td>
                <td data-proveedor-id="<?= htmlspecialchars($fila['proveedor_id']) ?>">
                  <?= htmlspecialchars($fila['proveedor']) ?>
                </td>
                <td class="acciones">
                  <button class="edit-button" data-id="<?= $fila['codigo1'] ?>">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <button class="delete-button" onclick="eliminarProducto('<?= $fila['codigo1'] ?>')"><i class="fa-solid fa-trash"></i></button>
                </td>
                <td>
                  <input type="checkbox" class="select-product" value="<?= $fila['codigo1'] ?>">
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        </div>
        <!-- Paginación -->

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

      <?php else: ?>
        <p>No se encontraron resultados.</p>
      <?php endif; ?>

      <!-- Modal de edición -->
      <div id="editModal" class="modal">
        <div class="modal-content">
          <span class="close">
            <i class="fa-solid fa-x"></i>
          </span>

          <h2>Editar Producto</h2>
          <form id="editForm" method="post">
            <!-- Campo oculto para enviar el código 1 -->
            <input type="hidden" id="editCodigo1" name="codigo1">
            <div class="campo"><label for="editCodigo1Visible">Código:</label>
              <input type="text" id="editCodigo1Visible" readonly>
            </div>
            <div class="campo"><label for="editCodigo2">Código 2:</label>
              <input type="text" id="editCodigo2" name="codigo2">
            </div>
            <div class="campo"><label for="editNombre">Nombre:</label>
              <input type="text" id="editNombre" name="nombre">
            </div>
            <div class="campo"> <label for="editPrecio1">Precio 1:</label>
              <input type="text" id="editPrecio1" name="precio1">
            </div>
            <div class="campo"><label for="editPrecio2">Precio 2:</label>
              <input type="text" id="editPrecio2" name="precio2">
            </div>
            <div class="campo"> <label for="editPrecio3">Precio 3:</label>
              <input type="text" id="editPrecio3" name="precio3">
            </div>
            <div class="campo"><label for="editCantidad">Cantidad:</label>
              <input type="text" id="editCantidad" name="cantidad">
            </div>
            <div class="campo"> <label for="editDescripcion">Descripción:</label>
              <input type="text" id="editDescripcion" name="descripcion">
            </div>
            <div class="campo"><label for="editCategoria">Categoría:</label>
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
            <div class="campo"><label for="editMarca">Marca:</label>
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
            <div class="campo"><label for="editUnidadMedida">Unidad Medida:</label>
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
            <div class="campo"><label for="editUbicacion">Ubicación:</label>
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
            <div class="campo"><label for="editProveedor">Proveedor:</label>
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
            <div class="modal-boton"> <button type="submit" id="modal-boton">Guardar Cambios</button></div>

          </form>
        </div>
      </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Seleccionamos todos los botones de edición
        const editButtons = document.querySelectorAll('.edit-button');
        // Modal y botón de cierre
        const modal = document.getElementById('editModal');
        // Si hay más de un ".close" en la página, asegúrate de seleccionar el de dentro del modal:
        const closeModal = modal.querySelector('.close');
        // Listener para cada botón de edición
        editButtons.forEach(button => {
          button.addEventListener('click', function() {
            const row = this.closest('tr');
            // Se asume que las columnas están en el siguiente orden:
            // 0: Código, 1: Código2, 2: Nombre, 3: Iva, 4: Precio1, 5: Precio2, 6: Precio3,
            // 7: Cantidad, 8: Descripción, 9: Categoría, 10: Marca, 11: Unidad Medida, 12: Ubicación, 13: Proveedor.
            const codigo1 = row.cells[0].innerText.trim();
            document.getElementById('editCodigo1').value = codigo1;
            document.getElementById('editCodigo1Visible').value = codigo1;
            document.getElementById('editCodigo2').value = row.cells[1].innerText.trim();
            document.getElementById('editNombre').value = row.cells[2].innerText.trim();
            // Asumimos que Precio1 está en la columna 4 (ajusta si es necesario)
            document.getElementById('editPrecio1').value = row.cells[4].innerText.trim();
            document.getElementById('editPrecio2').value = row.cells[5].innerText.trim();
            document.getElementById('editPrecio3').value = row.cells[6].innerText.trim();
            document.getElementById('editCantidad').value = row.cells[7].innerText.trim();
            document.getElementById('editDescripcion').value = row.cells[8].innerText.trim();
            // Para select de Categoría: usamos el data attribute de la celda correspondiente
            document.getElementById('editCategoria').value = row.cells[9].getAttribute('data-categoria-id');
            // Para los inputs de Marca, UnidadMedida, Ubicación y Proveedor, se usan los data attributes:
            document.getElementById('editMarca').value = row.cells[10].getAttribute('data-marca-id');
            document.getElementById('editUnidadMedida').value = row.cells[11].getAttribute('data-unidadmedida-id');
            document.getElementById('editUbicacion').value = row.cells[12].getAttribute('data-ubicacion-id');
            document.getElementById('editProveedor').value = row.cells[13].getAttribute('data-proveedor-id');

            modal.style.display = 'block';
          });
        });



        // Listener para cerrar el modal
        closeModal.addEventListener('click', function() {
          modal.style.display = 'none';
        });
      });

      // Función para eliminar un producto con SweetAlert2
      function eliminarProducto(codigo) {
        Swal.fire({
          title: '<span class="titulo-alerta advertencia">¿Estas Seguro?</span>',

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
            confirmButton: "btn-eliminar", // Clase personalizada para el botón de confirmación
            cancelButton: "btn-cancelar", // Clase personalizada para el botón de cancelar
            container: 'fondo-oscuro'
          }
        }).then((result) => {
          if (result.isConfirmed) {
            // Enviar la solicitud al servidor
            fetch('../html/listaproductos.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `eliminar=1&codigo=${encodeURIComponent(codigo)}`
              })
              .then(response => {
                if (!response.ok) {
                  throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
              })
              .then(data => {
                if (data.success) {
                  // Mostrar alerta de éxito
                  Swal.fire({
                    title: '<span class="titulo-alerta confirmacion">Producto Eliminado</span>',
                    html: `
                            <div class="custom-alert">
                                <div class="contenedor-imagen">
                                    <img src="../imagenes/moto.png" alt="Confirmacion" class="moto">
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
                    location.reload(); // Recargar página después de cerrar la alerta
                  });
                } else {
                  // Mostrar alerta de error
                  Swal.fire({
                    title: '<span class="titulo-alerta error">Error</span>',
                    html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/llave.png" alt="Error" class="llave">
                    </div>
                    <p>Error al eliminar el producto.</p>
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
                  });
                }
              })
              .catch(error => {
                console.error("Error:", error);
                Swal.fire("Error", "No se pudo eliminar. Ver consola para detalles.", "error");
              });
          }
        });
      }


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
            alert("Selecciona al menos un producto para eliminar.");
            return;
          }

          // Mostrar la alerta con SweetAlert
          Swal.fire({
            title: '<span class="titulo-alerta advertencia">¿Estas Seguro?</span>',
            html: `
            <div class="custom-alert">
                <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                <p>Los productos se eliminarán de forma permanente.</p>
            </div>
        `,
            background: '#ffffffdb',
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
            customClass: {
              popup: "custom-alert",
              confirmButton: "btn-eliminar", // Clase personalizada para el botón de confirmación
              cancelButton: "btn-cancelar", // Clase personalizada para el botón de cancelar
              container: 'fondo-oscuro'
            }
          }).then((result) => {
            if (result.isConfirmed) {
              // Depuración: Ver datos antes de enviarlos
              console.log("Enviando códigos a eliminar:", selectedCodes);

              // Enviar datos al servidor
              fetch("eliminar_productos.php", {
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
                  console.log("Respuesta del servidor:", data); // Depuración
                  if (data.success) {
                    Swal.fire({
                        title: '<span class="titulo-alerta confirmacion">Exito</span>',
                        html: `
                            <div class="custom-alert">
                                <div class="contenedor-imagen">
                                    <img src="../imagenes/moto.png" alt="Exito" class="moto">
                                </div>
                                <p>Productos elimanados correctamente.</p>
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
                      })
                      .then(() => location.reload()); // Recargar página después de cerrar la alerta
                  } else {
                    Swal.fire("Error", "Error al eliminar los productos: " + data.error, "error");
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