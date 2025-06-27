
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
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* Busca esta regla en tu CSS */
body {
  font-family: "Metal Mania", system-ui;
  background-image: url("/imagenes/fondo.webp");
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-attachment: fixed;
  
  /* CAMBIO FINAL: Sé específico para ocultar AMBOS scrolls no deseados */
  overflow-y: hidden; /* Oculta el scroll vertical principal */
  overflow-x: none ; /* Oculta el scroll horizontal principal */
}
/* --- ESTRUCTURA DEL SIDEBAR CON FLEXBOX --- */
.sidebar {
  position: fixed;
  z-index: 1001;
  top: 0;
  left: 0;
  width: 108px;
  height: 100%;
  background: linear-gradient(180deg, #1167cc, #083972, #000000);
  transition: width 0.3s ease;
  
  /* CAMBIO CLAVE: Convertimos en contenedor flexible vertical */
  display: flex;
  flex-direction: column;

  /* ELIMINADO: La propiedad overflow ya no va aquí */
  /* overflow: hidden; */
  /* overflow-y: auto; */
}

.sidebar:hover {
  width: 315px;
}

.sidebar:hover .logo {
  transform: scale(2);
  transition: 1s;
  margin-top: 20px;
  margin-left: 80px;
}

.sidebar:hover .sidebar-header i {
  transform: scale(3);
  transition: 1s;
  margin-left: 50px;
}

.sidebar-header {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  padding: 20px;
  color: rgb(255, 255, 255);
  /* CAMBIO CLAVE: Evita que el header se encoja */
  flex-shrink: 0;
}

/* --- SECCIÓN DEL MENÚ (AHORA CONTIENE EL SCROLL) --- */
.menu {
  list-style-type: none;
  padding: 20px;
  text-shadow: -1px -1px 0 #000000, 1px -1px 0 #000, -1px 1px 0 #000,
    3px 3px 0 #000;
  
  /* CAMBIO CLAVE: Ocupa el espacio sobrante y permite el scroll interno */
  flex-grow: 1;
  overflow-y: auto;
}

/* --- NUEVA REGLA: Estilo del scrollbar aplicado solo al menú --- */
.menu::-webkit-scrollbar {
  width: 5px;
}

.menu::-webkit-scrollbar-thumb {
  background-color: rgba(0, 0, 0, 0.932);
  border-radius: 4px;
}

.menu::-webkit-scrollbar-track {
  background: transparent; /* Fondo transparente para mejor integración */
}


/* --- Dropdowns --- */
.dropdown {
  list-style-type: none;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.5s ease;
}

.dropdown:hover {
  color: rgb(255, 255, 255);
}

.dropdown.open {
  max-height: 500px;
  transition: max-height 1s ease;
}


/* --- Estilos de los items del menú --- */
.menu li a {
  display: flex;
  align-items: center;
  text-decoration: none;
  font-size: 22px;
  padding: 10px;
  color: rgb(200, 200, 200);
  transition: background 0.3s ease, transform 0.3s ease;
  cursor: pointer;
}

.menu li a:hover {
  color: white;
  background-color: #3f6fb6;
  max-width: 400px;
  transform: translateX(10px);
  border-radius: 10px;
}

.menu li a span {
  display: none;
  color: white;
}

.sidebar:hover .menu li a span {
  display: inline-block;
  font-size: 26px;
}

.logo {
  width: 80px;
  height: auto;
  margin-right: 10px;
  cursor: pointer;
  filter: drop-shadow(0px 0px 9px #ffffff);
}

.menu li {
  margin: 35px 0;
  position: relative;
}

.menu li a i {
  margin-right: 10px;
  font-size: 45px;
  color: white;
}

.icon2 {
  margin-left: 13px;
}


/* --- El resto de tus estilos se mantienen intactos --- */

.inicio-img-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: calc(80vh - 50px);
  margin-left: 150px;
}
.inicio-img { max-width: 45%; height: 426px; }
.fondo { height: 100vh; width: 100%; position: absolute; z-index: -2; background-color: #0b111a89; }
.icon { color: #fdfcfc; transition: color 0.3s; }
.bx-tada { animation-duration: 5s; }
.sidebar-expanded .main { margin-left: 290px; transition: margin-left 0.3s ease; }
.main { margin-left: 108px; transition: margin-left 0.3s ease; }
.barra-navegacion { position: fixed; top: 0; left: 5%; width: 95%; display: flex; justify-content: space-between; align-items: center; background: linear-gradient( 90deg, #1167cc, #083972, #000000 ); padding: 8px 2%; box-sizing: border-box; z-index: 1000; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
.ubica { padding: 0; text-shadow: 1px 1px 0 #0000003d; font-family: Arial, Helvetica, sans-serif; font-size: 18px; color: white; }
.ubica a { color: white; text-decoration: none; padding: 10px 8px; border-radius: 8px; transition: background-color 0.3s ease; }
.ubica a:hover { background-color: rgba( 255, 255, 255, 0.2 ); }
.userContainer { display: flex; align-items: center; gap: 12px; }
.userInfo { display: flex; flex-direction: column; align-items: flex-start; text-align: left; font-family: Arial, sans-serif; line-height: 1.2; }
.userInfo p { margin: 0; padding: 0; color: white; text-shadow: 1px 1px 0 #0000003d; }
.userInfo .nombre { font-size: 16px; font-weight: bold; }
.userInfo .rol { font-size: 15px; opacity: 0.9; }
.profilePic { position: static; width: 35px; height: 35px; border-radius: 50%; overflow: hidden; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); background-color: #0b111a89; flex-shrink: 0; border: 1px solid white; }
.profilePic img { width: 100%; height: 100%; object-fit: cover; }
.menu li.active-section > a { color: #fff; }
.menu li .dropdown a.active-sub { font-weight: bold; text-decoration: underline; }

/* --- TUS MEDIA QUERIES NO SE HAN TOCADO Y SEGUIRÁN FUNCIONANDO --- */
@media only screen and (max-width: 870px) and (orientation: landscape) {
  /* ... tu código para móvil horizontal ... */
  .inicio-img { max-width: none; width: 35%; height: auto; margin-top: 10%; margin-right: 15%; }
  h2 { font-size: 30px; margin-top: 0; margin-right: 10%; }
  .accesibilidad-container { margin-top: 5%; }
  .sidebar { display: flex; flex-direction: row; align-items: center; width: 100%; height: 60px; overflow: visible; overflow-x: none; }
  .sidebar-header { width: 6rem; height: 4.4rem; }
  animated-icons div { font-size: 5px; }
  .sidebar:hover .logo { transform: none; transition: none; margin-top: 0; margin-left: 0; }
  .sidebar:hover .menu li a span { display: inline-block; font-size: 0px; }
  .sidebar:hover { width: 100%; }
  .menu { display: flex; flex-direction: row; gap: 20px; padding: 0 10px; }
  .menu li { margin: 0; }
  .menu li a { padding: 8px 12px; color: white; font-size: 1.2em; }
  .dropdown { position: absolute; top: 100%; left: 0; background: #083972; }
  .menu li a i { display: none; }
  .noti { margin-top: 50px; margin-right: 10px; }
  .notificaciones { right: 60px; }
  .accesibilidad-container { margin-right: 10px; }
}

@media screen and (max-width: 767px) and (orientation: portrait) {
  /* ... tu código para móvil vertical ... */
  .inicio-img { max-width: none; width: 110%; height: auto; }
  h2 { font-size: 40px; margin-bottom: 10px; }
  .fondo { height: 105%; width: 105%; }
  .sidebar { width: 80px; }
  .sidebar-header { padding: 5px; }
  .menu { padding: 5px; }
   .barra-navegacion {
    position: fixed;
    top: 0;
    width: calc(100% - 90px);
    left: 50px;
    height: auto;
    flex-direction: column;
    gap: 0.5rem;
    padding: 0.5rem;
    text-align: center;
    background: #083972;
    z-index: 100;
  
  }
  /* --- 4. NUEVO AJUSTE: Reducir letra de la barra de navegación --- */
  .barra-navegacion .ubica {
    font-size: 16px; /* Tamaño más pequeño para la ruta (ej. Configuración / ...) */
    margin-left: 10%;
    word-break: break-word; /* Permite que el texto se parta si es muy largo */
  }

  .barra-navegacion .userInfo .nombre {
    font-size: 14px; /* Un tamaño legible para el nombre */
  }

  .barra-navegacion .userInfo .rol {
    font-size: 12px; /* Un tamaño más pequeño para el rol */
  }
}
  </style>
</head>

<body>
<nav class="barra-navegacion">
  
  <button class="hamburger-button" aria-label="Abrir menú">☰</button>
  
  <div class="ubica"> ... </div>
  <div class="userContainer"> ... </div>
</nav>
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
<script>
  document.addEventListener('DOMContentLoaded', function() {
  
  // Seleccionamos los elementos necesarios
  const hamburgerButton = document.querySelector('.hamburger-button');
  const sidebar = document.getElementById('sidebar'); // Usamos el ID que ya tienes
  const body = document.body;

  // Si el botón y el sidebar existen en la página...
  if (hamburgerButton && sidebar) {
    
    // ...cuando se haga clic en el botón...
    hamburgerButton.addEventListener('click', function(event) {
      event.stopPropagation(); // Evita que otros clics se disparen
      // ...activamos o desactivamos las clases.
      sidebar.classList.toggle('is-active');
      body.classList.toggle('sidebar-open');
    });

    // Este código cierra el menú si haces clic fuera de él (en el fondo oscuro)
    body.addEventListener('click', function(event) {
      if (body.classList.contains('sidebar-open')) {
        // Si el clic NO fue en el sidebar...
        if (!sidebar.contains(event.target)) {
          sidebar.classList.remove('is-active');
          body.classList.remove('sidebar-open');
        }
      }
    });
  }
});
</script>
</body>

</html>