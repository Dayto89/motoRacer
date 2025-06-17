<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);
ini_set('error_log', 'C:\xampp\htdocs\php_errors.log');

session_start();


// Verificación de sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}


// require_once $_SERVER['DOCUMENT_ROOT'] . '../html/verificar_permisos.php';

// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

// 1. Eliminación por AJAX (JSON)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'], $_POST['codigo'])) {
    header('Content-Type: application/json');

    $codigo = $_POST['codigo'];

    $stmt = $conexion->prepare("DELETE FROM cliente WHERE codigo = ?");
    $stmt->bind_param("s", $codigo);

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
        exit;
    }

    if ($stmt->affected_rows === 0) {
        echo json_encode(['success' => false, 'error' => 'Cliente no encontrado']);
        exit;
    }

    echo json_encode(['success' => true]);
    exit;
}

// 2. Actualización de datos (desde formulario)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $identificacion = $_POST['identificacion'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    // Usando sentencias preparadas para mayor seguridad
    $stmt = $conexion->prepare("UPDATE cliente SET 
        identificacion = ?,
        nombre = ?,
        apellido = ?,
        telefono = ?,
        correo = ?
        WHERE codigo = ?");
    $stmt->bind_param("ssssss", $identificacion, $nombre, $apellido, $telefono, $correo, $id);

    if ($stmt->execute()) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Éxito',
            'message' => 'Datos actualizados correctamente.',
            'image' => 'moto.png',
            'redirect' => 'listaclientes.php'
        ];
    } else {
        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Error',
            'message' => 'Error al actualizar los datos: ' . $stmt->error,
            'image' => 'llave.png'
        ];
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// 3. Filtros de búsqueda y paginación
$filtros = [];
$valor = isset($_GET['valor']) ? mysqli_real_escape_string($conexion, $_GET['valor']) : '';

if (!empty($valor) && isset($_GET['criterios']) && is_array($_GET['criterios'])) {
    foreach ($_GET['criterios'] as $criterio) {
        $criterio = mysqli_real_escape_string($conexion, $criterio);
        $filtros[] = "$criterio LIKE '%$valor%'";
    }
}

// justo tras conectar a BD
$allQ = "SELECT codigo,identificacion,nombre,apellido,telefono,correo FROM cliente";
if (!empty($filtros)) $allQ .= " WHERE " . implode(' OR ', $filtros);
$allRes = mysqli_query($conexion, $allQ);
$allData = mysqli_fetch_all($allRes, MYSQLI_ASSOC);

$por_pagina = 10;
$pagina_actual = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_actual - 1) * $por_pagina;

// Conteo total de registros
$consulta_total = "SELECT COUNT(*) AS total FROM cliente WHERE 1=1";
if (!empty($filtros)) {
    $consulta_total .= " AND (" . implode(" OR ", $filtros) . ")";
}
$resultado_total = mysqli_query($conexion, $consulta_total);
$total_filas = mysqli_fetch_assoc($resultado_total)['total'];
$total_paginas = ceil($total_filas / $por_pagina);

// Consulta principal con paginación
$consulta = "SELECT * FROM cliente WHERE 1=1";
if (!empty($filtros)) {
    $consulta .= " AND (" . implode(" OR ", $filtros) . ")";
}
$consulta .= " LIMIT $por_pagina OFFSET $offset";

$resultado = mysqli_query($conexion, $consulta);
if (!$resultado) {
    die("No se pudo ejecutar la consulta: " . mysqli_error($conexion));
}

// 4. Widget de accesibilidad
include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inventario</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <link rel="stylesheet" href="../css/clientes.css" />
    <link rel="stylesheet" href="../css/alertas.css">
    <link rel="stylesheet" href="../componentes/header.css">
    <link rel="stylesheet" href="../componentes/header.php">
    <script src="../js/header.js"></script>
    <script src="/js/index.js"></script>

    <style>

        .required::after {
            content: " *";
            color: red;
        }
        .export-container {
            margin-bottom: 15px;
        }

        .btn-export {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            background-color: #28a745;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-export:hover {
            background-color: #218838;
        }

        .btn-export i {
            margin-right: 6px;
        }

        .pagination-dinamica {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 5px;
            font-family: arial;
            font-size: 13px;
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
            cursor: pointer;
        }

        /* Al arrancar, ocultamos la paginación PHP (queda como fallback) */
        .pagination {
            display: none;
        }


        #clientesTable tbody tr:hover,
        #clientesTable tbody tr:hover td {
            background-color: rgba(0, 123, 255, 0.15);
        }
    </style>
