<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

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

  $query = "INSERT INTO categoria (codigo, nombre) VALUES ('$codigo', '$nombre')";

  $resultado = mysqli_query($conexion, $query);

  if ($resultado) {
    echo "<script>alert('Categoría agregada correctamente');</script>";
  } else {
    echo "<script>alert('Error al agregar la categoría: " . mysqli_error($conexion) . "');</script>";
  }
}
// Eliminar categoría mediante boton
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
  $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);
  
  $query = "DELETE FROM categoria WHERE codigo = '$codigo'";
  $resultado = mysqli_query($conexion, $query);
  
  // Responder solo con JSON
  echo json_encode(["success" => $resultado]);
  exit();
}


// Obtener lista de productos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lista'])) {
    $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);
    
    $query = "SELECT * FROM producto WHERE Categoria_codigo = '$codigo'";
    $resultado = mysqli_query($conexion, $query);
    
    $productos = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $productos[] = $fila;
    }
    
    echo json_encode($productos);
    exit();
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categorías</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
  <link rel="stylesheet" href="/css/categorias.css">
  <link rel="stylesheet" href="../componentes/header.css">
  <link rel="stylesheet" href="../componentes/header.php">
  <script src="../js/header.js"></script>
  <script defer src="../js/index.js"></script> <!-- Cargar el JS de manera correcta -->
  <script src="/js/categorias.js"></script>
</head>
<body>
  <div id="menu"></div>
  <div id="categorias" class="form-section">
    <h1>Categorías</h1>
    <div class="container">
      <div class="actions">
        <button id="btnAbrirModal" class="btn-nueva-categoria"><i class='bx bx-plus bx-tada'></i>Nueva categoría</button>
      </div>
      <h3>Lista de categorías</h3>
      <table class="category-table">
        <tbody id="tabla-categorias">
          <?php
          $categorias = $conexion->query("SELECT * FROM categoria ORDER BY codigo ASC");
          while ($fila = $categorias->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($fila['codigo']) . "</td>";
              echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
              echo "<td class='options'>";
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
      <h2>Nueva categoría</h2>
      <form  method="POST" action="">
        <div class="form-group">
          <label>Ingrese el código:</label>
          <input type="text" id="codigo" name="codigo" required />
          <label>Ingrese el nombre de la categoría:</label>
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
