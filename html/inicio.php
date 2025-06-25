<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
if ($conexion->connect_errno) {
    die("No se pudo conectar a la base de datos: " . $conexion->connect_error);
}

// Obtener configuración existente (última fila de configuracion_stock)
$config = ['min_quantity' => 0, 'alarm_time' => '', 'notification_method' => ''];
$stmtConfig = $conexion->prepare("SELECT * FROM configuracion_stock ORDER BY id DESC LIMIT 1");
if ($stmtConfig->execute()) {
    $resultConfig = $stmtConfig->get_result();
    if ($resultConfig->num_rows > 0) {
        $config = $resultConfig->fetch_assoc();
    }
}
$stmtConfig->close();

// Procesar formulario al enviar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_config_stock'])) {
    // Validar y sanitizar inputs
    $min_quantity = isset($_POST['min_quantity']) ? (int) $_POST['min_quantity'] : 0;
    $alarm_time = $_POST['alarm_time'] ?? null;
    $notification_method = $_POST['notification_method'] ?? 'popup';

    $stmtInsert = $conexion->prepare("INSERT INTO configuracion_stock 
        (min_quantity, alarm_time, notification_method) VALUES (?, ?, ?)");
    $stmtInsert->bind_param("iss", $min_quantity, $alarm_time, $notification_method);

    if ($stmtInsert->execute()) {
        header("Location: inicio.php?success=1");
        exit();
    } else {
        header("Location: inicio.php?error=1");
        exit();
    }
    $stmtInsert->close();
}

// Facturas diarias de este mes
$stmt = $conexion->prepare(
    "SELECT DAY(fechaGeneracion) AS dia, COUNT(*) AS cantidad
     FROM factura
     WHERE MONTH(fechaGeneracion) = MONTH(NOW())
       AND YEAR(fechaGeneracion) = YEAR(NOW())
     GROUP BY DAY(fechaGeneracion)"
);
$stmt->execute();
$result = $stmt->get_result();
$facturas_diarias = [];
while ($row = $result->fetch_assoc()) {
    $facturas_diarias[$row['dia']] = $row['cantidad'];
}
$stmt->close();

// --------------------
// METRICAS PARA DASHBOARD (1 a 7)
// --------------------
$metrics = [];

// 1. Total de productos
$res = $conexion->query("SELECT COUNT(*) AS total_products FROM producto");
$metrics['total_products'] = $res->fetch_assoc()['total_products'];

// 2. Productos con stock bajo
$stmt = $conexion->prepare(
    "SELECT COUNT(*) AS low_stock FROM producto WHERE cantidad < ?"
);
$stmt->bind_param("i", $config['min_quantity']);
$stmt->execute();
$metrics['low_stock'] = $stmt->get_result()->fetch_assoc()['low_stock'];
$stmt->close();

// 3. Total de proveedores
$res = $conexion->query("SELECT COUNT(*) AS total_providers FROM proveedor");
$metrics['total_providers'] = $res->fetch_assoc()['total_providers'];

// 4. Total de clientes
$res = $conexion->query("SELECT COUNT(*) AS total_clients FROM cliente");
$metrics['total_clients'] = $res->fetch_assoc()['total_clients'];

// 5. Facturas este mes
$stmt = $conexion->prepare(
    "SELECT COUNT(*) AS invoices_month FROM factura
     WHERE MONTH(fechaGeneracion) = MONTH(NOW())
       AND YEAR(fechaGeneracion) = YEAR(NOW())"
);
$stmt->execute();
$metrics['invoices_month'] = $stmt->get_result()->fetch_assoc()['invoices_month'];
$stmt->close();


// 7. Notificaciones no leídas
$res = $conexion->query("SELECT COUNT(*) AS unread_notif FROM notificaciones WHERE leida = 0");
$metrics['unread_notif'] = $res->fetch_assoc()['unread_notif'];

