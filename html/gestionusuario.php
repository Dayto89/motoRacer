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
      <form id="formPermisos" method="POST">
        <input type="hidden" id="identificacion" name="identificacion">

        <!-- Sección Producto -->
        <div>
  <label>
    <input type="checkbox" id="producto_todo" onclick="toggleSeccion('producto', 'producto_todo'), toggleSeccionAll('producto_todo', 'producto')">
    <strong>Producto</strong>
  </label><br>

  <div id="producto_subsecciones" style="display: none; margin-left: 20px;">
    <label>
      <input type="checkbox" class="producto" name="permisos[]" value="producto_crear" onclick="verificarSubPermisos('producto_todo', 'producto')">
      Crear Producto
    </label><br>
    <label>
      <input type="checkbox" class="producto" name="permisos[]" value="producto_actualizar" onclick="verificarSubPermisos('producto_todo', 'producto')">
      Actualizar Producto
    </label><br>
    <label>
      <input type="checkbox" class="producto" name="permisos[]" value="categorias_acceder" onclick="verificarSubPermisos('producto_todo', 'producto')">
      Categorías
    </label><br>
    <label>
      <input type="checkbox" class="producto" name="permisos[]" value="ubicacion_acceder" onclick="verificarSubPermisos('producto_todo', 'producto')">
      Ubicación
    </label><br>
    <label>
      <input type="checkbox" class="producto" name="permisos[]" value="marca_acceder" onclick="verificarSubPermisos('producto_todo', 'producto')">
      Marca
    </label><br>
  </div>
</div>




        <!-- Sección Proveedor -->
        <div>
          <label>
            <input type="checkbox" id="proveedor_todo" onclick="toggleSeccion('proveedor', 'proveedor_todo'), toggleSeccionAll('proveedor_todo', 'proveedor')">
            <strong>Proveedor</strong>
          </label><br>
          <div id="proveedor_subsecciones" style="display: none; margin-left: 20px;">
          <label>
            <input type="checkbox" class="proveedor" name="permisos[]" value="proveedor_crear" onclick="verificarSubPermisos('proveedor_todo', 'proveedor')">
            Crear Proveedor
          </label><br>
          <label style="margin-left: 20px;">
            <input type="checkbox" class="proveedor" name="permisos[]" value="proveedor_actualizar" onclick="verificarSubPermisos('proveedor_todo', 'proveedor')">
            Actualizar Proveedor
          </label><br>
          <label style="margin-left: 20px;">
            <input type="checkbox" class="proveedor" name="permisos[]" value="proveedor_lista" onclick="verificarSubPermisos('proveedor_todo', 'proveedor')">
            Lista Proveedor
          </label><br>
        </div>
        </div>

        <!-- Sección Inventario -->
        <div>
          <label>
            <input type="checkbox" id="inventario_todo" onclick="toggleSeccion('inventario', 'inventario_todo'), toggleSeccionAll('inventario_todo', 'inventario')">
            <strong>Inventario</strong>
          </label><br>
          <div id="inventario_subsecciones" style="display: none; margin-left: 20px;">
          <label>
            <input type="checkbox" class="inventario" name="permisos[]" value="inventario_lista" onclick="verificarSubPermisos('inventario_todo', 'inventario')">
            Lista Productos
          </label><br>
        </div>
        </div>
        
        <!-- Sección factura -->
        <div>
          <label>
            <input type="checkbox" id="factura_todo" onclick="toggleSeccion('factura', 'factura_todo'), toggleSeccionAll('factura_todo', 'factura')">
            <strong>Factura</strong>
          </label><br>
          <div id="factura_subsecciones" style="display: none; margin-left: 20px;">
          <label>
            <input type="checkbox" class="factura" name="permisos[]" value="factura_venta" onclick="verificarSubPermisos('factura_todo', 'factura')">
            Venta 
          </label><br>
          <label style="margin-left: 20px;">
            <input type="checkbox" class="factura" name="permisos[]" value="factura_reportes" onclick="verificarSubPermisos('factura_todo', 'factura')">
            Reportes
          </label><br>
          </div>
          </div>

          <!-- Sección Usuario -->
        <div>
          <label>
            <input type="checkbox" id="usuario_todo" onclick="toggleSeccion('usuario', 'usuario_todo'), toggleSeccionAll('usuario_todo', 'usuario')">
            <strong>Usuario</strong>
          </label><br>
          <div id="usuario_subsecciones" style="display: none; margin-left: 20px;">
          <label>
            <input type="checkbox" class="usuario" name="permisos[]" value="usuario_info" onclick="verificarSubPermisos('usuario_todo', 'usuario')">
            Informacion del Usuario
          </label><br>
        </div>
        </div>
          
        <!-- Sección Configuracion -->
        <div>
          <label>
            <input type="checkbox" id="configuracion_todo" onclick="toggleSeccion('config', 'configuracion_todo'), toggleSeccionAll('configuracion_todo', 'configuracion')">
            <strong>Configuracion</strong>
          </label><br>
          <div id="config_subsecciones" style="display: none;">
          <label>
            <input type="checkbox" class="configuracion" name="permisos[]" value="configuarcion_stock" onclick="verificarSubPermisos('configuracion_todo', 'configuracion')">
            Stock
          </label><br>
          <label style="margin-left: 20px;">
            <input type="checkbox" class="configuracion" name="permisos[]" value="configuracion_gestion" onclick="verificarSubPermisos('configuracion_todo', 'configuracion')">
            Gestion de Usuarios
          </label><br>
          <label style="margin-left: 20px;">
            <input type="checkbox" class="configuracion" name="permisos[]" value="configuracion_personalizacion" onclick="verificarSubPermisos('configuracion_todo', 'configuracion')">
            Personalizacion de Reportes
          </label><br>
          <label style="margin-left: 20px;">
            <input type="checkbox" class="configuracion" name="permisos[]" value="configuracion_notificaciones" onclick="verificarSubPermisos('configuracion_todo', 'configuracion')">
            Notificaciones de Stock
          </label><br>
          <label style="margin-left: 20px;">
            <input type="checkbox" class="configuracion" name="permisos[]" value="configuracion_frecuencia" onclick="verificarSubPermisos('configuracion_todo', 'configuracion')">
            Frencuencia de Reportes Automáticos
          </label><br>
          </div>
          </div>
        
          

          <button type="button" onclick="guardarPermisos()">Guardar Permisos</button>


      </form>
    </div>
  </div>
  




  <script>
    // Función para marcar o desmarcar todas las sub-secciones al marcar la sección completa
    function toggleSeccionAll(seccion, clase) {
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

//Funcion para ocultar las subsecciones 

function toggleSeccion(mainCheckbox, generalCheck) {
  
    var subSection = document.getElementById(mainCheckbox + '_subsecciones');
    var gencheck = document.getElementById(generalCheck)
    
    if (gencheck.checked) {
      subSection.style.display = 'block';
    } else {
      subSection.style.display = 'none';
    }
  }



  //funciones del mdodal
    function abrirModal(id) {
      document.getElementById("identificacion").value = id;
      document.getElementById("modalPermisos").style.display = "block";
    }

    function cerrarModal() {
      document.getElementById("modalPermisos").style.display = "none";
    }

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
  </script>
</body>

</html>