<?php
session_start();
date_default_timezone_set('America/Bogota');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
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
        $file_size = formatSizeUnits(filesize($file_path));
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
                'path' => $file_path,
                'name' => $file,
                'date' => $creation_date,
                'size' => $file_size,
                'type' => $file_type
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


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestión de Copias de Seguridad</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="../componentes/header.css">
    <script src="../js/header.js"></script>
    <script src="/js/index.js"></script>
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Estilos mejorados para backups */
        .main-content {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            color: white;
            margin-top: 50px;
        }

        .main-content h1 {
            font-size: 50px;
            text-shadow: 7px -1px 0 #1c51a0, 1px -1px 0 #1c51a0, -1px 1px 0 #1c51a0, 3px 5px 0 #1c51a0;
        }

        .backup-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
        }

        .backup-table thead {
            align-items: center;
            justify-content: center;
        }

        .backup-table th,
        .backup-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
            color: white;
        }

        .backup-table th {
            background-color: #f5f5f5;
            font-weight: 600;
            color: black;
            font-size: 20px;
        }

        .backup-table td {
            font-size: 18px;
        }

        .backup-item-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-restore {
            background: #4CAF50;
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
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .type-db {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .type-files {
            background-color: #f0f4c3;
            color: #afb42b;
        }

        .filter-bar {
            display: flex;
            align-items: center;
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
            margin: 20px 0;
            display: flex;
            gap: 10px;
        }

        #search-input {
            padding: 15px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .search-container input {
            width: 300px;
            height: 40px;
        }

        .search-button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50px;
            height: 40px;
            width: 100px;
            font-size: 15px;
            cursor: pointer;
        }

        .search-button:hover {
            background-color: #0056b3;
            color: rgb(193, 121, 207);
        }

        .boton-agregar {

            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            height: 40px;
            width: 200px;
            font-size: 15px;
            cursor: pointer;
            margin-left: 48%;
        }

        .boton-agregar:hover {
            background-color: #0056b3;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 5px;
        }

        .pagination a {
            padding: 8px 12px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            text-decoration: none;
            color: #333;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: rgb(158, 146, 209);
        }

        .pagination a.active {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            pointer-events: none;
            border-color: #007bff;
        }
        *Alertas*/


/* Estilos generales de los párrafos */
p {
    font-size: 16px;
    color: black;
    font-family: arial;
    padding: 10px;
}



/* Ajuste para el popup de SweetAlert */
div:where(.swal2-container).swal2-center>.swal2-popup {
    width: 28%;
    /* Se ajusta automáticamente */
    max-width: 350px;
    /* Define un límite de ancho */
}



.custom-alert .tornillo,
.custom-alert .moto,
.custom-alert .llave {
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
    color: #e09804;
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

.swal2-border-radius {
    border-radius: 5px !important;
}



.fondo-oscuro {
    background-color: rgba(0, 0, 0, 0.7) !important;
    /* Fondo oscuro */
    backdrop-filter: blur(2px);
    /* Opcional: desenfoque sutil */
}

.swal2-popup {
    border-radius: 20px;
}

    </style>
</head>

<body>
    <div id="menu"></div>
    <div class="main-content">
        <h1>Gestión de Copias de Seguridad</h1>

        <div class="filter-bar">
            <form method="GET" action="copiadeseguridad.php" class="search-form">
                <div class="search-container">
                    <input id="#search-input" type="text"
                        name="busqueda"
                        placeholder="Buscar por nombre, fecha, tipo o tamaño..."
                        value="<?= htmlspecialchars($search_term) ?>"
                        aria-label="Buscar backups">
                    <button type="submit" class="search-button">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </form>
            <button class="boton boton-agregar" onclick="agregarBackup()">Nueva Copia de Seguridad</button>
        </div>

        <?php if (!empty($backups_pagina)): ?>
            <table class="backup-table">
                <thead>
                    <tr>
                        <th>Nombre del Backup</th>
                        <th>Fecha de Creación</th>
                        <th>Tipo</th>
                        <th>Tamaño</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
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
                                        <i class="fas fa-undo"></i> Restaurar
                                    </button>
                                    <button class="btn-delete"
                                        onclick="deleteBackup('<?= htmlspecialchars($backup['name']) ?>')">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

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
                    title: '<span class="titulo-alerta error">Información</span>',
                    html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <i class="fas fa-database fa-3x" style="color: #e0e0e0;"></i>
                    </div>
                    <p>No hay copias de seguridad</p>
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
            </script>
        <?php else: ?>
            <script>
                Swal.fire({
                    title: '<span class="titulo-alerta error">Información</span>',
                    html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <i class="fas fa-search fa-3x" style="color: #e0e0e0;"></i>
                    </div>
                    <p>No se encontraron resultados</p>
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
            </script>
        <?php endif; ?>
    </div>
<?php endif; ?>
</div>

<script>
    function agregarBackup() {
        window.location.href = "../includes/backup.php";
    }

    async function restoreBackup(filename) {
        const result = await Swal.fire({
            title: '<span class="titulo-alerta advertencia">¿Estás seguro?</span>',
            html: `
            <div class="custom-alert">
                <div class="contenedor-imagen">
                    <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                </div>
                <p>¿Restaurar ${filename}? ¡Esto sobrescribirá datos existentes!</p>
            </div>
        `,
            showCancelButton: true,
            confirmButtonText: 'Sí, restaurar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            background: '#ffffffdb',
            customClass: {
                popup: 'swal2-border-radius',
                confirmButton: 'btn-aceptar',
                cancelButton: 'btn-cancelar',
                container: 'fondo-oscuro'
            }
        });

        if (!result.isConfirmed) return;

        // Aquí continúa tu lógica original de restauración
        // ...
        try {
            // Tu código de restauración aquí
            console.log(`Restaurando backup: ${filename}`);
            // await tuFuncionDeRestauracion(filename);

            // Opcional: Mostrar mensaje de éxito
            await Swal.fire({
                title: '<span class="titulo-alerta exito">¡Éxito!</span>',
                html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <i class="fas fa-check-circle fa-3x" style="color: #28a745;"></i>
                    </div>
                    <p>El backup ${filename} se restauró correctamente</p>
                </div>
            `,
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#28a745',
                background: '#ffffffdb'
            });
        } catch (error) {
            // Manejo de errores
            await Swal.fire({
                title: '<span class="titulo-alerta error">Error</span>',
                html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <i class="fas fa-exclamation-triangle fa-3x" style="color: #dc3545;"></i>
                    </div>
                    <p>Error al restaurar el backup: ${error.message}</p>
                </div>
            `,
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#dc3545',
                background: '#ffffffdb'
            });
        }
    }

    async function deleteBackup(filename) {
        const confirmation = await Swal.fire({
            title: '<span class="titulo-alerta advertencia">¿Estás seguro?</span>',
            html: `
            <div class="custom-alert">
                <div class="contenedor-imagen">
                    <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                </div>
                <p>¿Eliminar ${filename} permanentemente? Esta acción no se puede deshacer.</p>
            </div>
        `,
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            background: '#ffffffdb',
            customClass: {
                popup: 'swal2-border-radius',
                confirmButton: 'btn-aceptar',
                cancelButton: 'btn-cancelar',
                container: 'fondo-oscuro'
            }
        });

        if (!confirmation.isConfirmed) return;

        try {
            const response = await fetch('../includes/delete_backup.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    file: filename
                }),
            });

            const result = await response.text();

            await Swal.fire({
                title: '<span class="titulo-alerta exito">¡Éxito!</span>',
                html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <i class="fas fa-check-circle fa-3x" style="color: #28a745;"></i>
                    </div>
                    <p>${result}</p>
                </div>
            `,
                background: '#ffffffdb',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#28a745',
                customClass: {
                    popup: 'swal2-border-radius',
                    container: 'fondo-oscuro'
                }
            });

            location.reload();
        } catch (error) {
            await Swal.fire({
                title: '<span class="titulo-alerta error">Error</span>',
                html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <i class="fas fa-exclamation-triangle fa-3x" style="color: #dc3545;"></i>
                    </div>
                    <p>Error al eliminar el backup: ${error.message}</p>
                </div>
            `,
                background: '#ffffffdb',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#dc3545',
                customClass: {
                    popup: 'swal2-border-radius',
                    container: 'fondo-oscuro'
                }
            });
        }
    }
</script>
</body>

</html>