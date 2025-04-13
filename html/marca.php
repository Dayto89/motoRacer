<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '../html/verificar_permisos.php';

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
  die("<script>alert('No se pudo conectar a la base de datos');</script>");
}

// Agregar categoría
if ($_POST && isset($_POST['guardar'])) {
  if (!$conexion) {
    die("<script>alert('No se pudo conectar a la base de datos');</script>");
  };
  $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);
  $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
  
  $query = "INSERT INTO marca (codigo, nombre) VALUES ('$codigo', '$nombre')";
  
  $resultado = mysqli_query($conexion, $query);
  
  if ($resultado) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: '<span class=\"titulo-alerta confirmacion\">Éxito</span>',
            html: `
                <div class=\"custom-alert\">
                    <div class=\"contenedor-imagen\">
                        <img src=\"../imagenes/moto.png\" alt=\"Confirmación\" class=\"moto\">
                    </div>
                    <p>Marca agregada correctamente.</p>
                </div>
            `,
            background: '#ffffffdb',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#007bff',
            customClass: {
                popup: 'swal2-border-radius',
                confirmButton: 'btn-aceptar',
                container: 'fondo-oscuro'
            }
        });
    });
</script>";
  } else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

$error = mysqli_error($conexion); // Captura el error fuera del script JS

echo "<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: '<span class=\"titulo-alerta error\">Error</span>',
        html: `
            <div class=\"custom-alert\">
                <div class=\"contenedor-imagen\">
                    <img src=\"../imagenes/llave.png\" alt=\"Error\" class=\"llave\">
                </div>
                <p>La marca no fue agregada.<br><small>$error</small></p>
            </div>
        `,
        background: '#ffffffdb',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#007bff',
        customClass: {
            popup: 'swal2-border-radius',
            confirmButton: 'btn-aceptar',
            container: 'fondo-oscuro'
        }
    });
});
</script>";
  }
}
// Eliminar marca mediante boton
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
  $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);
  
  $query = "DELETE FROM marca WHERE codigo = '$codigo'";
  $resultado = mysqli_query($conexion, $query);
  
  // Responder solo con JSON
  echo json_encode(["success" => $resultado]);
  exit();
}


// Obtener lista de productos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lista'])) {
  $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);
  
  $query = "SELECT * FROM producto WHERE Marca_codigo = '$codigo'";
  $resultado = mysqli_query($conexion, $query);
  
  $productos = [];
  while ($fila = mysqli_fetch_assoc($resultado)) {
    $productos[] = $fila;
  }
  
  echo json_encode($productos);
  exit();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Marca</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="/css/marca.css">
  <link rel="stylesheet" href="../componentes/header.css">
  <link rel="stylesheet" href="../componentes/header.php">
  <script defer src="../js/index.js"></script> <!-- Cargar el JS de manera correcta -->
  <script src="../js/header.js"></script>
  <script src="../js/marcas.js"></script>
</head>
<body>
  <div id="menu"></div>
  <div id="categorias" class="form-section">
    <h1>Marca</h1>
    <div class="container">
      <div class="actions">
        <button id="btnAbrirModal" class="btn-nueva-categoria"><i class='bx bx-plus bx-tada'></i>Nueva marca</button>
      </div>
      <h3>Lista de Marcas</h3>
      <table class="category-table">
        <tbody id="tabla-marcas">
          <?php
          $marcas = $conexion->query("SELECT * FROM Marca ORDER BY codigo ASC");
          while ($fila = $marcas->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($fila['codigo']) . "</td>";
              echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
              echo "<td class='td-options'>";
              echo "<button class='btn-list' data-id='" . htmlspecialchars($fila['codigo']) . "'>Lista de productos</button>";
              echo "<button class='btn-delete' data-id='" . htmlspecialchars($fila['codigo']) . "'><i class='fa-solid fa-trash'></i></button></td>";
              echo "</td>";
              echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal -->
  <div id="modal" class="modal">
    <div class="modal-content">
      <h2>Nueva marca</h2>
      <form  method="POST" action="">
        <div class="form-group">
          <label>Ingrese el código:</label>
          <input type="text" id="codigo" name="codigo" required />
          <label>Ingrese el nombre de la marca:</label>
          <input type="text" id="nombre" name="nombre" required />
        </div>
        <div class="modal-buttons">
          <button type="button" id="btnCancelar">Cancelar</button>
          <button type="submit" name="guardar" id="btnGuardar">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