</head>

<body>
    <script>
        const allData = <?php echo json_encode($allData, JSON_HEX_TAG | JSON_HEX_APOS); ?>;
    </script>
    <div class="sidebar">
        <div id="menu"></div>
    </div>

    <div class="main-content">
        <h1>Clientes</h1>
        <div class="filter-bar">
            <input type="text" id="searchRealtime" name="valor" placeholder="Ingrese el valor a buscar">
            <div class="export-container">
                <a href="exportar_excel_clientes.php" class="btn-export">
                    <i class="fa-solid fa-file-csv"></i> Exportar Excel
                </a>
            </div>
        </div>


        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <table id="clientesTable">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th data-col="1" data-type="string">Identificación<span class="sort-arrow"></span></th>
                        <th data-col="2" data-type="string">Nombre<span class="sort-arrow"></span></th>
                        <th data-col="3" data-type="string">Apellido<span class="sort-arrow"></span></th>
                        <th data-col="4" data-type="string">Teléfono<span class="sort-arrow"></span></th>
                        <th data-col="5" data-type="string">Correo<span class="sort-arrow"></span></th>
                        <th data-col="6" data-type="none">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?= htmlspecialchars($fila['codigo']) ?></td>
                            <td><?= htmlspecialchars($fila['identificacion']) ?></td>
                            <td><?= htmlspecialchars($fila['nombre']) ?></td>
                            <td><?= htmlspecialchars($fila['apellido']) ?></td>
                            <td><?= htmlspecialchars($fila['telefono']) ?></td>
                            <td><?= htmlspecialchars($fila['correo']) ?></td>
                            <td class="acciones">
                                <button class="edit-button" data-id="<?= $fila['codigo'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="delete-button" onclick="eliminarCliente('<?= $fila['codigo'] ?>')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div id="jsPagination" class="pagination-dinamica"></div>
            <!-- Modal de edición -->
            <div id="editModal" class="modal hide">
                <div class="modal-content">
                    <span class="close">
                        <i class="fa-solid fa-x"></i>
                    </span>
                    <h2>Editar Cliente</h2>
                    <form id="editForm" method="post">
                        <input type="hidden" id="editId" name="id">
                        <div class="campo">
                            <label class="required" for="editIdentificacion">Identificación:</label>
                            <input type="text" id="editIdentificacion" name="identificacion"
                                oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '')">
                        </div>
                        <div class="campo">
                            <label class="required" for="editNombre">Nombre:</label>
                            <input type="text" id="editNombre" name="nombre"
                                oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '')">
                        </div>
                        <div class="campo">
                            <label class="required" for="editApellido">Apellido:</label>
                            <input type="text" id="editApellido" name="apellido"
                                oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '')">
                        </div>
                        <div class="campo">
                            <label class="required" for="editTelefono">Teléfono:</label>
                            <input type="text" id="editTelefono" name="telefono" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <div class="campo">
                            <label class="required" for="editCorreo">Correo:</label>
                            <input type="email" id="editCorreo" name="correo"
                                pattern=".+@.+"
                                placeholder="ejemplo@correo.com">
                        </div>
                        <div class="modal-boton">
                            <button type="submit" id="modal-boton">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php if ($total_paginas > 1): ?>
                <div class="pagination">
                    <?php
                    $base_params = $_GET;
                    ?>
                    <a href="?<?= http_build_query(array_merge($base_params, ['pagina' => 1])) ?>">« Primera</a>

                    <?php if ($pagina_actual > 1): ?>
                        <a href="?<?= http_build_query(array_merge($base_params, ['pagina' => $pagina_actual - 1])) ?>">‹ Anterior</a>
                    <?php endif; ?>

                    <?php
                    $start = max(1, $pagina_actual - 2);
                    $end   = min($total_paginas, $pagina_actual + 2);

                    if ($start > 1) {
                        echo '<span class="ellips" style="color:white">…</span>';
                    }

                    for ($i = $start; $i <= $end; $i++):
                    ?>
                        <a href="?<?= http_build_query(array_merge($base_params, ['pagina' => $i])) ?>"
                            class="<?= $i == $pagina_actual ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor;

                    if ($end < $total_paginas) {
                        echo '<span class="ellips" style="color:white">…</span>';
                    }
                    ?>

                    <?php if ($pagina_actual < $total_paginas): ?>
                        <a href="?<?= http_build_query(array_merge($base_params, ['pagina' => $pagina_actual + 1])) ?>">Siguiente ›</a>
                    <?php endif; ?>

                    <a href="?<?= http_build_query(array_merge($base_params, ['pagina' => $total_paginas])) ?>">Última »</a>
                </div>
            <?php endif; ?>
    </div>
