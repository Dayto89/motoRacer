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

// Consultar los permisos del usuario seleccionado
if ($_POST && isset($_POST['permisos'])) {
  $id = $conexion->real_escape_string($_POST['id']);
  $query = "SELECT seccion, sub_seccion, permitido FROM accesos WHERE id_usuario = ?";
  $stmt = $conexion->prepare($query);
  $stmt->bind_param("i", $id); // CORREGIDO: Era $smt en vez de $stmt
  $stmt->execute();
  $result = $stmt->get_result();
  $permisos = [];

  while ($row = $result->fetch_assoc()) {
    $permisos[$row['seccion']][] = [
      'sub_seccion' => $row['sub_seccion'],
      'permitido' => $row['permitido']
    ];
  }

  $stmt->close();

  // Asegurar que la respuesta JSON se envíe correctamente
  header('Content-Type: application/json');

  echo json_encode($permisos);
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
  <link rel="stylesheet" href="../componentes/header.php">
  <link rel="stylesheet" href="../componentes/header.css">
  <script src="../js/header.js"></script>
  <script src="/js/index.js"></script>
</head>

<body>
  <div id="menu"></div>
  <h1>Gestión de Usuarios</h1>
  <div class="container">
  <div class="actions">
  <button class='btn-registro' onclick="location.href='../html/registro.php'"><i class='bx bx-plus bx-tada'></i>Registrar nuevo usuario</button>
  </div>
  <h3>Lista de Usuarios</h3>
    <table class="user-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Rol</th>
          <th>Permisos</th>
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
            echo "<td><button class='btn-permisos' onclick='abrirModal(" . $row['identificacion'] . ")' data-id='" . $row['identificacion'] . "'>Permisos</button></td>";
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

 

  <!-- Modal -->
  <div id="modalPermisos" class="modal">
    <div class="modal-content">
      <span class="close" onclick="cerrarModal()">&times;</span>
      <h2>Configurar Permisos</h2>
      <form id="formPermisos" method="POST">
        <input type="hidden" id="identificacion" name="identificacion">

        <?php $permisos = $permisos ?? []; ?>
        <?php foreach ($permisos as $seccion => $subsecciones): ?>

          <div>
            <label>
              <strong><?php echo ucfirst($seccion); ?></strong>
            </label><br>
            <div id="<?php echo $seccion; ?>_subsecciones" style="display: none; margin-left: 20px;">
              <?php foreach ($subsecciones as $subseccion): ?>
                <input type="hidden" name="permisos[<?php echo $seccion . '_' . str_replace(' ', '_', strtolower($subseccion['sub_seccion'])); ?>]" value="0">
                <label>
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
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("Permisos actualizados correctamente");
        cerrarModal();
      } else {
        alert("Error al actualizar permisos");
      }
    })
    .catch(error => console.error("Error:", error));
}


    function abrirModal(id) {
      document.getElementById("identificacion").value = id;
      document.getElementById("modalPermisos").style.display = "block";
    }

    function cerrarModal() {
      document.getElementById("modalPermisos").style.display = "none";
    }

    document.addEventListener('DOMContentLoaded', function() {
      // Agregar evento a los botones de permisos

      var btnPermisos = document.querySelectorAll('.btn-permisos');
      btnPermisos.forEach(function(btn) {
        btn.addEventListener('click', function() {
          var userId = this.getAttribute('data-id');
          permisosUsuario(userId);
        });
      });

      function permisosUsuario(userId) {
        fetch('gestiondeusuarios.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'permisos=true&id=' + userId
          })
          .then(response => response.json())
          .then(data => {
            if (data) {
              console.log(data); // Verifica en la consola si los permisos llegan correctamente
              actualizarModalPermisos(data);
              document.getElementById("modalPermisos").style.display = "block";
            } else {
              alert('No se encontraron permisos para este usuario.');
            }
          })
          .catch(error => {
            console.error('Error al obtener permisos:', error);
          });
      }

    })

    document.addEventListener('DOMContentLoaded', function() {
      // Agregar evento a los botones de eliminar
      var btnDelete = document.querySelectorAll('.btn-delete');
      btnDelete.forEach(function(btn) {
        btn.addEventListener('click', function() {
          var userId = this.getAttribute('data-id');
          eliminarUsuario(userId);
        });
      });

      // Función para eliminar un usuario
      function eliminarUsuario(userId) {
        if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
          fetch('gestiondeusuarios.php', {
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

    function actualizarModalPermisos(data) {
    let form = document.getElementById("formPermisos");
    let userId = document.getElementById("identificacion").value; // Guarda el ID

    form.innerHTML = ''; // Limpia el contenido previo

    // Mantiene el campo oculto del ID
    let inputId = document.createElement("input");
    inputId.type = "hidden";
    inputId.id = "identificacion";
    inputId.name = "identificacion";
    inputId.value = userId;
    form.appendChild(inputId);

    // Contenedor de columnas
    let columnContainer = document.createElement("div");
    columnContainer.className = "column-container";

    // Crear una columna por cada sección
    let columnCount = 0;
    for (let seccion in data) {
        if (columnCount % 6 === 0 && columnCount !== 0) {
            // Si ya hay 6 columnas, crea un nuevo contenedor
            form.appendChild(columnContainer);
            columnContainer = document.createElement("div");
            columnContainer.className = "column-container";
        }

        // Crear una columna
        let column = document.createElement("div");
        column.className = "column";

        // Título de la sección
        let sectionTitle = document.createElement("div");
        sectionTitle.className = "section-title";
        sectionTitle.textContent = seccion;
        column.appendChild(sectionTitle);

        // Subsecciones
        data[seccion].forEach(sub => {
            let subsection = document.createElement("div");
            subsection.className = "subsection";

            // Toggle switch
            let switchContainer = document.createElement("label");
            switchContainer.className = "switch";

            // Input oculto para el valor no marcado
            let hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = `permisos[${seccion}_${sub.sub_seccion.replace(/\s+/g, '_').toLowerCase()}]`;
            hiddenInput.value = "0"; // Si no se marca, se enviará como 0

            // Input del toggle switch
            let toggleInput = document.createElement("input");
            toggleInput.type = "checkbox";
            toggleInput.name = `permisos[${seccion}_${sub.sub_seccion.replace(/\s+/g, '_').toLowerCase()}]`;
            toggleInput.value = "1";
            toggleInput.checked = sub.permitido == 1;

            // Slider del toggle switch
            let slider = document.createElement("span");
            slider.className = "slider";

            // Label con el nombre de la subsección
            let label = document.createElement("label");
            label.textContent = sub.sub_seccion;

            // Agregar elementos al contenedor
            switchContainer.appendChild(hiddenInput);
            switchContainer.appendChild(toggleInput);
            switchContainer.appendChild(slider);
            subsection.appendChild(switchContainer);
            subsection.appendChild(label);
            column.appendChild(subsection);
        });

        columnContainer.appendChild(column);
        columnCount++;
    }

    // Agregar el contenedor de columnas al formulario
    form.appendChild(columnContainer);

    // Botón para guardar permisos
    let saveButton = document.createElement("button");
    saveButton.type = "button";
    saveButton.textContent = "Guardar Permisos";
    saveButton.onclick = guardarPermisos;
    form.appendChild(saveButton);
}

  </script>

</body>

</html>