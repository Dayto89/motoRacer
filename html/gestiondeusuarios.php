<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.php");
  exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '../html/verificar_permisos.php';

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
  <link rel="stylesheet" href="../css/alertas.css">
  <link rel="stylesheet" href="../componentes/header.php">
  <link rel="stylesheet" href="../componentes/header.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <script src="../js/header.js"></script>
  <script src="/js/index.js"></script>
</head>

<body>
   <?php include 'boton-ayuda.php'; ?>
  <div id="menu"></div>
 <div class="container-general">
    </div>
  <h1>Gestión de Usuarios</h1>
  <div class="container">
    <div class="actions">
      <button class='btn-registro' onclick="location.href='../html/registro.php'"><i class='bx bx-plus bx-tada'></i>Registrar nuevo usuario</button>
    </div>
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
      <tbody id="tabla-usuarios">
        <?php
        $sql = "SELECT * FROM usuario WHERE rol = 'gerente'";
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
              title: `<span class='titulo-alerta confirmacion'>Permisos actualizados</span>`,
              html: `
                            <div class="alerta">
                                <div class="contenedor-imagen">
                                    <img src="../imagenes/moto.png" class="moto">
                                </div>
                                <p>Los permisos se han actualizado correctamente.</p>
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
            })
          } else {
            Swal.fire({
              title: '<span class=\"titulo-alerta error\">Error</span>',
              html: `
                              <div class=\"custom-alert\">
                                  <div class='contenedor-imagen'>
                                        <img src=\"../imagenes/llave.png\" alt=\"Error\" class=\"llave\">
                                  </div>
                                <p>Error al actualizar los permisos.</p>
                            </div>
                        `,
              background: '#ffffffdb',
              confirmButtonText: 'Aceptar',
              confirmButtonColor: '#dc3545',
              customClass: {
                popup: 'swal2-border-radius',
                confirmButton: 'btn-aceptar',
                container: 'fondo-oscuro'
              }
            });
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
    window.addEventListener('click', function(event) {
      const modal = document.getElementById('modalPermisos');
      if (event.target === modal) {
        cerrarModal();
      }
    });


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
      var btnDelete = document.querySelectorAll('.btn-delete');
      btnDelete.forEach(function(btn) {
        btn.addEventListener('click', function() {
          var userId = this.getAttribute('data-id');
          eliminarUsuario(userId);
        });
      });

      function eliminarUsuario(userId) {
        Swal.fire({
          title: '<span class="titulo-alerta advertencia">¿Estás seguro?</span>',
          html: `
        <div class="custom-alert">
            <div class="contenedor-imagen">
                <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
            </div>
            <p>El usuario será eliminado permanentemente.</p>
        </div>
    `,
          background: '#ffffffdb',
          showCancelButton: true,
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar',
          confirmButtonColor: '#dc3545', // Rojo para botón eliminar
          customClass: {
            popup: 'swal2-border-radius',
            confirmButton: 'btn-eliminar',
            cancelButton: 'btn-cancelar',
            container: 'fondo-oscuro'
          }
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
                    title: `<span class="titulo-alerta confirmacion">Usuario Eliminado</span>`,
                    html: `
                            <div class="alerta">
                                <div class="contenedor-imagen">
                                    <img src="../imagenes/moto.png" class="moto">
                                </div>
                                <p>Usuario eliminado correctamente.</p>
                            </div>
                        `,
                    sbackground: '#ffffffdb',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#007bff',
                    customClass: {
                      popup: 'swal2-border-radius',
                      confirmButton: 'btn-aceptar',
                      container: 'fondo-oscuro'
                    }
                  }).then(() => {
                    location.reload();
                  });
                } else {
                  Swal.fire({
                    title: `<span class="titulo">Error</span>`,
                    html: `
                            <div class="alerta">
                                <div class="contenedor-imagen">
                                    <img src="../imagenes/llave.png" class="llave">
                                </div>
                                <p>Error al eliminar el usuario.</p>
                            </div>
                        `,
                    showConfirmButton: true,
                    confirmButtonText: "Aceptar",
                    customClass: {
                      confirmButton: "btn-aceptar" // Clase personalizada para el botón de aceptar
                    }
                  });
                }
              })
              .catch(error => {
                console.error("Error:", error);
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
 <div class="userContainer">
    <div class="userInfo">
      <!-- Nombre y apellido del usuario y rol -->
      <!-- Consultar datos del usuario -->
      <?php
      $conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
      $id_usuario = $_SESSION['usuario_id'];
      $sqlUsuario = "SELECT nombre, apellido, rol, foto FROM usuario WHERE identificacion = ?";
      $stmtUsuario = $conexion->prepare($sqlUsuario);
      $stmtUsuario->bind_param("i", $id_usuario);
      $stmtUsuario->execute();
      $resultUsuario = $stmtUsuario->get_result();
      $rowUsuario = $resultUsuario->fetch_assoc();
      $nombreUsuario = $rowUsuario['nombre'];
      $apellidoUsuario = $rowUsuario['apellido'];
      $rol = $rowUsuario['rol'];
      $foto = $rowUsuario['foto'];
      $stmtUsuario->close();
      ?>
      <p class="nombre"><?php echo $nombreUsuario; ?> <?php echo $apellidoUsuario; ?></p>
      <p class="rol">Rol: <?php echo $rol; ?></p>

    </div>
    <div class="profilePic">
      <?php if (!empty($rowUsuario['foto'])): ?>
        <img id="profilePic" src="data:image/jpeg;base64,<?php echo base64_encode($foto); ?>" alt="Usuario">
      <?php else: ?>
        <img id="profilePic" src="../imagenes/icono.jpg" alt="Usuario por defecto">
      <?php endif; ?>
    </div>
    </div>

</body>

</html>