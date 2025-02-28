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

// Obtener el valor de búsqueda
$valor = isset($_GET['valor']) ? mysqli_real_escape_string($conexion, $_GET['valor']) : '';

// Verificar si se han seleccionado criterios y si se ingresó un valor
if (!empty($valor) && isset($_GET['criterios']) && is_array($_GET['criterios'])) {
  $criterios = $_GET['criterios'];

  foreach ($criterios as $criterio) {
    // Sanitizar el criterio
    $criterio = mysqli_real_escape_string($conexion, $criterio);

    // Construir la condición correspondiente según el criterio
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

// Agregar los filtros a la consulta
if (!empty($filtros)) {
  // Unir las condiciones con 'OR' para buscar en cualquiera de los campos
  $consulta .= " AND (" . implode(" OR ", $filtros) . ")";
}

$resultado = mysqli_query($conexion, $consulta);

if (!$resultado) {
  die("No se pudo ejecutar la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <!-- Contenido del head -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inventario</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="../css/inventario.css" />
  <link rel="stylesheet" href="../componentes/header.css">
  <script src="/js/index.js"></script>
 
</head>

<body>
  <!-- Aquí se cargará el header -->
  <div class="sidebar">
    <div id="menu"></div>
  </div>
  <div class="main-content">
  <h1>Inventario</h1>
  <div class="filter-bar">
    <!-- Botón de filtrar -->
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
                
        </div>
    </details>

    <!-- Barra de búsqueda -->
    <input class="form-control" type="text" name="valor" placeholder="Ingrese el valor a buscar">
    <button class="search-button" type="submit">Buscar</button>
    </form> <!-- Cierre correcto del formulario -->

    <!-- Botón de Exportar a Excel -->
    <div class="export-button">
        <form action="exportar_excel.php" method="post">
            <button type="submit" class="icon-button" aria-label="Exportar a Excel" title="Exportar a Excel">
                <i class="fas fa-file-excel"></i>
                <label style="color: white; font-size: 14px;">  Exportar a Excel</label>
            </button>
        </form>
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
                <th class="text-center">
                  <input type="checkbox" />
                </th>
              </tr>
            </thead>
            <tbody>
              <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                  <td><?= $fila["codigo1"] ?? 'N/A'; ?></td>
                  <td><?= $fila["codigo2"] ?? 'N/A'; ?></td>
                  <td><?= $fila["nombre"] ?? 'N/A'; ?></td>
                  <td><?= $fila["iva"] ?? 'N/A'; ?></td>
                  <td><?= $fila["precio1"] ?? 'N/A'; ?></td>
                  <td><?= $fila["precio2"] ?? 'N/A'; ?></td>
                  <td><?= $fila["precio3"] ?? 'N/A'; ?></td>
                  <td><?= $fila["cantidad"] ?? 'N/A'; ?></td>
                  <td><?= $fila["descripcion"] ?? 'N/A'; ?></td>
                  <td><?= $fila["categoria"] ?? 'N/A'; ?></td>
                  <td><?= $fila["marca"] ?? 'N/A'; ?></td>
                  <td><?= $fila["unidadmedida"] ?? 'N/A'; ?></td>
                  <td><?= $fila["ubicacion"] ?? 'N/A'; ?></td>
                  <td><?= $fila["proveedor"] ?? 'N/A'; ?></td>
                  <td class='text-center'>
  <button class='edit-button' data-id='<?= $fila["codigo1"] ?>'>Editar</button>
  <button class='delete-button' data-id='<?= $fila["codigo1"] ?>'>Eliminar</button>
</td>
<div id="editModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Editar Producto</h2>
    <form id="editForm" method="post">
  <!-- Campo oculto para enviar el código 1 -->
  <input type="hidden" id="editCodigo1" name="codigo1">
  
  <!-- Campo visible pero solo lectura -->
  <label for="editCodigo1">Código:</label>
  <input type="text" id="editCodigo1Visible" readonly>
      <label for="editCodigo2">Código 2:</label>
      <input type="text" id="editCodigo2" name="codigo2">
      <label for="editNombre">Nombre:</label>
      <input type="text" id="editNombre" name="nombre">
    
      <label for="editPrecio1">Precio 1:</label>
      <input type="text" id="editPrecio1" name="precio1">
      <label for="editPrecio2">Precio 2:</label>
      <input type="text" id="editPrecio2" name="precio2">
      <label for="editPrecio3">Precio 3:</label>
      <input type="text" id="editPrecio3" name="precio3">
      <label for="editCantidad">Cantidad:</label>
      <input type="text" id="editCantidad" name="cantidad">
      <label for="editDescripcion">Descripción:</label>
      <input type="text" id="editDescripcion" name="descripcion">
      <label for="editCategoria">Categoría:</label>
      <input type="text" id="editCategoria" name="categoria">
      <label for="editMarca">Marca:</label>
      <input type="text" id="editMarca" name="marca">
      <label for="editUnidadMedida">Unidad Medida:</label>
      <input type="text" id="editUnidadMedida" name="unidadmedida">
      <label for="editUbicacion">Ubicación:</label>
      <input type="text" id="editUbicacion" name="ubicacion">
      <label for="editProveedor">Proveedor:</label>
      <input type="text" id="editProveedor" name="proveedor">
      <button type="submit">Guardar Cambios</button>
    </form>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
  const editButtons = document.querySelectorAll('.edit-button');
  const modal = document.getElementById('editModal');
  const closeModal = document.querySelector('.close');
  const editForm = document.getElementById('editForm');

  // Abrir modal y cargar datos
  editButtons.forEach(button => {
    button.addEventListener('click', function() {
      const row = this.closest('tr');

      const codigo1 = row.cells[0].innerText; // Código 1
      document.getElementById('editCodigo1').value = codigo1; // Campo oculto
      document.getElementById('editCodigo1Visible').value = codigo1; // Campo visible
      
     
      document.getElementById('editCodigo2').value = row.cells[1].innerText;
      document.getElementById('editNombre').value = row.cells[2].innerText;
      document.getElementById('editPrecio1').value = row.cells[4].innerText;
      document.getElementById('editPrecio2').value = row.cells[5].innerText;
      document.getElementById('editPrecio3').value = row.cells[6].innerText;
      document.getElementById('editCantidad').value = row.cells[7].innerText;
      document.getElementById('editDescripcion').value = row.cells[8].innerText;
      document.getElementById('editCategoria').value = row.cells[9].innerText;
      document.getElementById('editMarca').value = row.cells[10].innerText;
      document.getElementById('editUnidadMedida').value = row.cells[11].innerText;
      document.getElementById('editUbicacion').value = row.cells[12].innerText;
      document.getElementById('editProveedor').value = row.cells[13].innerText;

      modal.style.display = 'block';
    });
  });

  // Cerrar modal
  closeModal.addEventListener('click', function() {
    modal.style.display = 'none';
  });

  // Enviar formulario de edición
  document.querySelector("#formulario-editar").addEventListener("submit", function (e) {
    e.preventDefault(); // Evita el envío por defecto

    let formData = new FormData(this);

    fetch("../html/editar.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            location.reload(); // Recargar la página para reflejar los cambios
        }
    })
    .catch(error => console.error("Error:", error));
});

  
    });


</script>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p>No se encontraron resultados con los criterios seleccionados.</p>
        <?php endif; ?>
      </div>
  </div>
z
</body>

</html>