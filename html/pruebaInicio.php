<?php
session_start();
date_default_timezone_set('America/Bogota');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}



$conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$backup_dir = 'C:/xampp/htdocs/Proyecto SIMR/backups/';
$search_term = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

$backups = [];
$files = scandir($backup_dir);
foreach ($files as $file) {
    if ($file !== "." && $file !== ".." && preg_match('/\.(sql|zip)$/i', $file)) {
        $file_path = $backup_dir . $file;
        $file_info = pathinfo($file_path);
        $creation_date = date("Y-m-d H:i:s", filemtime($file_path));
        $bytes = filesize($file_path);
        $file_size = formatSizeUnits($bytes);
        $file_type = ($file_info['extension'] === 'sql') ? 'Base de datos' : 'Archivos';
        $searchable_date = date("d/m/Y H:i:s", filemtime($file_path));

        $match = empty($search_term) ||
            stripos($file, $search_term) !== false ||
            stripos($creation_date, $search_term) !== false ||
            stripos($searchable_date, $search_term) !== false ||
            stripos($file_size, $search_term) !== false ||
            stripos($file_type, $search_term) !== false;

        if ($match) {
            $backups[] = [
                'path'      => $file_path,
                'name'      => $file,
                'date'      => $creation_date,
                'type'      => $file_type,
                'size'      => $file_size,     // mantiene formato legible
                'sizeValue' => $bytes
            ];
        }
    }
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
    if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
    if ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
    return $bytes . ' bytes';
}

// PAGINACIÓN
$por_pagina = 8;
$total_backups = count($backups);
$total_paginas = ceil($total_backups / $por_pagina);
$pagina_actual = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$pagina_actual = max(1, min($total_paginas, $pagina_actual));
$inicio = ($pagina_actual - 1) * $por_pagina;
$backups_pagina = array_slice($backups, $inicio, $por_pagina);

include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';

