<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

//require_once $_SERVER['DOCUMENT_ROOT'] . '../html/verificar_permisos.php';

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

    $query = "INSERT INTO marca (codigo, nombre) VALUES ('$codigo', '$nombre')";

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
                    <p>Marca agregada correctamente.</p>
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
                <p>La marca no fue agregada.<br><small>$error</small></p>
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
// Eliminar marca mediante boton
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);

    $query = "DELETE FROM marca WHERE codigo = '$codigo'";
    $resultado = mysqli_query($conexion, $query);

    // Responder solo con JSON
    echo json_encode(["success" => $resultado]);
    exit();
}


// Obtener lista de productos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lista'])) {
    $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);

    // En tu archivo PHP (marca.php), verifica que la consulta incluya el código:
    $query = "SELECT codigo1, nombre FROM producto WHERE Marca_codigo = '$codigo'";
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
    <title>Marca</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="/css/marca.css">
    <link rel="stylesheet" href="../componentes/header.css">
    <link rel="stylesheet" href="../componentes/header.php">
    <script defer src="../js/index.js"></script> <!-- Cargar el JS de manera correcta -->
    <script src="../js/header.js"></script>
    <!--<script src="../js/marcas.js"></script>-->
</head>

<body>
    <div id="menu"></div>
    <div id="categorias" class="form-section">
        <h1>Marca</h1>
        <div class="container">
            <div class="actions">
                <button id="btnAbrirModal" class="btn-nueva-categoria"><i class='bx bx-plus bx-tada'></i>Nueva marca</button>
            </div>

            <table class="category-table">
                <tbody id="tabla-marcas">
                    <?php
                    $marcas = $conexion->query("SELECT * FROM Marca ORDER BY codigo ASC");
                    while ($fila = $marcas->fetch_assoc()) {
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
    <div id="modal" class="modal">
        <div class="modal-content">
            <h2>Nueva marca</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Ingrese el código:</label>
                    <input type="text" id="codigo" name="codigo" required />
                    <label>Ingrese el nombre de la marca:</label>
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
            <h2>Productos de esta marca</h2>
            <div id="lista-productos">
                <!-- Aquí se insertará la tabla o lista de productos -->
            </div>
        </div>
    </div>


   <script>
document.addEventListener("DOMContentLoaded", function() {
    const tablaMarcas = document.getElementById("tabla-marcas");
    const modalProductos = document.getElementById("modalProductos");
    const closeModal = modalProductos.querySelector('.close');

    // Mostrar modal con animación
    function mostrarModal() {
        modalProductos.classList.remove("hide");
        modalProductos.classList.add("show");
    }

    // Ocultar modal con animación
    function ocultarModal() {
        modalProductos.classList.remove("show");
        modalProductos.classList.add("hide");
        setTimeout(() => {
            modalProductos.classList.remove("hide");
        }, 300); // Duración de la animación
    }

    // Cerrar modal al hacer clic fuera del contenido
    modalProductos.addEventListener("click", function(event) {
        if (event.target === modalProductos) {
            ocultarModal();
        }
    });

    // Cerrar modal al hacer clic en la "X"
    closeModal.addEventListener("click", function() {
        ocultarModal();
    });

    if (!tablaMarcas) {
        console.error("No se encontró el elemento con id 'tabla-marcas'");
        return;
    }

    // Delegación de eventos para tabla de marcas
    tablaMarcas.addEventListener("click", function(event) {
        const target = event.target;

        // BOTÓN: Lista de productos
        if (target.classList.contains("btn-list")) {
            const marca_id = target.getAttribute("data-id");

            fetch("../html/marca.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `lista=1&codigo=${marca_id}`
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
                                <p>No hay productos en esta marca.</p>
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
    });

    // EVENTO: Eliminar marca (fuera de la tabla, delegación global)
    document.addEventListener("click", function (e) {
        let target = e.target;

        // Si se hace clic en el ícono dentro del botón, subir al botón
        if (target.tagName === "I" && target.parentElement.classList.contains("btn-delete")) {
            target = target.parentElement;
        }

        // BOTÓN: Eliminar marca
        if (target.classList.contains("btn-delete")) {
            const codigo = target.getAttribute("data-id");

            Swal.fire({
                title: '<span class="titulo-alerta advertencia">¿Está seguro?</span>',
                html: `
                    <div class="custom-alert">
                        <div class="contenedor-imagen">
                            <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                        </div>
                        <p>Esta acción eliminará la marca.<br>¿Desea continuar?</p>
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
                    fetch("../html/marca.php", {
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
                                        <p>Marca eliminada correctamente.</p>
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
                                        <p>No se pudo eliminar la marca.</p>
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
                                    <p>No se pudo eliminar la marca. Puede tener productos asociados.</p>
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

}); // ← Fin del DOMContentLoaded
</script>





</body>

</html>