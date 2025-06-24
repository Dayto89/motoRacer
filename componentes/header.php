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

$permisosRutas = [
  'PRODUCTO' => ['crearproducto', 'categorias', 'ubicacion', 'marca'],
  'PROVEEDOR' => ['listaproveedor'],
  'INVENTARIO' => ['listaproductos'],
  'FACTURA' => ['ventas', 'reportes', 'listaclientes', 'listanotificaciones', 'pagos', 'recibo'],
  'USUARIO' => ['información'],
  'CONFIGURACION' => ['gestiondeusuarios', 'copiadeseguridad', 'registro'],
  'INICIO' => ['']
];

// Si el usuario es administrador, mostrar todas las secciones
if ($rol === 'administrador') {
  $permisos = [
    'PRODUCTO' => ['Crear Producto', 'Categorias', 'Ubicacion', 'Marca'],
    'PROVEEDOR' => ['Lista Proveedor'],
    'INVENTARIO' => ['Lista productos'],
    'FACTURA' => ['Ventas', 'Reportes', 'Lista Clientes', 'Lista Notificaciones'],
    'USUARIO' => ['Información'],
    'CONFIGURACION' => ['Gestion de Usuarios', 'Copia de Seguridad']
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

// Mapeo sección → nombre de archivo GIF en /imagenes/icons/
$iconGifs = [
  'PRODUCTO'      => 'product.gif',
  'PROVEEDOR'     => 'warehouse.gif',
  'INVENTARIO'    => 'research.gif',
  'FACTURA'       => 'factura.gif',
  'USUARIO'       => 'user.gif',
  'CONFIGURACION' => 'setup.gif',
  // Logout
  'SALIR'         => 'exit.gif',
];



// 1) Generar mapa slug → sección/subsección
$breadcrumbMap = [];
foreach ($permisosRutas as $sec => $subs) {
  foreach ($subs as $sub) {
    $slug = strtolower(str_replace(' ', '', $sub));
    $breadcrumbMap[$slug] = [
      'section'    => $sec,
      'subsection' => $sub
    ];
  }
}

// ——————————————————————————————
// 2) Detectar página actual (sin .php)
if (!empty($_GET['page'])) {
  $currentPage = preg_replace('/[^a-z0-9]/', '', strtolower($_GET['page']));
} else {
  $currentPage = basename($_SERVER['SCRIPT_NAME'], '.php');
}

if (isset($breadcrumbMap[$currentPage])) {
  // Coincidencia en permisos
  $activeSection    = $breadcrumbMap[$currentPage]['section'];
  $activeSubSection = $breadcrumbMap[$currentPage]['subsection'];
} elseif ($currentPage === 'inicio') {
  // Home
  $activeSection    = '';
  $activeSubSection = 'Inicio';
} elseif ($currentPage === 'acceso_denegado') {
  // Acceso denegado
  $activeSection    = '';
  $activeSubSection = 'Acceso denegado';
} elseif ($currentPage === 'informacin') {
  // Información del usuario
  $activeSection    = 'USUARIO';
  $activeSubSection = 'Información';
} else {
  // No coincide con nada: no mostramos breadcrumb
  $activeSection    = '';
  $activeSubSection = '';
}

// Colores para cada sección
$sectionColors = [
  'PRODUCTO'      => '',
  'PROVEEDOR'     => '',
  'INVENTARIO'    => '',
  'FACTURA'       => '',
  'USUARIO'       => '',
  'CONFIGURACION' => '',
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

   .ubica {
    position: fixed;
    top: 1px;
    left: 7%;
    background-color: rgb(15 92 183 / 62%);
    border: 1px solid #ffffff;
    text-shadow: 1px 1px 0 #1c51a0, 1px 1px 0 #1c51a0, 1px 1px 0 #1c51a0, 2px 0px 0 #1c51a0;
    font-family: Arial, Helvetica, sans-serif;
    padding: 10px 8px;
    border-radius: 10px;
    font-size: 18px;
    color: white;
    z-index: 5;
    margin-left: 1%;
    transition: margin-left 0.3s ease;
    height: 4.5%;
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
        $isActive = ($seccion === $activeSection);
        $iconStyle = $isActive
          ? "background-color: {$sectionColors[$seccion]}; border-radius:8px;"
          : "";
        $gifFile = $iconGifs[$seccion] ?? 'default.gif';
        $gifPath = "../imagenes/icons/" . $gifFile;
      ?>
        <li>
          <a id="icon-<?= $seccion ?>"
            href="#"
            onclick="toggleDropdown('dropdown<?= $seccion ?>','icon-<?= $seccion ?>')"
            style="<?= $iconStyle ?>">
            <img src="<?= $gifPath ?>"
              alt="<?= strtolower($seccion) ?> icon"
              style="<?= $iconStyle ?>"
              height="54"
              width="54">
            <span><?= $seccion ?></span>
            <i class="bx bx-chevron-down icon2"></i>
          </a>

          <!-- ← Aquí va el bloque que falta: -->
          <ul id="dropdown<?= $seccion ?>" class="dropdown">
            <?php foreach ($subsecciones as $sub): ?>
              <li>
                <a href="../html/<?= strtolower(str_replace(' ', '', $sub)) ?>.php">
                  <?= $sub ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </li>
      <?php endforeach; ?>

      <!-- Botón Salir -->
      <?php $gifSalir = "../imagenes/icons/" . $iconGifs['SALIR']; ?>
      <li>
        <a href="../componentes/logout.php">
          <img src="<?php echo $gifSalir; ?>"
            alt="salir icon"
            style="<?php echo $iconStyle; ?>"
            height="52"
            width="52">
          <span>Salir</span>
        </a>
      </li>

    </ul>
  </div>

</body>

</html>