echo "<script>\n";
echo "  const allData = " . json_encode($backups, JSON_HEX_TAG | JSON_HEX_APOS) . ";\n";
echo "</script>\n";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestión de Copias de Seguridad</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="../componentes/header.css">
    <link rel="stylesheet" href="../css/alertas.css">
    <script src="../js/header.js"></script>
    <script src="/js/index.js"></script>
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Metal Mania", system-ui;
            background-image: url("fondoMotoRacer.png");
            background-size: cover;
            background-position: center;
        }

        /* Estilos mejorados para backups */
        .main-content {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            color: white;
            margin-top: 50px;
        }

        /* 2) Aplico transición a **todos** los hijos directos */
        .barra-navegacion>* {
            transition: transform 0.3s ease;
        }

        /* 3) Al hacer hover en #menu, desplazo **solo** el primer hijo */
        #menu:hover~.barra-navegacion>*:first-child {
            transform: translateX(210px);
            /* ancho menú expandido */
        }

        /* 4) Garantizo que el último hijo (tu avatar+rol) NO se mueva */
        #menu:hover~.barra-navegacion>*:last-child {
            transform: none;
        }

        .main-content h1 {
            font-size: 50px;
            text-shadow: 7px -1px 0 #1c51a0, 1px -1px 0 #1c51a0, -1px 1px 0 #1c51a0,
                3px 5px 0 #1c51a0;
            margin-left: 28%;
            margin-top: 6%;
        }

        .backup-table {
            width: 96%;
            border-collapse: collapse;
            color: white;
            margin-left: 6%;
            font-family: Arial;
            box-shadow: 0 0 15px #222a37;
            margin-top: 2%;
            border-radius: 10px;
            box-shadow: 0 0 15px #222a37;
        }

        .backup-table thead {
            align-items: center;
            justify-content: center;
        }

        th,
        td {
            border: 1px solid #fff7f7;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: rgb(32 69 113);
            font-weight: bold;
            text-align: center;
        }

        #tabla-backups td {
            background-color: rgb(63 61 61);
            text-align: center;
            color: white;
        }

        .productos-table th {
            background-color: #98bde9;
            color: #0b111a;
            font-family: Arial, Helvetica, sans-serif;
        }

        .backup-table td {
            font-size: 16px;
            font-family: arial;
            text-align: center;
        }

        .backup-item-actions {
            display: flex;
            gap: 0.8rem;
            justify-content: center;
        }

        .btn-restore {
            background: #326534;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .btn-delete {
            background: #f44336;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .btn-restore:hover,
        .btn-delete:hover {
            opacity: 0.9;
        }

        .backup-type {
            padding: 0.25rem 0.5rem;
            border-radius: 5px;
            font-size: 15px;
            font-weight: 500;
        }

        .type-db {
            color: #ffffff;
        }

        .type-files {
            background-color: #f0f4c3;
            color: #afb42b;
        }

        .filter-bar {
            display: flex;
            align-items: center;
            margin-top: 3%;
            justify-content: space-evenly;
        }

        .no-backups {
            text-align: center;
            padding: 2rem;
            color: #757575;
            border: 2px dashed #e0e0e0;
            margin-top: 2rem;
            border-radius: 8px;
        }

        .search-container {
            font-size: 16px;
            padding: 8px 23px;
            border-radius: 9px;
            width: 50%;
        }

        #search-input {
            padding: 15px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .search-container input {
            border-radius: 10px;
            width: 300px;
            height: 40px;
            padding: 9px;
        }

        .search-button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 12px;
            height: 40px;
            width: 100px;
            font-size: 15px;
            cursor: pointer;
        }

        .search-button:hover {
            background-color: #0056b3;
        }

        .boton-agregar {
            background-color: #007bff;
            font-weight: bold;
            color: white;
            border: none;
            padding: 9px 23px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 10px;
        }

        .boton-agregar:hover {
            background-color: #0056b3;
        }

        .pagination {
            display: none;
        }

        .pagination-dinamica {
            display: flex;
            justify-content: center;
            margin-top: 34px;
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
        }

        #backupTable tbody tr:hover,
        #backupTable tbody tr:hover td {
            background-color: rgba(0, 123, 255, 0.15);
        }

        ul {
            list-style-type: none;
            padding-left: 0;
            /* opcional: elimina el espacio donde estaban los puntos */
        }

        .container-general {
            position: fixed;
            top: 8%;
            left: 19%;
            width: 67%;
            height: 89%;
            background: rgb(211 210 210 / 84%);
            z-index: -1000;
            pointer-events: none;
            box-shadow: 0 4px 20px #0b111a;
            border-radius: 10px;
        }

        /* =================================================================== */
        /* ======== RESPONSIVE PARA GESTIÓN DE COPIAS DE SEGURIDAD ========= */
        /* =================================================================== */

        /* MÓVILES - VISTA VERTICAL (Portrait) */
        @media screen and (max-width: 767px) and (orientation: portrait) {

            /* 1. Ajustes generales del layout */
            body {
                margin-top: 0;
            }

            .main-content {
                width: calc(100% - 90px);
                margin-left: 90px;
                padding: 15px;
                box-sizing: border-box;
                overflow-x: hidden;
                /* Quitamos el scroll de aquí para que no mueva todo */
            }

            .container-general {
                position: fixed;
                top: 11%;
                left: 21%;
                width: 79%;
                height: 87%;
                background: rgb(211 210 210 / 84%);
                z-index: -1000;
                pointer-events: none;
                box-shadow: 0 4px 20px #0b111a;
                border-radius: 10px;
            }

            h1 {
                font-size: 27px!important;
                text-align: center;
                margin: 100px auto 20px auto;
            }

            /* 2. Barra de Acciones (Botón y Búsqueda) */
            .filter-bar {
                display: flex;
                flex-direction: column;
                gap: 1rem;
                margin-bottom: 20px;
            }

            .filter-bar .boton-agregar,
            .filter-bar .search-container {
                width: 100%;
                margin: 0;
            }

            .filter-bar .search-container input {
                width: 100%;
            }

            /* 3. ✅ ¡AQUÍ VA EL SCROLL AHORA! */
            .backup-table {
                display: block;
                /* Hacemos la tabla un bloque para que acepte overflow */
                overflow-x: auto;
                /* El scroll horizontal ahora está SOLO en la tabla */
                width: 100%;
                /* La "ventana" de la tabla ocupa el 100% de su contenedor */
                -webkit-overflow-scrolling: touch;
            }

            .backup-table th,
            .backup-table td {
                white-space: nowrap;
                /* Mantenemos esto para que las columnas no se rompan */
            }

            /* 4. Paginación */
            .pagination-dinamica {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 0.5rem;
                margin-top: 20px;
            }
        }


        /* MÓVILES - VISTA HORIZONTAL (Landscape) */
        @media screen and (max-width: 870px) and (orientation: landscape) {

            .barra-navegacion,
            .container-general {
                display: none !important;
            }

            body {
                margin-top: 0;
            }

            .main-content {
                width: 100%;
                margin: 0;
                padding: 1rem;
                overflow-x: hidden;
                /* Quitamos el scroll de aquí */
            }

            h1 {
                font-size: 2rem;
                margin: 1rem auto 1.5rem auto;
            }

            .filter-bar {
                flex-direction: row;
                align-items: center;
                margin-bottom: 20px;
            }

            /* Se mantienen los demás estilos para el filter-bar y la tabla */
            .backup-table {
                display: block;
                /* Hacemos la tabla un bloque */
                overflow-x: auto;
                /* El scroll SOLO en la tabla */
                width: 100%;
                -webkit-overflow-scrolling: touch;
            }

            .backup-table th,
            .backup-table td {
                white-space: nowrap;
            }
        }
    </style>
