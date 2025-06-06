<?php
// reportes_ajax.php
header('Content-Type: application/json; charset=UTF-8');
session_start();
if (!isset($_SESSION['usuario_id'])) {
  echo json_encode(['error' => 'No autorizado']);
  exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '../html/verificar_permisos.php';

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
  echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
  exit;
}

// 1) Recibir parámetros: búsqueda, criterios[], fecha_desde, fecha_hasta
$busqueda = isset($_GET['busqueda']) ? mysqli_real_escape_string($conexion, $_GET['busqueda']) : '';
$criterios = isset($_GET['criterios']) && is_array($_GET['criterios']) ? $_GET['criterios'] : [];
$fecha_desde = isset($_GET['fecha_desde']) ? mysqli_real_escape_string($conexion, $_GET['fecha_desde']) : '';
$fecha_hasta = isset($_GET['fecha_hasta']) ? mysqli_real_escape_string($conexion, $_GET['fecha_hasta']) : '';

$filtros = [];

// Filtro por rango de fechas
if (!empty($fecha_desde) && !empty($fecha_hasta)) {
  $fd = $fecha_desde . ' 00:00:00';
  $fh = $fecha_hasta . ' 23:59:59';
  $filtros[] = "f.fechaGeneracion BETWEEN '$fd' AND '$fh'";
}

// Filtro por texto de búsqueda
if ($busqueda !== '') {
  $condiciones = [];
  if (!empty($criterios)) {
    foreach ($criterios as $c) {
      $c = mysqli_real_escape_string($conexion, $c);
      switch ($c) {
        case 'codigo':
          $condiciones[] = "f.codigo = '$busqueda'";
          break;
        case 'fechaGeneracion':
          $condiciones[] = "f.fechaGeneracion LIKE '%$busqueda%'";
          break;
        case 'metodoPago':
          $condiciones[] = "EXISTS (
                              SELECT 1 
                                FROM factura_metodo_pago tmp 
                               WHERE tmp.Factura_codigo = f.codigo 
                                 AND tmp.metodoPago = '$busqueda'
                            )";
          break;
        case 'cliente':
          $condiciones[] = "(f.nombreCliente LIKE '%$busqueda%' OR f.apellidoCliente LIKE '%$busqueda%')";
          break;
        case 'vendedor':
          $condiciones[] = "(f.nombreUsuario LIKE '%$busqueda%' OR f.apellidoUsuario LIKE '%$busqueda%')";
          break;
        case 'precioTotal':
          $condiciones[] = "f.precioTotal = '$busqueda'";
          break;
      }
    }
    $filtros[] = '(' . implode(' OR ', $condiciones) . ')';
  } else {
    // búsqueda global si no hay criterios
    $global = [
      "f.codigo = '$busqueda'",
      "f.precioTotal = '$busqueda'",
      "(f.nombreCliente LIKE '%$busqueda%' OR f.apellidoCliente LIKE '%$busqueda%')",
      "(f.nombreUsuario LIKE '%$busqueda%' OR f.apellidoUsuario LIKE '%$busqueda%')",
      "EXISTS (
         SELECT 1 
           FROM factura_metodo_pago tmp 
          WHERE tmp.Factura_codigo = f.codigo 
            AND tmp.metodoPago = '$busqueda'
        )"
    ];
    $filtros[] = '(' . implode(' OR ', $global) . ')';
  }
}

// 2) Armamos la consulta sin LIMIT ni OFFSET
$sql = "
  SELECT 
    f.codigo,
    f.fechaGeneracion,
    f.nombreUsuario,
    f.apellidoUsuario,
    f.nombreCliente,
    f.apellidoCliente,
    f.telefonoCliente,
    f.identificacionCliente,
    f.precioTotal,
    GROUP_CONCAT(DISTINCT m.metodoPago SEPARATOR ', ') AS metodoPago
  FROM factura f
  LEFT JOIN factura_metodo_pago m ON m.Factura_codigo = f.codigo
";

if (!empty($filtros)) {
  $sql .= " WHERE " . implode(' AND ', $filtros);
}

$sql .= "
  GROUP BY 
    f.codigo,
    f.fechaGeneracion,
    f.nombreUsuario,
    f.apellidoUsuario,
    f.nombreCliente,
    f.apellidoCliente,
    f.telefonoCliente,
    f.identificacionCliente,
    f.precioTotal
  ORDER BY f.fechaGeneracion DESC
";

$result = mysqli_query($conexion, $sql);
if (!$result) {
  echo json_encode(['error' => 'Error en la consulta: '. mysqli_error($conexion)]);
  exit;
}

// 3) Construimos el array de facturas
$facturas = [];
while ($row = mysqli_fetch_assoc($result)) {
  $facturas[] = [
    'codigo'               => $row['codigo'],
    'fechaGeneracion'      => $row['fechaGeneracion'],
    'vendedor'             => $row['nombreUsuario'] . ' ' . $row['apellidoUsuario'],
    'cliente'              => $row['nombreCliente'] . ' ' . $row['apellidoCliente'],
    'telefonoCliente'      => $row['telefonoCliente'],
    'identificacionCliente'=> $row['identificacionCliente'],
    'precioTotal'          => number_format($row['precioTotal']),
    'metodoPago'           => $row['metodoPago'],
  ];
}

// 4) Devolvemos JSON
echo json_encode(['data' => $facturas]);
exit;
