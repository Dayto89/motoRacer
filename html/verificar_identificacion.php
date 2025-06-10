<?php
require '../conexion/conexion.php';

$identificacion = isset($_GET['identificacion']) ? $_GET['identificacion'] : '';

if (!empty($identificacion)) {
    $conexion = conectar();
    
    $stmt = $conexion->prepare("SELECT identificacion FROM usuario WHERE identificacion = ?");
    $stmt->bind_param("s", $identificacion);
    $stmt->execute();
    $stmt->store_result();
    
    $existe = $stmt->num_rows > 0;
    
    echo json_encode(['existe' => $existe]);
    
    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(['existe' => false]);
}
?>