<?php else: ?>
    <p>No se encontraron resultados.</p>
<?php endif; ?>

<!-- Mostrar alertas desde sesión -->
<?php if (isset($_SESSION['alert'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '<span class="titulo-alerta confirmacion <?= $_SESSION['alert']['type'] ?>"><?= $_SESSION['alert']['title'] ?></span>',
                html: `
            <div class="custom-alert">
                <div class="contenedor-imagen">
                    <img class="<?= $_SESSION['alert']['type'] ?>" src="../imagenes/<?= $_SESSION['alert']['image'] ?>" alt="<?= $_SESSION['alert']['title'] ?>">
                </div>
                <p><?= $_SESSION['alert']['message'] ?></p>
            </div>
        `,
                background: '#ffffffdb',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '<?= $_SESSION['alert']['type'] === 'success' ? '#007bff' : '#dc3545' ?>',
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    container: 'fondo-oscuro'
                }
            }).then(() => {
                <?php if (isset($_SESSION['alert']['redirect'])): ?>
                    window.location.href = '<?= $_SESSION['alert']['redirect'] ?>';
                <?php endif; ?>
            });
            <?php unset($_SESSION['alert']); ?>
        });
    </script>
<?php endif; ?>

<script>
    // JavaScript para el modal de edición
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-button');
        const modal = document.getElementById('editModal');
        const closeModal = modal.querySelector('.close');

        function closeEditModal() {
            if (modal) { // Asegurarse de que el modal exista antes de intentar cerrarlo
                modal.classList.remove('show'); // Quita la clase 'show' para iniciar la animación de salida
                modal.classList.add('hide'); // Añade 'hide' para asegurar que se oculte completamente
            }
        }

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                document.getElementById('editId').value = row.cells[0].innerText.trim();
                document.getElementById('editIdentificacion').value = row.cells[1].innerText.trim();
                document.getElementById('editNombre').value = row.cells[2].innerText.trim();
                document.getElementById('editApellido').value = row.cells[3].innerText.trim();
                document.getElementById('editTelefono').value = row.cells[4].innerText.trim();
                document.getElementById('editCorreo').value = row.cells[5].innerText.trim();
                modal.style.display = 'block';
            });
        });

        closeModal.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Cerrar modal al hacer clic fuera
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
    // Función para eliminar cliente
    function eliminarCliente(codigo) {
        Swal.fire({
            title: '<span class="titulo-alerta advertencia">¿Estas Seguro?</span>',
            html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                    </div>
                    <p>¿Quieres eliminar el cliente <strong>${codigo}</strong>?</p>
                </div>
            `,
            background: '#ffffffdb',
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: '#dc3545',
            customClass: {
                popup: "custom-alert",
                confirmButton: "btn-eliminar",
                cancelButton: "btn-cancelar",
                container: 'fondo-oscuro'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../html/listaclientes.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `eliminar=1&codigo=${encodeURIComponent(codigo)}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: '<span class="titulo-alerta confirmacion"> Eliminado</span>',
                                html: `
                                <div class="custom-alert">
                                    <div class="contenedor-imagen">
                                        <img src="../imagenes/moto.png" alt="Confirmacion" class="moto">
                                    </div>
                                    <p>El cliente <strong>${codigo}</strong> ha sido eliminado correctamente.</p>
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
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: '<span class="titulo-alerta error">Error</span>',
                                html: `
                                <div class="custom-alert">
                                    <div class="contenedor-imagen">
                                        <img src="../imagenes/llave.png" alt="Error" class="llave">
                                    </div>
                                    <p>${data.error || 'Error al eliminar el cliente'}</p>
                                </div>
                            `,
                                background: '#ffffffdb',
                                confirmButtonText: 'Aceptar',
                                confirmButtonColor: '#dc3545',
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
                                <p>Error al eliminar el cliente, puede tener registros de ventas.</p>
                            </div>
                        `,
                            background: '#ffffffdb',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#dc3545',
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
</script>
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
        const rowsPerPage = 7;
        let currentPage = 1;
        let filteredData = [...allData];

        console.log("allData:", allData);
        console.log("filteredData tras input:", filteredData);

        const tableBody = document.querySelector('#clientesTable tbody');
        const paginationContainer = document.getElementById('jsPagination');
        const inputBusqueda = document.getElementById('searchRealtime');
        const headers = document.querySelectorAll('#clientesTable thead th');

        // Render tabla
        function renderTable() {
            const start = (currentPage - 1) * rowsPerPage;
            const pageData = filteredData.slice(start, start + rowsPerPage);

            tableBody.innerHTML = '';
            pageData.forEach(row => {
                const tr = document.createElement('tr');
                ['codigo', 'identificacion', 'nombre', 'apellido', 'telefono', 'correo'].forEach(f => {
                    const td = document.createElement('td');
                    td.textContent = row[f];
                    tr.appendChild(td);
                });
                // Acciones (usa exactamente tu HTML)
                const tdAcc = document.createElement('td');
                tdAcc.innerHTML = `<button class="edit-button" data-id="${row.codigo}"><i class="fa-solid fa-pen-to-square"></i></button>
                         <button class="delete-button" onclick="eliminarCliente('${row.codigo}')"><i class="fa-solid fa-trash"></i></button>`;
                tr.appendChild(tdAcc);

                tableBody.appendChild(tr);
            });
            renderPaginationControls();
        }

        document.getElementById('clientesTable').addEventListener('click', function(e) {
            if (e.target.closest('.edit-button')) {
                const btn = e.target.closest('.edit-button');
                // Busca la fila correspondiente:
                const row = btn.closest('tr');
                // Rellena y abre el modal:
                document.getElementById('editId').value = row.cells[0].innerText.trim();
                document.getElementById('editIdentificacion').value = row.cells[1].innerText.trim();
                document.getElementById('editNombre').value = row.cells[2].innerText.trim();
                document.getElementById('editApellido').value = row.cells[3].innerText.trim();
                document.getElementById('editTelefono').value = row.cells[4].innerText.trim();
                document.getElementById('editCorreo').value = row.cells[5].innerText.trim();
                document.getElementById('editModal').style.display = 'block';
            }
        });

        // Controles de paginación
        function renderPaginationControls() {
            paginationContainer.innerHTML = '';
            const totalPages = Math.ceil(filteredData.length / rowsPerPage);
            if (totalPages <= 1) return;

            const btn = (txt, pg) => {
                const b = document.createElement('button');
                b.textContent = txt;
                if (pg === currentPage) b.classList.add('active');
                b.onclick = () => {
                    currentPage = pg;
                    renderTable();
                };
                return b;
            };

            paginationContainer.append(btn('«', 1), btn('‹', Math.max(1, currentPage - 1)));

            let start = Math.max(1, currentPage - 2),
                end = Math.min(totalPages, currentPage + 2);
            if (start > 1) paginationContainer.append(Object.assign(document.createElement('span'), {
                textContent: '…'
            }));
            for (let i = start; i <= end; i++) paginationContainer.append(btn(i, i));
            if (end < totalPages) paginationContainer.append(Object.assign(document.createElement('span'), {
                textContent: '…'
            }));

            paginationContainer.append(btn('›', Math.min(totalPages, currentPage + 1)), btn('»', totalPages));
        }

        // Búsqueda en tiempo real (global)
        inputBusqueda.addEventListener('input', () => {
            const q = inputBusqueda.value.trim().toLowerCase();
            filteredData = allData.filter(r =>
                Object.values(r).some(v => v.toLowerCase().includes(q))
            );
            currentPage = 1;
            renderTable();
        });

        // Ordenamiento por click en <th>
        const sortStates = {};
        headers.forEach((th, idx) => {
            const type = th.dataset.type;
            if (!type || type === 'none') return;
            th.style.cursor = 'pointer';
            sortStates[idx] = true;
            th.onclick = () => {
                sortStates[idx] = !sortStates[idx];
                const asc = sortStates[idx];
                filteredData.sort((a, b) => {
                    let va = a[Object.keys(a)[idx]].toLowerCase();
                    let vb = b[Object.keys(b)[idx]].toLowerCase();
                    if (type === 'number') {
                        va = +va;
                        vb = +vb;
                    }
                    return (va < vb ? -1 : va > vb ? 1 : 0) * (asc ? 1 : -1);
                });
                // Actualiza flechas
                headers.forEach(h => {
                    const sp = h.querySelector('.sort-arrow');
                    if (sp) sp.textContent = '';
                });
                th.querySelector('.sort-arrow').textContent = asc ? '▲' : '▼';
                renderTable();
            };
        });

        // Arranca
        renderTable();
    });
</script>
</body>

</html>