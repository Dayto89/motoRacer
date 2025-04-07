<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    die('Acceso no autorizado');
}

$backup_dir = 'C:/xampp/htdocs/Proyecto SIMR/backups/';
$data = json_decode(file_get_contents('php://input'), true);
$filename = $data['file'];

// Validación corregida (agregar "_db" en el patrón)
if (!preg_match('/^backup_db_\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2}\.sql$/', $filename)) {
    die('Archivo no válido');
}

$file_path = $backup_dir . $filename;

// Verificar que el archivo existe antes de eliminar
if (!file_exists($file_path)) {
    die('El archivo no existe');
}

// Verificar permisos de escritura
if (!is_writable($file_path)) {
    die('Sin permisos para eliminar');
}

if (unlink($file_path)) {
    echo "Backup eliminado correctamente";
} else {
    echo "Error al eliminar (Verifica permisos)";
}
?>