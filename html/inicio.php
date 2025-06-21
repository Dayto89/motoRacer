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

        /* Contenedor general del dashboard */
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

        /* Contenedor de cada gráfico */
        .chart-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            position: relative;
            width: 100%;
            max-width: 500px;
            /* Limita el ancho máximo */
            margin: 0 auto;
            aspect-ratio: 4 / 3;
            /* Proporción más cuadrada */
        }

        /* Asegurar que el canvas ocupe todo el contenedor */
        .chart-container canvas {
            width: 100% !important;
            height: 100% !important;
        }

        /* Estilo de cada tarjeta de métrica */
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
            /* Borde para simular grosor */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15), inset 0 0 10px rgba(255, 255, 255, 0.3);
            /* Sombra externa e interna */
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
            background: linear-gradient(to bottom,
                    rgba(255, 255, 255, 0.4),
                    rgba(255, 255, 255, 0));
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



        /* Ajustes responsivos */
        @media (max-width: 600px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }

            button.noti,
            button.stock {
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
    <div class="fondo"></div>

    <!-- DASHBOARD METRICAS -->
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

    <!-- Contenedor de gráficos -->
    <div class="charts-grid">
        <!-- Gráfico de barras -->
        <div class="chart-container">
            <canvas id="metricsChart"></canvas>
        </div>
        <!-- Gráfico de pastel -->
        <div class="chart-container">
            <canvas id="stockPieChart"></canvas>
        </div>
        <?php if (isset($facturas_diarias)): ?>
            <!-- Gráfico de líneas -->
            <div class="chart-container">
                <canvas id="invoicesLineChart"></canvas>
            </div>
        <?php endif; ?>
    </div>
    <div id="notificaciones" class="notificaciones">
        <h3>Notificaciones</h3>
        <ul id="listaNotificaciones"></ul>
    </div>

    <!-- BOTONES NOTIFICACIONES y STOCK -->
    <button class="noti" onclick="mostrarNotificaciones()" title="notificaciones"><animated-icons
            src="https://animatedicons.co/get-icon?name=notification&style=minimalistic&token=2a8c285f-a7a0-4f4d-b2c3-acccc136c454"
            trigger="loop-on-hover"
            attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":2.5,"defaultColours":{"group-1":"#1B1B1BFF","group-2":"#000000FF","background":"#FFFFFFFF"}}'
            height="70"
            width="70"></animated-icons>
        <div id="badgeNotificaciones" class="badge-notificaciones">0</div>
    </button>

    <button class="stock" onclick="mostrarStock()" title="stock">
        <animated-icons
            src="https://animatedicons.co/get-icon?name=Minecraft&style=minimalistic&token=e1134e0f-af6b-4a81-894b-9708d1f0d153"
            trigger="hover"
            attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#000000FF","background":"#FFFFFFFF"}}'
            height="70"
            width="70"></animated-icons>
    </button>
    <div id="stock" class="cantidad">
        <h3>Stock</h3>

        <!-- Aquí reemplazamos la lista vacía por el formulario -->
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
                        customClass: {
                            popup: 'swal2-border-radius',
                            confirmButton: 'btn-aceptar',
                            container: 'fondo-oscuro'
                        }
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
                        customClass: {
                            popup: 'swal2-border-radius',
                            confirmButton: 'btn-aceptar',
                            container: 'fondo-oscuro'
                        }
                    })
                </script>
            <?php endif; ?>
        </div>
    </div>

    <!-- Info usuario -->
    <div class="userContainer">
        <div class="userInfo">
            <!-- Nombre y apellido del usuario y rol -->
            <!-- Consultar datos del usuario -->
            <?php
            $conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
            $id_usuario = $_SESSION['usuario_id'];
            $sqlUsuario = "SELECT nombre, apellido, rol, foto FROM usuario WHERE identificacion = ?";
            $stmtUsuario = $conexion->prepare($sqlUsuario);
            $stmtUsuario->bind_param("i", $id_usuario);
            $stmtUsuario->execute();
            $resultUsuario = $stmtUsuario->get_result();
            $rowUsuario = $resultUsuario->fetch_assoc();
            $nombreUsuario = $rowUsuario['nombre'];
            $apellidoUsuario = $rowUsuario['apellido'];
            $rol = $rowUsuario['rol'];
            $foto = $rowUsuario['foto'];
            $stmtUsuario->close();
            ?>
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
        // Función para mostrar/ocultar stock
        function mostrarStock() {
            // Si esta mostrando notificaciones, ocultarlas
            if (document.getElementById('notificaciones').style.display === 'block') {
                mostrarNotificaciones();
            }
            const notificaciones = document.getElementById('stock');
            notificaciones.style.display = notificaciones.style.display === 'none' ? 'block' : 'none';
        }

        // Función para mostrar/ocultar notificaciones
        function mostrarNotificaciones() {

            // Si esta mostrando stock, ocultarlo
            if (document.getElementById('stock').style.display === 'block') {
                mostrarStock();
            }
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
                    console.log('Elemento listaNotificaciones:', lista);
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

        document.addEventListener('DOMContentLoaded', () => {
            // Cargar notificaciones
            cargarNotificaciones();
            setInterval(cargarNotificaciones, 30000);

            // Animación de las tarjetas
            const cards = document.querySelectorAll('.metric-card');
            console.log('Número de tarjetas encontradas:', cards); // Para depurar

            cards.forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    const rotateX = (y - centerY) / 5; // Aumentamos la sensibilidad (de /10 a /5)
                    const rotateY = (centerX - x) / 5; // Aumentamos la sensibilidad
                    card.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-6px) translateZ(20px)`; // Añadimos translateZ para profundidad
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'rotateX(0deg) rotateY(0deg) translateY(0px) translateZ(0px)';
                });
            });

            // Gráfico de barras
        // Gráfico de barras
const ctx = document.getElementById('metricsChart').getContext('2d');
const metricsChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Total Productos', 'Stock Bajo', 'Proveedores', 'Clientes', 'Facturas Mes', 'Notificaciones'],
        datasets: [{
            label: 'Métricas',
            data: [
                <?= $metrics['total_products'] ?>,
                <?= $metrics['low_stock'] ?>,
                <?= $metrics['total_providers'] ?>,
                <?= $metrics['total_clients'] ?>,
                <?= $metrics['invoices_month'] ?>,
                <?= $metrics['unread_notif'] ?>
            ],
            backgroundColor: ['#4e79a7', '#f28e2b', '#e15759', '#76b7b2', '#59a14f', '#edc948'],
            borderColor: ['#4e79a7', '#f28e2b', '#e15759', '#76b7b2', '#59a14f', '#edc948'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // Permite ajustar la proporción según el contenedor
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Cantidad',
                    font: { size: 16 }
                },
                ticks: { font: { size: 14 } }
            },
            x: {
                ticks: {
                    font: { size: 14 },
                    autoSkip: false, // Muestra todas las etiquetas
                    maxRotation: 45, // Rota las etiquetas para mejor legibilidad
                    minRotation: 45
                }
            }
        },
        plugins: {
            legend: { display: false },
            title: {
                display: true,
                text: 'Resumen de Métricas',
                font: { size: 18 }
            }
        }
    }
});

          // Gráfico de pastel
const ctxPie = document.getElementById('stockPieChart').getContext('2d');
const stockPieChart = new Chart(ctxPie, {
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
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                labels: { font: { size: 14 } }
            },
            title: {
                display: true,
                text: 'Proporción de Stock',
                font: { size: 18 }
            }
        }
    }
});

            <?php if (isset($facturas_diarias)): ?>
              // Gráfico de líneas
const ctxLine = document.getElementById('invoicesLineChart').getContext('2d');
const invoicesLineChart = new Chart(ctxLine, {
    type: 'line',
    data: {
        labels: [<?php foreach ($facturas_diarias as $dia => $cantidad) echo "'$dia',"; ?>],
        datasets: [{
            label: 'Facturas Diarias',
            data: [<?php foreach ($facturas_diarias as $cantidad) echo "$cantidad,"; ?>],
            borderColor: '#4e79a7',
            backgroundColor: 'rgba(78, 121, 167, 0.2)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Facturas',
                    font: { size: 16 }
                },
                ticks: { font: { size: 14 } }
            },
            x: {
                title: {
                    display: true,
                    text: 'Día del Mes',
                    font: { size: 16 }
                },
                ticks: { font: { size: 14 } }
            }
        },
        plugins: {
            legend: {
                position: 'top',
                labels: { font: { size: 14 } }
            },
            title: {
                display: true,
                text: 'Facturas Diarias del Mes',
                font: { size: 18 }
            }
        }
    }
});
            <?php endif; ?>
        });
    </script>
</body>

</html>