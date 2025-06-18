<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);


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

//verificar que nit no se repita con el input rojo

if (isset($_GET['verificar_nit'])) {
  header('Content-Type: application/json');
  $nit = $conexion->real_escape_string($_GET['verificar_nit']);
  $stmt = $conexion->prepare("SELECT COUNT(*) FROM proveedor WHERE nit = ?");
  $stmt->bind_param("s", $nit);
  $stmt->execute();
  $stmt->bind_result($cnt);
  $stmt->fetch();
  $stmt->close();
  echo json_encode(['existe' => $cnt > 0]);
  exit;  // Termina la ejecución aquí para devolver sólo el JSON
}
//-----------------------------------------

// Construcción de filtros
$filtros = [];
$valor = isset($_GET['valor']) ? mysqli_real_escape_string($conexion, $_GET['valor']) : '';
$criterios = isset($_GET['criterios']) && is_array($_GET['criterios']) ? $_GET['criterios'] : [];

if (!empty($valor) && empty($criterios)) {
  $criterios = ['nit', 'nombre', 'telefono', 'direccion', 'correo'];
}

if (!empty($valor) && !empty($criterios)) {
  foreach ($criterios as $criterio) {
    $c = mysqli_real_escape_string($conexion, $criterio);
    switch ($c) {
      case 'nit':
        $filtros[] = "p.nit LIKE '%$valor%'";
        break;
      case 'nombre':
        $filtros[] = "p.nombre LIKE '%$valor%'";
        break;
      case 'telefono':
        $filtros[] = "p.telefono LIKE '%$valor%'";
        break;
      case 'direccion':
        $filtros[] = "p.direccion LIKE '%$valor%'";
        break;
      case 'correo':
        $filtros[] = "p.correo LIKE '%$valor%'";
        break;
    }
  }
}

// justo tras conectar a BD
$allQ = "SELECT nit,nombre,telefono,direccion,correo FROM proveedor p";
if (!empty($filtros)) $allQ .= " WHERE " . implode(' OR ', $filtros);
$allRes = mysqli_query($conexion, $allQ);
$allData = mysqli_fetch_all($allRes, MYSQLI_ASSOC);


// PAGINACIÓN
$por_pagina = 7;
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

// Consulta principal con LIMIT
$consulta = "SELECT 
  p.nit,
  p.nombre, 
  p.telefono, 
  p.direccion,
  p.correo
FROM proveedor p
WHERE 1=1";
if (!empty($filtros)) {
  $consulta .= " AND (" . implode(' OR ', $filtros) . ")";
}
$consulta .= " LIMIT $por_pagina OFFSET $offset";

$resultado = mysqli_query($conexion, $consulta);
if (!$resultado) {
  die("Error en consulta: " . mysqli_error($conexion));
}

// Agregar proveedor
if ($_POST && isset($_POST['guardar'])) {
  if (!$conexion) {
    die("<script>alert('No se pudo conectar a la base de datos');</script>");
  };
  $nit = mysqli_real_escape_string($conexion, $_POST['nit']);
  $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
  $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
  $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
  $correo = mysqli_real_escape_string($conexion, $_POST['correo']);


  $query = "INSERT INTO proveedor (nit, nombre, telefono, direccion, correo) VALUES ('$nit', '$nombre', '$telefono', '$direccion', '$correo')";

  $resultado = mysqli_query($conexion, $query);

  if ($resultado) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: '<span class=\"titulo-alerta confirmacion\">Éxito</span>',
            html: `
                <div class=\"custom-alert\">
                    <div class=\"contenedor-imagen\">
                        <img src=\"../imagenes/moto.png\" alt=\"Confirmación\" class=\"moto\">
                    </div>
                    <p>Proveedor agregado correctamente.</p>
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
    });
</script>";
  } else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

    $error = mysqli_error($conexion); // Captura el error fuera del script JS

    echo "<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: '<span class=\"titulo-alerta error\">Error</span>',
        html: `
            <div class=\"custom-alert\">
                <div class=\"contenedor-imagen\">
                    <img src=\"../imagenes/llave.png\" alt=\"Error\" class=\"llave\">
                </div>
                <p>El proveedor no fue agregado.<br><small>$error</small></p>
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
});
</script>";
  }
}

