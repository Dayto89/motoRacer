<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.php");
  exit();
}

require_once $_SERVER['DOCUMENT_ROOT'].'../html/verificar_permisos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/componentes/accesibilidad-widget.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>proveedor</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="../css/actualizarproveedor.css">
  <link rel="stylesheet" href="../css/proveedor.css">
  <link rel="stylesheet" href="../css/alertas.css">
  <link rel="stylesheet" href="/componentes/header.php">
  <link rel="stylesheet" href="/componentes/header.css">
  <script src="../js/header.js"></script>
    <script src="/js/index.js"></script>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
  </style>
</head>

<body>
  <!-- Aquí se cargará el header -->
  <div id="menu"></div>

  <!-- Sección para Crear Proveedor -->
  <div id="crearProveedor" class="form-section">
    <h1>Crear Proveedor</h1>

    <div class="container">

      <form id="proveedor-form" method="POST" action="">
        
         <div class="campo">
          <label for="codigoProveedor">Código:</label>
          <input
            type="text"
            id="codigoProveedor"
            name="codigoProveedor"
            required />
        </div>
        <div class="campo">
          <label for="nombreProveedor">Nombre:</label>
          <input
            type="text"
            id="nombreProveedor"
            name="nombreProveedor"
            required />
        </div>
        <div class="campo">
          <label for="telefonoProveedor">Teléfono:</label>
          <input
            type="text"
            id="telefonoProveedor"
            name="telefonoProveedor"
            required />
        </div>
        <div class="campo">
          <label for="direccionProveedor">Dirección:</label>
          <input
            type="text"
            id="direccionProveedor"
            name="direccionProveedor"
            required />
        </div>
        <div class="campo">
          <label for="correoProveedor">Correo:</label>
          <input
            type="text"
            id="correoProveedor"
            name="correoProveedor"
            required />
        </div>
        <div class="campo">
          <label for="estadoProveedor">Estado:</label>
          <select name="estadoProveedor" id="estadoProveedor" required>

            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
          </select>
        </div>
        <div class="button-container">
          <div class="boton">
            <button type="submit">Guardar</button>
          </div>
        </div>
      
    </form>
  </div>
</div>

  
   
<?php

$mensaje = null;  // Variable para almacenar el estado del mensaje

  if ($_POST) {
    $conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
    if (!$conexion) {
      die("<script>alert('No se pudo conectar a la base de datos');</script>");
    };
    $codigoProveedor = $_POST['codigoProveedor'];
    $nombreProveedor = $_POST['nombreProveedor'];
    $telefonoProveedor = $_POST['telefonoProveedor'];
    $direccionProveedor = $_POST['direccionProveedor'];
    $correoProveedor = $_POST['correoProveedor'];
    $estadoProveedor = $_POST['estadoProveedor'];

    $query = "INSERT INTO proveedor (nit, nombre, telefono, direccion, correo, estado) VALUES ('$codigoProveedor', '$nombreProveedor', '$telefonoProveedor', '$direccionProveedor', '$correoProveedor', '$estadoProveedor')";

    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $mensaje = 'proveedor_agregado';
    } else {
        $mensaje = 'error_al_agregar';
    }
  }
  ?>
<script>
    
   //llamar la variable mensaje y alertas
const mensaje = "<?php echo $mensaje; ?>";

if (mensaje === "proveedor_agregado") {
Swal.fire({
    title: '<span class="titulo-alerta confirmacion">Proveedor agregado</span>',
    html: `
        <div class="custom-alert">
            <div class="contenedor-imagen">
                <img src="../imagenes/moto.png" alt="Confirmacion" class="moto">
            </div>
            <p>Proveedor agregado con éxito.</p>
        </div>
    `,
    background: 'hsl(0deg 0% 100% / 76%)',
    confirmButtonText: 'Aceptar',
    confirmButtonColor: '#007bff',
    customClass: {
        popup: 'swal2-border-radius',
        confirmButton: 'btn-aceptar',
        container: 'fondo-oscuro'
    }
});
} else if (mensaje === "error_al_agregar") {
Swal.fire({
    title: '<span class="titulo-alerta error">Error</span>',
    html: `
        <div class="custom-alert">
            <div class="contenedor-imagen">
                <img src="../imagenes/llave.png" alt="Error" class="llave">
            </div>
            <p>Error al agregar el proveedor.</p>
        </div>
    `,
    background: 'hsl(0deg 0% 100% / 76%)',
    confirmButtonText: 'Aceptar',
    confirmButtonColor: '#007bff',
    customClass: {
        popup: 'swal2-border-radius',
        confirmButton: 'btn-aceptar',
        container: 'fondo-oscuro'
    }
});
} 
</script>

</body>

</html>