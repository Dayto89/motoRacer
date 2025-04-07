<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    die('Acceso no autorizado');
}

$backup_dir = __DIR__ . '/../backups/';
$data = json_decode(file_get_contents('php://input'), true);
$filename = $data['file'];

// Validación reforzada del nombre
if (!preg_match('/^backup_db_\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2}\.sql$/', $filename)) {
    die('Nombre de archivo inválido');
}

$file_path = $backup_dir . $filename;

// Verificar existencia del archivo
if (!file_exists($file_path)) {
    die('El archivo de backup no existe');
}

// Comando con rutas absolutas y redirección de errores
$command = '"C:\xampp\mysql\bin\mysql.exe" --user=root --password= --host=localhost inventariomotoracer < "' . $file_path . '" 2>&1';

exec($command, $output, $return_code);

if ($return_code === 0) {
    echo "Base de datos restaurada con éxito";
} else {
    echo "Error al restaurar (Código $return_code):<br>" . implode("<br>", $output);
}