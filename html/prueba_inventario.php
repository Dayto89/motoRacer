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
        p.codigo1,
        p.codigo2,
        p.nombre,
        p.iva,
        p.precio1,
        p.precio2,
        p.precio3,
        p.cantidad,
        p.descripcion,
        p.Categoria_codigo,
        p.Marca_codigo,
        p.UnidadMedida_codigo,
        p.Ubicacion_codigo,
        p.proveedor_nit,
        c.nombre AS categoria,
        m.nombre AS marca,
        u.nombre AS unidadmedida,
        ub.nombre AS ubicacion,
        pr.nombre AS proveedor
    FROM 
        producto p
    LEFT JOIN 
        categoria c ON p.Categoria_codigo = c.codigo
    LEFT JOIN 
        marca m ON p.Marca_codigo = m.codigo
    LEFT JOIN 
        unidadmedida u ON p.UnidadMedida_codigo = u.codigo
    LEFT JOIN 
        ubicacion ub ON p.Ubicacion_codigo = ub.codigo
    LEFT JOIN 
        proveedor pr ON p.proveedor_nit = pr.nit
    WHERE 1=1
";

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
    echo "<script>alert('Datos actualizados correctamente')</script>";
  } else {
    echo "<script>alert('Error al actualizar los datos: " . mysqli_error($conexion) . "')</script>";
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
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inventario</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="../css/inventario.css" />
  <link rel="stylesheet" href="../componentes/header.css">
  <link rel="stylesheet" href="../componentes/header.php">
  <script src="../js/header.js"></script>
  <script src="/js/index.js"></script>

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
          <form method="GET" action="../html/listaproductos.php" class="search-form">
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
            <label style="color: white; font-size: 14px;"> Exportar a Excel</label>
          </button>
        </form>
        <button id="delete-selected" style="display: none; background-color: red; color: white; padding: 8px 12px; border: none; border-radius: 5px; cursor: pointer;">
  🗑 Eliminar Seleccionados
</button>

      </div>
    </div>

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
              <td data-categoria-id="<?= htmlspecialchars($fila['Categoria_codigo']) ?>">
                <?= htmlspecialchars($fila['categoria']) ?>
              </td>
              <td data-marca-id="<?= htmlspecialchars($fila['Marca_codigo']) ?>">
                <?= htmlspecialchars($fila['marca']) ?>
              </td>
              <td data-unidadmedida-id="<?= htmlspecialchars($fila['UnidadMedida_codigo']) ?>">
                <?= htmlspecialchars($fila['unidadmedida']) ?>
              </td>
              <td data-ubicacion-id="<?= htmlspecialchars($fila['Ubicacion_codigo']) ?>">
                <?= htmlspecialchars($fila['ubicacion']) ?>
              </td>
              <td data-proveedor-id="<?= htmlspecialchars($fila['proveedor_nit']) ?>">
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
      </td> <!-- Checkbox agregado -->
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>

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
    if (!confirm(`¿Eliminar producto ${codigo}?`)) return;

    fetch('../html/listaproductos.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
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
            alert('Producto eliminado');
            location.reload();
        } else {
            alert(data.error || 'Error desconocido');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('No se pudo eliminar. Ver consola para detalles.');
    });
}
// funcion de los checkboxes
document.getElementById("select-all").addEventListener("change", function () {
  let checkboxes = document.querySelectorAll(".select-product");
  checkboxes.forEach(checkbox => {
    checkbox.checked = this.checked;
  });
});

document.addEventListener("DOMContentLoaded", function () {
  let selectAllCheckbox = document.getElementById("select-all");
  let checkboxes = document.querySelectorAll(".select-product");
  let deleteButton = document.getElementById("delete-selected");

  function toggleDeleteButton() {
    let anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
    deleteButton.style.display = anyChecked ? "inline-block" : "none";
  }

  selectAllCheckbox.addEventListener("change", function () {
    checkboxes.forEach(checkbox => {
      checkbox.checked = this.checked;
    });
    toggleDeleteButton();
  });

  checkboxes.forEach(checkbox => {
    checkbox.addEventListener("change", toggleDeleteButton);
  });

  deleteButton.addEventListener("click", function () {
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
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ codigos: selectedCodes })
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




  </script>
</body>

</html>