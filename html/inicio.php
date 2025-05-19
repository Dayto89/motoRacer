<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
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
    <link rel="stylesheet" href="../css/alertas.css">
    <script src="../js/header.js"></script>
    <script src="/js/index.js"></script>
    <link rel="stylesheet" href="/css/inicio.css">
    <script src="https://kit.fontawesome.com/d6f1e7ff1f.js"></script>
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
    <style>
        /* Agregar estilos para las notificaciones */
        .notificaciones {
            position: fixed;
            top: 100px;
            right: 20px;
            background-color: rgb(174 174 174 / 59%);
            border: 1px solid #ccc;
            width: 350px;
            max-height: 85%;
            overflow-y: auto;
            display: none;
            /* Oculto por defecto */
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 15px;
            letter-spacing: 1px;
        }

        .notificaciones h3 {
            margin-top: 0;
            color: white;
            font-size: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            text-shadow: 7px -1px 0 #1c51a0, 1px -1px 0 #1c51a0, -1px 1px 0 #1c51a0, 3px 5px 0 #1c51a0;
            letter-spacing: 3px;
        }

        #listaNotificaciones {
            list-style: none;
            padding: 0;
            margin: 0;
            color: black;
        }

        #listaNotificaciones li {
            padding: 10px;
            margin: 5px 0;
            font-size: 14px;
            background: #f8f9fa;
            font-family: Arial, Helvetica, sans-serif;
            border-left: 8px solid rgb(255, 191, 0);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #listaNotificaciones li.leida {
            background: #fff;
            border-left-color: rgb(0, 0, 0);
            opacity: 0.7;
        }

        #listaNotificaciones li:hover {
            background: rgb(184, 186, 187);
        }

        .badge-notificaciones {
            position: absolute;
            top: 10px;
            right: 8px;
            background: #ff4444;
            color: white;
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: bold;
            display: none;
            min-width: 20px;
            text-align: center;
        }

        .noti {
            position: fixed;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            cursor: pointer;
            z-index: 1001;
        }

        .notificaciones::-webkit-scrollbar {
            width: 8px;
            background-color: rgba(174, 174, 174, 0.2);
            border-radius: 4px;
        }

        .notificaciones::-webkit-scrollbar-track {
            background-color: rgba(174, 174, 174, 0.3);
            border-radius: 4px;
        }

        .notificaciones::-webkit-scrollbar-thumb {
            background-color: rgb(6, 45, 91);
            border-radius: 4px;
            border: 1px solid rgba(0, 0, 0, 0.9);
        }
    </style>
</head>

<body>
    <div id="menu"></div>
    <div class="fondo"></div>

    <div class="inicio-img-container">
        <img src="/imagenes/LOGO.webp" alt="Imagen centrada" class="inicio-img">

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
            attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":2.5,"defaultColours":{"group-1":"#1B1B1BFF","group-2":"#000000FF","background":"#FFFFFFFF"}}'
            height="70"
            width="70"></animated-icons>
        <div id="badgeNotificaciones" class="badge-notificaciones">0</div>
    </button>

    <script>
        // Función para mostrar/ocultar notificaciones
        function mostrarNotificaciones() {
            const notificaciones = document.getElementById('notificaciones');
            notificaciones.style.display = notificaciones.style.display === 'none' ? 'block' : 'none';
        }

        // Cargar notificaciones cada 30 segundos
        function cargarNotificaciones() {
            fetch('../html/obtener_notificaciones.php')
                .then(response => {
                    if (!response.ok) throw new Error('Error en la respuesta');
                    return response.json();
                })
                .then(data => {
                    const lista = document.getElementById("listaNotificaciones");
                    lista.innerHTML = data.map(notif => `
                        <li class="${notif.leida ? 'leida' : 'nueva'}" 
                            onclick="marcarLeida(${notif.id}, this)">
                            <small>${new Date(notif.fecha).toLocaleString()}</small><br>
                            ${notif.mensaje}
                        </li>
                    `).join('');
                    const contador = data.filter(notif => !notif.leida).length;
                    const badge = document.getElementById('badgeNotificaciones');
                    badge.textContent = contador;
                    badge.style.display = contador > 0 ? 'block' : 'none';
                })
                .catch(error => console.error('Error:', error));
        }

        // Función para marcar como leída
        function marcarLeida(id, elemento) {
            fetch(`../html/marcar_leida.php?id=${id}`)
                .then(response => {
                    if (response.ok) {
                        if (!elemento.classList.contains('leida')) {
                            const badge = document.getElementById('badgeNotificaciones');
                            const currentCount = parseInt(badge.textContent) || 0;
                            badge.textContent = currentCount - 1;
                            if (currentCount - 1 <= 0) {
                                badge.style.display = 'none';
                            }
                        }
                        elemento.classList.remove('nueva');
                        elemento.classList.add('leida');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Cargar al iniciar y cada 30 segundos
        document.addEventListener('DOMContentLoaded', () => {
            cargarNotificaciones();
            setInterval(cargarNotificaciones, 30000);
        });
    </script>
</body>

</html>