<?php
// Conexión directa
$conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");

$filtros = [];

if (!empty($_GET['fecha_inicio']) && !empty($_GET['fecha_fin'])) {
  $fechaInicio = $_GET['fecha_inicio'];
  $fechaFin = $_GET['fecha_fin'];
  $filtros[] = "f.fecha BETWEEN '$fechaInicio' AND '$fechaFin'";
}

if (!empty($_GET['metodo_pago'])) {
  $metodoPago = $_GET['metodo_pago'];
  $filtros[] = "m.Metodo_pago_idMetodo_pago = '$metodoPago'";
}

if (!empty($_GET['cliente'])) {
  $cliente = $_GET['cliente'];
  $filtros[] = "c.codigo = '$cliente'";
}

if (!empty($_GET['usuario'])) {
  $usuario = $_GET['usuario'];
  $filtros[] = "n.identificacion = '$usuario'";
}

// PAGINACIÓN
$registros_por_pagina = 10;
$pagina_actual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Consulta para contar total de resultados
$consulta_total = "SELECT COUNT(DISTINCT f.codigo) AS total FROM factura f 
LEFT JOIN factura_metodo_pago m ON m.Factura_codigo = f.codigo 
LEFT JOIN cliente c ON c.codigo = f.Cliente_codigo 
LEFT JOIN usuario n ON n.identificacion = f.Usuario_identificacion";

if (!empty($filtros)) {
  $consulta_total .= " WHERE " . implode(" AND ", $filtros);
}

$resultado_total = mysqli_query($conexion, $consulta_total);
$total_filas = mysqli_fetch_assoc($resultado_total)['total'];
$total_paginas = ceil($total_filas / $registros_por_pagina);

// Consulta principal con paginación
$consulta = "SELECT f.codigo, f.fecha, f.total, f.descuento, f.subtotal, 
             c.nombre AS nombre_cliente, c.apellido AS apellido_cliente, 
             n.nombre AS nombre_usuario 
             FROM factura f 
             LEFT JOIN factura_metodo_pago m ON m.Factura_codigo = f.codigo 
             LEFT JOIN cliente c ON c.codigo = f.Cliente_codigo 
             LEFT JOIN usuario n ON n.identificacion = f.Usuario_identificacion";

if (!empty($filtros)) {
  $consulta .= " WHERE " . implode(" AND ", $filtros);
}

$consulta .= " GROUP BY f.codigo, f.fecha, f.total, f.descuento, f.subtotal, 
                      c.nombre, c.apellido, n.nombre 
               LIMIT $registros_por_pagina OFFSET $offset";

$resultado = mysqli_query($conexion, $consulta);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Listado de Facturas</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 8px 12px;
      border: 1px solid #ddd;
    }

    th {
      background-color: #f4f4f4;
    }

    .pagination {
      margin-top: 20px;
      text-align: center;
    }

    .pagination a {
      margin: 0 5px;
      padding: 6px 12px;
      border: 1px solid #ccc;
      text-decoration: none;
      border-radius: 5px;
      color: #333;
    }

    .pagination a.active {
      background-color: #007bff;
      color: white;
      pointer-events: none;
    }

    .pagination a:hover:not(.active) {
      background-color: #ddd;
    }
  </style>
</head>
<body>

<h2>Listado de Facturas</h2>

<table>
  <thead>
    <tr>
      <th>Código</th>
      <th>Fecha</th>
      <th>Cliente</th>
      <th>Usuario</th>
      <th>Subtotal</th>
      <th>Descuento</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php if (mysqli_num_rows($resultado) > 0): ?>
      <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
        <tr>
          <td><?= $fila['codigo'] ?></td>
          <td><?= $fila['fecha'] ?></td>
          <td><?= $fila['nombre_cliente'] . ' ' . $fila['apellido_cliente'] ?></td>
          <td><?= $fila['nombre_usuario'] ?></td>
          <td><?= $fila['subtotal'] ?></td>
          <td><?= $fila['descuento'] ?></td>
          <td><?= $fila['total'] ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr>
        <td colspan="7" style="text-align:center;">No se encontraron resultados.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>

<?php if ($total_paginas > 1): ?>
  <div class="pagination">
    <?php
    for ($i = 1; $i <= $total_paginas; $i++):
      $query_params = $_GET;
      $query_params['pagina'] = $i;
      $url = '?' . http_build_query($query_params);
    ?>
      <a href="<?= $url ?>" class="<?= $i == $pagina_actual ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
  </div>
<?php endif; ?>

</body>
</html>
