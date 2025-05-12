<?php
session_start();
ob_clean();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

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
  
  $query = "SELECT * FROM producto WHERE Categoria_codigo = '$codigo'";
  $resultado = mysqli_query($conexion, $query);
  
  $productos = [];
  while ($fila = mysqli_fetch_assoc($resultado)) {
    $productos[] = $fila;
  }

  header('Content-Type: application/json');
  echo json_encode($productos);
  exit();
}

include_once $_SERVER['DOCUMENT_ROOT'].'/componentes/accesibilidad-widget.php';

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
  <link rel="stylesheet" href="../componentes/header.css">
  <link rel="stylesheet" href="../componentes/header.php">
  <script src="../js/header.js"></script>
  <script defer src="../js/index.js"></script> <!-- Cargar el JS de manera correcta -->
  <script src="/js/categorias.js"></script>
</head>
<body>
    <style>
        /* Reseteo y estilo global */
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
  
}
body::before {
  position: fixed;
  width: 200%;
  height: 200%;
  z-index: -1;
  background: black;
  opacity: 0.6;
}

/* Título principal */
#categorias h1 {
  font-size: 50px;
  margin-top: 92px;
  color: white;
  text-shadow: 7px -1px 0 #1c51a0, 1px -1px 0 #1c51a0, -1px 1px 0 #1c51a0, 3px 5px 0 #1c51a0;
  margin-left: 871px;
  letter-spacing: 5px;
  padding: 18px;
  letter-spacing: 5px;
}

/* Contenedor principal */
.container {
  background-color: rgb(174 174 174 / 59%);
  padding: 44px;
  border-radius: 15px;
  max-width: 1079px;
  margin-left: 482px;
}

/* Botón para agregar categoría */
.btn-nueva-categoria {
  background-color: #1167CC;
  color: white;
  font-size: 17px;
  font-weight: bold;
  padding: 13px 21px;
  border: none;
  border-radius: 11px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin-bottom: 15px;
}

.btn-nueva-categoria:hover {
  background-color: #0056b3;
}
h3{
  color: black;
  color: rgb(0, 0, 0);
  margin-left: 401px;
  margin-top: -12px;
  padding: initial;
  margin-bottom: 30px;
  font-size: 23px;
  text-shadow: 2.8px -1px 0 #007bff
}
/* Tabla de categorías */
.category-table {
  width: 100%;
   
  
}

.category-table td {
  text-align: center;
  font-family: Arial, sans-serif;
  width: 225px;
  padding: 5px;
}

.category-table th {
  background-color: #98bde9;
  color: #0b111a;
}

.category-table tr:nth-child(even) {
  background-color: #f9f9f9b7;
  color: black;
}

.category-table tr:nth-child(odd) {
  background-color: rgb(33 32 32 / 59%);
  color: white;
}

.options {
      gap: 39px;
      margin-left: 260px;
}

.btn-list, .btn-delete { 
  padding: 4px 10px; /* Reducir el padding para angostar */
  border: none;
  border-radius: 15px;
  color: rgb(255, 255, 255);
  cursor: pointer;
  font-size: 14px; /* Reducir ligeramente el tamaño del texto */
  white-space: nowrap; /* Mantener el texto en una sola línea */
  text-align: center; /* Centrar el texto dentro del botón */
}
.btn-list {
  background-color: #0965c7;
  margin-left: 10px; /* Ajusta el margen entre los botones y el texto si es necesario */
border: 2px solid #0b111a;
margin-right: 10px;
}

.btn-list:hover {
  background-color: #0056b3; /* Color de fondo al pasar el mouse sobre una fila */
}

.btn-delete {
  background-color: #fa163c;
  margin-left: 10px; /* Ajusta el margen entre los botones y el texto si es necesario */
  border: 2px solid #0b111a;
}

.btn-delete:hover {
  background-color: #a71d2a;
}


/* Ocultar el modal por defecto */
.modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  justify-content: center;
  align-items: center;
  z-index: 1000;
  opacity: 0; /* Inicialmente oculto */
  transform: translateY(-50px); /* Inicia desplazado hacia arriba */
  transition: opacity 0.3s ease, transform 0.3s ease; /* Transiciones suaves */
}

/* Mostrar el modal con animación */
.modal.show {
  display: flex;
  opacity: 1;
  transform: translateY(0); /* Se desliza a su posición */
}

