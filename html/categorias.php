<?php
session_start();

// --- Función para mostrar alertas de SweetAlert desde la sesión ---
function display_session_alert() {
    if (isset($_SESSION['status'])) {
        $status = $_SESSION['status'];
        $type = htmlspecialchars($status['type']);
        $message = $status['message']; // El mensaje puede contener HTML, como <br>

        $icon_img = ($type === 'success') ? 'moto.png' : 'llave.png';
        $alt_text = ($type === 'success') ? 'Confirmación' : 'Error';
        $title_class = ($type === 'success') ? 'confirmacion' : 'error';
        $title_text = ($type === 'success') ? 'Éxito' : 'Error';
        $img_class = ($type === 'success') ? 'moto' : 'llave';

        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '<span class=\"titulo-alerta $title_class\">$title_text</span>',
                html: `
                    <div class=\"custom-alert\">
                        <div class=\"contenedor-imagen\">
                            <img src=\"../imagenes/$icon_img\" alt=\"$alt_text\" class=\"$img_class\">
                        </div>
                        <p>$message</p>
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

        // Limpiar la variable de sesión para que no se muestre de nuevo
        unset($_SESSION['status']);
    }
}


if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/html/verificar_permisos.php';


$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("<script>alert('No se pudo conectar a la base de datos');</script>");
}

// --- Validación AJAX de nombre de categoría ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_nombre'])) {
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $sql = "SELECT COUNT(*) as cnt FROM categoria WHERE nombre = '$nombre'";
    $res = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($res);
    header('Content-Type: application/json');
    echo json_encode(['exists' => ($row['cnt'] > 0)]);
    exit();
}

// Agregar categoría (CORREGIDO CON PRG)
if ($_POST && isset($_POST['guardar'])) {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $query = "INSERT INTO categoria (nombre) VALUES ('$nombre')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $_SESSION['status'] = [
            'type' => 'success',
            'message' => 'Categoría agregada correctamente.'
        ];
    } else {
        $error = mysqli_error($conexion);
        $_SESSION['status'] = [
            'type' => 'error',
            'message' => "La categoría no fue agregada.<br><small>$error</small>"
        ];
    }
    // Redirigir para evitar reenvío de formulario al recargar
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Eliminar categoría mediante boton
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);
    $query = "DELETE FROM categoria WHERE codigo = '$codigo'";
    $resultado = mysqli_query($conexion, $query);
    header('Content-Type: application/json');
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
    header('Content-Type: application/json');
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
    <script defer src="../js/index.js"></script> <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
    

</head>

<body>
    <?php 
    // Llamar a la función que mostrará la alerta si existe en la sesión
    display_session_alert(); 
    include 'boton-ayuda.php'; 
    ?>
    <?php
    // NOTA: Este bloque estaba sobrescribiendo la variable $allData. Lo he comentado para que la tabla funcione.
    // Si necesitas los datos de notificaciones, deberías usar una variable con un nombre diferente.
    /*
    $allQ = "SELECT id,mensaje,descripcion,fecha,leida FROM notificaciones n";
    if (!empty($filtros)) $allQ .= " WHERE " . implode(' OR ', $filtros);
    $allRes = mysqli_query($conexion, $allQ);
    $allData = mysqli_fetch_all($allRes, MYSQLI_ASSOC);
    */
    ?>
    <script>
        // Esta variable es necesaria para el script de más abajo. Asegurémonos de que tenga los datos de las categorías.
        const allData = <?php
            $allQ = "SELECT codigo, nombre FROM categoria";
            $allRes = mysqli_query($conexion, $allQ);
            $allData = mysqli_fetch_all($allRes, MYSQLI_ASSOC);
            echo json_encode($allData, JSON_HEX_TAG | JSON_HEX_APOS);
        ?>;
    </script>
    <div id="menu"></div>
    
    <nav class="barra-navegacion">
        <div class="ubica"> Productos/Categorias </div>
        <div class="userContainer">
            <div class="userInfo">
                <?php
                // Se reutiliza la conexión existente
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
                <p class="nombre"><?php echo htmlspecialchars($nombreUsuario); ?> <?php echo htmlspecialchars($apellidoUsuario); ?></p>
                <p class="rol">Rol: <?php echo htmlspecialchars($rol); ?></p>

            </div>
            <div class="profilePic">
                <?php if (!empty($rowUsuario['foto'])): ?>
                    <img id="profilePic" src="data:image/jpeg;base64,<?php echo base64_encode($foto); ?>" alt="Usuario">
                <?php else: ?>
                    <img id="profilePic" src="../imagenes/icono.jpg" alt="Usuario por defecto">
                <?php endif; ?>
            </div>
        </div>
    </nav>
        <div class="container-general">
        </div>
    <div id="categorias" class="form-section">
        <h1>Categorías</h1>
        <div class="container">
            <div class="actions">
                <button id="btnAbrirModal" class="btn-nueva-categoria"><i class='bx bx-plus bx-tada icon'></i>Nueva categoría</button>
                <input type="text" id="searchRealtime" name="valor" placeholder="Ingrese la categoría a buscar">
            </div>
            <table class="category-table">
                <thead>
                    <tr>
                        <th data-col="0" data-type="string">Nombre<span class="sort-arrow"></span></th>
                        <th data-col="1" data-type="string">Acciones<span class="sort-arrow"></span></th>
                    </tr>
                </thead>
                <tbody id="tabla-categorias">
                    <?php
                    // La renderización inicial se deja, aunque el script de JS la reemplazará
                    $categorias = $conexion->query("SELECT * FROM categoria ORDER BY codigo ASC");
                    while ($fila = $categorias->fetch_assoc()) {
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

    <div id="modalNuevo" class="modal_nueva_categoria">
        <div class="modal-content-nueva">
            <h2>Nueva categoría</h2>
            <form method="POST" action="">
                <div class="form-group" style="position: relative;">
                    <label>Ingrese el nombre de la categoría:</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        required
                        oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" />
                    <span id="nombre-error" class="input-error-message">
                        Esta categoría ya está registrada.
                    </span>
                </div>
                <div class="modal-buttons">
                    <button type="button" id="btnCancelar">Cancelar</button>
                    <button type="submit" name="guardar" id="btnGuardar" disabled>Guardar</button>
                </div>
            </form>
        </div>
    </div>
    <div id="modalProductos" class="modal">
        <div class="modal-content">
            <span class="close">
                <i class="fa-solid fa-x"></i>
            </span>
            <h2>Productos de la categoría</h2>
            <div id="lista-productos" class="productos-container">
                </div>
        </div>
    </div>
      <!-- Footer con derehcos de autor -->
<footer class="footer">
  <div class="footer-item datos">© 2025 MotoRacer</div>
  <div class="footer-item">
    Desarrollado por:
    <strong>Mariana Castillo</strong> ·
    <strong>Daniel López</strong> ·
    <strong>Deicy Caro</strong> ·
    <strong>Marlen Salcedo</strong>
    <span class="version">v1.0</span>
  </div>
</footer>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // — Datos iniciales inyectados por PHP —
        const allCategories = <?php
                                $cats = [];
                                $res = $conexion->query("SELECT codigo, nombre FROM categoria ORDER BY nombre ASC");
                                while ($r = $res->fetch_assoc()) $cats[] = $r;
                                echo json_encode($cats, JSON_HEX_TAG | JSON_HEX_APOS);
                                ?>;

        const tableBody = document.getElementById('tabla-categorias');
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
        const modalNuevaCategoria = document.getElementById('modalNuevo'); // Asegúrate de que el ID sea 'modal'
        const btnAbrirNuevaCategoria = document.getElementById('btnAbrirModal'); // Asume este ID para el botón de abrir
        const btnCancelarNuevaCategoria = modalNuevaCategoria.querySelector('#btnCancelar');

        if (btnAbrirNuevaCategoria) {
            btnAbrirNuevaCategoria.addEventListener('click', () => {
                modalNuevaCategoria.classList.add('show');
            });
        }

        if (btnCancelarNuevaCategoria) {
            btnCancelarNuevaCategoria.addEventListener('click', () => {
                modalNuevaCategoria.classList.remove('show');
            });
        }

        if (modalNuevaCategoria) {
            modalNuevaCategoria.addEventListener('click', (e) => {
                if (e.target === modalNuevaCategoria) {
                    modalNuevaCategoria.classList.remove('show');
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
            paginationEl.appendChild(btnFactory('Última»', totalPages));
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
                fetch('../html/categorias.php', {
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
                                    <td>${p.nombre  || ''}</td>
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
            } else if (btn.classList.contains('btn-delete')) {
                // Eliminar categoría
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
                }).then(res => {
                    if (res.isConfirmed) {
                        fetch('../html/categorias.php', {
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
                                })
                                .then(() => {
                                    // refrescar datos en cliente
                                    const idx = allCategories.findIndex(c => c.codigo == id);
                                    if (idx > -1) allCategories.splice(idx, 1);
                                    filtered = filtered.filter(c => c.codigo != id);
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
                                    <p>No se pudo eliminar la categoría porque hay productos asociados.</p>
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
                        .catch(() =>  Swal.fire({
                            title: '<span class="titulo-alerta error">Error</span>',
                            html: `
                                <div class="custom-alert">
                                    <div class="contenedor-imagen">
                                        <img src="../imagenes/llave.png" alt="Error" class="llave">
                                    </div>
                                    <p>No se pudo eliminar la categoría porque hay productos asociados..</p>
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

    document.addEventListener('DOMContentLoaded', () => {
        const nombreInput = document.getElementById('nombre');
        const nombreError = document.getElementById('nombre-error');
        const btnGuardar = document.getElementById('btnGuardar');
        let nombreValido = false;

        async function validarNombre(nombre) {
            try {
                const form = new URLSearchParams();
                form.append('check_nombre', '1');
                form.append('nombre', nombre.trim());
                const res = await fetch('', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: form.toString()
                });
                const json = await res.json();
                return !json.exists;
            } catch (e) {
                console.error(e);
                return false;
            }
        }

        nombreInput.addEventListener('input', async () => {
            const valor = nombreInput.value.trim();

            if (!valor || !/[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]/.test(valor)) {
                nombreInput.classList.remove('invalid');
                nombreError.style.display = 'none';
                btnGuardar.disabled = true;
                return;
            }

            nombreValido = await validarNombre(valor);

            if (!nombreValido) {
                nombreInput.classList.add('invalid');
                nombreError.style.display = 'block';
            } else {
                nombreInput.classList.remove('invalid');
                nombreError.style.display = 'none';
            }
            btnGuardar.disabled = !nombreValido;
        });

        document.getElementById('btnAbrirModal').addEventListener('click', () => {
            nombreInput.value = '';
            nombreInput.classList.remove('invalid');
            nombreError.style.display = 'none';
            btnGuardar.disabled = true;
        });
    });
</script>

</body>

</html>