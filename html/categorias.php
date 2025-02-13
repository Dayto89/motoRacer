<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categorias</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="/css/categorias.css">
  <link rel="stylesheet" href="/componentes/header.html">
  <link rel="stylesheet" href="/componentes/header.css">
  <link
    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
    rel="stylesheet" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
  </style>
</head>

<body>
  <!-- Aquí se cargará el header -->
  <div id="menu"></div>

  <div id="categorias" class="form-section">
    <h1>Categorías</h1>

    <!-- Contenedor principal -->
    <div class="container">
      <!-- Botón para agregar nueva categoría -->
      <div class="actions">

        <button id="btnAbrirModal" class="btn-nueva-categoria"><i class='bx bx-plus bx-tada'></i>Nueva categoría</button>
      </div>
      <h3>Lista de categorías</h3>

      <!-- Tabla de categorías -->
      <table class="category-table">
       
          <!-- Traer datos de la base de datos y mostrarlos en la tabla -->
           <?php
           $conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');

           if (!$conexion) {
               die("No se pudo conectar a la base de datos");
           };

           $categorias = $conexion->query("SELECT * FROM categoria ORDER BY codigo ASC");

           while ($fila = $categorias->fetch_assoc()) {
               echo "<tr>";
               echo "<td>" . $fila['codigo'] . "</td>";
               echo "<td>" . $fila['nombre'] . "</td>";
               echo "<td class='options'>";
               echo "<button class='btn-list'>Lista de productos</button>";
               echo "<button class='btn-delete' onclick='deleteCategoria(" . $fila['codigo'] . ")'>Eliminar</button>";
               echo "</td>";
               echo "</tr>";
           }
           ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php
    //Eliminar categoría de la base de datos con el boton eliminar submit sin formulario
    if ($_POST) {
      if (!$conexion) {
        die("<script>alert('No se pudo conectar a la base de datos');</script>");
      };
      $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);
      $query = "DELETE FROM categoria WHERE codigo = '$codigo'";
      $resultado = mysqli_query($conexion, $query);
      if ($resultado) {
        echo "<script>console.log('Categoría eliminada correctamente');</script>";
      } else {
        echo "<script>console.log('Error al eliminar la categoría: " . mysqli_error($conexion) . "');</script>";
      }
    }
  ?>

  <!-- Modal -->
  <div id="modal" class="modal">
    <div class="modal-content">
      <h2>Nueva categoría</h2>
      <form id="formCategoria" method="POST" action="">
        <div class="form-group">
          <label>Ingrese el código:</label>
          <input type="text" id="codigo" name="codigo" required />
          <label>Ingrese el nombre de la categoría:</label>
          <input type="text" id="nombre" name="nombre" required />

        </div>
        <div class="modal-buttons">
          <button type="button" id="btnCancelar">Cancelar</button>
          <button type="submit">Guardar</button>
        </div>
      </form>
    </div>
  </div>

  <script src="../js/index.js"></script>

  <?php
  $conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
  if (!$conexion) {
      die("<script>alert('No se pudo conectar a la base de datos');</script>");
  }
  
    if ($_POST) {
      if (!$conexion) {
        die("<script>alert('No se pudo conectar a la base de datos');</script>");
      };
      $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);
      $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
      
      $query = "INSERT INTO categoria (codigo, nombre) VALUES ('$codigo', '$nombre')";
      
      $resultado = mysqli_query($conexion, $query);

      if ($resultado) {
        echo "<script>console.log('Categoría agregada correctamente');</script>";
      } else {
        echo "<script>console.log('Error al agregar la categoría: " . mysqli_error($conexion) . "');</script>";
      }
    }
  ?>
  <script>
    function deleteCategoria(codigo) {
      var respuesta = confirm("¿Está seguro de que desea eliminar la categoría?");
      if (respuesta) {
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open("GET", "deleteCategoria.php?codigo=" + codigo, true);
        xmlHttp.send();
      }
    }

  </script>
</body>

</html>
