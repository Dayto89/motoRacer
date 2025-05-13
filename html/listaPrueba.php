<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

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

// Construcción de filtros
$filtros = [];
$valor = isset($_GET['valor']) ? mysqli_real_escape_string($conexion, $_GET['valor']) : '';
$criterios = isset($_GET['criterios']) && is_array($_GET['criterios']) ? $_GET['criterios'] : [];

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
      case 'estado':
        $filtros[] = "p.estado LIKE '%$valor%'";
        break;
    }
  }
}

// PAGINACIÓN
$por_pagina = 15;
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
  p.correo, 
  p.estado
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
  $estado = mysqli_real_escape_string($conexion, $_POST['estado']);

  $query = "INSERT INTO proveedor (nit, nombre, telefono, direccion, correo, estado) VALUES ('$nit', '$nombre', '$telefono', '$direccion', '$correo', '$estado')";

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
                    <p>Categoría agregada correctamente.</p>
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
                <p>La categoría no fue agregada.<br><small>$error</small></p>
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
  $estado = mysqli_real_escape_string($conexion, $_POST['estado']);

  $consulta_update = "UPDATE proveedor SET 
        nit = '$nit', 
        nombre = '$nombre', 
        telefono = '$telefono', 
        direccion = '$direccion', 
        correo = '$correo', 
        estado = '$estado'
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
                      window.location.href = 'listaPrueba.php'; // Redirige después de cerrar el alert
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



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'], $_POST['nit'])) {
  header('Content-Type: application/json');

  // Debug: Registrar el código recibido
  error_log("Código recibido: " . $_POST['nit']);

  if (!$conexion) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión']);
    exit;
  }

  $nit = $_POST['nit'];
  $stmt = $conexion->prepare("DELETE FROM proveedor WHERE nit = ?");
  $stmt->bind_param("s", $nit);

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
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inventario</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
  <link rel="stylesheet" href="../css/listaproveedor.css" />
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
    <h1>Proveedores</h1>
    <div class="filter-bar">
      <details class="filter-dropdown">
        <summary class="filter-button">Filtrar</summary>
        <div class="filter-options">
          <form method="GET" action="../html/listaproductosPrueba.php" class="search-form">
            <div class="criteria-group">
              <label><input type="checkbox" name="criterios[]" value="nit"> Nit</label>
              <label><input type="checkbox" name="criterios[]" value="nombre"> Nombre</label>
              <label><input type="checkbox" name="criterios[]" value="telefono"> Teléfono</label>
              <label><input type="checkbox" name="criterios[]" value="direccion"> Dirección</label>
              <label><input type="checkbox" name="criterios[]" value="correo"> Correo</label>
              <label><input type="checkbox" name="criterios[]" value="estado"> Estado</label>
            </div>

        </div>
      </details>
      <input class="form-control" type="text" name="valor" placeholder="Ingrese el valor a buscar">
      <button class="search-button" type="submit">Buscar</button>
      </form>
      <button id="btnAbrirModal" class="btn-nueva-categoria"><i class='bx bx-plus bx-tada icon'></i>Nuevo Proveedor</button>
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

    <?php if (mysqli_num_rows($resultado) > 0): ?>
      <table>
        <thead>
          <tr>
            <th>Nit</th>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Correo</th>
            <th>Estado</th>
            <th>Acciones</th>
            <th><input type="checkbox" id="select-all"></th>

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
              <td><?= htmlspecialchars($fila['estado']) ?></td>
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

      <!-- Modal -->
  <div id="modal" class="modal">
    <div class="modal-content">
      <h2>Nuevo Proveedor</h2>
      <form method="POST" action="">
        <div class="form-group">
          <label>Ingrese el nit:</label>
          <input type="text" id="nit" name="nit" required />
          <label>Ingrese el nombre del proveedor:</label>
          <input type="text" id="nombre" name="nombre" required />
          <label for="telefono">Ingrese el telefono:</label>
          <input type="text" id="telefono" name="telefono" required />
          <label for="direccion">Ingrese la dirección:</label>
          <input type="text" id="direccion" name="direccion" required />
          <label for="correo">Ingrese el correo:</label>
          <input type="text" id="correo" name="correo" required />
          <label for="estado">Ingrese el estado:</label>
          <input type="text" id="estado" name="estado" required />
        </div>
        <div class="modal-buttons">
          <button type="button" id="btnCancelar">Cancelar</button>
          <button type="submit" name="guardar" id="btnGuardar">Guardar</button>
        </div>
      </form>
    </div>
  </div>

    <!-- Modal de edición -->
    <div id="editModal" class="modal">
      <div class="modal-content">
        <span class="close">
          <i class="fa-solid fa-x"></i>
        </span>

        <h2>Editar Proveedor</h2>
        <form id="editForm" method="post">
          <!-- Campo oculto para enviar el código 1 -->
          <input type="hidden" id="editNit" name="nit">
          <div class="campo"><label for="editNitVisible">Nit:</label>
            <input type="text" id="editNitVisible" readonly>
          </div>
          <div class="campo"><label for="editNombre">Nombre:</label>
            <input type="text" id="editNombre" name="nombre">
          </div>
          <div class="campo"> <label for="editTelefono">Teléfono:</label>
            <input type="text" id="editTelefono" name="telefono">
          </div>
          <div class="campo"><label for="editDireccion">Dirección:</label>
            <input type="text" id="editDireccion" name="direccion">
          </div>
          <div class="campo"> <label for="editCorreo">Correo:</label>
            <input type="text" id="editCorreo" name="correo">
          </div>
          <div class="campo"><label for="editEstado">Estado:</label>
            <input type="text" id="editEstado" name="estado">
          </div>
          <div class="modal-boton"> <button type="submit" id="modal-boton">Guardar Cambios</button></div>

        </form>
      </div>
    </div>
  </div>
  <script>
        document.addEventListener("DOMContentLoaded", () => {
      // 1) Abrir/Cerrar modal "Nuevo Proveedor"
      const modal = document.getElementById("modal");
      const openBtn = document.getElementById("btnAbrirModal");
      const cancelBtn = document.getElementById("btnCancelar");

      if (openBtn && modal && cancelBtn) {
        // Asegúrate de que el modal tenga class="modal hide" inicialmente
        openBtn.addEventListener("click", () => {
          modal.classList.replace("hide", "show");
          modal.style.display = "block";
        });
        cancelBtn.addEventListener("click", () => {
          modal.classList.replace("show", "hide");
          setTimeout(() => modal.style.display = "none", 300);
        });
        window.addEventListener("click", e => {
          if (e.target === modal) {
            modal.classList.replace("show", "hide");
            setTimeout(() => modal.style.display = "none", 300);
          }
        });
      }
    });
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
          const nit = row.cells[0].innerText.trim();
          document.getElementById('editNit').value = nit;
          document.getElementById('editNitVisible').value = nit;
          document.getElementById('editNombre').value = row.cells[1].innerText.trim();
          document.getElementById('editTelefono').value = row.cells[2].innerText.trim();
          document.getElementById('editDireccion').value = row.cells[3].innerText.trim();
          document.getElementById('editCorreo').value = row.cells[4].innerText.trim();
          document.getElementById('editEstado').value = row.cells[5].innerText.trim();
          modal.style.display = 'block';
        });
      });



      // Listener para cerrar el modal
      closeModal.addEventListener('click', function() {
        modal.style.display = 'none';
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
                <p>¿Quieres eliminar el producto <strong>${nit}</strong>?</p>
            </div>
        `,

        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
        customClass: {
          popup: "custom-alert",
          confirmButton: "btn-eliminar", // Clase personalizada para el botón de confirmación
          cancelButton: "btn-cancelar" // Clase personalizada para el botón de cancelar
        }
      }).then((result) => {
        if (result.isConfirmed) {
          // Enviar la solicitud al servidor
          fetch('../html/listaPrueba.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              },
              body: `eliminar=1&nit=${encodeURIComponent(nit)}`
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
                                 <p>El producto <strong>${nit}</strong> ha sido eliminado correctamente.</p>
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
          alert("Selecciona al menos un proveedor para eliminar.");
          return;
        }

        // Mostrar la alerta con SweetAlert
        Swal.fire({
          title: '<span class="titulo-alerta advertencia">¿Estas Seguro?</span>',
          html: `
            <div class="custom-alert">
                <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                <p>Los proveedores se eliminarán de forma permanente.</p>
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
        }).then((result) => {
          if (result.isConfirmed) {
            // Depuración: Ver datos antes de enviarlos
            console.log("Enviando códigos a eliminar:", selectedCodes);

            // Enviar datos al servidor
            fetch("eliminar_proveedores.php", {
                method: "POST",
                headers: {
                  "Content-Type": "application/json"
                },
                body: JSON.stringify({
                  nits: selectedCodes
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