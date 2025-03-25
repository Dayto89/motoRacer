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
$valor = isset($_GET['valor']) ? mysqli_real_escape_string($conexion, $_GET['valor']) : '';

if (!empty($valor) && isset($_GET['criterios']) && is_array($_GET['criterios'])) {
  $criterios = $_GET['criterios'];
  foreach ($criterios as $criterio) {
    $criterio = mysqli_real_escape_string($conexion, $criterio);
    switch ($criterio) {
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
        GROUP_CONCAT(m.metodoPago SEPARATOR ', ') AS metodoPago
    FROM 
        factura f
    LEFT JOIN 
        factura_metodo_pago m ON m.Factura_codigo = f.codigo
    LEFT JOIN
        cliente c ON c.codigo = f.Cliente_codigo
    LEFT JOIN
       usuario n ON n.identificacion = f.Usuario_identificacion
    GROUP BY 
        f.codigo, f.fechaGeneracion, f.Usuario_identificacion, f.Cliente_codigo, f.precioTotal,         c.nombre, 
        c.apellido, 
        n.nombre, 
        n.apellido 
";

// Aplicar filtros dinámicos
$filtros = [];

if (!empty($_GET['fecha_desde']) && !empty($_GET['fecha_hasta'])) {
    $fecha_desde = mysqli_real_escape_string($conexion, $_GET['fecha_desde']);
    $fecha_hasta = mysqli_real_escape_string($conexion, $_GET['fecha_hasta']);
    $filtros[] = "f.fechaGeneracion BETWEEN '$fecha_desde' AND '$fecha_hasta'";
}

if (!empty($_GET['busqueda'])) {
    $busqueda = mysqli_real_escape_string($conexion, $_GET['busqueda']);
    $filtros[] = "(c.nombre LIKE '%$busqueda%' OR c.apellido LIKE '%$busqueda%' 
                   OR u.nombre LIKE '%$busqueda%' OR u.apellido LIKE '%$busqueda%' 
                   OR m.metodoPago LIKE '%$busqueda%')";
}

if (!empty($filtros)) {
    $consulta .= " WHERE " . implode(" AND ", $filtros);
}

if (!empty($filtros)) {
  $consulta .= " AND (" . implode(" OR ", $filtros) . ")";
}

$resultado = mysqli_query($conexion, $consulta);

if (!$resultado) {
  die("No se pudo ejecutar la consulta: " . mysqli_error($conexion));
}

// Actualización de datos del modal
if (isset($_POST['codigo1'])) {
  // Se reciben y se escapan las variables
  $codigo1 = mysqli_real_escape_string($conexion, $_POST['codigo1']);
  $fechaGeneracion = mysqli_real_escape_string($conexion, $_POST['fechaGeneracion']);
  $Usuario_identificacion = mysqli_real_escape_string($conexion, $_POST['Usuario_identificacion']);
  $Cliente_codigo = mysqli_real_escape_string($conexion, $_POST['Cliente_codigo']);
  $precioTotal = mysqli_real_escape_string($conexion, $_POST['precioTotal']);


  $consulta_update = "UPDATE producto SET 
      codigo1 = '$codigo1', 
      fechaGeneracion = '$fechaGeneracion', 
      Usuario_identificacion = '$Usuario_identificacion', 
      Cliente_codigo = '$Cliente_codigo', 
      precioTotal = '$precioTotal', 

      WHERE codigo1 = '$codigo1'";
  if (mysqli_query($conexion, $consulta_update)) {
    echo "<script>alert('Datos actualizados correctamente')</script>";
  } else {
    echo "<script>alert('Error al actualizar los datos: " . mysqli_error($conexion) . "')</script>";
  }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'], $_POST['codigo'])) {
  header('Content-Type: application/json'); // Para que el JS lo entienda como JSON
  $codigo = $_POST['codigo'];

  $consulta = "DELETE FROM producto WHERE codigo1 = '$codigo'";
  $eliminado = mysqli_query($conexion, $consulta);
  if (!$eliminado) {
    echo json_encode(['success' => false, 'error' => mysqli_error($conexion)]);
    exit;
  }

  echo json_encode(['success' => $eliminado]);
  exit; // Para evitar mezclar con HTML
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reportes</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="../css/reporte.css" />
  <link rel="stylesheet" href="../componentes/header.css">
  <link rel="stylesheet" href="../componentes/header.php">
  <script src="../js/header.js"></script>
  <script src="/js/index.js"></script>
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>

</head>

<body>
  <div class="sidebar">
    <div id="menu"></div>
  </div>
  <div class="main-content">
    <h1>Reportes</h1>
    <div class="filter-bar">
      <details class="filter-dropdown">
        <summary class="filter-button">Filtrar</summary>
        <div class="filter-options">
          <form method="GET" action="inventario.php" class="search-form">
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
            <form method="GET" action="reportes.php">
    <label>Desde:</label>
    <input type="date" name="fecha_desde" required>

    <label>Hasta:</label>
    <input type="date" name="fecha_hasta" required>

    <input type="text" name="busqueda" placeholder="Ingrese el valor a buscar">

    <button type="submit">Filtrar</button>
</form>

        </div>
      </details>
      <input class="form-control" type="text" name="valor" placeholder="Ingrese el valor a buscar">
      <button class="search-button" type="submit">Buscar</button>
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
            <th>Nro. Factura</th>
            <th>Fecha</th>
            <th>Metodo de pago</th>
            <th>vendedor</th>
            <th>Cliente</th>
            <th>Total venta</th>
            <th>Accion</th>

          </tr>
        </thead>
        <tbody>
          <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
            <tr>
              <td><?= htmlspecialchars($fila['codigo']) ?></td>

              <td data-categoria-id="<?= htmlspecialchars($fila['fechaGeneracion']) ?>">
                <?= htmlspecialchars($fila['fechaGeneracion']) ?>
              </td>
              <td data-marca-id="<?= htmlspecialchars($fila['metodoPago']) ?>">
                <?= htmlspecialchars($fila['metodoPago']) ?>
              </td>

              <td data-marca-id="<?= htmlspecialchars($fila['Usuario_identificacion']) ?>">
                <?= htmlspecialchars($fila['usuario_nombre'] . ' ' . $fila['usuario_apellido']) ?>
              </td>
              <td data-unidadmedida-id="<?= htmlspecialchars($fila['Cliente_codigo']) ?>">
                <?= htmlspecialchars($fila['cliente_nombre'] . ' ' . $fila['cliente_apellido']) ?>
              </td>

              <td data-ubicacion-id="<?= htmlspecialchars($fila['precioTotal']) ?>">
                <?= htmlspecialchars($fila['precioTotal']) ?>
              </td>

              <td class="acciones">
                <button class="delete-button" onclick="eliminarProducto('<?= $fila['codigo'] ?>')"><animated-icons
                    src="https://animatedicons.co/get-icon?name=delete&style=minimalistic&token=c1352b7b-2e14-4124-b8fd-a064d7e44225"
                    trigger="hover"
                    attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#536DFE","background":"#FFFFFF"}}'
                    height="25"
                    width="25"></animated-icons></button>
                <button class="recibo-button"><animated-icons
                    src="https://animatedicons.co/get-icon?name=search&style=minimalistic&token=12e9ffab-e7da-417f-a9d9-d7f67b64d808"
                    trigger="hover"
                    attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#FFFFFFFF","group-2":"#536DFE","background":"#FFFFFFFF"}}'
                    height="25"
                    width="25"></animated-icons></button>
              </td>
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

    // Función para eliminar un producto
    function eliminarProducto(codigo) {
      if (!confirm(`¿Está seguro de eliminar el producto con código ${codigo}?`)) {
        return;
      }

      fetch('inventario.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `eliminar=1&codigo=${encodeURIComponent(codigo)}`
        })
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => {
          if (data.success) {
            alert('Producto eliminado correctamente');
            location.reload();
          } else {
            alert('Error al eliminar el producto');
          }
        })
        .catch(error => {
          alert('Error en la solicitud');
          console.error('Error en fetch:', error);
        });
    }
  </script>
</body>

</html>