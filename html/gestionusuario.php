<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.php");
  exit();
}

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');

if (!$conexion) {
  die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

// Eliminar usuario
if ($_POST && isset($_POST['eliminar'])) {
  $id = mysqli_real_escape_string($conexion, $_POST['id']);

  $query = "DELETE FROM usuario WHERE identificacion = '$id'";
  $resultado = mysqli_query($conexion, $query);

  echo json_encode(["success" => $resultado]);
  exit();
}

// Obtener lista de permisos de un usuario
if ($_POST && isset($_POST['lista'])) {
  $id = mysqli_real_escape_string($conexion, $_POST['id']);

  // Verificar si el usuario es el administrador
  $query = "SELECT rol FROM usuario WHERE identificacion = '$id'";
  $resultado = mysqli_query($conexion, $query);
  $fila = mysqli_fetch_assoc($resultado);

  if ($fila['rol'] === 'administrador') {
    echo json_encode(["error" => "No se pueden asignar permisos al administrador."]);
    exit();
  }

  // Obtener permisos asignados al usuario
  $query = "SELECT p.id, p.nombre 
            FROM permiso p
            JOIN usuario_permiso up ON p.id = up.permiso_id
            WHERE up.usuario_id = '$id'";
  $resultado = mysqli_query($conexion, $query);

  $permisos = [];
  while ($fila = mysqli_fetch_assoc($resultado)) {
    $permisos[] = $fila;
  }

  echo json_encode($permisos);
  exit();
}

// Obtener todos los permisos disponibles
if ($_POST && isset($_POST['todos_los_permisos'])) {
  $query = "SELECT id, nombre FROM permiso";
  $resultado = mysqli_query($conexion, $query);

  $permisos = [];
  while ($fila = mysqli_fetch_assoc($resultado)) {
    $permisos[] = $fila;
  }

  echo json_encode($permisos);
  exit();
}

// Asignar permisos a un usuario
if ($_POST && isset($_POST['asignar_permisos'])) {
  $usuario_id = mysqli_real_escape_string($conexion, $_POST['usuario_id']);
  $permisos = json_decode($_POST['permisos']); // Array de permisos seleccionados

  // Verificar si el usuario es el administrador
  $query = "SELECT rol FROM usuario WHERE identificacion = '$usuario_id'";
  $resultado = mysqli_query($conexion, $query);
  $fila = mysqli_fetch_assoc($resultado);

  if ($fila['rol'] === 'administrador') {
    echo json_encode(["error" => "No se pueden asignar permisos al administrador."]);
    exit();
  }

  // Eliminar permisos anteriores del usuario
  $query = "DELETE FROM usuario_permiso WHERE usuario_id = '$usuario_id'";
  mysqli_query($conexion, $query);

  // Asignar nuevos permisos
  foreach ($permisos as $permiso_id) {
    $permiso_id = mysqli_real_escape_string($conexion, $permiso_id);
    $query = "INSERT INTO usuario_permiso (usuario_id, permiso_id) VALUES ('$usuario_id', '$permiso_id')";
    mysqli_query($conexion, $query);
  }

  echo json_encode(["success" => true]);
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Usuarios</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="/css/gestionusuario.css">
  <link rel="stylesheet" href="/componentes/header.css">
  <link
    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
    rel="stylesheet" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
  </style>
  <script src="/js/index.js"></script>
</head>

<body>
  <!-- Aquí se cargará el header -->
  <div id="menu"></div>

  <div id="gestionusuario" class="form-section">
    <h1>Gestión Usuarios</h1>

    <div class="container">
      <table class="user-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          
          <?php
          $conn = new mysqli('localhost', 'root', '', 'inventariomotoracer');
          $sql = "SELECT * FROM usuario";
          $result = $conn->query($sql);
          $contador = 0; // Contador para alternar colores

          while ($row = $result->fetch_assoc()) {
            // Alterna clases según el contador
            $claseFila = ($contador % 2 == 0) ? 'row-ocre' : 'row-gray';

            echo "<tr class='$claseFila'>
            <td>" . $row['identificacion'] . "</td>
            <td>" . $row['nombre'] . "</td>
            <td>" . $row['apellido'] . "</td>
            <td>
              <button class='btn-permissions'  id='lista' data-id='" . $row['identificacion'] . "'>Permisos</button>


                <button class='btn-delete' id='eliminar' data-id='" . $row['identificacion'] . "'>Eliminar</button>
            </td>
          </tr>";
            $contador++;
          }
          ?>
          
        </div>
</div>
<button class='btn-registro' onclick="location.href='../html/registro.php'"> <i class='bx bx-plus bx-tada'></i>Registrar nuevo usuario</button>
</tbody>
      </table>
      <!-- Modal para asignar permisos -->
<div id="permisosModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Asignar Permisos</h2>
    <form id="formPermisos">
      <div id="permisosList">
        <!-- Aquí se cargarán dinámicamente los permisos -->
      </div>
      <button type="submit">Guardar Permisos</button>
    </form>
  </div>
</div>
<Script>
  document.addEventListener('DOMContentLoaded', function () {
  var modal = document.getElementById('permisosModal');
  var btnPermissions = document.querySelectorAll('.btn-permissions');
  var span = document.getElementsByClassName('close')[0];

  const permisosGenerales = {
    '1': [2, 3, 4, 5, 6], // PRODUCTO contiene estos permisos
    '7': [8, 9, 10], // PROVEEDOR
    '11': [12, 13], // INVENTARIO
    '14': [15, 16], // FACTURA
    '17': [18, 19], // USUARIO
    '20': [21, 22]  // CONFIGURACIÓN
  };

  btnPermissions.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var userId = this.getAttribute('data-id');
      cargarPermisosUsuario(userId);
      modal.style.display = 'block';
    });
  });

  span.onclick = function () {
    modal.style.display = 'none';
  }

  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = 'none';
    }
  }

  function cargarPermisosUsuario(userId) {
    fetch('gestionusuario.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'lista=true&id=' + userId
    })
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          alert(data.error);
          modal.style.display = 'none';
          return;
        }

        var permisosList = document.getElementById('permisosList');
        permisosList.innerHTML = '';

        fetch('gestionusuario.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: 'todos_los_permisos=true'
        })
          .then(response => response.json())
          .then(permisos => {
            permisos.forEach(function (permiso) {
              var div = document.createElement('div');
              var checked = data.some(p => p.id === permiso.id) ? 'checked' : '';
              div.innerHTML = `
                <input type="checkbox" id="permiso_${permiso.id}" name="permisos[]" value="${permiso.id}" ${checked}>
                <label for="permiso_${permiso.id}">${permiso.nombre}</label>
              `;
              permisosList.appendChild(div);
            });

            agregarEventosCheckboxes();
          });
      });
  }

  function agregarEventosCheckboxes() {
    Object.keys(permisosGenerales).forEach(permisoGeneralId => {
      const checkboxGeneral = document.querySelector(`input[name="permisos[]"][value="${permisoGeneralId}"]`);
      if (checkboxGeneral) {
        checkboxGeneral.addEventListener('change', function () {
          manejarPermisoGeneral(permisoGeneralId, this.checked);
        });
      }
    });

    document.querySelectorAll('input[name="permisos[]"]').forEach(checkbox => {
      checkbox.addEventListener('change', function () {
        const permisoId = parseInt(this.value);
        const permisoGeneralId = Object.keys(permisosGenerales).find(key => permisosGenerales[key].includes(permisoId));

        if (permisoGeneralId) {
          const permisoGeneralCheckbox = document.querySelector(`input[name="permisos[]"][value="${permisoGeneralId}"]`);
          if (permisoGeneralCheckbox) {
            const todosSeleccionados = permisosGenerales[permisoGeneralId].every(subpermisoId => {
              return document.querySelector(`input[name="permisos[]"][value="${subpermisoId}"]`).checked;
            });
            permisoGeneralCheckbox.checked = todosSeleccionados;
          }
        }
      });
    });
  }

  function manejarPermisoGeneral(permisoGeneralId, checked) {
    permisosGenerales[permisoGeneralId].forEach(subpermisoId => {
      const subpermisoCheckbox = document.querySelector(`input[name="permisos[]"][value="${subpermisoId}"]`);
      if (subpermisoCheckbox) {
        subpermisoCheckbox.checked = checked;
      }
    });
  }

  document.getElementById('formPermisos').addEventListener('submit', function (event) {
    event.preventDefault();
    var userId = document.querySelector('.btn-permissions').getAttribute('data-id');
    var permisos = Array.from(document.querySelectorAll('input[name="permisos[]"]:checked')).map(input => input.value);

    fetch('gestionusuario.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'asignar_permisos=true&usuario_id=' + userId + '&permisos=' + JSON.stringify(permisos)
    })
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          alert(data.error);
        } else if (data.success) {
          alert('Permisos asignados correctamente');
          modal.style.display = 'none';
        } else {
          alert('Error al asignar permisos');
        }
      });
  });
});

</Script>
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