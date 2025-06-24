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
// --- AJAX: validar nombre de ubicación único ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_ubicacion'])) {
$nombre = mysqli_real_escape_string($conexion, trim($_POST                                                                                                                                  ['nombre']));                                                                                                                                                                                                                                                                                                                                                 
$sql = "SELECT COUNT(*) AS cnt FROM ubicacion WHERE nombre = '$nombre'";
$res = mysqli_query($conexion, $sql);
$row = mysqli_fetch_assoc($res);
echo json_encode(['exists' => ($row['cnt'] > 0)]);
    exit;
}

// justo tras conectar a BD
$allQ = "SELECT codigo,nombre FROM ubicacion c";
if (!empty($filtros)) $allQ .= " WHERE " . implode(' OR ', $filtros);
$allRes = mysqli_query($conexion, $allQ);
$allData = mysqli_fetch_all($allRes, MYSQLI_ASSOC);

// Agregar Ubicacion
if ($_POST && isset($_POST['guardar'])) {
    if (!$conexion) {
        die("<script>alert('No se pudo conectar a la base de datos');</script>");
    };
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);

    $query = "INSERT INTO ubicacion (nombre) VALUES ('$nombre')";

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

    $query = "SELECT codigo1, nombre FROM producto WHERE Ubicacion_codigo = '$codigo'";

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
    <link rel="stylesheet" href="../css/alertas.css">
    <link rel="stylesheet" href="../componentes/header.css">
    <link rel="stylesheet" href="../componentes/header.php">
    <script src="../js/header.js"></script>
    <script defer src="../js/index.js"></script> <!-- Cargar el JS de manera correcta -->
    <!--<script src="/js/ubicaciones.js"></script>-->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
</head>