// --------------------
// Lógica Usuario
// --------------------
$conexionUsuario = new mysqli('localhost', 'root', '', 'inventariomotoracer');
$id_usuario = $_SESSION['usuario_id'];
$sqlUsuario = "SELECT nombre, apellido, rol, foto FROM usuario WHERE identificacion = ?";
$stmtUsuario = $conexionUsuario->prepare($sqlUsuario);
$stmtUsuario->bind_param("i", $id_usuario);
$stmtUsuario->execute();
$resultUsuario = $stmtUsuario->get_result();
$rowUsuario = $resultUsuario->fetch_assoc();
$nombreUsuario = $rowUsuario['nombre'];
$apellidoUsuario = $rowUsuario['apellido'];
$rol = $rowUsuario['rol'];
$foto = $rowUsuario['foto'];
$stmtUsuario->close();

include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Moto Racer</title>
    <link rel="icon" type="image/x-icon" href="../imagenes/logo1.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/componentes/header.php">
    <link rel="stylesheet" href="/componentes/header.css">
    <link rel="stylesheet" href="../css/alertas.css">
    <script src="../js/header.js"></script>
    <script src="/js/index.js"></script>
    <link rel="stylesheet" href="/css/inicio.css">
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
    <style>
        .chart-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1rem;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .modo-alto-contraste .chart-container {
            background-color: black;
        }

        .modo-claro .chart-container {
            border: 4px solid #000000;
        }
        
        /* --- NUEVO CSS PARA ANIMACIÓN DE MODALES --- */

        /* Estilos base para ambos modales (notificaciones y stock) */
        .modal-animado {
            background-color: rgb(174 174 174 / 59%);
            border: 1px solid #ccc;
            width: 350px;
            max-height: 85%;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 15px;
            letter-spacing: 1px;
            
            /* Estado inicial para la animación (oculto) */
            opacity: 0;
            transform: translateY(-20px); /* Empieza 20px arriba */
            pointer-events: none; /* No se puede interactuar con el modal invisible */
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        /* Clase que activa el modal (lo hace visible con animación) */
        .modal-animado.modal-activo {
            opacity: 1;
            transform: translateY(0); /* Vuelve a su posición original */
            pointer-events: auto; /* Se puede interactuar con el modal */
        }
        
        /* Posicionamiento específico del modal de notificaciones */
        #notificaciones {
            position: fixed;
            top: 120px;
            right: 20px;
        }

        /* Posicionamiento específico del modal de stock */
        #stock {
            position: fixed;
            top: 120px;
            right: 20px; /* Ajusta este valor si se solapa con el de notificaciones */
        }
        
        /* --- FIN DEL NUEVO CSS --- */


        .notificaciones h3, #stock h3 {
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
            top: 57px;
            right: 26px;
            background: #ff4444;
            color: white;
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: bold;
            display: none;
            min-width: 20px;
            text-align: center;
            z-index: 1001;
        }

        .noti {
            position: fixed;
            top: 50px;
            right: 20px;
            background: none;
            border: none;
            cursor: pointer;
            z-index: 1001;
        }

        .noti img {
            width: 65px;
            height: 65px;
        }

        .stock img {
            width: 65px;
            height: 65px;
        }
        
        /* --- NUEVO: Posicionamiento del botón de stock --- */
            .notificaciones {
        position: fixed;
        top: 120px;
        right: 20px;
        background-color: rgb(174 174 174 / 59%);
        border: 1px solid #ccc;
        width: 350px;
        max-height: 85%;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 15px;
        letter-spacing: 1px;
        
        /* LA LÍNEA 'display: none;' HA SIDO ELIMINADA DE AQUÍ */
    }

    /* Estilos base para AMBOS modales */
    .modal-animado {
        /* ¡CLAVE! Asegura que el modal exista en el layout para poder ser animado */
        display: block; 
        
        /* Estado inicial (oculto) */
        opacity: 0;
        transform: translateY(-20px);
        pointer-events: none;
        transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
    }

    /* Clase que activa el modal (lo hace visible con animación) */
    .modal-animado.modal-activo {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }
    
    /* Posicionamiento específico del modal de stock */
        .stock {
            position: fixed;
            top: 50px;
            right: 100px; /* Ajusta para que no se solape con el botón de notificaciones */
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

        .dashboard-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            padding: 5.5rem 16.5rem 1.5rem 16.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .chart-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            position: relative;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            aspect-ratio: 4 / 3;
        }

        .chart-container canvas {
            width: 100% !important;
            height: 100% !important;
        }

        .metric-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            perspective: 1000px;
            transform-style: preserve-3d;
            border: 4px solid #ffffff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15), inset 0 0 10px rgba(255, 255, 255, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .metric-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2), inset 0 0 15px rgba(255, 255, 255, 0.5);
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0));
            transform: rotate(30deg);
            pointer-events: none;
            transition: all 0.5s ease;
        }

        .metric-card:hover::before {
            top: -70%;
            left: -70%;
        }

        .metric-card h4 {
            font-size: 1rem;
            color: #333;
            margin-bottom: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: 'Merriweather', serif;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .metric-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1c51a0;
            line-height: 1;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .metric-value small {
            font-size: 0.75rem;
            font-weight: 400;
            vertical-align: super;
        }

        #menu:hover~.ubica {
            margin-left: 20px;
        }

        #menu:hover~.ubica {
            margin-left: 20px;
            transition: margin-left 0.3s ease;
            margin-right: 0px;
        }

        #btnMarcar20 {
            background-color: #007bff;
            font-weight: bold;
            color: white;
            border: none;
            padding: 8px 20px;
            font-size: 1.2rem;
            cursor: pointer;
            border-radius: 10px;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        #btnMarcar20:hover {
            background-color: rgb(0, 71, 148);
        }

        @media (max-width: 600px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }

            button.noti, button.stock {
                width: 50px;
                height: 50px;
            }

            .userContainer {
                flex-direction: column;
                bottom: 80px;
            }
        }
    </style>
