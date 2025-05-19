<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '../html/verificar_permisos.php';

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

// Obtener configuración existente
$config = ['min_quantity' => 0, 'alarm_time' => '', 'notification_method' => ''];
$stmt = $conexion->prepare("SELECT * FROM configuracion_stock ORDER BY id DESC LIMIT 1");
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $config = $result->fetch_assoc();
    }
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y sanitizar inputs
    $min_quantity = isset($_POST['min_quantity']) ? (int)$_POST['min_quantity'] : 0;
    $alarm_time = $_POST['alarm_time'] ?? null;
    $notification_method = $_POST['notification_method'] ?? 'popup'; // Valor por defecto
    
    $stmt = $conexion->prepare("INSERT INTO configuracion_stock 
        (min_quantity, alarm_time, notification_method) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $min_quantity, $alarm_time, $notification_method);
    
    if ($stmt->execute()) {
        header("Location: stock.php?success=1");
    } else {
        header("Location: stock.php?error=1");
    }
    exit();
}
include_once $_SERVER['DOCUMENT_ROOT'].'/componentes/accesibilidad-widget.php';
?>
<!DOCTYPE html>
<html lang="es">
    
    <head>
        <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Configuracion stock</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <link rel="stylesheet" href="../css/stock.css" />
    <link rel="stylesheet" href="../css/alertas.css">
    <link rel="stylesheet" href="/componentes/header.php" />
    <link rel="stylesheet" href="/componentes/header.css" />
    <script sr></script>
    <script src="/js/index.js"></script>
    <script src="../js/header.js"></script>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap");
    </style>
</head>

<body>


    <!-- Aquí se cargará el header -->
    <div id="menu"></div>
    <div class="fondo-opaco"></div>
    <div id="stock" class="form-section">
        <h1>Configuración de stock</h1>

        <main>
            <form class="config-form" method="POST">
                <div class="form-group">
                    <label>Cantidad Mínima:</label>
                    <input type="number" name="min_quantity"
                        value="<?= htmlspecialchars($config['min_quantity']) ?>"
                        min="1" required>
                </div>
                <div class="form-group">
                    <label for="alarm_time">Hora de Alarma:</label>
                    <input type="time" id="alarm_time" name="alarm_time" required>
                </div>
                <div class="form-group">
                    <label for="notification_method">Método de Notificación:</label>
                    <select id="notification_method" name="notification_method" required>
                        <option value="popup" <?= ($config['notification_method'] ?? '') === 'popup' ? 'selected' : '' ?>>Emergente</option>
                        <option value="email" <?= ($config['notification_method'] ?? '') === 'email' ? 'selected' : '' ?>>Notificación</option>
                        <option value="both" <?= ($config['notification_method'] ?? '') === 'both' ? 'selected' : '' ?>>Ambos</option>
                    </select>
                </div>
                <button type="submit">Guardar Configuración</button>
            </form>
    </div>

    <div class="alert hidden" id="alert">
        <p>⚠️ Alerta: Algunos productos están por debajo de la cantidad mínima configurada.</p>
    </div>
    </main>
</body>
<script>
    // Escucha del formulario
    document.getElementById('stock-config-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const cantidadMinima = parseInt(document.getElementById('min-quantity').value);
        const horaAlarma = document.getElementById('alarm-time').value;
        const metodoNotificacion = document.getElementById('notification-method').value;

        // Guardar configuración (puede conectarse a un backend)
        console.log('Cantidad Mínima:', cantidadMinima);
        console.log('Hora de Alarma:', horaAlarma);
        console.log('Método de Notificación:', metodoNotificacion);

        // Validación de inventario
        const productosPorDebajo = inventario.filter(p => p.cantidad < cantidadMinima);

        if (productosPorDebajo.length > 0) {
            if (metodoNotificacion === "popup" || metodoNotificacion === "both") {
                mostrarAlerta();
            }
            if (metodoNotificacion === "email" || metodoNotificacion === "both") {
                enviarCorreo(productosPorDebajo);
            }
        }
    });

    // Función para mostrar una alerta emergente
    function mostrarAlerta() {
        const alertDiv = document.getElementById('alert');
        alertDiv.classList.remove('hidden');
    }

    // Simulación del envío de correo
    function enviarCorreo(productos) {
        console.log("Enviando correo con los siguientes productos:");
        productos.forEach(p => console.log(`- ${p.nombre} (Cantidad: ${p.cantidad})`));
    }
</script>

</html>