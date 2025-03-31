<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'].'../html/verificar_permisos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/componentes/accesibilidad-widget.php';
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Usuario</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <link rel="stylesheet" href="../css/configuracion.css" />
    <link rel="stylesheet" href="/componentes/header.php" />
    <link rel="stylesheet" href="/componentes/header.css" />
    <script src="../js/header.js"></script>
    <script src="/js/index.js"></script>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap");
    </style>
  </head>
  <body>
    <!-- Aquí se cargará el header -->
    <div id="menu"></div>

    <!-- Contenido principal -->
    <div class="main-content">
        <!-- Sección de Configuración -->
        <div id="configuracion" class="form-section" style="display: BLOCK;">
            <h1>Configuración</h1>
            <div class="submenu">
                <button onclick="showForm('nivelesStock')">Stock</button>
                <button onclick="showForm('gestionUsuarios')">Gestión de Usuarios</button>
                <button onclick="showForm('permisos')">Permisos</button>
                <button onclick="showForm('personalizacionReportes')">Personalización de Reportes</button>
                <button onclick="showForm('alertasInventario')">Alertas de Inventario</button>
                <button onclick="showForm('notificacionstock')">Notificaciones de Stock</button>
                <button onclick="showForm('frecuenciareportes')">Frecuencia de Reportes Automáticos</button>
            </div>
        </div>

        <!-- Sección para Niveles de Stock -->
        <div id="nivelesStock" class="form-section" style="display: none;">
            <h1>Niveles de Stock</h1>
        
        </div>

        <!-- Sección para Gestión de Usuarios -->
        <div id="gestionUsuarios" class="form-section" style="display: none;">
            <h1>Gestión de Usuarios</h1>
           
        </div>

        <!-- Sección para Permisos -->
        <div id="permisos" class="form-section" style="display: none;">
            <h1>Permisos</h1>
           
        </div>

        <!-- Sección para Personalización de Reportes -->
        <div id="personalizacionReportes" class="form-section" style="display: none;">
            <h1>Personalización de Reportes</h1>
         
        </div>

        <!-- Sección para Alertas de Inventario -->
        <div id="alertasInventario" class="form-section" style="display: none;">
            <h1>Alertas de Inventario</h1>
        </div>
         <!-- Sección para Notificaionnde Stock -->
         <div id="notificacionstock" class="form-section" style="display: none;">
            <h1>Notificacion de Stock</h1>  
        </div>

         <!-- Sección para Alertas de Inventario -->
         <div id="frecuenciareportes" class="form-section" style="display: none;">
            <h1>Frecuencias de Reportes Automaticos </h1>
         </div>
    </div>
  </body>
</html>
