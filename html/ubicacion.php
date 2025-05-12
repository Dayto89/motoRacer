<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'].'../html/verificar_permisos.php';

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
  die("<script>alert('No se pudo conectar a la base de datos');</script>");
}

// Agregar Ubicacion
if ($_POST && isset($_POST['guardar'])) {
  if (!$conexion) {
    die("<script>alert('No se pudo conectar a la base de datos');</script>");
  };
  $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);
  $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
  
  $query = "INSERT INTO ubicacion (codigo, nombre) VALUES ('$codigo', '$nombre')";
  
  $resultado = mysqli_query($conexion, $query);
  
  if ($resultado) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: '<span class=\"titulo-alerta confirmacion\">Éxito</span>',
            html: `
                <div class=\"custom-alert\">
                    <div class=\"contenedor-imagen\">
                        <img src=\"../imagenes/moto.png\" alt=\"Confirmación\" class=\"moto\">
                    </div>
                    <p>Ubicación agregada correctamente.</p>
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
        });
    });
</script>";
  } else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

$error = mysqli_error($conexion); // Captura el error fuera del script JS

echo "<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: '<span class=\"titulo-alerta error\">Error</span>',
        html: `
            <div class=\"custom-alert\">
                <div class=\"contenedor-imagen\">
                    <img src=\"../imagenes/llave.png\" alt=\"Error\" class=\"llave\">
                </div>
                <p>La ubicación no fue agregada.<br><small>$error</small></p>
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
    });
});
</script>";
  }
}
// Eliminar ubicacion mediante boton
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
  $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);
  
  $query = "DELETE FROM ubicacion WHERE codigo = '$codigo'";
  $resultado = mysqli_query($conexion, $query);
  
  // Responder solo con JSON
  echo json_encode(["success" => $resultado]);
  exit();
}


// Obtener lista de productos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lista'])) {
  $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);
  
  $query = "SELECT codigo1, nombre, FROM producto WHERE Ubicacion_codigo = '$codigo'";
  $resultado = mysqli_query($conexion, $query);
  
  $productos = [];
  while ($fila = mysqli_fetch_assoc($resultado)) {
    $productos[] = $fila;
  }
  
  echo json_encode($productos);
  exit();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubicación</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="/css/ubicacion.css">
    <link rel="stylesheet" href="../componentes/header.css">
    <link rel="stylesheet" href="../componentes/header.php">
  <script src="../js/header.js"></script>
  <script defer src="../js/index.js"></script> <!-- Cargar el JS de manera correcta -->
  <script src="/js/ubicaciones.js"></script>
</head>
<body>
  <div id="menu"></div>
  <div id="categorias" class="form-section">
    <h1>Ubicación</h1>
    <div class="container">
      <div class="actions">
        <button id="btnAbrirModal" class="btn-nueva-categoria"><i class='bx bx-plus bx-tada'></i>Nueva ubicación</button>
      </div>
      
      <table class="category-table">
        <tbody id="tabla-ubicaciones">
          <?php
          $ubicaciones = $conexion->query("SELECT * FROM ubicacion ORDER BY codigo ASC");
          while ($fila = $ubicaciones->fetch_assoc()) {
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
      <h2>Nueva ubicación</h2>
      <form  method="POST" action="">
        <div class="form-group">
          <label>Ingrese el código:</label>
          <input type="text" id="codigo" name="codigo" required />
          <label>Ingrese el nombre de la ubicación:</label>
          <input type="text" id="nombre" name="nombre" required />
        </div>
        <div class="modal-buttons">
          <button type="button" id="btnCancelar">Cancelar</button>
          <button type="submit" name="guardar" id="btnGuardar">Guardar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal de productos - Mismo estilo que el modal principal -->
    <!-- Modal de productos -->
    <div id="modalProductos" class="modal">
        <div class="modal-content">
            <span class="close">
                <i class="fa-solid fa-x"></i>
            </span>
            <h2>Productos de esta Ubicacion</h2>
            <div id="lista-productos">
                <!-- Aquí se insertará la tabla o lista de productos -->
            </div>
        </div>
    </div>


  <script>
    document.addEventListener("DOMContentLoaded", function () {
    const tablaUbicaciones = document.getElementById("tabla-ubicaciones");
    const a

    if (!tablaUbicaciones) {
        console.error("No se encontró el elemento con id 'tabla-ubicaciones'");
        return;
    }

    tablaUbicaciones.addEventListener("click", function (event) {
        const target = event.target;

        if (target.classList.contains("btn-list")) {
            const ubicacion_id = target.getAttribute("data-id");

            fetch("../html/ubicacion.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `lista=1&codigo=${ubicacion_id}`
            })
            .then(response => response.json())
            .then(data => {
                alert(data.length > 0 ? `Productos de la ubicación:\n${data.map(p => `- ${p.nombre}`).join("\n")}` : "No hay productos en esta ubicación.");
            })
            .catch(error => console.error("Error:", error));
        }

        if (target.classList.contains("btn-delete")) {
            const codigo = target.getAttribute("data-id");

           
            Swal.fire({
                title: '<span class="titulo-alerta advertencia">¿Esta seguro?</span>',
                html: `
                    <div class="custom-alert">
                        <div class="contenedor-imagen">
                            <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                        </div>
                        <p>Esta acción eliminará la ubicación.<br>¿Desea continuar?</p>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                background: '#ffffffdb',
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-eliminaar',
                    cancelButton: 'btn-cancelar',
                    container: 'fondo-oscuro'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("../html/ubicacion.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: `eliminar=1&codigo=${codigo}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: '<span class="titulo-alerta confrimacion">Eliminado</span>',
                                html: `
                                    <div class="custom-alert">
                                        <div class="contenedor-imagen">
                                            <img src="../imagenes/moto.png" alt="Éxito" class="moto">
                                        </div>
                                        <p>Ubicación eliminada correctamente.</p>
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
                            }).then(() => location.reload());
                        } else {
                            Swal.fire({
                                title: '<span class="titulo-alerta error">Error</span>',
                                html: `
                                    <div class="custom-alert">
                                        <div class="contenedor-imagen">
                                            <img src="../imagenes/llave.png" alt="Error" class="llave">
                                        </div>
                                        <p>No se pudo eliminar la ubicación.</p>
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
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: '<span class="titulo-alerta error">Error</span>',
                            html: `
                                <div class="custom-alert">
                                    <div class="contenedor-imagen">
                                        <img src="../imagenes/llave.png" alt="Error" class="llave">
                                    </div>
                                    <p>No se pudo eliminar la ubicación. Puede tener productos asociados.</p>
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
                        });
                    });
                }
            });
            }
    });
        
});



  </script>
</body>
</html>