</head>

<body>
    <?php include 'boton-ayuda.php'; ?>
    <div id="menu"></div>
    <nav class="barra-navegacion">
        <div class="ubica"> Configuración / Copia de seguridad</div>
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
    </nav>
    <div class="container-general">
    </div>
    <div class="main-content">
        <h1>Gestión de Copias de Seguridad</h1>

        <div class="filter-bar">
            <button class="boton boton-agregar" onclick="agregarBackup()">Nueva Copia de Seguridad</button>
            <div class="search-container">
                <input id="searchRealtime" type="text" placeholder="Buscar copias de seguridad…" />

            </div>

        </div>

        <?php if (!empty($backups_pagina)): ?>
            <table id="backupTable" class="backup-table">
                <thead>
                    <tr>
                        <th data-field="name" data-type="text">Nombre del Backup <span class="sort-arrow"></span></th>
                        <th data-field="date" data-type="date">Fecha de Creación <span class="sort-arrow"></span></th>
                        <th data-field="type" data-type="text">Tipo <span class="sort-arrow"></span></th>
                        <th data-field="sizeValue" data-type="number">Tamaño <span class="sort-arrow"></span></th>
                        <th data-field="actions" data-type="none">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-backups">
                    <?php foreach ($backups_pagina as $backup): ?>
                        <tr>
                            <td><?= htmlspecialchars($backup['name']) ?></td>
                            <td><?= $backup['date'] ?></td>
                            <td>
                                <span class="backup-type <?= ($backup['type'] === 'Base de datos') ? 'type-db' : 'type-files' ?>">
                                    <?= $backup['type'] ?>
                                </span>
                            </td>
                            <td><?= $backup['size'] ?></td>
                            <td>
                                <div class="backup-item-actions">
                                    <button class="btn-restore"
                                        onclick="restoreBackup('<?= htmlspecialchars($backup['name']) ?>')">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                    <button class="btn-delete"
                                        onclick="deleteBackup('<?= htmlspecialchars($backup['name']) ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div id="jsPagination" class="pagination-dinamica"></div>

            <!-- PAGINACIÓN -->

            <?php if ($total_paginas > 1): ?>
                <div class="pagination">
                    <?php
                    // Construir query base conservando filtros
                    $base_params = $_GET;
                    ?>
                    <!-- Primera -->
                    <?php
                    $base_params['pagina'] = 1;
                    $url = '?' . http_build_query($base_params);
                    ?>
                    <a href="<?= $url ?>">« Primera</a>

                    <!-- Anterior -->
                    <?php if ($pagina_actual > 1): ?>
                        <?php
                        $base_params['pagina'] = $pagina_actual - 1;
                        $url = '?' . http_build_query($base_params);
                        ?>
                        <a href="<?= $url ?>">‹ Anterior</a>
                    <?php endif; ?>

                    <?php
                    // Rango de páginas: dos antes y dos después
                    $start = max(1, $pagina_actual - 2);
                    $end   = min($total_paginas, $pagina_actual + 2);

                    // Si hay hueco antes, muestra ellipsis
                    if ($start > 1) {
                        echo '<span class="ellips">…</span>';
                    }

                    // Botones de páginas
                    for ($i = $start; $i <= $end; $i++):
                        $base_params['pagina'] = $i;
                        $url = '?' . http_build_query($base_params);
                    ?>
                        <a href="<?= $url ?>"
                            class="<?= $i == $pagina_actual ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor;

                    // Si hay hueco después, muestra ellipsis
                    if ($end < $total_paginas) {
                        echo '<span class="ellips">…</span>';
                    }
                    ?>

                    <!-- Siguiente -->
                    <?php if ($pagina_actual < $total_paginas): ?>
                        <?php
                        $base_params['pagina'] = $pagina_actual + 1;
                        $url = '?' . http_build_query($base_params);
                        ?>
                        <a href="<?= $url ?>">Siguiente ›</a>
                    <?php endif; ?>

                    <!-- Última -->
                    <?php
                    $base_params['pagina'] = $total_paginas;
                    $url = '?' . http_build_query($base_params);
                    ?>
                    <a href="<?= $url ?>">Última »</a>
                </div>
            <?php endif; ?>
    </div>