<body>
    <?php include 'boton-ayuda.php'; ?>
    <script>
        const allData = <?php echo json_encode($allData, JSON_HEX_TAG | JSON_HEX_APOS); ?>;
        </script>
    <div id="menu"></div>
    <div class="ubica"> Productos / Ubicación</div>
     <div class="container-general">
    </div>
    <div id="categorias" class="form-section">
        <h1>Ubicación</h1>
        <div class="container">
            <div class="actions">
                <button id="btnAbrirModal" class="btn-nueva-categoria"><i class='bx bx-plus bx-tada'></i>Nueva ubicación</button>  
            <input type="text" id="searchRealtime" name="valor" placeholder="Ingrese la ubicación a buscar">
             </div>
            <table class="category-table">
                <thead>
                    <tr>
                        <th data-col="0" data-type="string">Nombre<span class="sort-arrow"></span></th>
                        <th data-col="1" data-type="string">Acciones<span class="usort-arrow"></span></th>
                    </tr>
                </thead>
                <tbody id="tabla-ubicaciones">
                    <?php
                    $ubicaciones = $conexion->query("SELECT * FROM ubicacion ORDER BY codigo ASC");
                    while ($fila = $ubicaciones->fetch_assoc()) {
                        echo "<tr>";
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
            <div id="jsPagination" class="pagination-dinamica"></div>
        </div>
    </div>

    <!-- Modal Nueva Ubicación -->
    <div id="modalNuevo" class="modal_nueva_ubicacion">
        <div class="modal-content-nueva">
            <h2>Nueva ubicación</h2>
            <form method="POST" action="">
                <div class="form-group" style="position: relative;">
                    <label>Ingrese el nombre de la ubicación:</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        required/>
                    <span id="nombre-error" class="input-error-message">
                        Esta ubicación ya está registrada.
                    </span>
                </div>
                <div class="modal-buttons">
                    <button type="button" id="btnCancelar">Cancelar</button>
                    <button type="submit" name="guardar" id="btnGuardar" disabled>Guardar</button>
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // — Datos iniciales inyectados por PHP —
            const allCategories = <?php
                                    $cats = [];
                                    $res = $conexion->query("SELECT codigo, nombre FROM ubicacion ORDER BY nombre ASC");
                                    while ($r = $res->fetch_assoc()) $cats[] = $r;
                                    echo json_encode($cats, JSON_HEX_TAG | JSON_HEX_APOS);
                                    ?>;

            const tableBody = document.getElementById('tabla-ubicaciones');
            const searchInput = document.getElementById('searchRealtime');
            const paginationEl = document.getElementById('jsPagination');

            let filtered = [...allCategories];
            const rowsPerPage = 10;
            let currentPage = 1;

            function renderTable() {
                tableBody.innerHTML = '';
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                filtered.slice(start, end).forEach(cat => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
        <td>${cat.nombre}</td>
        <td class="td-options">
          <button class="btn-list boton-accion marcarL" data-id="${cat.codigo}">Productos</button>
          <button class="btn-delete boton-accion marcarN" data-id="${cat.codigo}">
            <i class="fa-solid fa-trash"></i>
          </button>
        </td>`;
                    tableBody.appendChild(tr);
                });
                renderPagination();
            }
            // —ANIMACIONES Modal de Nueva Categoría —
            const modalNuevaUbicacion = document.getElementById('modalNuevo'); // Asegúrate de que el ID sea 'modal'
            const btnAbrirNuevaUbicacion = document.getElementById('btnAbrirModal'); // Asume este ID para el botón de abrir
            const btnCancelarNuevaUbicacion = modalNuevaUbicacion.querySelector('#btnCancelar');

            if (btnAbrirNuevaUbicacion) {
                btnAbrirNuevaUbicacion.addEventListener('click', () => {
                    modalNuevaUbicacion.classList.add('show');
                });
            }

            if (btnCancelarNuevaUbicacion) {
                btnCancelarNuevaUbicacion.addEventListener('click', () => {
                    modalNuevaUbicacion.classList.remove('show');
                });
            }

            if (modalNuevaUbicacion) {
                modalNuevaUbicacion.addEventListener('click', (e) => {
                    if (e.target === modalNuevaUbicacion) {
                        modalNuevaUbicacion.classList.remove('show');
                    }
                });
            }
            // — cierre del modal de productos —
            const modalProductos = document.getElementById('modalProductos');
            const closeBtnModalProductos = modalProductos.querySelector('.close');
            // Función para ocultar
            function hideProductosModal() {
                modalProductos.classList.remove('show');
            }
            // Cerrar al pulsar la X
            if (closeBtnModalProductos) {
                closeBtnModalProductos.addEventListener('click', hideProductosModal);
            }
            // Cerrar al hacer clic fuera del contenido
            if (modalProductos) {
                modalProductos.addEventListener('click', (e) => {
                    if (e.target === modalProductos) {
                        hideProductosModal();
                    }
                });
            }

            function renderPagination() {
                paginationEl.innerHTML = '';
                const totalPages = Math.ceil(filtered.length / rowsPerPage);
                if (totalPages <= 1) return;
                const btnFactory = (txt, pg) => {
                    const b = document.createElement('button');
                    b.textContent = txt;
                    if (pg === currentPage) b.classList.add('active');
                    b.addEventListener('click', () => {
                        currentPage = pg;
                        renderTable();
                    });
                    return b;
                };

                // « First, ‹ Prev
                paginationEl.appendChild(btnFactory('« Primera', 1));
                paginationEl.appendChild(btnFactory('‹ Anterior', Math.max(1, currentPage - 1)));
                // pages
                let start = Math.max(1, currentPage - 2),
                    end = Math.min(totalPages, currentPage + 2);
                if (start > 1) paginationEl.append('…');
                for (let i = start; i <= end; i++) {
                    paginationEl.appendChild(btnFactory(i, i));
                }
                if (end < totalPages) paginationEl.append('…');
                // › Next, » Last
                paginationEl.appendChild(btnFactory('Siguiente ›', Math.min(totalPages, currentPage + 1)));
                paginationEl.appendChild(btnFactory('Última »', totalPages));
            }

            // búsqueda en tiempo real
            searchInput.addEventListener('input', () => {
                const q = searchInput.value.trim().toLowerCase();
                filtered = allCategories.filter(cat =>
                    cat.nombre.toLowerCase().includes(q)
                );
                currentPage = 1;
                renderTable();
            });

            // manejo de clics en botones List y Delete
            tableBody.addEventListener('click', e => {
                const btn = e.target.closest('button');
                if (!btn) return;
                const id = btn.dataset.id;

                if (btn.classList.contains('btn-list')) {
                    // Listar productos
                    fetch('../html/ubicacion.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `lista=1&codigo=${id}`
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.length) {
                                const html = `
            <table class="productos-table" style="width:100%">
              <thead><tr><th>Código</th><th>Nombre</th></tr></thead>
              <tbody>
                ${data.map(p => `
                  <tr>
                    <td>${p.codigo1 || ''}</td>
                    <td>${p.nombre   || ''}</td>
                  </tr>`).join('')}
              </tbody>
            </table>`;
                                document.getElementById('lista-productos').innerHTML = html;
                                document.getElementById('modalProductos').classList.add('show');
                            } else {
                                Swal.fire({
                                    title: '<span class="titulo-alerta advertencia">Sin productos</span>',
                                    html: `
                  <div class="custom-alert">
                    <div class="contenedor-imagen">
                      <img src="../imagenes/llave.png" alt="Sin productos" class="llave">
                    </div>
                    <p>No hay productos en esta ubicación.</p>
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
                } else if (btn.classList.contains('btn-delete')) {
                    // Eliminar ubicacion
                    Swal.fire({
                        title: '<span class="titulo-alerta advertencia">¿Está seguro?</span>',
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
                            confirmButton: 'btn-eliminar',
                            cancelButton: 'btn-cancelar',
                            container: 'fondo-oscuro'
                        }
                    }).then(res => {
                        if (res.isConfirmed) {
                            fetch('../html/ubicacion.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: `eliminar=1&codigo=${id}`
                                })
                                .then(r => r.json())
                                .then(resp => {
                                    if (resp.success) {
                                        Swal.fire({
                                                title: '<span class="titulo-alerta confirmacion">Eliminado</span>',
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
                                            })
                                            .then(() => {
                                                // refrescar datos en cliente
                                                const idx = allCategories.findIndex(c => c.codigo === id);
                                                if (idx > -1) allCategories.splice(idx, 1);
                                                filtered = filtered.filter(c => c.codigo !== id);
                                                renderTable();
                                            });
                                    } else {
                                      Swal.fire({
                    title: '<span class="titulo-alerta error">Error</span>',
                    html: `
                      <div class="custom-alert">
                        <div class="contenedor-imagen">
                          <img src="../imagenes/llave.png" alt="Error" class="llave">
                        </div>
                        <p>No se pudo eliminar la ubicación porque hay productos asociados.</p>
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
                                .catch(() => Swal.fire({
                  title: '<span class="titulo-alerta error">Error</span>',
                  html: `
                    <div class="custom-alert">
                      <div class="contenedor-imagen">
                        <img src="../imagenes/llave.png" alt="Error" class="llave">
                      </div>
                      <p>No se pudo eliminar la ubicación porque hay productos asociados..</p>
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
              }));
            }
          });
        }
      });

            // inicializar
            renderTable();
        });


        //ventana para que no se repita ubicacion
        // Referencias
        const nombreInput = document.getElementById('nombre');
        const btnGuardar = document.getElementById('btnGuardar');
        const btnAbrir = document.getElementById('btnAbrirModal');
        let nombreValido = false;

        // AJAX de validación
        async function validarUbicacion(nombre) {
            try {
                const form = new URLSearchParams();
                form.append('check_ubicacion', '1');
                form.append('nombre', nombre.trim());
                const res = await fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: form.toString()
                });
                const json = await res.json();
                return !json.exists;
            } catch (e) {
                console.error(e);
                return false;
            }
        }

        // Listener en tiempo real
        nombreInput.addEventListener('input', async () => {
            const val = nombreInput.value.trim();
            nombreValido = val ? await validarUbicacion(val) : false;

            if (!nombreValido) {
                nombreInput.classList.add('invalid');
            } else {
                nombreInput.classList.remove('invalid');
            }
            btnGuardar.disabled = !nombreValido;
        });

        // Al abrir el modal, resetear estado
        btnAbrir.addEventListener('click', () => {
            nombreInput.value = '';
            nombreInput.classList.remove('invalid');
            btnGuardar.disabled = true;
        });
    </script>

</body>

</html>