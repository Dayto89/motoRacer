<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar autenticación
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

// Configuración de rutas
$backup_dir = 'C:/xampp/htdocs/Proyecto SIMR/backups/';
$search_term = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

// Obtener y filtrar backups
$backups = [];
$files = scandir($backup_dir);
foreach ($files as $file) {
    if ($file !== "." && $file !== ".." && preg_match('/\.(sql|zip)$/i', $file)) {
        $file_path = $backup_dir . $file;
        $file_info = pathinfo($file_path);

        // Datos para búsqueda
        $creation_date = date("Y-m-d H:i:s", filemtime($file_path));
        $file_size = formatSizeUnits(filesize($file_path));
        $file_type = ($file_info['extension'] === 'sql') ? 'Base de datos' : 'Archivos';
        $searchable_date = date("d/m/Y H:i:s", filemtime($file_path));

        // Coincidencias de búsqueda
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

// Función para formatear tamaños
function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
    if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
    if ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
    return $bytes . ' bytes';
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestión de Backups</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="../componentes/header.css">
    <link rel="stylesheet" href="../componentes/header.php">
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
        }

        .backup-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
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
            padding: 8px;
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
    </style>
</head>

<body>
    <div id="menu"></div>
    <div class="main-content">
        <h1>Gestión de Copias de Seguridad</h1>

        <!-- Barra de búsqueda mejorada -->
        <div class="filter-bar">
            <form method="GET" action="pruebaBackups.php" class="search-form">
                <div class="search-container">
                    <input type="text"
                        name="busqueda"
                        placeholder="Buscar por nombre, fecha, tipo o tamaño..."
                        value="<?= htmlspecialchars($search_term) ?>"
                        aria-label="Buscar backups">
                    <button type="submit" class="search-button">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </form>
        </div>

        <?php if (!empty($backups)): ?>
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
                    <?php foreach ($backups as $backup): ?>
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
        <?php else: ?>
            <div class="no-backups">
                <i class="fas fa-database fa-3x" style="color: #e0e0e0; margin-bottom: 1rem;"></i>
                <p><?= empty($search_term) ? 'No hay copias de seguridad' : 'No se encontraron resultados' ?></p>
            </div>
        <?php endif; ?>
    </div>


    <script>
        async function restoreBackup(filename) {
            if (!confirm(`¿Restaurar ${filename}? ¡Esto sobrescribirá datos!`)) return;

            try {
                const response = await fetch('../includes/restore.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        file: filename
                    }),
                });
                const result = await response.text();
                alert(result);
            } catch (error) {
                alert("Error: " + error.message);
            }
        }
        // Función para eliminar backups
        async function deleteBackup(filename) {
            if (!confirm(`¿Eliminar ${filename} permanentemente?`)) return;

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
                alert(result);
                location.reload(); // Recarga la página para actualizar la lista
            } catch (error) {
                alert("Error: " + error.message);
            }
        }
    </script>
</body>

</html>