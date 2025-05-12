<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.php");
  exit();
}

$conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
if ($conexion->connect_error) {
  die("No se pudo conectar a la base de datos: " . $conexion->connect_error);
}

$id_usuario = $_SESSION['usuario_id'];
// Consultar el rol del usuario
$sqlRol = "SELECT rol FROM usuario WHERE identificacion = ?";
$stmtRol = $conexion->prepare($sqlRol);
$stmtRol->bind_param("i", $id_usuario);
$stmtRol->execute();
$resultRol = $stmtRol->get_result();
$rowRol = $resultRol->fetch_assoc();
$rol = $rowRol['rol'];
$stmtRol->close();

// Si el usuario es administrador, mostrar todas las secciones
if ($rol === 'administrador') {
  $permisos = [
    'PRODUCTO' => ['Crear Producto', 'Categorias', 'Ubicacion', 'Marca'],
    'PROVEEDOR' => ['Crear Proveedor', 'Actualizar Proveedor', 'Lista Proveedor'],
    'INVENTARIO' => ['Lista productos'],
    'FACTURA' => ['Ventas', 'Reportes', 'Lista Clientes', 'Lista Notificaciones'],
    'USUARIO' => ['Información'],
    'CONFIGURACION' => ['Stock', 'Gestion de Usuarios', 'Copia de Seguridad']
  ];
} else {
  // Si no es administrador, consultar los permisos del usuario
  $sqlPermisos = "SELECT seccion, sub_seccion FROM accesos WHERE id_usuario = ? AND permitido = 1";
  $stmtPermisos = $conexion->prepare($sqlPermisos);
  $stmtPermisos->bind_param("i", $id_usuario);
  $stmtPermisos->execute();
  $resultPermisos = $stmtPermisos->get_result();
  $permisos = [];
  while ($row = $resultPermisos->fetch_assoc()) {
    $permisos[$row['seccion']][] = $row['sub_seccion'];
  }
  $stmtPermisos->close();
}

$animatedIcons = [
  'PRODUCTO' => [
    'src' => 'https://animatedicons.co/get-icon?name=Product&style=minimalistic&token=64f0cb11-7ef5-4030-8e65-e6b4975a0256',
    'trigger' => 'loop',
    'attributes' => '{"variationThumbColour":"#4CAF50","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":2.5,"defaultColours":{"group-1":"#FFFFFFFF","group-2":"#FFFFFFFF","background":"#FFFFFF00"}}',
    'size' => 53.5
  ],
  'PROVEEDOR' => [
    'src' => 'https://animatedicons.co/get-icon?name=Warehouse&style=minimalistic&token=cd5fc961-b158-4062-bac4-bc62dc29ca43',
    'trigger' => 'loop',
    'attributes' => '{"variationThumbColour":"#FF9800","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":2.5,"defaultColours":{"group-1":"#FFFFFFFF","group-2":"#FFFFFFFF","background":"#FFFFFF00"}}',
    'size' => 53.5
  ],
  'INVENTARIO' => [
    'src' => 'https://animatedicons.co/get-icon?name=Research&style=minimalistic&token=debf6854-a861-4155-b483-b1a147f1f3ec',
    'trigger' => 'loop',
    'attributes' => '{"variationThumbColour":"#9C27B0","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":2.5,"defaultColours":{"group-1":"#FFFFFFFF","group-2":"#FFFFFFFF","background":"#FFFFFF00"}}',
    'size' => 53.5
  ],
  'FACTURA' => [
    'src' => 'https://animatedicons.co/get-icon?name=Invoice&style=minimalistic&token=89c130bf-0940-48c2-92e3-16b6ffe3b232',
    'trigger' => 'loop',
    'attributes' => '{"variationThumbColour":"#E91E63","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":2.5,"defaultColours":{"group-1":"#FFFFFFFF","group-2":"#FFFFFFFF","background":"#FFFFFF00"}}',
    'size' => 53.5
  ],
  'USUARIO' => [
    'src' => 'https://animatedicons.co/get-icon?name=Individual&style=minimalistic&token=ae97ee7c-56cc-4490-90bd-ecd3fc81466e',
    'trigger' => 'loop',
    'attributes' => '{"variationThumbColour":"#607D8B","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":2.5,"defaultColours":{"group-1":"#FFFFFFFF","group-2":"#FFFFFFFF","background":"#FFFFFF00"}}',
    'size' => 53.5
  ],
  'CONFIGURACION' => [
    'src' => 'https://animatedicons.co/get-icon?name=Setup&style=minimalistic&token=eb758eaf-90cb-43dc-9be6-dcfdc8296167',
    'trigger' => 'loop',
    'attributes' => '{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":2.5,"defaultColours":{"group-1":"#FFFFFFFF","group-2":"#FFFFFFFF","background":"#FFFFFF00"}}',
    'size' => 53.5
  ]
];
 
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/logo.webp">
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="../js/header.js"></script>
  <script src="../js/index.js"></script>
  <link
    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
    rel="stylesheet" />
  <link rel="stylesheet" href="/componentes/header.css" />
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap");

    .menu li a {
      display: flex;
      align-items: center;
    }
  </style>
</head>

<body>
  <div id="sidebar" class="sidebar">
    <div class="sidebar-header">
      <a href="../html/inicio.php"><img src="../imagenes/LOGO.webp" alt="Logo" class="logo" /></a>
    </div>

    <ul class="menu">
      <?php foreach ($permisos as $seccion => $subsecciones):
        $iconData = $animatedIcons[$seccion] ?? null;
      ?>
        <li>
          <a href="#" onclick="toggleDropdown('dropdown<?php echo $seccion; ?>')">
            <?php if ($iconData): ?>
              <animated-icons
                src="<?php echo $iconData['src']; ?>"
                trigger="<?php echo $iconData['trigger']; ?>"
                attributes='<?php echo $iconData['attributes']; ?>'
                height="<?php echo $iconData['size']; ?>"
                width="<?php echo $iconData['size']; ?>"></animated-icons>
            <?php else: ?>
              <i class="bx bx-folder"></i>
            <?php endif; ?>
            <span><?php echo $seccion; ?></span>
            <i class="bx bx-chevron-down icon2"></i>
          </a>
          <ul id="dropdown<?php echo $seccion; ?>" class="dropdown">
            <?php foreach ($subsecciones as $subseccion): ?>
              <li>
                <a href="../html/<?php echo strtolower(str_replace(' ', '', $subseccion)); ?>.php">
                  <?php echo $subseccion; ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </li>
      <?php endforeach; ?>

      <li>
        <a href="../componentes/logout.php">
          <animated-icons
            src="https://animatedicons.co/get-icon?name=exit&style=minimalistic&token=6e09845f-509a-4b0a-a8b0-c47e168ad977"
            trigger="loop"
            attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":2.5,"defaultColours":{"group-1":"#FFFFFFFF","group-2":"#FFFFFFFF","background":"#FFFFFF00"}}'
            height="52"
            width="52"></animated-icons>
          <span>Salir</span>
        </a>
      </li>
    </ul>
  </div>
</body>

</html>