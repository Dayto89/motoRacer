<?php

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');

if (!$conexion) {
  die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

$busqueda = isset($_GET['busqueda']) ? mysqli_real_escape_string($conexion, $_GET['busqueda']) : '';

$consulta = "
    SELECT 
        p.`codigo1`,
        p.`codigo2`,
        p.nombre,
        p.iva,
        p.`precio1`,
        p.`precio2`,
        p.`precio3`,
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
";

if ($busqueda != '') {
  $consulta .= " WHERE 
      p.codigo1 LIKE '%$busqueda%' OR 
      p.codigo2 LIKE '%$busqueda%' OR
      p.nombre LIKE '%$busqueda%' OR 
      p.cantidad LIKE '%$busqueda%' OR
      p.descripcion LIKE '%$busqueda%' OR
      c.nombre LIKE '%$busqueda%' OR 
      m.nombre LIKE '%$busqueda%' OR 
      ub.nombre LIKE '%$busqueda%'";
}



$resultado = mysqli_query($conexion, $consulta);

if (!$resultado) {
  die("No se pudo ejecutar la consulta: " . mysqli_error($conexion));
}




?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inventario</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="../css/inventario.css" />
  <link rel="stylesheet" href=" ../componentes/header.html">
  <link rel="stylesheet" href="../componentes/header.css">
  <script src="/js/index.js"></script>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap");
  </style>
</head>

<body>
  <!-- Aquí se cargará el header -->
  <div id="menu"></div>


  <!--Barra de búsqueda fija con efecto deslizante -->
  <div class="search-bar">
    <form method="GET" action="inventario.php">
      <button class="search-icon" type="submit" aria-label="Buscar" title="Buscar">
        <i class="bx bx-search-alt-2 icon"></i>
      </button>
      <input class="form-control" type="text" name="busqueda" placeholder="Buscar">
    </form>

  </div>

  <!-- Contenido principal -->
  <div class="main-content">

    <!-- Sección del Inventario -->

    <div id="inventario" class="form-section">
      <h1>Inventario</h1>
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
            <th>Categoria</th>
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
          <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
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
                <i class='fa-solid fa-trash' title='Eliminar'></i>
              </td>
            </tr>
          <?php } ?>
        </tbody>

      </table>
    </div>
  </div>
</body>

</html>