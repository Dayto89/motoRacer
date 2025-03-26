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
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Usuarios</title>

  <link rel="stylesheet" href="../componentes/header.php">
  <link rel="stylesheet" href="../componentes/header.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


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
  
  <style>
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
  margin-top: 7%;
}
body::before {
  position: fixed;
  width: 200%;
  height: 200%;
  z-index: -1;
  background: black;
  opacity: 0.6;
}

.container {
  width: 45%;
  margin: 50px auto;
  text-align: center;
  background-color:rgb(174 174 174 / 73%);
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  margin-top: 2%;
  margin-left: 583px;
}

/* Título principal */
h1 {
    color: white;
    text-align: center;
    margin-top: 40px;
    margin-bottom: 20px;
    font-family: "Metal Mania", system-ui;
    font-size: 60px;
    text-shadow: rgb(28, 81, 160) 7px -1px 0px, rgb(28, 81, 160) 1px -1px 0px, rgb(28, 81, 160) -1px 1px 0px, rgb(28, 81, 160) 3px 5px 0px;
}

h3 {
  font-family: Arial, Helvetica, sans-serif;
  color: black;
  background-color: #5e96d9;
  padding: 9px;
  width: 193px;
  margin-top: 8px;
  font-size: 16px;
  margin-bottom: 5px;
}

 /* Tabla de categorías */
 .user-table {
  width: 100%;
  border-collapse: collapse; 
  
}

.user-table td {
  padding: 1px;
  text-align: center;
  font-family: Arial, sans-serif;
  width: 225px;
}

.user-table th {
  font-family: Arial, Helvetica, sans-serif;
  color: black;
  background-color: #98bde9;
  padding: 9px;
  width: 193px;
  
  margin-top: 8px;
  font-size: 16px;
}

.user-table tr:nth-child(even) {
  background-color: #f9f9f9b7;
  color: black;
}

.user-table tr:nth-child(odd) {
  background-color: rgb(33 32 32 / 59%);
  color: white;
}
.row-gray {
  background-color: rgb(33 32 32 / 59%);
  color: white;
}

.row-ocre {
  background-color: #f9f9f9b7;
  color: black;
}

/* Ajuste para mover "Nombre" hacia la derecha */
.user-table td:nth-child(2), .user-table th:nth-child(2) {
  padding-left: 115px;
  text-align: left;
}
  

.btn-permisos, .btn-delete {
  padding: 8px 12px;
  margin: 5px;
  border: none;
  cursor: pointer;
  color: white;
}
.btn-registro {
  background-color: #219b40;
  color: white;
  font-size: 17px;
  font-weight: bold;
  padding: 10px 21px;
  border: none;
  border-radius: 11px;
  cursor: pointer;
  margin-right: 69%;
  width: 33%;

}

.btn-permisos {
  background-color: #20663b;
  border-radius: 15px;
}

.btn-delete {
  background-color: #dc3545;
  border-radius: 15px;
}


.btn-permisos:hover {
  background-color: #1f4d30;
}

.btn-delete:hover {
  background-color: #c82333;
}
.btn-registro:hover {
  background-color: rgb(5, 105, 30);
}
.modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.78);
  justify-content: center;
  align-items: center;
}

div.modal-content {
  
  margin: 8% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 100%;
  background-color: rgb(200 200 200 / 76%);
  padding: 20px;
  border-radius: 10px;
  width: 78%;
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

.close {
  font-family: Arial, Helvetica, sans-serif;
  float: right;
  font-size: 30px;
  cursor: pointer;
  color: white;
}

.permissions-table {
  width: 100%;
  margin-top: 20px;
  border-collapse: collapse;
}

.permissions-table th, .permissions-table td {
  padding: 10px;
  text-align: center;
  background-color: #f9f9f9b7;
  color: black;
  font-family: Arial, Helvetica, sans-serif;
  text-align: left;
  font-weight: bold;
}

.permissions-table th {
  background-color: #417ab5;
  color: white;
  font-family: Arial, Helvetica, sans-serif;
}

.btn-save {
  background-color: #007bff;
  border-radius: 15px;
  color: white;
  padding:  13px 36px;
  border: none;
  cursor: pointer;
  margin-top: 10px;
}

.btn-save:hover {
  background-color: #0056b3;
}

tbody input[type="checkbox"] {
  transform: translate(175%, 9%) scale(1.5);
  background-color: #417ab5;
}

.modal-content h2 {
  font-size: 52px;
  color: white;
  text-align: center;
  margin-top: 2px;
  margin-left: 16px;
  font-weight: bold;
  text-shadow: 7px -1px 0 #1c51a0, 1px -1px 0 #1c51a0, -1px 1px 0 #1c51a0, 3px 5px 0 #1c51a0;
  letter-spacing: 5px;
}
/* Agregamos la animación de entrada */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Agregamos la animación de salida */
@keyframes fadeOut {
  from {
    opacity: 1;
    transform: translateY(0);
  }
  to {
    opacity: 0;
    transform: translateY(-20px);
  }
}

/* Estilo inicial del modal (oculto) */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

/* Contenido del modal con animación */
.modal-content {
  background-color: #fefefe;
  margin: 10% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 500px;
  opacity: 0; /* Oculto por defecto */
  transform: translateY(-20px);
  transition: opacity 0.3s ease-out, transform 0.3s ease-out;
}

/* Clases para activar las animaciones */
.modal.mostrar .modal-content {
  opacity: 1;
  transform: translateY(0);
  animation: fadeIn 0.3s forwards;
}

.modal.ocultar .modal-content {
  animation: fadeOut 0.3s forwards;
}

.close:hover, .close:focus {
  color: #a30d0d;
  text-decoration: none;
  cursor: pointer;
}
.close {
  color: #302f2f;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

/* Estilos para el toggle switch */
.switch {
  position: relative;
  display: inline-block;
  width: 49px;
  height: 20px;
  
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #C55655;
  transition: 0.4s;
  border-radius: 34px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 12px;
  width: 12px;
  left: 4px;
  bottom: 4px;
  background-color: rgb(255 255 255);
  transition: 0.4s;
  border-radius: 50%;
}

input:checked + .slider {
  background-color: #1f78bf;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  transform: translateX(30px);
}
input[type="checkbox"] {
  display: none;
}

/* Estilos para el contenedor de columnas */
.column-container {
  display: grid;
  grid-template-columns: 1.5fr 1.5fr 1.5fr 1fr 1fr 2fr;
  gap: 20px; /* Espacio entre columnas */
  padding: 20px;
  align-items: start; /* Alinea las columnas a la izquierda */

}

/* Estilos para cada columna */
.column {
  background-color: #f9f9f9;
  padding: 15px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Estilos para las secciones */
.section-title {
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 10px;
  font-family: arial;
}

/* Estilos para las subsecciones */
.subsection {
  display: flex;
  align-items: center; /* Centra verticalmente el label con el switch */
  gap: 10px; /* Espacio entre el switch y el label */
}

div.subsection{

  font-family: Arial, Helvetica, sans-serif;
  font-size: 14px;
  margin-bottom: 15px; /* Ajusta el valor según necesites */
}

#btnGuardar {
  background-color:  #007bff;
  color: white;
  padding: 10px 20px;
  font-size: 16px;
  border: none;
  border-radius: 16px;
  cursor: pointer;
  transition: background 0.3s;
}

#btnGuardar:hover {
  background-color:#0056b3;
}
  </style>
  
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
      saveButton.id = "btnGuardar";
      saveButton.onclick = guardarPermisos;
      form.appendChild(saveButton);
    }
  </script>

</body>

</html>