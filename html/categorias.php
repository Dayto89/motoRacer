<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.php");
  exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '../html/verificar_permisos.php';


$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
  die("<script>alert('No se pudo conectar a la base de datos');</script>");
}

// Agregar categoría
if ($_POST && isset($_POST['guardar'])) {
  if (!$conexion) {
    die("<script>alert('No se pudo conectar a la base de datos');</script>");
  };
  $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);
  $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);

  $query = "INSERT INTO categoria (codigo, nombre) VALUES ('$codigo', '$nombre')";

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
                    <p>Categoría agregada correctamente.</p>
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
                <p>La categoría no fue agregada.<br><small>$error</small></p>
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
// Eliminar categoría mediante boton
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
  $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);

  $query = "DELETE FROM categoria WHERE codigo = '$codigo'";
  $resultado = mysqli_query($conexion, $query);

  // Responder solo con JSON
  echo json_encode(["success" => $resultado]);
  exit();
}


// Obtener lista de productos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lista'])) {
  $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);

  $query = "SELECT codigo1, nombre FROM producto WHERE Categoria_codigo = '$codigo'";
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
  <title>Categorías</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="/css/categorias.css">
  <link rel="stylesheet" href="../css/alertas.css">
  <link rel="stylesheet" href="../componentes/header.css">
  <link rel="stylesheet" href="../componentes/header.php">
  <script src="../js/header.js"></script>
  <script defer src="../js/index.js"></script> <!-- Cargar el JS de manera correcta -->

</head>

<body>
  <div id="menu"></div>
  <div id="categorias" class="form-section">
    <h1>Categorías</h1>
    <div class="container">
      <div class="actions">
        <button id="btnAbrirModal" class="btn-nueva-categoria"><i class='bx bx-plus bx-tada icon'></i>Nueva categoría</button>
      </div>

      <table class="category-table">
        <thead>
          <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="tabla-categorias">
          <?php
          $categorias = $conexion->query("SELECT * FROM categoria ORDER BY codigo ASC");
          while ($fila = $categorias->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($fila['codigo']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
            echo "<td class='td-options'>";
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
  <div id="modal" class="modal_nueva_categoria">
    <div class="modal-content-nueva">
      <h2>Nueva categoría</h2>
      <form method="POST" action="">
        <div class="form-group">
          <label>Ingrese el código:</label>
          <input type="text" id="codigo" name="codigo" required />
          <label>Ingrese el nombre de la categoría:</label>
          <input type="text" id="nombre" name="nombre" required />
        </div>
        <div class="modal-buttons">
          <button type="button" id="btnCancelar">Cancelar</button>
          <button type="submit" name="guardar" id="btnGuardar">Guardar</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Modal para Lista de Productos -->
  <div id="modalProductos" class="modal">
    <div class="modal-content">
      <span class="close">
        <i class="fa-solid fa-x"></i>
      </span>
      <h2>Productos de la categoría</h2>
      <div id="lista-productos" class="productos-container">
        <!-- Los productos se cargarán aquí dinámicamente -->
      </div>
    </div>
  </div>
 <script>
  document.addEventListener("DOMContentLoaded", function () {
    const tablaCategorias = document.getElementById("tabla-categorias");
    const modalProductos = document.getElementById("modalProductos");
    const closeModal = modalProductos.querySelector('.close');

    function mostrarModal() {
      modalProductos.classList.remove("hide");
      modalProductos.classList.add("show");
    }

    function ocultarModal() {
      modalProductos.classList.remove("show");
      modalProductos.classList.add("hide");
      setTimeout(() => {
        modalProductos.classList.remove("hide");
      }, 300);
    }

    modalProductos.addEventListener("click", function (event) {
      if (event.target === modalProductos) {
        ocultarModal();
      }
    });

    closeModal.addEventListener("click", function () {
      ocultarModal();
    });

    if (!tablaCategorias) {
      console.error("No se encontró el elemento con id 'tabla-categorias'");
      return;
    }

    tablaCategorias.addEventListener("click", function (event) {
      let target = event.target;

      // Si se hace clic en el ícono dentro del botón, subimos al botón
      if (target.tagName === "I" && target.parentElement.classList.contains("btn-delete")) {
        target = target.parentElement;
      }

      // BOTÓN: Lista de productos
      if (target.classList.contains("btn-list")) {
        const categorias_id = target.getAttribute("data-id");

        fetch("../html/categorias.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: `lista=1&codigo=${categorias_id}`
        })
          .then(response => response.json())
          .then(data => {
            if (data.length > 0) {
              const listaHTML = `
              <table class="productos-table" style="width: 100%;">
                <thead>
                  <tr>
                    <th style="width: 30%;">Código</th>
                    <th style="width: 70%;">Nombre</th>
                  </tr>
                </thead>
                <tbody>
                  ${data.map(p => `
                    <tr>
                      <td>${p.codigo1 || 'N/A'}</td>
                      <td>${p.nombre || 'N/A'}</td>
                    </tr>
                  `).join('')}
                </tbody>
              </table>`;
              document.getElementById("lista-productos").innerHTML = listaHTML;
              mostrarModal();
            } else {
              Swal.fire({
                title: '<span class="titulo-alerta advertencia">Sin productos</span>',
                html: `
                  <div class="custom-alert">
                    <div class="contenedor-imagen">
                      <img src="../imagenes/llave.png" alt="Sin productos" class="llave">
                    </div>
                    <p>No hay productos en esta categoria.</p>
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
            console.error("Error al obtener productos:", error);
          });
      }

      // BOTÓN: Eliminar categoría
      if (target.classList.contains("btn-delete")) {
        const codigo = target.getAttribute("data-id");

        Swal.fire({
          title: '<span class="titulo-alerta advertencia">¿Está seguro?</span>',
          html: `
            <div class="custom-alert">
              <div class="contenedor-imagen">
                <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
              </div>
              <p>Esta acción eliminará la categoría.<br>¿Desea continuar?</p>
            </div>
          `,
          showCancelButton: true,
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar',
          background: '#ffffffdb',
         
          customClass: {
            popup: 'swal2-border-radius',
            confirmButton: 'btn-eliminar',
            cancelButton: 'btn-cancelar',
            container: 'fondo-oscuro'
          }
        }).then((result) => {
          if (result.isConfirmed) {
            fetch("../html/categorias.php", {
              method: "POST",
              headers: {
                "Content-Type": "application/x-www-form-urlencoded"
              },
              body: `eliminar=1&codigo=${codigo}`
            })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  Swal.fire({
                    title: '<span class="titulo-alerta confirmacion">Eliminado</span>',
                    html: `
                      <div class="custom-alert">
                        <div class="contenedor-imagen">
                          <img src="../imagenes/moto.png" alt="Éxito" class="moto">
                        </div>
                        <p>Categoría eliminada correctamente.</p>
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
                        <p>No se pudo eliminar la categoría.</p>
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
                      <p>No se pudo eliminar la categoría.</p>
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