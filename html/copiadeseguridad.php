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
$por_pagina = 6;
$total_backups = count($backups);
$total_paginas = ceil($total_backups / $por_pagina);
$pagina_actual = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$pagina_actual = max(1, min($total_paginas, $pagina_actual));
$inicio = ($pagina_actual - 1) * $por_pagina;
$backups_pagina = array_slice($backups, $inicio, $por_pagina);

include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
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

        /* Añadir estilos para la paginación */
        .pagination {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .pagination button {
            padding: 8px 12px;
            border: 1px solid #ddd;
            background: #f5f5f5;
            cursor: pointer;
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
        /* ... (todo el CSS que ya tenías, sin cambios) ... */
        .pagination {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .pagination button {
            padding: 8px 12px;
            border: 1px solid #ddd;
            background: #f5f5f5;
            cursor: pointer;
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
            <div class="pagination">
                <?php if ($pagina_actual > 1): ?>
                    <a href="?busqueda=<?= urlencode($search_term) ?>&pagina=<?= $pagina_actual - 1 ?>">
                        <button>&laquo; Anterior</button>
                    </a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <a href="?busqueda=<?= urlencode($search_term) ?>&pagina=<?= $i ?>">
                        <button <?= ($i === $pagina_actual) ? 'style="font-weight:bold;background-color:#007bff;color:white;"' : '' ?>>
                            <?= $i ?>
                        </button>
                    </a>
                <?php endfor; ?>

                <?php if ($pagina_actual < $total_paginas): ?>
                    <a href="?busqueda=<?= urlencode($search_term) ?>&pagina=<?= $pagina_actual + 1 ?>">
                        <button>Siguiente &raquo;</button>
                    </a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="no-backups">
                <i class="fas fa-database fa-3x" style="color: #e0e0e0; margin-bottom: 1rem;"></i>
                <p><?= empty($search_term) ? 'No hay copias de seguridad' : 'No se encontraron resultados' ?></p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function agregarBackup() {
            window.location.href = "../includes/backup.php";
        }

        async function restoreBackup(filename) {
            if (!confirm(`¿Restaurar ${filename}? ¡Esto sobrescribirá datos!`)) return;

            try {
                const response = await fetch('../includes/restore.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ file: filename }),
                });
                const result = await response.text();
                alert(result);
            } catch (error) {
                alert("Error: " + error.message);
            }
        }

        async function deleteBackup(filename) {
            if (!confirm(`¿Eliminar ${filename} permanentemente?`)) return;

            try {
                const response = await fetch('../includes/delete_backup.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ file: filename }),
                });
                const result = await response.text();
                alert(result);
                location.reload();
            } catch (error) {
                alert("Error: " + error.message);
            }
        }
    </script>
</body>
</html>