// Actualización de datos del modal
if (isset($_POST['nit'])) {
  // Se reciben y se escapan las variables
  $nit = mysqli_real_escape_string($conexion, $_POST['nit']);
  $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
  $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
  $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
  $correo = mysqli_real_escape_string($conexion, $_POST['correo']);

  $consulta_update = "UPDATE proveedor SET 
        nit = '$nit', 
        nombre = '$nombre', 
        telefono = '$telefono', 
        direccion = '$direccion', 
        correo = '$correo'
        WHERE nit = '$nit'";
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
                      window.location.href = 'listaproveedor.php'; // Redirige después de cerrar el alert
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
  $stmt = $conexion->prepare("DELETE FROM proveedor WHERE nit = ?");
  $stmt->bind_param("s", $codigo);

  if (!$stmt->execute()) {
    error_log("Error SQL: " . $stmt->error); // Registrar el error
    echo json_encode(['success' => false, 'error' => $stmt->error]);
    exit;
  }

  if ($stmt->affected_rows === 0) {
    echo json_encode(['success' => false, 'error' => 'Proveedor no encontrado']);
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

  <title>Proveedores</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
  <link rel="stylesheet" href="../css/listaproveedor.css" />
  <link rel="stylesheet" href="../css/alertas.css">
  <link rel="stylesheet" href="../componentes/header.css">
  <link rel="stylesheet" href="../componentes/header.php">
  <script src="../js/header.js"></script>
  <script src="/js/index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .required::after {
      content: " *";
      color: red;
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
    }

    /* Al arrancar, ocultamos la paginación PHP (queda como fallback) */
    .pagination {
      display: none;
    }


    #providerTable tbody tr:hover,
    #providerTable tbody tr:hover td {
      background-color: rgba(0, 123, 255, 0.15);
    }
  </style>
</head>