<?php else: ?>
    <div class="no-backups">
        <?php if (empty($search_term)): ?>
            <script>
                Swal.fire({
                    title: '<span class="titulo-alerta error">Error</span>',
                    html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                         <img src="../imagenes/llave.png" alt="Error" class="llave">
                    </div>
                    <p>No hay copias de seguridad</p>
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
            </script>
        <?php else: ?>
            <script>
                Swal.fire({
                    title: '<span class="titulo-alerta error">Error</span>',
                    html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/llave.png" alt="Error" class="llave">
                    </div>
                    <p>No se encontraron resultados</p>
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
            </script>
        <?php endif; ?>
    </div>
<?php endif; ?>
</div>


<script>
    /**
     * Restaura un backup: llama a restore_backup.php
     */
    async function restoreBackup(filename) {
        const {
            isConfirmed
        } = await Swal.fire({
            title: '<span class="titulo-alerta advertencia">Advertencia</span>',
            html: `
      <div class="custom-alert">
        <div class="contenedor-imagen">
          <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
        </div>
        <p>¿Seguro que deseas restaurar <strong>${filename}</strong>? Se sobrescribirán datos existentes.</p>
      </div>`,
            showCancelButton: true,
            confirmButtonText: 'Sí, restaurar',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'swal2-border-radius',
                confirmButton: 'btn-aceptar',
                cancelButton: 'btn-cancelar',
                container: 'fondo-oscuro'
            }
        });

        if (!isConfirmed) return;

        try {
            const resp = await fetch('../includes/restore_backup.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    file: filename
                })
            });
            const result = await resp.json();
            if (!result.success) throw new Error(result.message);

            await Swal.fire({
                title: '<span class="titulo-alerta confirmacion">Éxito</span>',
                html: `
        <div class="custom-alert">
          <div class="contenedor-imagen">
            <img src="../imagenes/moto.png" alt="Confirmación" class="moto">
          </div>
          <p>${result.message}</p>
        </div>`,
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    container: 'fondo-oscuro'
                }
            });
            location.reload();
        } catch (err) {
            console.error(err);
            Swal.fire({
                title: '<span class="titulo-alerta error">Error</span>',
                html: `
        <div class="custom-alert">
          <div class="contenedor-imagen">
            <img src="../imagenes/llave.png" alt="Error" class="llave">
          </div>
          <p>${err.message}</p>
        </div>`,
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    container: 'fondo-oscuro'
                }
            });
        }
    }

    /**
     * Elimina un backup: llama a delete_backup.php
     */
    async function deleteBackup(filename) {
        const {
            isConfirmed
        } = await Swal.fire({
            title: '<span class="titulo-alerta advertencia">¿Eliminar?</span>',
            html: `
      <div class="custom-alert">
        <div class="contenedor-imagen">
          <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
        </div>
        <p>¿Eliminar permanentemente <strong>${filename}</strong>? Esta acción no se puede deshacer.</p>
      </div>`,
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'swal2-border-radius',
                confirmButton: 'btn-aceptar',
                cancelButton: 'btn-cancelar',
                container: 'fondo-oscuro'
            }
        });

        if (!isConfirmed) return;

        try {
            const resp = await fetch('../includes/delete_backup.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    file: filename
                })
            });
            const result = await resp.json();
            if (!result.success) throw new Error(result.message);

            await Swal.fire({
                title: '<span class="titulo-alerta confirmacion">Eliminado</span>',
                html: `
        <div class="custom-alert">
          <div class="contenedor-imagen">
            <img src="../imagenes/moto.png" alt="Confirmación" class="moto">
          </div>
          <p>${result.message}</p>
        </div>`,
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    container: 'fondo-oscuro'
                }
            });
            location.reload();
        } catch (err) {
            console.error(err);
            Swal.fire({
                title: '<span class="titulo-alerta error">Error</span>',
                html: `
        <div class="custom-alert">
          <div class="contenedor-imagen">
            <img src="../imagenes/llave.png" alt="Error" class="llave">
          </div>
          <p>${err.message}</p>
        </div>`,
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    container: 'fondo-oscuro'
                }
            });
        }
    }

    async function agregarBackup() {
        try {
            const resp = await fetch('../includes/backup.php');
            const result = await resp.json();
            if (!result.success) throw new Error(result.message);

            Swal.fire({
                title: '<span class="titulo-alerta confirmacion">Copia Creada</span>',
                html: `
        <div class="custom-alert">
          <div class="contenedor-imagen">
            <img src="../imagenes/moto.png" alt="Éxito" class="moto">
          </div>
          <p>${result.message}</p>
        </div>`,
                confirmButtonText: 'Aceptar',
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    container: 'fondo-oscuro'
                }
            }).then(() => location.reload());

        } catch (err) {
            console.error(err);
            Swal.fire({
                title: '<span class="titulo-alerta error">Error</span>',
                html: `
        <div class="custom-alert">
          <div class="contenedor-imagen">
            <img src="../imagenes/llave.png" alt="Error" class="llave">
          </div>
          <p>${err.message}</p>
        </div>`,
                confirmButtonText: 'Aceptar',
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    container: 'fondo-oscuro'
                }
            });
        }
    }



    document.addEventListener('DOMContentLoaded', () => {
        const rowsPerPage = 9;
        let currentPage = 1;
        let filteredData = [...allData];

        const tableBody = document.querySelector('#backupTable tbody');
        const paginationContainer = document.getElementById('jsPagination');
        const inputBusqueda = document.getElementById('searchRealtime');
        const headers = document.querySelectorAll('#backupTable thead th');

        // Render tabla:
        function renderTable() {
            const start = (currentPage - 1) * rowsPerPage;
            const pageData = filteredData.slice(start, start + rowsPerPage);

            tableBody.innerHTML = '';
            pageData.forEach(row => {
                const tr = document.createElement('tr');

                // Nombre
                let td = document.createElement('td');
                td.textContent = row.name;
                tr.appendChild(td);

                // Fecha
                td = document.createElement('td');
                td.textContent = row.date;
                tr.appendChild(td);

                // Tipo
                td = document.createElement('td');
                const span = document.createElement('span');
                span.className = `backup-type ${ row.type === 'Base de datos' ? 'type-db' : 'type-files' }`;
                span.textContent = row.type;
                td.appendChild(span);
                tr.appendChild(td);

                // Tamaño
                td = document.createElement('td');
                td.textContent = row.size;
                tr.appendChild(td);

                // Acciones
                td = document.createElement('td');
                td.innerHTML = `
        <button class="btn-restore" onclick="restoreBackup('${row.name}')">
          <i class="fas fa-undo"></i>
        </button>
        <button class="btn-delete"  onclick="deleteBackup ('${row.name}')">
          <i class="fas fa-trash"></i>
        </button>`;
                tr.appendChild(td);

                tableBody.appendChild(tr);
            });

            renderPaginationControls();
            attachActionBindings();
        }

        // Busqueda en tiempo real
        inputBusqueda.addEventListener('input', () => {
            const q = inputBusqueda.value.trim().toLowerCase();
            filteredData = allData.filter(r =>
                Object.values(r).some(v =>
                    String(v).toLowerCase().includes(q)
                )
            );
            currentPage = 1;
            renderTable();
        });

        // Paginación
        function renderPaginationControls() {
            paginationContainer.innerHTML = '';
            const totalPages = Math.ceil(filteredData.length / rowsPerPage);
            if (totalPages < 2) return;

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

            paginationContainer.append(btn('« Primera', 1), btn('‹ Anterior', Math.max(1, currentPage - 1)));

            let start = Math.max(1, currentPage - 2),
                end = Math.min(totalPages, currentPage + 2);
            if (start > 1) paginationContainer.append(Object.assign(document.createElement('span'), {
                textContent: '…'
            }));
            for (let i = start; i <= end; i++) paginationContainer.append(btn(i, i));
            if (end < totalPages) paginationContainer.append(Object.assign(document.createElement('span'), {
                textContent: '…'
            }));

            paginationContainer.append(btn('Siguiente ›', Math.min(totalPages, currentPage + 1)), btn(' Última »', totalPages));
        }

        // Ordenamiento
        const sortStates = {};
        headers.forEach((th, idx) => {
            const type = th.dataset.type;
            if (type === 'none') return;
            th.style.cursor = 'pointer';
            sortStates[idx] = true;
            th.onclick = () => {
                sortStates[idx] = !sortStates[idx];
                const asc = sortStates[idx];
                const field = th.dataset.field;
                filteredData.sort((a, b) => {
                    let va = a[field],
                        vb = b[field];
                    if (type === 'number') {
                        va = +a[field];
                        vb = +b[field];
                    }
                    if (type === 'date') {
                        va = new Date(a[field]);
                        vb = new Date(b[field]);
                    }
                    return (va < vb ? -1 : va > vb ? 1 : 0) * (asc ? 1 : -1);
                });
                headers.forEach(h => {
                    const sp = h.querySelector('.sort-arrow');
                    if (sp) sp.textContent = ''
                });
                th.querySelector('.sort-arrow').textContent = asc ? '▲' : '▼';
                currentPage = 1;
                renderTable();
            };
        });

        // Reenlazar botones de acción tras cada render
        function attachActionBindings() {
            document.querySelectorAll('.btn-restore').forEach(b =>
                b.addEventListener('click', e => {
                    /* tu restoreBackup */
                })
            );
            document.querySelectorAll('.btn-delete').forEach(b =>
                b.addEventListener('click', e => {
                    /* tu deleteBackup  */
                })
            );
        }

        // Inicializar
        renderTable();
    });
</script>
</body>

</html>