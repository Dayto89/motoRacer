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
// Consultar los permisos disponibles
$sqlPermisos = "SELECT seccion, sub_seccion, permitido FROM accesos WHERE id_usuario = ?";
$stmt = $conexion->prepare($sqlPermisos);
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$resultPermisos = $stmt->get_result();
$permisos = [];
while ($row = $resultPermisos->fetch_assoc()) {
  $permisos[$row['seccion']][] = [
    'sub_seccion' => $row['sub_seccion'],
    'permitido' => $row['permitido']
  ];
}
$stmt->close();

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
      <form id="formPermisos" method="POST">
        <input type="hidden" id="identificacion" name="identificacion">

        <?php foreach ($permisos as $seccion => $subsecciones): ?>
          <div>
            <label>
              <input type="checkbox" id="<?php echo $seccion; ?>_todo" onclick="toggleSeccion('<?php echo $seccion; ?>', '<?php echo $seccion; ?>_todo'), toggleSeccionAll('<?php echo $seccion; ?>_todo', '<?php echo $seccion; ?>')">
              <strong><?php echo ucfirst($seccion); ?></strong>
            </label><br>
            <div id="<?php echo $seccion; ?>_subsecciones" style="display: none; margin-left: 20px;">
              <?php foreach ($subsecciones as $subseccion): ?>
                <input type="hidden" name="permisos[<?php echo $seccion . '_' . str_replace(' ', '_', strtolower($subseccion['sub_seccion'])); ?>]" value="0">
                <label>
                  <input type="checkbox" class="<?php echo $seccion; ?>" name="permisos[]" value="<?php echo $seccion . '_' . str_replace(' ', '_', strtolower($subseccion['sub_seccion'])); ?>" <?php echo $subseccion['permitido'] ? 'checked' : ''; ?> onclick="verificarSubPermisos('<?php echo $seccion; ?>_todo', '<?php echo $seccion; ?>')">
                  <?php echo $subseccion['sub_seccion']; ?>
                </label><br>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>

        <button type="button" onclick="guardarPermisos()">Guardar Permisos</button>
      </form>
    </div>
  </div>

  <script>
    function guardarPermisos() {
      var formData = new FormData(document.getElementById("formPermisos"));
      
      fetch("../html/guardar_permisos.php", {
          method: "POST",
          body: formData
        }).then(response => response.text())
        .then(data => {
          alert(data);
          cerrarModal();
        }).catch(error => console.error("Error:", error));
    }
  </script>

  <script>
    // Funciones JavaScript para manejar los permisos
    function toggleSeccionAll(seccion, clase) {
      let seccionCheckbox = document.getElementById(seccion);
      let subPermisos = document.querySelectorAll(`.${clase}`);

      subPermisos.forEach(sub => {
        sub.checked = seccionCheckbox.checked;
      });
    }

    function verificarSubPermisos(seccion, clase) {
      let seccionCheckbox = document.getElementById(seccion);
      let subPermisos = document.querySelectorAll(`.${clase}`);
      let totalMarcados = document.querySelectorAll(`.${clase}:checked`).length;

      seccionCheckbox.checked = (totalMarcados === subPermisos.length); 
    }

    function toggleSeccion(mainCheckbox, generalCheck) {
      var subSection = document.getElementById(mainCheckbox + '_subsecciones');
      var gencheck = document.getElementById(generalCheck);
      
      if (gencheck.checked) {
        subSection.style.display = 'block';
      } else {
        subSection.style.display = 'none';
      }
    }

    function abrirModal(id) {
      document.getElementById("identificacion").value = id;
      document.getElementById("modalPermisos").style.display = "block";
    }

    function cerrarModal() {
      document.getElementById("modalPermisos").style.display = "none";
    }


  </script>
    <script>
  document.addEventListener('DOMContentLoaded', function () {
    // Agregar evento a los botones de eliminar
    var btnDelete = document.querySelectorAll('.btn-delete');
    btnDelete.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var userId = this.getAttribute('data-id');
        eliminarUsuario(userId);
      });
    });

    // Función para eliminar un usuario
    function eliminarUsuario(userId) {
      if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
        fetch('gestionusuario.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'eliminar=true&id=' + userId
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Usuario eliminado correctamente');
              // Recargar la página o eliminar la fila de la tabla
              location.reload();
            } else {
              alert('Error al eliminar el usuario');
            }
          })
          .catch(error => {
            console.error('Error:', error);
          });
      }
    }
  });
</script>
 
</body>

</html>