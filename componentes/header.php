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
    'PRODUCTO' => ['Crear Producto', 'Actualizar Producto', 'Categorias', 'Ubicacion', 'Marca'],
    'PROVEEDOR' => ['Crear Proveedor', 'Actualizar Proveedor', 'Lista Proveedor'],
    'INVENTARIO' => ['Lista productos'],
    'FACTURA' => ['Ventas', 'Reportes'],
    'USUARIO' => ['Información'],
    'CONFIGURACION' => ['Stock', 'Gestion de Usuarios']
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/logo.webp">
  <script src="../js/header.js"></script>
  <script src="../js/index.js"></script>
  <link
    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="/componentes/header.css" />
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
      <a href="../html/inicio.php"
        ><img src="../imagenes/LOGO.png" alt="Logo" class="logo"
      /></a>
    </div>
    
    <ul class="menu">
  <?php 
  // Definir un array con los iconos específicos para cada sección
  $iconos = [
      "PRODUCTO" => "bx bx-package bx-tada icon",
      "PROVEEDOR" => "bx bxs-truck bx-tada icon",
      "INVENTARIO" => "bx bx-task bx-tada icon",
      "FACTURA" => "bx bx-file bx-tada icon",
      "USUARIO" => "bx bx-user-circle bx-tada icon",
      "CONFIGURACION" => "bx bxs-cog bx-tada icon"
  ];

  foreach ($permisos as $seccion => $subsecciones): 
    // Usar un icono por defecto si la sección no tiene un icono definido
    $icono = isset($iconos[$seccion]) ? $iconos[$seccion] : "bx bx-folder";
  ?>
    <li>
      <a href="#" onclick="toggleDropdown('dropdown<?php echo $seccion; ?>')">
        <i class="<?php echo $icono; ?> bx-tada icon"></i>
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
      <i class="bx bx-log-out-circle bx-tada icon"></i>
      <span>Salir</span>
    </a>
  </li>
</ul>

  </div>
</body>

</html>
