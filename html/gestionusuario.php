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

// Eliminar usuario
if ($_POST && isset($_POST['eliminar'])) {
  $id = $conexion->real_escape_string($_POST['id']);
  $query = "DELETE FROM usuario WHERE identificacion = '$id'";
  $resultado = $conexion->query($query);
  echo json_encode(["success" => $resultado]);
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Usuarios</title>
  <link rel="stylesheet" href="/css/gestionusuario.css">
  <script src="/js/index.js"></script>
</head>

<body>
  <h1>Gestión de Usuarios</h1>
  <div class="container">
    <table class="user-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Rol</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM usuario";
        $result = $conexion->query($sql);
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row['identificacion'] . "</td>";
          echo "<td>" . $row['nombre'] . "</td>";
          echo "<td>" . $row['apellido'] . "</td>";
          echo "<td>" . $row['rol'] . "</td>";

          if ($row['rol'] == 'gerente') {
            echo "<td><button onclick='abrirModal(" . $row['identificacion'] . ")'>Permisos</button></td>";
          } else {
            echo "<td></td>";
          }

          echo "<td><button class='btn-delete' data-id='" . $row['identificacion'] . "'>Eliminar</button></td>";
          echo "</tr>";
        }
        ?>

      </tbody>
    </table>
  </div>

  <button class='btn-registro' onclick="location.href='../html/registro.php'">Registrar nuevo usuario</button>

  <!-- Modal -->
  <div id="modalPermisos" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>
        <h2>Configurar Permisos</h2>
        <form id="formPermisos">
            <input type="hidden" id="identificacion" name="identificacion">

            <!-- Sección Producto -->
            <div>
                <label>
                    <input type="checkbox" id="producto_todo" onclick="toggleSeccion('producto_todo', 'producto')">
                    <strong>Producto</strong>
                </label><br>
                <label style="margin-left: 20px;">
                    <input type="checkbox" class="producto" name="permisos[]" value="producto_crear" onclick="verificarSubPermisos('producto_todo', 'producto')">
                    Crear Producto
                </label><br>
                <label style="margin-left: 20px;">
                    <input type="checkbox" class="producto" name="permisos[]" value="producto_actualizar" onclick="verificarSubPermisos('producto_todo', 'producto')">
                    Actualizar Producto
                </label><br>
            </div>

            <!-- Sección Categorías -->
            <div>
                <label>
                    <input type="checkbox" id="categorias_todo" onclick="toggleSeccion('categorias_todo', 'categorias')">
                    <strong>Categorías</strong>
                </label><br>
                <label style="margin-left: 20px;">
                    <input type="checkbox" class="categorias" name="permisos[]" value="categorias_acceder" onclick="verificarSubPermisos('categorias_todo', 'categorias')">
                    Acceder a Categorías
                </label><br>
            </div>

            <button type="button" onclick="guardarPermisos()">Guardar Permisos</button>
        </form>
    </div>
</div>



  <script>
   // Función para marcar o desmarcar todas las sub-secciones al marcar la sección completa
function toggleSeccion(seccion, clase) {
    let seccionCheckbox = document.getElementById(seccion);
    let subPermisos = document.querySelectorAll(`.${clase}`);

    subPermisos.forEach(sub => {
        sub.checked = seccionCheckbox.checked;
    });
}

// Función para verificar si todas las sub-secciones están marcadas y actualizar la sección principal
function verificarSubPermisos(seccion, clase) {
    let seccionCheckbox = document.getElementById(seccion);
    let subPermisos = document.querySelectorAll(`.${clase}`);
    let totalMarcados = document.querySelectorAll(`.${clase}:checked`).length;

    // Si todas las sub-secciones están marcadas, marcar la sección principal
    // Si alguna sub-sección se desmarca, desmarcar la sección principal
    seccionCheckbox.checked = (totalMarcados === subPermisos.length);
}


    function abrirModal(id) {
      document.getElementById("identificacion").value = id;
      document.getElementById("modalPermisos").style.display = "block";
    }

    function cerrarModal() {
      document.getElementById("modalPermisos").style.display = "none";
    }

    function guardarPermisos() {
      var formData = new FormData(document.getElementById("formPermisos"));
      fetch("guardar_permisos.php", {
          method: "POST",
          body: formData
        }).then(response => response.text())
        .then(data => {
          alert(data);
          cerrarModal();
        }).catch(error => console.error("Error:", error));
    }
  </script>
</body>

</html>