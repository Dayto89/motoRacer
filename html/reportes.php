<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.php");
  exit();
}

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

// Eliminar el manejo de 'valor' y usar solo 'busqueda'
$busqueda = isset($_GET['busqueda']) ? mysqli_real_escape_string($conexion, $_GET['busqueda']) : '';

// Manejar búsqueda general
if (!empty($busqueda)) {
  $condiciones = [];

  if (isset($_GET['criterios']) && is_array($_GET['criterios'])) {
    // Búsqueda por criterios seleccionados
    foreach ($_GET['criterios'] as $criterio) {
      $criterio = mysqli_real_escape_string($conexion, $criterio);
      switch ($criterio) {
        case 'codigo':
          $condiciones[] = "f.codigo = '$busqueda'";
          break;
        case 'fechaGeneracion':
          $condiciones[] = "f.fechaGeneracion LIKE '%$busqueda%'";
          break;
        case 'metodoPago':
          // Busqueda exacta en tabla de métodos
          $condicionesBusqueda[] = "EXISTS (
                SELECT 1 
                FROM factura_metodo_pago tmp 
                WHERE tmp.Factura_codigo = f.codigo 
                AND tmp.metodoPago = '$valor'
            )";
          break;
        case 'Cliente_codigo':
          $condiciones[] = "f.Cliente_codigo LIKE '%$busqueda%'";
          break;
        case 'vendedor':
          $condiciones[] = "(n.nombre LIKE '%$busqueda%' OR n.apellido LIKE '%$busqueda%')";
          break;
        case 'cliente':
          $condiciones[] = "(c.nombre LIKE '%$busqueda%' OR c.apellido LIKE '%$busqueda%')";
          break;
        case 'precioTotal':
          $condiciones[] = "f.precioTotal = '$busqueda'";
          break;
      }
    }
  } else {
    // Búsqueda general si no hay criterios seleccionados
    $condicionesGenerales = [
      "f.codigo = '$busqueda'",
      "f.Cliente_codigo = '$busqueda'",
      "f.precioTotal = '$busqueda'",
      "(c.nombre LIKE '%$busqueda%' OR c.apellido LIKE '%$busqueda%')",
      "(n.nombre LIKE '%$busqueda%' OR n.apellido LIKE '%$busqueda%')",
      "EXISTS (
          SELECT 1 
          FROM factura_metodo_pago tmp 
          WHERE tmp.Factura_codigo = f.codigo 
          AND tmp.metodoPago = '$busqueda'
      )"
    ];

    $filtros[] = "(" . implode(" OR ", $condicionesGenerales) . ")";
  }
}

$consulta = "
    SELECT 
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
    FROM 
        factura f
    LEFT JOIN factura_metodo_pago m 
        ON m.Factura_codigo = f.codigo
    LEFT JOIN cliente c 
        ON c.codigo = f.Cliente_codigo
    LEFT JOIN usuario n 
        ON n.identificacion = f.Usuario_identificacion
";

// Añadir condiciones WHERE si hay filtros
if (!empty($filtros)) {
  $consulta .= " WHERE " . implode(" AND ", $filtros);
}

// Agregar GROUP BY una sola vez
$consulta .= " GROUP BY 
    f.codigo, 
    f.fechaGeneracion, 
    f.Usuario_identificacion, 
    f.Cliente_codigo, 
    f.precioTotal, 
    c.nombre, 
    c.apellido, 
    n.nombre, 
    n.apellido";

// Ejecutar la consulta
$resultado = mysqli_query($conexion, $consulta);

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

</head>

<body>
  <script>
    // Función para eliminar un producto
    function eliminarFactura(codigo) {
      if (!confirm(`¿Eliminar factura ${codigo} y todos sus datos asociados?`)) return;

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
            alert('Factura y registros relacionados eliminados');
            location.reload();
          } else {
            alert(`Error: ${data.error || 'No se pudo completar la eliminación'}`);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error al conectar con el servidor');
        });
    }
  </script>
  <div class="sidebar">
    <div id="menu"></div>
  </div>
  <div class="main-content">
    <h1>Reportes</h1>
    <div class="filter-bar">
      <form method="GET" action="reportes.php" class="search-form"> <!-- Form único que envía todo -->
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
          <input style="width: 650px" type="text"
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
            <i class="fas fa-file-excel"></i>
            <label style="color: white; font-size: 14px;"> Exportar a Excel</label>
          </button>
        </form>

      </div>

    </div>

    <?php if (mysqli_num_rows($resultado) > 0): ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
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
                <button class="delete-button" onclick="eliminarFactura('<?= $fila['codigo'] ?>')"><animated-icons
                    src="https://animatedicons.co/get-icon?name=delete&style=minimalistic&token=c1352b7b-2e14-4124-b8fd-a064d7e44225"
                    trigger="hover"
                    attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#536DFE","background":"#FFFFFF"}}'
                    height="25"
                    width="25"></animated-icons></button>
                <form method="POST">
                  <input type="hidden" name="factura_id" value="<?php echo $fila['codigo']; ?>">
                  <button type="submit" class="recibo-button">
                    <animated-icons
                      src="https://animatedicons.co/get-icon?name=search&style=minimalistic&token=12e9ffab-e7da-417f-a9d9-d7f67b64d808"
                      trigger="hover"
                      attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#FFFFFFFF","group-2":"#536DFE","background":"#FFFFFFFF"}}'
                      height="25"
                      width="25"></animated-icons>
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

        if (!confirm(`¿Estás seguro de eliminar ${selectedCodes.length} productos?`)) {
          return;
        }

        // Depuración: Ver datos antes de enviarlos
        console.log("Enviando códigos a eliminar:", selectedCodes);

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
              alert("Productos eliminados correctamente.");
              location.reload();
            } else {
              alert("Error al eliminar los productos: " + data.error);
            }
          })
          .catch(error => {
            console.error("Error en la solicitud:", error);
            alert("Error en la comunicación con el servidor.");
          });
      });
    });