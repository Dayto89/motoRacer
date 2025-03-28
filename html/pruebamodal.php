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
  <style>
    /* Reseteo y estilo global */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  
  body {
    font-family: "Metal Mania", system-ui;
    background-image: url('fondoMotoRacer.png'); 
    background-size: cover;
    background-position: center;
    
}
body::before {
    position: fixed;
    width: 200%;
    height: 200%;
    z-index: -1;
    background: black;
    opacity: 0.6;
}
  
  /* Título principal */
  #categorias h1 {
    font-size: 50px;
    margin-top: 92px;
    color: white;
    text-shadow: 7px -1px 0 #1c51a0, 1px -1px 0 #1c51a0, -1px 1px 0 #1c51a0, 3px 5px 0 #1c51a0;
    margin-left: 871px;
    letter-spacing: 5px;
    padding: 18px;
    letter-spacing: 5px;
  }
  
  /* Contenedor principal */
  .container {
    background-color: rgb(174 174 174 / 59%);
    padding: 44px;
    border-radius: 15px;
    max-width: 1079px;
    margin-left: 482px;
  }
  
  /* Botón para agregar categoría */
  .btn-nueva-categoria {
    background-color: #1167CC;
    color: white;
    font-size: 17px;
    font-weight: bold;
    padding: 13px 21px;
    border: none;
    border-radius: 11px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .btn-nueva-categoria:hover {
    background-color: #0056b3;
  }
  h3{
    font-family: Arial, Helvetica, sans-serif;
    color: black;
    background-color: #98bde9;
    padding: 9px;
    width: 193px;
    border-radius: 8px;
    margin-top: 8px;
    font-size: 16px;
  }
  /* Tabla de categorías */
  .category-table {
    width: 100%;
    border-collapse: collapse; 
    
  }
  
  .category-table td {
    padding: 1px;
    text-align: center;
    font-family: Arial, sans-serif;
    width: 225px;
}
  
  .category-table th {
    background-color: #98bde9;
    color: #0b111a;
  }
  
  .category-table tr:nth-child(even) {
    background-color: #f9f9f9b7;
    color: black;
  }
  
  .category-table tr:nth-child(odd) {
    background-color: rgb(33 32 32 / 59%);
    color: white;
  }
  
  .options {
        display: flex;
        gap: 39px;
        margin-left: 260px;
  }
 
  .btn-list, .btn-delete { 
    padding: 8px 15px; /* Reducir el padding para angostar */
    border: none;
    border-radius: 15px;
    color: rgb(255, 255, 255);
    cursor: pointer;
    font-size: 14px; /* Reducir ligeramente el tamaño del texto */
    white-space: nowrap; /* Mantener el texto en una sola línea */
    text-align: center; /* Centrar el texto dentro del botón */
}
  
  .btn-list {
    background-color: #0965c7;
    margin-left: 10px; /* Ajusta el margen entre los botones y el texto si es necesario */
  }
  
  .btn-list:hover {
    background-color: #0056b3; /* Color de fondo al pasar el mouse sobre una fila */
  }
  
  .btn-delete {
    background-color: #fa163c;
  }
  
  .btn-delete:hover {
    background-color: #a71d2a;
  }
  
  

/* Botón de cerrar */
.btn-cerrar {
  display: inline-block;
  text-decoration: none;
  text-align: center;
  background-color: #df2f2f;
  color: white;
  padding: 10px 15px;
  cursor: pointer;
  border-radius: 10px;
  font-weight: bold;
  font-size: 16px;
}

/* Cambio de color al pasar el mouse */
.btn-cerrar:hover {
  background-color: #a71d2a;
}
  
  #btnCancelar {
    background-color: #df2f2f;
    color: white;
    padding: 10px 15px;
    cursor: pointer;
    border: none;
    border-radius: 10px;
    font-weight: bold;
    font-size: 16px;
  }
  
  #btnCancelar:hover {
    background-color: #a71d2a;
  }
  
  button[type="submit"] {
    background-color: #007bff;
    color: white;
    padding: 10px 15px;
    cursor: pointer;
    border: none;
    border-radius: 10px;
    font-weight: bold;
    font-size: 16px;
  }
  
  button[type="submit"]:hover {
    background-color: #0056b3;
  }
  .form-group label{
    font-family: Arial, Helvetica, sans-serif;
    color: black;
    size: 50px;
    font-weight: bold;
  }
  /* Estilo para los inputs del formulario */
input[type="text"] {
  width: 89%;
  padding: 8px;
  font-size: 16px; /* Tamaño del texto */
  border: 1px solid #ccc; /* Borde del input */
  border-radius: 5px; /* Bordes redondeados */
  box-sizing: border-box; /* Asegura que padding no afecte el ancho total */
  margin-top: 26px;
  margin-bottom: 18px;
}


.bx-tada {
  color: #fdfcfc;
  transition: color 0.3s;
}

/* Ocultar el modal por defecto */
.modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

/* Mostrar el modal cuando el ID es referenciado */
:target {
  display: flex;
}

/* Contenido del modal */
.modal-content {
  background-color: rgba(200, 200, 200, 0.76);
  padding: 20px;
  border-radius: 10px;
  width: 400px;
  text-align: center;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  animation: slideIn 0.3s ease-out;
}

/* Animación de aparición */
@keyframes slideIn {
  from {
      transform: translateY(-50px);
      opacity: 0;
  }
  to {
      transform: translateY(0);
      opacity: 1;
  }
}

/* Animación de desaparición */
@keyframes slideOut {
  from {
      transform: translateY(0);
      opacity: 1;
  }
  to {
      transform: translateY(-50px);
      opacity: 0;
  }
}

/* Clase para ocultar con animación */
.modal.hidden .modal-content {
  animation: slideOut 0.3s ease-out;
}

 
.modal-content h2 {

  font-size: 32px;
  margin-top: -7px;
  color: white;
  text-shadow:4px -2px 0 #1c51a0, -3px -1px 0 #1c51a0, -3px 1px 0 #1c51a0, -2px 3px 0 #1c51a0; 
  margin-left: 13px;
  letter-spacing: 5px;
  padding: 28px;
  
}

/* Botones del modal */
.modal-buttons {
  display: flex;
  gap: 34px;
  justify-content: center;
  border-radius: 10px;
  font-weight: bold;
}

  </style>
  <script>
  document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("modal");
    const btnCancelar = document.getElementById("btnCancelar");

    btnCancelar.addEventListener("click", function () {
        modal.classList.add("hidden"); // Agrega la clase para la animación de salida
        
        setTimeout(() => {
            modal.style.display = "none"; // Oculta el modal después de la animación
            modal.classList.remove("hidden"); // Remueve la clase después
        }, 300); // Ajusta el tiempo a la duración de la animación en CSS (300ms)
    });
});

  </script>
</body>
</html>