/* Ocultar el modal con animación */
.modal.hide {
  opacity: 0;
  transform: translateY(-50px); /* Se desliza hacia arriba */
  transition: opacity 0.3s ease, transform 0.3s ease;
}
/* Contenido del modal */
.modal-content {
background-color: rgba(200, 200, 200, 0.76);
padding: 20px;
border-radius: 10px;
width: 400px;
text-align: center;
box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
animation: slideIn 0.3s ease-out;
}



/* Botón de cerrar */
.btn-cerrar {
display: inline-block;
text-decoration: none;
text-align: center;
background-color: #df2f2f;
color: white;
padding: 10px 15px;
cursor: pointer;
border-radius: 10px;
font-weight: bold;
font-size: 16px;
}

/* Cambio de color al pasar el mouse */
.btn-cerrar:hover {
background-color: #a71d2a;
}



.modal-content h2 {

  font-size: 32px;
  margin-top: -7px;
  color: white;
  text-shadow:4px -2px 0 #1c51a0, -3px -1px 0 #1c51a0, -3px 1px 0 #1c51a0, -2px 3px 0 #1c51a0; 
  margin-left: 13px;
  letter-spacing: 5px;
  padding: 28px;
  
}

/* Botones del modal */
.modal-buttons {
  display: flex;
  gap: 34px;
  justify-content: center;
  border-radius: 10px;
  font-weight: bold;
}

#btnCancelar {
  background-color: #df2f2f;
  color: white;
  padding: 10px 15px;
  cursor: pointer;
  border: none;
  border-radius: 10px;
  font-weight: bold;
  font-size: 16px;
}

#btnCancelar:hover {
  background-color: #a71d2a;
}

button[type="submit"] {
  background-color: #007bff;
  color: white;
  padding: 10px 15px;
  cursor: pointer;
  border: none;
  border-radius: 10px;
  font-weight: bold;
  font-size: 16px;
}

button[type="submit"]:hover {
  background-color: #0056b3;
}
.form-group label{
  font-family: Arial, Helvetica, sans-serif;
  color: black;
  size: 50px;
  font-weight: bold;
}
/* Estilo para los inputs del formulario */
input[type="text"] {
width: 89%;
padding: 8px;
font-size: 16px; /* Tamaño del texto */
border: 1px solid #ccc; /* Borde del input */
border-radius: 5px; /* Bordes redondeados */
box-sizing: border-box; /* Asegura que padding no afecte el ancho total */
margin-top: 26px;
margin-bottom: 18px;
}


.bx-tada {
color: #fdfcfc;
transition: color 0.3s;
}

/*Alertas*/

  
  /* Estilos generales de los párrafos */
  p {
    font-size: 16px;
    color: black;
    font-family: arial;
    padding: 10px;
  }
  

  
  /* Ajuste para el popup de SweetAlert */
  div:where(.swal2-container).swal2-center>.swal2-popup {
    width: 28%; /* Se ajusta automáticamente */
    max-width: 350px; /* Define un límite de ancho */
  }
  
  

.custom-alert .tornillo, .custom-alert .moto, .custom-alert .llave {
    width: 201px;
    height: 145px;
}

  
  
  /* Contenedor de la imagen */
  .contenedor-imagen {
    position: relative;
    display: inline-block;
  }



.titulo-alerta {
    font-size: 28px;
    font-weight: bold;
    display: block;
    margin-bottom: 10px;
    font-family: 'Arial Black', sans-serif;
    letter-spacing: 1px;
}

.titulo-alerta.confirmacion {
    font-family: 'Metal Mania', system-ui;
    font-size: 1.01em;
    letter-spacing: 3px;
    color: #9b9496;
    text-shadow: -1px -1px 0 #000000, 1px -1px 0 #000, -1px 1px 0 #000, 3px 3px 0 #000;
    margin: auto;
}
.titulo-alerta.error {
    font-family: 'Metal Mania', system-ui;
    font-size: 1.01em;
    letter-spacing: 3px;
    color: #af3b3b;
    text-shadow: -1px -1px 0 #000000, 1px -1px 0 #000, -1px 1px 0 #000, 3px 3px 0 #000;
    margin: auto;
}
.titulo-alerta.advertencia {
    font-family: 'Metal Mania', system-ui;
    font-size: 1.01em;
    letter-spacing: 3px;
    color:#e09804;
    text-shadow: -1px -1px 0 #000000, 1px -1px 0 #000, -1px 1px 0 #000, 3px 3px 0 #000;
    margin: auto;
}


.btn-aceptar {
    background-color: #007bff !important;
    color: white !important;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px;
}

