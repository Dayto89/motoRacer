<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');

// Obtener configuración existente
$config = [];
$result = mysqli_query($conexion, "SELECT * FROM configuracion_stock ORDER BY id DESC LIMIT 1");
if($result && mysqli_num_rows($result) > 0) {
    $config = mysqli_fetch_assoc($result);
}

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $min_quantity = $_POST['min_quantity'];
    $alarm_time = $_POST['alarm_time'];
    $notification_method = $_POST['notification_method'];
    
    mysqli_query($conexion, "INSERT INTO configuracion_stock 
        (min_quantity, alarm_time, notification_method) 
        VALUES ('$min_quantity', '$alarm_time', '$notification_method')");
    
    header("Location: configuracion_stock.php");
    exit();
}

// Obtener inventario
$inventario = [];
$result = mysqli_query($conexion, "SELECT * FROM producto");
while ($fila = mysqli_fetch_assoc($result)) {
    $inventario[] = $fila;
}



 
// Dentro de pago.php va esto:

// Dentro del bloque POST, después de actualizar los productos:
foreach ($productos as $producto) {
    // ... código existente para actualizar inventario ...
}

// ====================================================================
// VERIFICAR STOCK MÍNIMO Y GENERAR NOTIFICACIONES (AGREGA ESTE BLOQUE)
// ====================================================================

// Obtener la configuración de stock más reciente
$min_quantity = 0;
$config_query = $conn->query("
    SELECT COALESCE(min_quantity, 0) AS min_quantity 
    FROM configuracion_stock 
    ORDER BY id DESC 
    LIMIT 1
");
if ($config_query && $config = $config_query->fetch_assoc()) {
    $min_quantity = (int)$config['min_quantity'];
}

// Buscar productos por debajo del mínimo
$low_stock_query = $conn->query("
    SELECT codigo1, nombre, cantidad 
    FROM producto 
    WHERE cantidad < $min_quantity
");

// Generar notificaciones
while ($producto = $low_stock_query->fetch_assoc()) {
    $mensaje = "Producto {$producto['nombre']} bajo mínimo! ";
    $mensaje .= "Stock actual: {$producto['cantidad']}";
    
    $stmt = $conn->prepare("INSERT INTO notificaciones (mensaje) VALUES (?)");
    $stmt->bind_param("s", $mensaje);
    $stmt->execute();
}

// ====================================================================
// FIN DE SECCIÓN AGREGADA
// ====================================================================

$_SESSION['factura_id'] = $factura_id;
header('Content-Type: application/json');
echo json_encode(["success" => true, "factura_id" => $factura_id]);
exit;




// Tablas a revisar:
/* 
-- Ejecuta estas sentencias en tu MySQL
CREATE TABLE IF NOT EXISTS configuracion_stock (
    id INT PRIMARY KEY AUTO_INCREMENT,
    min_quantity INT NOT NULL,
    alarm_time TIME,
    notification_method VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS notificaciones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    mensaje TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    leida BOOLEAN DEFAULT FALSE
);
*/


// Inicio.php
/* 
// Reemplazar el setInterval simulado con esto
function cargarNotificaciones() {
    fetch('obtener_notificaciones.php')
        .then(response => response.json())
        .then(data => {
            const lista = document.getElementById("listaNotificaciones");
            lista.innerHTML = '';
            data.forEach(notif => {
                const li = document.createElement('li');
                li.textContent = notif.mensaje;
                li.className = notif.leida ? 'leida' : 'nueva';
                lista.appendChild(li);
            });
        });
}

// Cargar al inicio y cada 30 segundos
cargarNotificaciones();
setInterval(cargarNotificaciones, 30000);
*/



// ====================================================================
//  Archivo obtener_notificaciones.php
// ====================================================================
/*
<?php
session_start();
require_once 'conexion.php'; // Archivo con la conexión

$result = mysqli_query($conexion, "SELECT * FROM notificaciones ORDER BY fecha DESC LIMIT 10");
$notificaciones = [];

while($fila = mysqli_fetch_assoc($result)) {
    $notificaciones[] = $fila;
}

header('Content-Type: application/json');
echo json_encode($notificaciones);
*/ 


// ====================================================================
// Notificaciones Leidadas
// ====================================================================
/*
function marcarLeida(id) {
    fetch('marcar_leida.php?id=' + id);
}

// En la lista de notificaciones:
li.addEventListener('click', () => {
    li.classList.remove('nueva');
    li.classList.add('leida');
    marcarLeida(notif.id);
});
*/


// ====================================================================
// css notificaciones nueva y leida
// ====================================================================
/*
.notificaciones li.nueva {
    background: #fff3cd;
    border-left: 4px solid #ffc107;
    padding: 10px;
    margin: 5px 0;
}

.notificaciones li.leida {
    background: #f8f9fa;
    border-left: 4px solid #6c757d;
    opacity: 0.7;
}
*/

?>

<!-- Mantener el HTML existente y modificar el formulario -->
<form class="config-form" id="stock-config-form" method="POST">
    <div class="form-group">
        <label for="min-quantity">Cantidad Mínima para Todos los Productos:</label>
        <input type="number" id="min-quantity" name="min_quantity" 
               value="<?= $config['min_quantity'] ?? '' ?>" min="1" placeholder="Ej. 10" required>
    </div>
    <!-- Resto del formulario igual pero con name attributes -->
</form>
