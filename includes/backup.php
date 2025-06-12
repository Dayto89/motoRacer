<?php

session_start();

date_default_timezone_set('America/Bogota');
header('Content-Type: application/json; charset=UTF-8');

// 1) Comprobar sesión
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['success'=>false,'message'=>'No autorizado']);
    exit;
}

// 2) Parámetros de conexión
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'inventariomotoracer';

// 3) Conectar
$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(['success'=>false,'message'=>'Error de conexión DB: '.$mysqli->connect_error]);
    exit;
}
$mysqli->set_charset('utf8');

// 4) Preparar nombre de archivo
$backupDir = __DIR__ . '/../backups/';
if (!is_dir($backupDir)) mkdir($backupDir, 0755, true);

$filename = "{$dbName}_" . date('Ymd_His') . '.sql';
$filePath = $backupDir . $filename;

// 5) Abrir para escritura
if (! $fp = fopen($filePath, 'w')) {
    http_response_code(500);
    echo json_encode(['success'=>false,'message'=>"No se puede escribir $filePath"]);
    exit;
}

// 6) Cabecera del volcado
fwrite($fp, "-- Volcado de la base de datos `{$dbName}`\n");
fwrite($fp, "-- Fecha: ". date('Y-m-d H:i:s') ."\n\n");
// ** INI : asegurar UTF-8 **
fwrite($fp, "/*!40101 SET NAMES utf8mb4 */;\n");
fwrite($fp, "/*!40101 SET CHARACTER SET utf8mb4 */;\n\n");
fwrite($fp, "SET FOREIGN_KEY_CHECKS=0;\n\n");


// 7) Obtener todas las tablas
$tables = [];
$res = $mysqli->query("SHOW TABLES");
while ($row = $res->fetch_array()) {
    $tables[] = $row[0];
}
$res->free();

// 8) Para cada tabla: CREATE y INSERTs
foreach ($tables as $table) {
    // 8.1) DROP + CREATE
    fwrite($fp, "-- -----------------------------\n");
    fwrite($fp, "-- Estructura de la tabla `$table`\n");
    fwrite($fp, "-- -----------------------------\n");
    fwrite($fp, "DROP TABLE IF EXISTS `$table`;\n");
    $row = $mysqli->query("SHOW CREATE TABLE `$table`")->fetch_assoc();
    fwrite($fp, $row['Create Table'] . ";\n\n");

    // 8.2) Datos
    fwrite($fp, "-- -----------------------------\n");
    fwrite($fp, "-- Datos de la tabla `$table`\n");
    fwrite($fp, "-- -----------------------------\n");
    $res2 = $mysqli->query("SELECT * FROM `$table`");
    while ($r = $res2->fetch_assoc()) {
        $columns = array_keys($r);
        $values  = array_map(function($v) use ($mysqli){
            if (is_null($v)) return 'NULL';
            return "'".$mysqli->real_escape_string($v)."'";
        }, array_values($r));
        fwrite(
            $fp,
            "INSERT INTO `$table` (`". implode('`,`',$columns) ."`) VALUES (". implode(',', $values) .");\n"
        );
    }
    $res2->free();
    fwrite($fp, "\n");
}

// 9) Pie del volcado
fwrite($fp, "SET FOREIGN_KEY_CHECKS=1;\n");
fclose($fp);
$mysqli->close();

// 10) Devolver respuesta
echo json_encode([
    'success'  => true,
    'message'  => "Backup “{$filename}” creado correctamente.",
    'filename' => $filename
]);
exit;