/* Botón de "Sí, eliminar" */
.btn-eliminar {
  border: 0;
  border-radius: 1em;
  background-color: #a10505; /* Rojo */
  color: #fff;
  font-size: 1em;
}

/* Botón de "Cancelar" */
.btn-cancelar {
  border: 0;
  border-radius: 1em;
  background-color: #54728d; /* Azul */
  color: #fff;
  font-size: 1em;
}



.swal2-border-radius {
    border-radius: 5px !important;
}



.fondo-oscuro {
    background-color: rgba(0, 0, 0, 0.7) !important; /* Fondo oscuro */
    backdrop-filter: blur(2px); /* Opcional: desenfoque sutil */
}

.swal2-popup {
    border-radius: 20px;
}

/* MÓVILES */
/* Horizontal */
@media screen and (max-width: 870px) and (orientation: landscape) {

}

/* Vertical */
@media screen and (max-width: 767px) and (orientation: portrait) {

}


/* TABLETS */
/* Horizontal */
@media (min-width: 871px) and (max-width: 1023px) and (orientation: landscape) {

}

/* Vertical */
@media screen and (min-width: 870px) and (max-width: 1023px) and (orientation: portrait) {

}



    </style>
  <div id="menu"></div>
  <div id="categorias" class="form-section">
    <h1>Categorías</h1>
    <div class="container">
      <div class="actions">
        <button id="btnAbrirModal" class="btn-nueva-categoria"><i class='bx bx-plus bx-tada icon'></i>Nueva categoría</button>
      </div>
      
      <table class="category-table">
        <tbody id="tabla-categorias">
          <?php
          $categorias = $conexion->query("SELECT * FROM categoria ORDER BY codigo ASC");
          while ($fila = $categorias->fetch_assoc()) {
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
      <h2>Nueva categoría</h2>
      <form  method="POST" action="">
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

  <div id="productosModal" class="modal">
  <div class="modal-content">
    <span class="close-btn">&times;</span>
    <h2>Lista de Productos</h2>
    <div id="productosContenido">
      <p>Cargando productos...</p>
    </div>
  </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM cargado, inicializando eventos.");

    const tablaCategorias = document.getElementById("tabla-categorias");
    const modal = document.getElementById("productosModal");
    const modalContent = document.getElementById("productosContenido");
    const closeBtn = document.querySelector("#productosModal .close-btn");

    if (!tablaCategorias) {
        console.error("No se encontró el elemento con id 'tabla-categorias'");
        return;
    }

    // CLIC EN TABLA
    tablaCategorias.addEventListener("click", function (event) {
        const target = event.target;
        console.log("Clic detectado en:", target);

        // BOTÓN LISTA
        if (target.classList.contains("btn-list")) {
            const codigo = target.dataset.id;

            modal.classList.add("show");
            modalContent.innerHTML = "<p>Cargando productos...</p>";

            fetch("pruebamodal.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({ lista: true, codigo: codigo })
            })
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    let html = "<ul>";
                    data.forEach(producto => {
                        html += `<li><strong>${producto.nombre}</strong>: ${producto.descripcion}</li>`;
                    });
                    html += "</ul>";
                    modalContent.innerHTML = html;
                } else {
                    modalContent.innerHTML = "<p>No hay productos en esta categoría.</p>";
                }
            })
            .catch(error => {
                modalContent.innerHTML = "<p>Error al cargar productos.</p>";
                console.error(error);
            });
        }

        // BOTÓN ELIMINAR
        if (target.classList.contains("btn-delete")) {
            const codigo = target.dataset.id;

            Swal.fire({
                title: '<span class="titulo-alerta advertencia">¿Esta seguro?</span>',
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
                    confirmButton: 'btn-eliminaar',
                    cancelButton: 'btn-cancelar',
                    container: 'fondo-oscuro'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("../html/categorias.php", {
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
                                    <p>No se pudo eliminar la categoría. Puede tener productos asociados.</p>
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

   // CERRAR MODAL con animación
closeBtn.addEventListener("click", function () {
    cerrarModalConAnimacion();
});

window.addEventListener("click", function (event) {
    if (event.target === modal) {
        cerrarModalConAnimacion();
    }
});

// Función para cerrar el modal con animación
function cerrarModalConAnimacion() {
    modal.classList.remove("show");
    modal.classList.add("hide");

    // Esperar a que termine la transición antes de ocultarlo completamente
    setTimeout(() => {
        modal.classList.remove("hide");
    }, 300); // Debe coincidir con el tiempo de transición del CSS
}

});
</script>

</body>
</html>
