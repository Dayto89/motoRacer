<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

$stmt = $conexion->prepare("
    SELECT id, mensaje, leida 
    FROM notificaciones 
    ORDER BY fecha DESC 
    LIMIT 10
");
$stmt->execute();
$result = $stmt->get_result();

$notificaciones = [];
while ($fila = $result->fetch_assoc()) {
    $notificaciones[] = $fila;
}

header('Content-Type: application/json');
echo json_encode($notificaciones);