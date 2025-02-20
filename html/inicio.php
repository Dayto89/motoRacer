<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio/Moto Racer</title>
    <link rel="icon" type="image/x-icon" href="../imagenes/logo1.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/css/inicio.css">
    <link rel="stylesheet" href="/componentes/header.html">
    <link rel="stylesheet" href="/componentes/header.css">
    <script src="https://kit.fontawesome.com/d6f1e7ff1f.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
        </style>
</head>
<body>
    
    <!-- Aquí se cargará el header -->
    <div id="menu"></div>
    
    <div class="inicio-img-container">
        <img src="/imagenes/LOGO.png" alt="Imagen centrada" class="inicio-img">
        
    </div>
    <div class="texto-debajo"><h2> SOFTWARE DE INVENTARIO MOTO RACER </h2>
    </div>
    <script src="/js/index.js"></script>
</body>

</html>