<body>
  <?php
  // Justo después de tu conexión y filtros:
  $allQ = "SELECT nit,nombre,telefono,direccion,correo FROM proveedor p";
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
    <h1>Proveedores</h1>
    <div class="filter-bar">
      <button id="btnAbrirModal" class="btn-nuevo-proveedor"><i class="bx bx-plus bx-flip-vertical bx-beat "></i>Nuevo </button>

      <input type="text" id="searchRealtime" name="valor" placeholder="Ingrese el provedor a buscar">

      <div class="export-button">
        <form action="exportar_excel_proveedores.php" method="get">
          <!-- Pasa filtros actuales si los hay -->
          <?php foreach ($_GET as $k => $v): ?>
            <?php if (is_array($v)): ?>
              <?php foreach ($v as $val): ?>
                <input type="hidden" name="<?= htmlspecialchars($k) ?>[]" value="<?= htmlspecialchars($val) ?>">
              <?php endforeach; ?>
            <?php else: ?>
              <input type="hidden" name="<?= htmlspecialchars($k) ?>" value="<?= htmlspecialchars($v) ?>">
            <?php endif; ?>
          <?php endforeach; ?>
          <button type="submit" id="exportar-boton" class="icon-button" title="Exportar proveedores a Excel">
            <i class="fas fa-file-excel"></i> Exportar a Excel
          </button>
        </form>
      </div>




    </div>
    <div class="table-wrapper">
      <?php if (mysqli_num_rows($resultado) > 0): ?>
        <table id="providerTable" class="tabla-centrada">
          <thead>
            <tr>
              <th>Nit </th>
              <th data-col="1" data-type="string">Nombre <span class="sort-arrow"></span></th>
              <th data-col="2" data-type="string">Teléfono <span class="sort-arrow"></span></th>
              <th data-col="3" data-type="string">Dirección <span class="sort-arrow"></span></th>
              <th data-col="4" data-type="string">Correo <span class="sort-arrow"></span></th>
              <th data-col="5" data-type="none">Acciones</th>
              <th data-col="6" data-type="none" class="acciones-multiples">
                <button id="delete-selected" class="btn btn-danger" style="display: none;"><i class="fa-solid fa-trash"></i></button>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
              <tr>
                <td><?= htmlspecialchars($fila['nit']) ?></td>
                <td><?= htmlspecialchars($fila['nombre']) ?></td>
                <td><?= htmlspecialchars($fila['telefono']) ?></td>
                <td><?= htmlspecialchars($fila['direccion']) ?></td>
                <td><?= htmlspecialchars($fila['correo']) ?></td>
                <td class="acciones">
                  <button class="edit-button" data-id="<?= $fila['nit'] ?>">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <button class="delete-button" onclick="eliminarProducto('<?= $fila['nit'] ?>')"><i class="fa-solid fa-trash"></i></button>
                </td>
                <td>
                  <input type="checkbox" class="select-product" value="<?= $fila['nit'] ?>">
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <div id="jsPagination" class="pagination-dinamica"></div>
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

  <!-- Modal de nuevo proveedor -->
  <div id="nuevoModal" class="modal hide">
    <div class="modal-content-nuevo">
      <h2>Nuevo Proveedor</h2>
      <form id="nuevoForm" method="POST" action="">
        <div class="form-grid">
          <div class="campo" id="nit-campo">
            <label class="required">Nit:</label>
            <input type="text"
              id="nit"
              name="nit"
              required
              oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
            <div id="nit-tooltip" class="small-error-tooltip">
              Este NIT ya está registrado
            </div>
          </div>
          <div class="campo">
            <label class="required">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required />
          </div>

          <div class="campo">
            <label class="required" for="telefono">Telefono:</label>
            <input type="text" id="telefono" name="telefono" required
              oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
          </div>

          <div class="campo">
            <label class="required" for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" required />
          </div>
          <div class="campo">
            <label class="required" for="correo">Correo:</label>
            <input type="text" id="correo" name="correo" required
              pattern=".+@.+"
              placeholder="ejemplo@correo.com">
          </div>
          <div class="modal-buttons">
            <button type="button" id="btnCancelar">Cancelar</button>
            <button type="submit" name="guardar" id="btnGuardar">Guardar</button>
          </div>
        </div>
    </div>
    </form>
  </div>
  </div>

  <!-- Modal de edición -->
  <div id="editModal" class="modal hide">
    <div class="modal-content" id="editContent">
      <h2>Editar Proveedor</h2>
      <form id="editForm" method="post">
        <!-- Campo oculto para enviar el código 1 -->
        <input type="hidden" id="editNit" name="nit">
        <div class="campo"><label class="required" for="editNitVisible">Nit:</label>
          <input type="text" id="editNitVisible" readonly
            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>
        <div class="campo"><label class="required" for="editNombre">Nombre:</label>
          <input type="text" id="editNombre" name="nombre">
        </div>
        <div class="campo"> <label class="required" for="editTelefono">Teléfono:</label>
          <input type="text" id="editTelefono" name="telefono"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>
        <div class="campo"><label class="required" for="editDireccion">Dirección:</label>
          <input type="text" id="editDireccion" name="direccion">
        </div>
        <div class="campo"> <label class="required" for="editCorreo">Correo:</label>
          <input type="text" id="editCorreo" name="correo"
            pattern=".+@.+"
            placeholder="ejemplo@correo.com">
        </div>
        <div class="modal-buttons">
          <button type="button" id="btnCancelarEdit">Cancelar</button>
          <button type="submit" id="modal-boton">Guardar </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    let allData = <?php echo json_encode($allData, JSON_HEX_TAG | JSON_HEX_APOS); ?>;
  </script>

  <script>
    const selectedProviderNits = new Set();
    document.addEventListener("DOMContentLoaded", () => {
      // 1) Abrir/Cerrar modal "Nuevo Proveedor"
      const nuevoModal = document.getElementById("nuevoModal");
      const openNuevo = document.getElementById("btnAbrirModal");
      const cancelNuevo = document.getElementById("btnCancelar");
      const editButtons = document.querySelectorAll(".edit-button");
      const editModal = document.getElementById("editModal");
      const cancelEdit = document.getElementById("btnCancelarEdit");


      if (openNuevo && nuevoModal && cancelNuevo) {
        // Abrir con clase .show
        openNuevo.addEventListener("click", () => {
          nuevoModal.classList.replace("hide", "show");
        });
        // Cerrar con botón
        cancelNuevo.addEventListener("click", () => {
          nuevoModal.classList.replace("show", "hide");
        });
        // Cerrar al clicar fuera
        nuevoModal.addEventListener("click", e => {
          if (e.target === nuevoModal) {
            nuevoModal.classList.replace("show", "hide");
          }
        });
      }

      if (cancelEdit && editModal) {
        // Cerrar con botón
        cancelEdit.addEventListener("click", () => {
          editModal.classList.replace("show", "hide");
        });
        // Cerrar al clicar fuera
        editModal.addEventListener("click", e => {
          if (e.target === editModal) {
            editModal.classList.replace("show", "hide");
          }
        });
      }

      // Abrir + rellenar datos
      editButtons.forEach(btn => {
        btn.addEventListener("click", e => {
          const row = btn.closest("tr");
          document.getElementById("editNit").value = row.cells[0].innerText.trim();
          document.getElementById("editNitVisible").value = row.cells[0].innerText.trim();
          document.getElementById("editNombre").value = row.cells[1].innerText.trim();
          document.getElementById("editTelefono").value = row.cells[2].innerText.trim();
          document.getElementById("editDireccion").value = row.cells[3].innerText.trim();
          document.getElementById("editCorreo").value = row.cells[4].innerText.trim();
          // Abrir con clase .show
          editModal.classList.replace("hide", "show");
        });
      });
      document.addEventListener('click', function(event) {
        const filterDropdown = document.querySelector('.filter-dropdow  n');

        if (
          filterDropdown.hasAttribute('open') &&
          !filterDropdown.contains(event.target)
        ) {
          filterDropdown.removeAttribute('open');
        }
      });
    });
    // Función para eliminar un producto con SweetAlert2
    function eliminarProducto(nit) {
      Swal.fire({
        title: '<span class="titulo-alerta advertencia">¿Estas Seguro?</span>',

        html: `
            <div class="custom-alert">
                <div class="contenedor-imagen">
                    <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                </div>
                <p>¿Quieres eliminar el proveedor <strong>${nit}</strong>?</p>
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
          fetch('../html/listaproveedor.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              },
              body: `eliminar=1&codigo=${encodeURIComponent(nit)}`
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
                                 <p>El proveedor <strong>${nit}</strong> ha sido eliminado correctamente.</p>
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
                    <p>Error al eliminar el proveedor.</p>
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
              Swal.fire({
                title: '<span class="titulo-alerta error">Error</span>',
                html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/llave.png" alt="Error" class="llave">
                    </div>
                    <p>Error al eliminar el proveedor puede tener productos asociados.</p>
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

    });
  </script>
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
      const rowsPerPage = 7;
      let currentPage = 1;
      let filteredData = [...allData];

      const tableBody = document.querySelector('#providerTable tbody');
      const paginationContainer = document.getElementById('jsPagination');
      const inputBusqueda = document.getElementById('searchRealtime');
      const headers = document.querySelectorAll('#providerTable thead th');
      const deleteBtn = document.getElementById('delete-selected');

      // Mostrar/ocultar botón según checkboxes
      function toggleBtn() {
        const anyChecked = !!document.querySelector('.select-product:checked');
        deleteBtn.style.display = anyChecked ? 'inline-block' : 'none';
      }
      document.querySelectorAll('.select-product').forEach(cb => {
        cb.addEventListener('change', toggleBtn);
      });

      // Al hacer clic en “Eliminar seleccionados”:
      deleteBtn.addEventListener('click', () => {
        const selected = Array.from(document.querySelectorAll('.select-product:checked'))
          .map(cb => cb.value.trim());
        if (selected.length === 0) return;

        Swal.fire({
          title: '<span class="titulo-alerta advertencia">¿Estas Seguro?</span>',
          html: `
          <div class="custom-alert">
                <div class="contenedor-imagen">
                    <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                </div>
          <p>Se eliminarán ${selected.length} proveedores.</p>
          </div>`,
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
        }).then(choice => {
          if (!choice.isConfirmed) return;

          fetch('eliminar_proveedores.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                nits: selected
              })
            })
            .then(r => r.json())
            .then(data => {
              if (data.success) {
                // Quita filas del DOM
                selected.forEach(nit => {
                  const row = document.querySelector(`.select-product[value="${nit}"]`);
                  if (row) row.closest('tr').remove();
                });
                Swal.fire({
                  title: '<span class="titulo-alerta confirmacion">Éxito</span>',
                  html: `
          <div class="custom-alert">
                <div class="contenedor-imagen">
                    <img src="../imagenes/moto.png" alt="Confirmacion" class="moto">
                </div>
          <p>Los proveedores se eliminaron correctamente.</p>
          </div>`,
                  background: '#ffffffdb',
                  confirmButtonText: 'Aceptar',
                  confirmButtonColor: '#007bff',
                  customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    container: 'fondo-oscuro'
                  }
                });
                toggleBtn();
              } else {
                Swal.fire('Error', data.error || 'No se pudo eliminar.', 'error');
              }
            })
            .catch(() => Swal.fire('Error', 'Fallo de comunicación.', 'error'));
        });
      });

      // Render tabla
      function renderTable() {
        const start = (currentPage - 1) * rowsPerPage;
        const pageData = filteredData.slice(start, start + rowsPerPage);

        tableBody.innerHTML = '';
        pageData.forEach(row => {
          const tr = document.createElement('tr');
          ['nit', 'nombre', 'telefono', 'direccion', 'correo'].forEach(f => {
            const td = document.createElement('td');
            td.textContent = row[f];
            tr.appendChild(td);
          });
          // Acciones (usa exactamente tu HTML)
          const tdAcc = document.createElement('td');
          tdAcc.innerHTML = `<button class="edit-button" data-id="${row.nit}"><i class="fa-solid fa-pen-to-square"></i></button>
                         <button class="delete-button" onclick="eliminarProducto('${row.nit}')"><i class="fa-solid fa-trash"></i></button>`;
          tr.appendChild(tdAcc);
          tableBody.appendChild(tr);

          // Selección múltiple
          const tdCheckbox = document.createElement('td');
          const checkbox = document.createElement('input');
          checkbox.type = 'checkbox';
          checkbox.className = 'select-product';
          checkbox.value = row.nit;
          if (selectedProviderNits.has(row.nit)) {
            checkbox.checked = true;
          }
          tdCheckbox.appendChild(checkbox);
          tr.appendChild(tdCheckbox);
        });
        renderPaginationControls();
        attachCheckboxListeners();
      }

      function attachCheckboxListeners() {
        // Recolectamos checkboxes y botón de cabecera
        const checkboxes = document.querySelectorAll(".select-product");
        const deleteBtn = document.getElementById("delete-selected");

        // Cada vez que cambie cualquier checkbox, actualizamos visibilidad
        checkboxes.forEach(cb => {
          cb.addEventListener("change", () => {
            const nit = cb.value;
            if (cb.checked) {
              selectedProviderNits.add(nit);
            } else {
              selectedProviderNits.delete(nit);
            }
            // Persistir selección
            // Mostrar/ocultar botón
            toggleDeleteButtonVisibility();
          });
        });

        // Inicializamos estado al cargar
        toggleDeleteButtonVisibility();

      }

      function toggleDeleteButtonVisibility() {
        const checkedCount = document.querySelectorAll(".select-product:checked").length;
        const deleteBtn = document.getElementById("delete-selected");
        // Mostramos solo si hay 2 o más
        deleteBtn.style.display = checkedCount >= 2 ? "inline-block" : "none";
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
          Object.values(r).some(v => v.toLowerCase().includes(q))
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

      const editModal = document.getElementById("editModal");
      const cancelEdit = document.getElementById("btnCancelarEdit");

      // Cerrar modal
      cancelEdit.addEventListener("click", () => {
        editModal.classList.replace("show", "hide");
      });
      editModal.addEventListener("click", e => {
        if (e.target === editModal) {
          editModal.classList.replace("show", "hide");
        }
      });

      // Abrir + rellenar datos
      function bindEditButtons() {
        document.querySelectorAll(".edit-button").forEach(btn => {
          btn.addEventListener("click", () => {
            const row = btn.closest("tr");
            document.getElementById("editNit").value = row.cells[0].innerText.trim();
            document.getElementById("editNitVisible").value = row.cells[0].innerText.trim();
            document.getElementById("editNombre").value = row.cells[1].innerText.trim();
            document.getElementById("editTelefono").value = row.cells[2].innerText.trim();
            document.getElementById("editDireccion").value = row.cells[3].innerText.trim();
            document.getElementById("editCorreo").value = row.cells[4].innerText.trim();
            editModal.classList.replace("hide", "show");
          });
        });
      }

      bindEditButtons(); // para los botones estáticos
      // si usas paginación dinámica:
      window.renderTable = function renderTable() {
        bindEditButtons(); // vuelve a enlazar después de regenerar filas
      };
      renderTable();

      document.getElementById("providerTable")
        .addEventListener("click", e => {
          const btn = e.target.closest(".edit-button");
          if (!btn) return;
          const cells = btn.closest("tr").cells;
          document.getElementById("editNit").value = cells[0].innerText.trim();
          document.getElementById("editNitVisible").value = cells[0].innerText.trim();
          document.getElementById("editNombre").value = cells[1].innerText.trim();
          document.getElementById("editTelefono").value = cells[2].innerText.trim();
          document.getElementById("editDireccion").value = cells[3].innerText.trim();
          document.getElementById("editCorreo").value = cells[4].innerText.trim();
          document.getElementById("editModal").classList.replace("hide", "show");
        });

    });


    //verificar que nit no se repita, campo se vuelav rojo
    document.addEventListener('DOMContentLoaded', () => {
      const nitInput = document.getElementById('nit');
      const campoDiv = document.getElementById('nit-campo');
      const tooltip = document.getElementById('nit-tooltip');
      const saveBtn = document.querySelector('#btnGuardar');
      let debounce;

      // Oculta tooltip al cargar
      tooltip.style.display = 'none';

      nitInput.addEventListener('input', () => {
        clearTimeout(debounce);
        const val = nitInput.value.trim();

        // 1) Si está vacío: quita errores y oculta todo
        if (!val) {
          nitInput.classList.remove('error');
          tooltip.style.display = 'none';
          saveBtn.disabled = false;
          return;
        }

        // 2) Espera 400ms para no saturar el servidor
        debounce = setTimeout(() => {
          fetch(`listaproveedor.php?verificar_nit=${encodeURIComponent(val)}`)
            .then(r => r.json())
            .then(data => {
              // Dentro de tu listener de input…
              if (data.existe) {
                nitInput.classList.add('error');
                tooltip.style.display = 'block';
                saveBtn.disabled = true;
              } else {
                nitInput.classList.remove('error');
                tooltip.style.display = 'none';
                saveBtn.disabled = false;
              }
            })
            .catch(err => {
              console.error('Validación NIT fallida:', err);
              // Ante fallo, mejor permitir guardar
              nitInput.classList.remove('error');
              campoDiv.classList.remove('error');
              tooltip.style.display = 'none';
              saveBtn.disabled = false;
            });
        }, 400);
      });
    });
  </script>


</body>

</html>