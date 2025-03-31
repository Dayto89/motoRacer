<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/componentes/header.php';
?>

<div class="container">
    <h2>Acceso Denegado</h2>
    <p>No tienes permisos para acceder a esta sección.</p>
    <a href="dashboard.php" class="btn btn-primary">Volver al Inicio</a>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/componentes/footer.php'; ?>