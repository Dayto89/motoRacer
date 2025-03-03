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

// Obtener lista de permisos
if ($_POST && isset($_POST['lista'])) {
  $id = mysqli_real_escape_string($conexion, $_POST['id']);

  $query = "SELECT * FROM permiso WHERE usuario_id = '$id'";
  $resultado = mysqli_query($conexion, $query);

  $permisos = [];
  while ($fila = mysqli_fetch_assoc($resultado)) {
    $permisos[] = $fila;
  }

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
          <!-- Aquí se mostrarán los apartados del software -->
          <div><input type="checkbox" id="permiso_producto" name="permisos[]" value="1"><label for="permiso_producto">Producto</label></div>
          <div><input type="checkbox" id="permiso_crear_producto" name="permisos[]" value="2"><label for="permiso_crear_producto">Crear Producto</label></div>
          <div><input type="checkbox" id="permiso_actualizar_producto" name="permisos[]" value="3"><label for="permiso_actualizar_producto">Actualizar Producto</label></div>
          <div><input type="checkbox" id="permiso_categoria" name="permisos[]" value="4"><label for="permiso_categoria">Categoria</label></div>
          <div><input type="checkbox" id="permiso_ubicacion" name="permisos[]" value="5"><label for="permiso_ubicacion">Ubicacion</label></div>
          <div><input type="checkbox" id="permiso_marca" name="permisos[]" value="6"><label for="permiso_marca">Marca</label></div>
          <div><input type="checkbox" id="permiso_proveedor" name="permisos[]" value="7"><label for="permiso_proveedor">Proveedor</label></div>
          <div><input type="checkbox" id="permiso_crear_proveedor" name="permisos[]" value="8"><label for="permiso_crear_proveedor">Crear Proveedor</label></div>
          <div><input type="checkbox" id="permiso_actualizar_proveedor" name="permisos[]" value="9"><label for="permiso_actualizar_proveedor">Actualizar Proveedor</label></div>
          <div><input type="checkbox" id="permiso_lista_proveedor" name="permisos[]" value="10"><label for="permiso_lista_proveedor">lista Proveedor</label></div>
          <div><input type="checkbox" id="permiso_inventario" name="permisos[]" value="8"><label for="permiso_inventario">INVENTARIO</label></div>
          <div><input type="checkbox" id="permiso_factura" name="permisos[]" value="9"><label for="permiso_factura">FACTURA</label></div>
          <div><input type="checkbox" id="permiso_usuario" name="permisos[]" value="10"><label for="permiso_usuario">USUARIO</label></div>
          <div><input type="checkbox" id="permiso_configuracion" name="permisos[]" value="11"><label for="permiso_configuracion">CONFIGURACION</label></div>
        </div>
        <button type="submit">Guardar Permisos</button>
      </form>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Obtener referencias a los elementos del modal
      var modal = document.getElementById('permisosModal');
      var btnPermissions = document.querySelectorAll('.btn-permissions');
      var span = document.getElementsByClassName('close')[0];

      // Abrir modal al hacer clic en el botón de permisos
      btnPermissions.forEach(function (btn) {
        btn.addEventListener('click', function () {
          modal.style.display = 'block'; // Mostrar el modal
        });
      });

      // Cerrar modal al hacer clic en la 'x'
      span.onclick = function () {
        modal.style.display = 'none'; // Ocultar el modal
      }

      // Cerrar modal al hacer clic fuera del modal
      window.onclick = function (event) {
        if (event.target == modal) {
          modal.style.display = 'none'; // Ocultar el modal
        }
      }
    });
  </script>
</body>

</html>