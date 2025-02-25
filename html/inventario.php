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
  <style>
    /* Tus estilos CSS adicionales */
    .criteria-group {
      display: flex;
      flex-wrap: wrap;
      margin-bottom: 10px;
    }

    .criteria-group label {
      margin-right: 15px;
    }

    .filter-bar {
      margin-bottom: 20px;
    }

    .search-button {
      padding: 8px 16px;
      background-color: #007bff;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 4px;
    }

    .search-button:hover {
      background-color: #0056b3;
    }
  </style>
</head>

<body>
  <!-- Aquí se cargará el header -->
  <div class="sidebar">
    <div id="menu"></div>
  </div>
  <div class="filter-bar">
  <!-- Botón y menú desplegable de filtrado -->
  <details class="filter-dropdown">
    <summary class="filter-button">Filtrar</summary>
    <div class="filter-options">
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

  <!-- Barra de búsqueda (siempre visible) -->
  <form method="GET" action="inventario.php" class="search-form">
    <input class="form-control" type="text" name="valor" placeholder="Ingrese el valor a buscar">
    <button class="search-button" type="submit">Buscar</button>
  </form>
</div>

  <!-- Contenido principal -->
  <div class="main-content">
    <!-- Sección del Inventario -->
    <div id="inventario" class="form-section">
      <h1>Inventario</h1>
      <div class="export-button">
        <form action="exportar_excel.php" method="post">
          <button type="submit" class="icon-button" aria-label="Exportar a Excel" title="Exportar a Excel">
            <i class="fas fa-file-excel"></i>
            <label style="color: white; font-size: 16px;">Exportar a Excel</label>
          </button>
        </form>
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
                  <i class='fa-regular fa-pen-to-square' title='Editar'></i>
                  <i class='fa-solid fa-trash' id="eliminar" title='Eliminar'></i>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>No se encontraron resultados con los criterios seleccionados.</p>
      <?php endif; ?>
    </div>
  </div>

</body>

</html>