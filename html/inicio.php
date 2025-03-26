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
    <link rel="stylesheet" href="/componentes/header.php">
    <link rel="stylesheet" href="/componentes/header.css">
    <script src="../js/header.js"></script>
    <script src="/js/index.js"></script>
    <link rel="stylesheet" href="/css/inicio.css">
    <script src="https://kit.fontawesome.com/d6f1e7ff1f.js"></script>
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
</head>

<body>
    <!-- Aquí se cargará el header -->
    <div id="menu"></div>
    <div class="fondo"></div>

    <div class="inicio-img-container">
        <img src="/imagenes/LOGO.png" alt="Imagen centrada" class="inicio-img">

    </div>
    <div class="texto-debajo">
        <h2> SOFTWARE DE INVENTARIO MOTO RACER </h2>
    </div>
    <div id="notificaciones" class="notificaciones">
        <h3>Notificaciones</h3>
        <ul id="listaNotificaciones"></ul>
    </div>
    <button class="noti" onclick="mostrarNotificaciones()"><animated-icons
            src="https://animatedicons.co/get-icon?name=notification&style=minimalistic&token=2a8c285f-a7a0-4f4d-b2c3-acccc136c454"
            trigger="loop-on-hover"
            attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":0.8400000000000001,"defaultColours":{"group-1":"#000000FF","group-2":"#000000FF","background":"#FFFA00FF"}}'
            height="80"
            width="80"></animated-icons></button>
    <script>
        // Cargar notificaciones cada 30 segundos
        function cargarNotificaciones() {
            fetch('../html/obtener_notificaciones.php')
                .then(response => response.json())
                .then(data => {
                    const lista = document.getElementById("listaNotificaciones");
                    lista.innerHTML = data.map(notif => `
                <li class="${notif.leida ? 'leida' : 'nueva'}" 
                    onclick="marcarLeida(${notif.id})">
                    ${notif.mensaje}
                </li>
            `).join('');
                });
        }

        function marcarLeida(id) {
            fetch(`../html/marcar_leida.php?id=${id}`);
        }

        setInterval(cargarNotificaciones, 30000);
        cargarNotificaciones();
    </script>

</body>


</html>