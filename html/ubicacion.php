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

        .boton-accion {
            padding: 5px 10px;
            margin: 2px;
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .boton-accion:hover {
            background-color: #5a6268;
        }

        .pagination {
            display: none;
        }

        .pagination-dinamica {
            display: flex;
            justify-content: center;
            margin-top: 23px;
            gap: 12px;
            font-family: arial;
            font-size: 11px;
        }

        .pagination-dinamica button {
            padding: 8px 12px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            text-decoration: none;
            color: #333;
            border-radius: 4px;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .pagination-dinamica button:hover {
            background-color: rgb(158, 146, 209);
        }

        .pagination-dinamica button.active {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            pointer-events: none;
            border-color: #007bff;
            text-shadow: none;
        }

        .marcarN {
            background-color: rgb(128, 0, 0);
        }

        .marcarN:hover {
            background-color: rgb(255, 0, 0);
        }

        .marcarL {
            background-color: rgb(11, 128, 0);
        }

        .marcarL:hover {
            background-color: rgb(15, 184, 0);
        }
    </style>
</head>

<body>
    <script>
        const allData = <?php echo json_encode($allData, JSON_HEX_TAG | JSON_HEX_APOS); ?>;
    </script>
    <div id="menu"></div>
    <div id="categorias" class="form-section">
        <h1>Ubicación</h1>
        <div class="container">
            <div class="actions">
                <button id="btnAbrirModal" class="btn-nueva-categoria"><i class='bx bx-plus bx-tada'></i>Nueva ubicación</button>
            </div>
            <input type="text" id="searchRealtime" name="valor" placeholder="Ingrese el valor a buscar">
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

    <!-- Modal -->
    <div id="modal" class="modal_nueva_ubicacion">
        <div class="modal-content-nueva">
            <h2>Nueva ubicación</h2>
            <form method="POST" action="">
                <div class="form-group">
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
            const rowsPerPage = 7;
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

            // — cierre del modal de productos —
            const modalProductos = document.getElementById('modalProductos');
            const closeBtn = modalProductos.querySelector('.close');

            // Función para ocultar
            function hideProductosModal() {
                modalProductos.classList.remove('show');
            }

            // Cerrar al pulsar la X
            closeBtn.addEventListener('click', hideProductosModal);

            // Cerrar al hacer clic fuera del contenido
            modalProductos.addEventListener('click', (e) => {
                if (e.target === modalProductos) {
                    hideProductosModal();
                }
            });

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
                paginationEl.appendChild(btnFactory('«', 1));
                paginationEl.appendChild(btnFactory('‹', Math.max(1, currentPage - 1)));
                // pages
                let start = Math.max(1, currentPage - 2),
                    end = Math.min(totalPages, currentPage + 2);
                if (start > 1) paginationEl.append('…');
                for (let i = start; i <= end; i++) {
                    paginationEl.appendChild(btnFactory(i, i));
                }
                if (end < totalPages) paginationEl.append('…');
                // › Next, » Last
                paginationEl.appendChild(btnFactory('›', Math.min(totalPages, currentPage + 1)));
                paginationEl.appendChild(btnFactory('»', totalPages));
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
                                Swal.fire('Sin productos', 'No hay productos en esta categoría.', 'info');
                            }
                        })
                        .catch(() => Swal.fire('Error', 'No se pudieron cargar los productos.', 'error'));

                } else if (btn.classList.contains('btn-delete')) {
                    // Eliminar categoría
                    Swal.fire({
                        title: '¿Está seguro?',
                        text: 'Se eliminará esta categoría.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
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
                                        Swal.fire('Eliminado', 'Categoría eliminada.', 'success')
                                            .then(() => {
                                                // refrescar datos en cliente
                                                const idx = allCategories.findIndex(c => c.codigo === id);
                                                if (idx > -1) allCategories.splice(idx, 1);
                                                filtered = filtered.filter(c => c.codigo !== id);
                                                renderTable();
                                            });
                                    } else {
                                        Swal.fire('Error', 'No se pudo eliminar.', 'error');
                                    }
                                })
                                .catch(() => Swal.fire('Error', 'No se pudo eliminar.', 'error'));
                        }
                    });
                }
            });

            // inicializar
            renderTable();
        });
    </script>

</body>

</html>