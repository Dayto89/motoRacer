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

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conexion->prepare("UPDATE notificaciones SET leida = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}