</head>

<body>
    <?php include 'boton-ayuda.php'; ?>
    <div id="menu"></div>
    <div class="ubica">Inicio</div>
    <div class="fondo"></div>

    <div class="dashboard-container">
        <?php
        $labels = [
            'total_products'  => 'Total Productos',
            'low_stock'       => 'Stock Bajo',
            'total_providers' => 'Proveedores',
            'total_clients'   => 'Clientes',
            'invoices_month'  => 'Facturas Mes',
            'unread_notif'    => 'Notificaciones'
        ];
        foreach ($labels as $key => $label): ?>
            <div class="metric-card">
                <h4><?= $label ?></h4>
                <p class="metric-value"><?= number_format($metrics[$key], 0, ',', '.') ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="charts-grid">
        <div class="chart-container">
            <canvas id="metricsChart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="stockPieChart"></canvas>
        </div>
        <?php if (isset($facturas_diarias)): ?>
            <div class="chart-container">
                <canvas id="invoicesLineChart"></canvas>
            </div>
        <?php endif; ?>
    </div>
    
    <div id="notificaciones" class="notificaciones modal-animado">
        <h3>Notificaciones</h3>
        <button id="btnMarcar20" onclick="marcarUltimasLeidas()" style="margin-bottom:10px; width:100%;">
            Marcar Todas Leidas
        </button>
        <ul id="listaNotificaciones"></ul>
    </div>

    <button class="noti" onclick="mostrarNotificaciones()" title="notificaciones">
        <img src="../imagenes/notification.gif" alt="notificaciones">
    </button>
    <div id="badgeNotificaciones" class="badge-notificaciones">0</div>

    <button class="stock" onclick="mostrarStock()" title="stock">
        <img src="../imagenes/stock.gif" alt="stock">
    </button>
    
    <div id="stock" class="cantidad modal-animado"> <h3>Stock</h3>
        <div class="form-stock">
            <form method="POST">
                <input type="hidden" name="guardar_config_stock" value="1">
                <div class="form-group">
                    <label for="min_quantity">Cantidad Mínima:</label>
                    <input type="text" id="min_quantity" name="min_quantity"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           value="<?= htmlspecialchars($config['min_quantity']) ?>"
                           min="1" required>
                </div>
                <button type="submit">Guardar</button>
            </form>
            <?php if (isset($_GET['success'])): ?>
                <script>
                    Swal.fire({
                        title: `<span class='titulo-alerta confirmacion'>Éxito</span>`,
                        html: `
                            <div class="alerta">
                                <div class="contenedor-imagen">
                                    <img src="../imagenes/moto.png" class="moto">
                                </div>
                                <p>Los cambios fueron guardados correctamente.</p>
                            </div>
                        `,
                        background: '#ffffffdb',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#007bff',
                        customClass: { popup: 'swal2-border-radius', confirmButton: 'btn-aceptar', container: 'fondo-oscuro' }
                    })
                </script>
            <?php elseif (isset($_GET['error'])): ?>
                <script>
                    Swal.fire({
                        title: `<span class='titulo-alerta confirmacion'>Error</span>`,
                        html: `
                            <div class="alerta">
                                <div class="contenedor-imagen">
                                    <img src="../imagenes/llave.png" class="llave">
                                </div>
                                <p>Error al guardar los cambios.</p>
                            </div>
                        `,
                        background: '#ffffffdb',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#007bff',
                        customClass: { popup: 'swal2-border-radius', confirmButton: 'btn-aceptar', container: 'fondo-oscuro' }
                    })
                </script>
            <?php endif; ?>
        </div>
    </div>

    <div class="userContainer">
        <div class="userInfo">
            <p class="nombre"><?php echo $nombreUsuario; ?> <?php echo $apellidoUsuario; ?></p>
            <p class="rol">Rol: <?php echo $rol; ?></p>
        </div>
        <div class="profilePic">
            <?php if (!empty($rowUsuario['foto'])): ?>
                <img id="profilePic" src="data:image/jpeg;base64,<?php echo base64_encode($foto); ?>" alt="Usuario">
            <?php else: ?>
                <img id="profilePic" src="../imagenes/icono.jpg" alt="Usuario por defecto">
            <?php endif; ?>
        </div>
    </div>

    <script src="/js/index.js"></script>
    <script>
        function marcarUltimasLeidas() {
            fetch(`../html/marcar_leidas_varias.php?limit=20`, { method: 'POST' })
                .then(response => {
                    if (!response.ok) throw new Error('Error al marcar notificaciones');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        cargarNotificaciones();
                        Swal.fire({
                            title: `<span class='titulo-alerta confirmacion'>Éxito</span>`,
                            html: `<div class="alerta"><div class="contenedor-imagen"><img src="../imagenes/moto.png" class="moto"></div><p>Se marcaron como leídas las últimas 20 notificaciones.</p></div>`,
                            background: '#ffffffdb',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#007bff',
                            customClass: { popup: 'swal2-border-radius', confirmButton: 'btn-aceptar', container: 'fondo-oscuro' }
                        });
                    } else {
                        Swal.fire({
                            title: `<span class='titulo-alerta confirmacion'>Error</span>`,
                            html: `<div class="alerta"><div class="contenedor-imagen"><img src="../imagenes/llave.png" class="llave"></div><p>${data.message || 'No se pudieron marcar las notificaciones.'}</p></div>`,
                            background: '#ffffffdb',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#007bff',
                            customClass: { popup: 'swal2-border-radius', confirmButton: 'btn-aceptar', container: 'fondo-oscuro' }
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        title: `<span class='titulo-alerta confirmacion'>Error</span>`,
                        html: `<div class="alerta"><div class="contenedor-imagen"><img src="../imagenes/llave.png" class="llave"></div><p>No se pudieron marcar las notificaciones.</p></div>`,
                        background: '#ffffffdb',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#007bff',
                        customClass: { popup: 'swal2-border-radius', confirmButton: 'btn-aceptar', container: 'fondo-oscuro' }
                    });
                });
        }
        
        // --- MODIFICADO PARA ANIMACIÓN ---
        function mostrarStock() {
            const stockModal = document.getElementById('stock');
            const notificacionesModal = document.getElementById('notificaciones');

            // Cierra el otro modal si está abierto
            if (notificacionesModal.classList.contains('modal-activo')) {
                notificacionesModal.classList.remove('modal-activo');
            }
            
            // Alterna la visibilidad del modal de stock
            stockModal.classList.toggle('modal-activo');
        }

        // --- MODIFICADO PARA ANIMACIÓN ---
        function mostrarNotificaciones() {
            const notificacionesModal = document.getElementById('notificaciones');
            const stockModal = document.getElementById('stock');

            // Cierra el otro modal si está abierto
            if (stockModal.classList.contains('modal-activo')) {
                stockModal.classList.remove('modal-activo');
            }
            
            // Alterna la visibilidad del modal de notificaciones
            notificacionesModal.classList.toggle('modal-activo');
        }

        function cargarNotificaciones() {
            fetch('../html/obtener_notificaciones.php')
                .then(response => {
                    if (!response.ok) throw new Error('Error en la respuesta');
                    return response.json();
                })
                .then(data => {
                    const lista = document.getElementById("listaNotificaciones");
                    if (lista) {
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
                    } else {
                        console.error("El elemento con id 'listaNotificaciones' no se encontró en el DOM.");
                    }
                })
                .catch(error => console.error('Error al cargar notificaciones:', error));
        }

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
        
        document.addEventListener('DOMContentLoaded', () => {

            // --- NUEVO: CERRAR MODALES AL HACER CLIC FUERA ---
            document.addEventListener('click', function(event) {
                const notifModal = document.getElementById('notificaciones');
                const stockModal = document.getElementById('stock');
                const notifButton = document.querySelector('.noti');
                const stockButton = document.querySelector('.stock');

                // Si el modal de notificaciones está activo y el clic fue fuera del modal y fuera del botón
                if (notifModal.classList.contains('modal-activo') && 
                    !notifModal.contains(event.target) && 
                    !notifButton.contains(event.target)) {
                    notifModal.classList.remove('modal-activo');
                }

                // Si el modal de stock está activo y el clic fue fuera del modal y fuera del botón
                if (stockModal.classList.contains('modal-activo') && 
                    !stockModal.contains(event.target) && 
                    !stockButton.contains(event.target)) {
                    stockModal.classList.remove('modal-activo');
                }
            });

            // Cargar notificaciones
            cargarNotificaciones();
            setInterval(cargarNotificaciones, 30000);

            // Animación de las tarjetas
            const cards = document.querySelectorAll('.metric-card');
            cards.forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    const rotateX = (y - centerY) / 5;
                    const rotateY = (centerX - x) / 5;
                    card.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-6px) translateZ(20px)`;
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'rotateX(0deg) rotateY(0deg) translateY(0px) translateZ(0px)';
                });
            });
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let metricsChart, stockPieChart, invoicesLineChart;

        function getTextoColorPorModo() {
            return document.body.classList.contains('modo-alto-contraste') ? '#fff' : '#000';
        }

        function crearCharts() {
            const colorTexto = getTextoColorPorModo();
            const ctxBar = document.getElementById('metricsChart').getContext('2d');
            metricsChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ['Total Productos', 'Stock Bajo', 'Proveedores', 'Clientes', 'Facturas Mes', 'Notificaciones'],
                    datasets: [{
                        label: 'Métricas',
                        data: [
                            <?= $metrics['total_products'] ?>, <?= $metrics['low_stock'] ?>,
                            <?= $metrics['total_providers'] ?>, <?= $metrics['total_clients'] ?>,
                            <?= $metrics['invoices_month'] ?>, <?= $metrics['unread_notif'] ?>
                        ],
                        backgroundColor: ['#4e79a7', '#f28e2b', '#e15759', '#76b7b2', '#59a14f', '#edc948'],
                        borderColor: ['#4e79a7', '#f28e2b', '#e15759', '#76b7b2', '#59a14f', '#edc948'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, title: { display: true, text: 'Cantidad', font: { size: 16 }, color: colorTexto }, ticks: { font: { size: 14 }, color: colorTexto } },
                        x: { ticks: { font: { size: 14 }, color: colorTexto, autoSkip: false, maxRotation: 45, minRotation: 45 } }
                    },
                    plugins: { legend: { display: false }, title: { display: true, text: 'Resumen de Métricas', font: { size: 18 }, color: colorTexto } }
                }
            });
            const ctxPie = document.getElementById('stockPieChart').getContext('2d');
            stockPieChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: ['Stock Bajo', 'Stock Normal'],
                    datasets: [{
                        data: [<?= $metrics['low_stock'] ?>, <?= $metrics['total_products'] - $metrics['low_stock'] ?>],
                        backgroundColor: ['#e15759', '#59a14f'],
                        borderColor: ['#e15759', '#59a14f'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { position: 'top', labels: { font: { size: 14 }, color: colorTexto } }, title: { display: true, text: 'Proporción de Stock', font: { size: 18 }, color: colorTexto } }
                }
            });
            <?php if (isset($facturas_diarias) && count($facturas_diarias) > 0) { ?>
                const ctxLine = document.getElementById('invoicesLineChart').getContext('2d');
                invoicesLineChart = new Chart(ctxLine, {
                    type: 'line',
                    data: {
                        labels: [<?php foreach ($facturas_diarias as $dia => $cantidad) echo "'$dia',"; ?>],
                        datasets: [{
                            label: 'Facturas Diarias',
                            data: [<?php foreach ($facturas_diarias as $cantidad) echo "$cantidad,"; ?>],
                            borderColor: '#4e79a7', backgroundColor: 'rgba(78,121,167,0.2)', fill: true, tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true, title: { display: true, text: 'Facturas', font: { size: 16 }, color: colorTexto }, ticks: { font: { size: 14 }, color: colorTexto } },
                            x: { title: { display: true, text: 'Día del Mes', font: { size: 16 }, color: colorTexto }, ticks: { font: { size: 14 }, color: colorTexto } }
                        },
                        plugins: { legend: { position: 'top', labels: { font: { size: 14 }, color: colorTexto } }, title: { display: true, text: 'Facturas Diarias del Mes', font: { size: 18 }, color: colorTexto } }
                    }
                });
            <?php } ?>
        }
        function actualizarColorCharts() {
            const c = getTextoColorPorModo();
            metricsChart.options.scales.y.title.color = c;
            metricsChart.options.scales.y.ticks.color = c;
            metricsChart.options.scales.x.ticks.color = c;
            metricsChart.options.plugins.title.color = c;
            metricsChart.update();
            stockPieChart.options.plugins.legend.labels.color = c;
            stockPieChart.options.plugins.title.color = c;
            stockPieChart.update();
            if (typeof invoicesLineChart !== 'undefined') {
                invoicesLineChart.options.scales.y.title.color = c;
                invoicesLineChart.options.scales.y.ticks.color = c;
                invoicesLineChart.options.scales.x.title.color = c;
                invoicesLineChart.options.scales.x.ticks.color = c;
                invoicesLineChart.options.plugins.legend.labels.color = c;
                invoicesLineChart.options.plugins.title.color = c;
                invoicesLineChart.update();
            }
        }
        document.addEventListener('DOMContentLoaded', () => {
            crearCharts();
            new MutationObserver(muts => {
                if (muts.some(m => m.attributeName === 'class')) {
                    actualizarColorCharts();
                }
            }).observe(document.body, {
                attributes: true,
                attributeFilter: ['class']
            });
        });
    </script>
</body>
</html>