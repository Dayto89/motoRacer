<?php
date_default_timezone_set('America/Bogota'); // 🕒 Establecer zona horaria Colombia

// Configuración
$backup_dir = 'C:/xampp/htdocs/Proyecto SIMR/backups/';
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'inventariomotoracer';
$retention_days = 90; // Cambia si quieres conservar más días

// Asegura que la carpeta de backups existe
if (!is_dir($backup_dir)) {
    mkdir($backup_dir, 0777, true);
}

// Eliminar backups viejos
$files = glob($backup_dir . 'backup_db_*.sql');
$now = time();

foreach ($files as $file) {
    if (is_file($file)) {
        $file_time = filemtime($file);
        $file_age = ($now - $file_time) / (60 * 60 * 24); // En días
        if ($file_age > $retention_days) {
            unlink($file);
        }
    }
}

// Crear nuevo backup con hora colombiana
$sql_file = $backup_dir . 'backup_db_' . date('Y-m-d_H-i-s') . '.sql';
$command = "C:\\xampp\\mysql\\bin\\mysqldump --user=$db_user --password=$db_pass --host=$db_host $db_name > \"$sql_file\" 2>&1";
exec($command, $sql_output, $sql_code);

// Mostrar confirmación
if ($sql_code === 0) {
    echo "Backup realizado correctamente: " . basename($sql_file);
    echo "<script>location.href='../html/copiadeseguridad.php';</script>";
} else {
    echo "Error al generar backup: " . implode("\n", $sql_output);
}
?>
