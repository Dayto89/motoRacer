<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.php");
  exit();
}

require_once $_SERVER['DOCUMENT_ROOT'].'../html/verificar_permisos.php';

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
  $stmt->bind_param("i", $id); 
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
include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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
            echo "<td><button class='btn-permisos' onclick='abrirModal(" . $row['identificacion'] . ")' data-id='" . $row['identificacion'] . "'>  <i class='bx bxs-key'></i></button></td>";
          } else {
            echo "<td></td>";
          }

          echo "<td><button class='btn-delete' data-id='" . $row['identificacion'] . "'>
        <i class='fa-solid fa-trash'></i>
      </button></td>";

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

        <button type="button" id="btnGuardar" onclick="guardarPermisos()">Guardar Permisos</button>

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
        Swal.fire({
          title: "¡Permisos actualizados!",
          text: "Los permisos se han actualizado correctamente.",
          icon: "success",
          confirmButtonColor: "#6C5CE7",
          confirmButtonText: "OK"
        }).then(() => {
          cerrarModal();
        });
      } else {
        Swal.fire({
          title: "Error",
          text: "No se pudieron actualizar los permisos.",
          icon: "error",
          confirmButtonColor: "#d33",
          confirmButtonText: "Intentar de nuevo"
        });
      }
    })
    .catch(error => {
      console.error("Error:", error);
      Swal.fire({
        title: "Error inesperado",
        text: "Ocurrió un problema al actualizar los permisos.",
        icon: "error",
        confirmButtonColor: "#d33",
        confirmButtonText: "Cerrar"
      });
    });
}


    function abrirModal(id) {
  let modal = document.getElementById("modalPermisos");
  let modalContent = modal.querySelector(".modal-content");

  document.getElementById("identificacion").value = id;
  modal.style.display = "block";
  modal.classList.add("mostrar");
  modal.classList.remove("ocultar");

  let boton = modal.querySelector("button");
  if (boton) {
    boton.class = "btnGuardar";
  } else {
    console.error("No se encontró el botón dentro del modal.");
  }
}

function cerrarModal() {
  let modal = document.getElementById("modalPermisos");

  modal.classList.add("ocultar");
  modal.classList.remove("mostrar");

  // Esperamos a que termine la animación para ocultarlo
  setTimeout(() => {
    modal.style.display = "none";
  }, 300);
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

  // Función para eliminar un usuario con SweetAlert2
  function eliminarUsuario(userId) {
    Swal.fire({
      title: '¿Eliminar usuario?',
      text: 'Esta acción no se puede deshacer',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#6C5CE7',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
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
              Swal.fire({
                title: '¡Eliminado!',
                text: 'El usuario ha sido eliminado correctamente.',
                icon: 'success',
                confirmButtonColor: '#6C5CE7'
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire('Error', 'No se pudo eliminar el usuario.', 'error');
            }
          })
          .catch(error => {
            console.error('Error:', error);
          });
      }
    });
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
      saveButton.id = "btnGuardar";
      saveButton.onclick = guardarPermisos;
      form.appendChild(saveButton);
    }
  </script>

</body>

</html>