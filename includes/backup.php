<?php
// Configuración
$backup_dir = 'C:/xampp/htdocs/Proyecto SIMR/backups/';
$db_host = 'localhost';
$db_user = 'root';
$db_pass = ''; // Si tienes contraseña, colócala aquí
$db_name = 'inventariomotoracer'; // ¡Reemplaza esto!

// Asegurar que la carpeta existe
if (!is_dir($backup_dir)) {
    mkdir($backup_dir, 0777, true);
}

// 1. Backup de la base de datos
$sql_file = $backup_dir . 'backup_db_' . date('Y-m-d_H-i-s') . '.sql';
$command = "C:\\xampp\\mysql\\bin\\mysqldump --user=$db_user --password=$db_pass --host=$db_host $db_name > \"$sql_file\" 2>&1";
exec($command, $sql_output, $sql_code);

if ($sql_code !== 0) {
    die("Error al generar backup de la BD: " . implode("\n", $sql_output));
}

// Volver a los backups
echo '<script>location.href="../html/copiadeseguridad.php"</script>';

?>