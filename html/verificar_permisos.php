<?php
/**
 * Verificador de Permisos
 * 
 * Este script verifica si el usuario actual tiene permisos para acceder a la página solicitada.
 * Se debe incluir al inicio de cada página que requiera control de acceso.
 */

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirigir si no está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /index.php?error=no_sesion");
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "inventariomotoracer");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener la página actual
$pagina_actual = basename($_SERVER['PHP_SELF']);

// Mapeo de páginas a secciones y subsecciones
$mapeo_permisos = [
    'crearproducto.php' => ['seccion' => 'PRODUCTO', 'subseccion' => 'Crear Producto'],
    'actualizarproducto.php' => ['seccion' => 'PRODUCTO', 'subseccion' => 'Actualizar Producto'],
    'categorias.php' => ['seccion' => 'PRODUCTO', 'subseccion' => 'Categorias'],
    'ubicacion.php' => ['seccion' => 'PRODUCTO', 'subseccion' => 'Ubicación'],
    'marca.php' => ['seccion' => 'PRODUCTO', 'subseccion' => 'Marca'],
    'crearproveedor.php' => ['seccion' => 'PROVEEDOR', 'subseccion' => 'Crear Proveedor'],
    'actualizarproveedor.php' => ['seccion' => 'PROVEEDOR', 'subseccion' => 'Actualizar Proveedor'],
    'listaproveedor.php' => ['seccion' => 'PROVEEDOR', 'subseccion' => 'Lista Proveedor'],
    'inventario.php' => ['seccion' => 'INVENTARIO', 'subseccion' => 'Lista Productos'],
    'ventas.php' => ['seccion' => 'FACTURA', 'subseccion' => 'Realizar Venta'],
    'reportes.php' => ['seccion' => 'FACTURA', 'subseccion' => 'Ver Reportes'],
    'información.php' => ['seccion' => 'USUARIO', 'subseccion' => 'Información'],
    'stock.php' => ['seccion' => 'CONFIGURACIÓN', 'subseccion' => 'Stock'],
    'gestiondeusuarios.php' => ['seccion' => 'CONFIGURACIÓN', 'subseccion' => 'Gestión de Usuarios'], 
    // Agrega más páginas según sea necesario
];

// Obtener sección y subsección actual
$seccion_actual = $mapeo_permisos[$pagina_actual]['seccion'] ?? null;
$subseccion_actual = $mapeo_permisos[$pagina_actual]['subseccion'] ?? null;

// Si la página no está en el mapeo, permitir acceso (o denegar según tu política)
if ($seccion_actual === null) {
    //header("Location: /acceso_denegado.php?razon=pagina_no_registrada");
    //exit();
    // O simplemente continuar si quieres permitir páginas no mapeadas
}

// Consultar permisos en la base de datos
$query = "SELECT permitido FROM accesos 
          WHERE id_usuario = ? AND seccion = ? AND sub_seccion = ?";
$stmt = $conexion->prepare($query);

if ($stmt === false) {
    die("Error en la consulta: " . $conexion->error);
}

$stmt->bind_param("sss", $_SESSION['usuario_id'], $seccion_actual, $subseccion_actual);
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar si tiene permiso
if ($resultado->num_rows === 0) {
    // No existe registro de permiso
    header("Location: ../html/acceso_denegado.php?razon=sin_permiso");
    exit();
}

$permiso = $resultado->fetch_assoc();

if ($permiso['permitido'] != 1) {
    // Permiso denegado en la base de datos
    header("Location: ../html/acceso_denegado.php?razon=permiso_denegado");
    exit();
}

// Cerrar conexiones
$stmt->close();
$conexion->close();

// Si llegó hasta aquí, tiene permiso y puede continuar cargando la página
?>