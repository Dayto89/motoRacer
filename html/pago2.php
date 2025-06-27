<?php
// prueba.php (Versión Mejorada en un solo archivo)

// --- 1. CONFIGURACIÓN Y CONEXIÓN ---
// Se recomienda mover esto a un archivo externo como 'config.php' en el futuro
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "inventariomotoracer";

// Habilitar reporte de todos los errores para desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Conexión fallida: " . $conn->connect_error]);
    exit;
}
$conn->set_charset("utf8");

// --- 2. INICIO DE SESIÓN Y ENRUTAMIENTO ---
session_start();

// Validar que el usuario esté logueado para todas las operaciones AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['accion'])) {
    if (!isset($_SESSION['usuario_id'])) {
        header('Content-Type: application/json');
        http_response_code(403); // Forbidden
        echo json_encode(["success" => false, "error" => "Acceso no autorizado. Inicie sesión."]);
        exit();
    }
}

// --- MANEJO DE PETICIÓN POST (GUARDAR FACTURA) ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        http_response_code(400);
        echo json_encode(["success" => false, "error" => "No se recibieron datos"]);
        exit;
    }

    $requiredFields = ["codigo", "tipoDoc", "nombre", "apellido", "productos", "metodos_pago", "total", "descuento", "cambio"];
    foreach ($requiredFields as $f) {
        if (!isset($data[$f])) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Falta el campo requerido: $f"]);
            exit;
        }
    }

    // NUEVO: Iniciar transacción para garantizar la integridad de los datos
    $conn->begin_transaction();

    try {
        // 1. Obtener datos del vendedor
        $stmtUsr = $conn->prepare("SELECT nombre, apellido FROM usuario WHERE identificacion = ?");
        $stmtUsr->bind_param("s", $_SESSION["usuario_id"]);
        $stmtUsr->execute();
        $rowUsr = $stmtUsr->get_result()->fetch_assoc();
        $nameUser = $rowUsr["nombre"];
        $apellidoUser = $rowUsr["apellido"];
        $stmtUsr->close();
        
        // 2. Variables del cliente
        $codigo_cliente = $data["codigo"];
        $nombre_cliente = $data["nombre"];

        // 3. Verificar/Insertar cliente
        $stmtCl = $conn->prepare("SELECT codigo FROM cliente WHERE codigo = ?");
        $stmtCl->bind_param("s", $codigo_cliente);
        $stmtCl->execute();
        if ($stmtCl->get_result()->num_rows === 0) {
            $stmtInsertCl = $conn->prepare("INSERT INTO cliente (codigo, identificacion, nombre, apellido, telefono, correo) VALUES (?, ?, ?, ?, ?, ?)");
            $stmtInsertCl->bind_param("ssssss", $codigo_cliente, $data["tipoDoc"], $nombre_cliente, $data["apellido"], $data["telefono"], $data["correo"]);
            if (!$stmtInsertCl->execute()) throw new Exception("Error al crear el cliente: " . $stmtInsertCl->error);
            $stmtInsertCl->close();
        }
        $stmtCl->close();

        // 4. NUEVO: Obtener y actualizar consecutivo de factura
        $conn->query("UPDATE `configuracion` SET `valor` = LAST_INSERT_ID(`valor` + 1) WHERE `clave` = 'consecutivo_factura'");
        $resultConsecutivo = $conn->query("SELECT LAST_INSERT_ID() as id");
        $nuevoValor = $resultConsecutivo->fetch_assoc()['id'];
        $consecutivo_factura = "FACT-" . str_pad($nuevoValor, 6, "0", STR_PAD_LEFT);
        
        // 5. Registrar factura
        $sqlFac = "INSERT INTO factura (fechaGeneracion, consecutivo, Usuario_identificacion, nombreUsuario, apellidoUsuario, Cliente_codigo, nombreCliente, apellidoCliente, telefonoCliente, identificacionCliente, cambio, descuento, precioTotal, activo, productos_resumen) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?)";
        $stmtFac = $conn->prepare($sqlFac);
        $productos_resumen = json_encode($data["productos"], JSON_UNESCAPED_UNICODE);
        $stmtFac->bind_param("sisssssssddds", $consecutivo_factura, $_SESSION["usuario_id"], $nameUser, $apellidoUser, $codigo_cliente, $nombre_cliente, $data["apellido"], $data["telefono"], $codigo_cliente, $data["cambio"], $data["descuento"], $data["total"], $productos_resumen);
        if (!$stmtFac->execute()) throw new Exception("Error al registrar la factura: " . $stmtFac->error);
        $factura_id = $stmtFac->insert_id;
        $stmtFac->close();

        // 6. Registrar métodos de pago
        $stmtMP = $conn->prepare("INSERT INTO factura_metodo_pago (Factura_codigo, metodoPago, monto) VALUES (?, ?, ?)");
        foreach ($data["metodos_pago"] as $m) {
            $stmtMP->bind_param("isd", $factura_id, $m["tipo"], $m["valor"]);
            if (!$stmtMP->execute()) throw new Exception("Error al registrar método de pago: " . $stmtMP->error);
        }
        $stmtMP->close();
        
        // 7. Descontar stock
        $stmtUp = $conn->prepare("UPDATE producto SET cantidad = cantidad - ? WHERE codigo1 = ?");
        foreach ($data["productos"] as $prod) {
            $stmtUp->bind_param("ii", $prod["cantidad"], $prod["id"]);
            if (!$stmtUp->execute()) throw new Exception("Error al actualizar stock del producto " . $prod['id'] . ": " . $stmtUp->error);
        }
        $stmtUp->close();
        
        // NUEVO: Si todo fue exitoso, confirmar la transacción
        $conn->commit();

        unset($_SESSION['productos'], $_SESSION['total']);

        echo json_encode(["success" => true, "factura_id" => $factura_id, "consecutivo" => $consecutivo_factura]);

    } catch (Exception $e) {
        // NUEVO: Si algo falló, revertir todos los cambios
        $conn->rollback();
        http_response_code(500);
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }

    $conn->close();
    exit; // Terminar ejecución para no renderizar HTML
}

// --- MANEJO DE PETICIONES GET (API) ---
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['accion'])) {
    header('Content-Type: application/json');
    
    switch ($_GET['accion']) {
        case 'buscar_cliente':
            if (isset($_GET['codigo'])) {
                $codigoBusqueda = $_GET['codigo'] . '%';
                $stmt = $conn->prepare("SELECT codigo, identificacion, nombre, apellido, telefono, correo FROM cliente WHERE codigo LIKE ?");
                $stmt->bind_param("s", $codigoBusqueda);
                $stmt->execute();
                $result = $stmt->get_result();
                $clientes = $result->fetch_all(MYSQLI_ASSOC);
                echo json_encode($clientes);
                $stmt->close();
            } else {
                echo json_encode([]);
            }
            break;
        // Se podrían añadir más casos aquí en el futuro (ej. ?accion=generar_pdf)
    }

    $conn->close();
    exit; // Terminar ejecución para no renderizar HTML
}


// --- 3. LÓGICA PARA MOSTRAR LA PÁGINA (SI NO ES UNA PETICIÓN AJAX) ---
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php"); // O a tu página de login
    exit();
}
$productos_sesion = $_SESSION['productos'] ?? [];
$total_sesion = $_SESSION['total'] ?? 0;
if (empty($productos_sesion)) {
    // Si no hay productos, redirigir a la página de ventas.
    header("Location: ventas.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar Factura</title>
    <link rel="stylesheet" href="../css/pago.css">
    <link rel="stylesheet" href="../css/alertas.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <div class="main-content">
            <div class="content">
                <div class="user-info">
                    <h2>Información del Cliente</h2>
                    <select id="tipo_doc" name="tipo_doc">
                        <option value="CC">Cédula de Ciudadanía</option>
                        <option value="TI">Tarjeta de Identidad</option>
                        <option value="NIT">NIT</option>
                    </select>
                    <div class="input-group">
                         <input type="text" id="codigo" name="codigo" oninput="this.value = this.value.replace(/[^0-9]/g, '');" inputmode="numeric" autocomplete="off" placeholder="Documento del cliente">
                         <div id="suggestions" class="suggestions"></div>
                    </div>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre">
                    <input type="text" id="apellido" name="apellido" placeholder="Apellido">
                    <input type="text" id="telefono" name="telefono" placeholder="Teléfono">
                    <input type="email" id="correo" name="correo" placeholder="Correo Electrónico">
                </div>
                <div class="payment-box">
                    </div>
            </div>
        </div>
        <div class="summary-section">
            <h3>Información de pago</h3>
            <div class="summary-container">
                <h2>Productos:</h2>
                <div class="tabla-scroll">
                    <table class="tabla-productos">
                        <thead>
                            <tr><th>Cantidad</th><th>Nombre</th><th>Precio Unitario</th><th>Total</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos_sesion as $producto): ?>
                                <tr data-id="<?php echo htmlspecialchars($producto['id']); ?>">
                                    <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                    <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                                    <td>$<?php echo number_format($producto['cantidad'] * $producto['precio'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="summary-totals">
                    <p>Subtotal: <strong id="subtotal-display">$<?php echo number_format($total_sesion, 2); ?></strong></p>
                    <div class="descuento-group">
                        <label for="descuento">Descuento ($):</label>
                        <input type="number" id="descuento" value="0" min="0" step="1000" class="input-descuento">
                    </div>
                    <hr>
                    <h2 class="total-final">Total a Pagar: <strong id="total-final-display">$<?php echo number_format($total_sesion, 2); ?></strong></h2>
                </div>

                <button class="btn-pagar" onclick="guardarFactura()">Finalizar y Pagar</button>
                <button class="btn-editar" onclick="window.location.href='ventas.php'">✏️ Editar productos</button>
            </div>
        </div>
    </div>

    <script>
    // Guardamos el total inicial de la sesión en una variable JS
    const totalOriginal = <?php echo $total_sesion; ?>;

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('descuento').addEventListener('input', actualizarTotalFinal);
        document.getElementById('codigo').addEventListener('input', buscarCodigo);
        // ...otros listeners que tenías
    });

    function actualizarTotalFinal() {
        const descuento = parseFloat(document.getElementById('descuento').value) || 0;
        const totalFinal = totalOriginal - descuento;
        document.getElementById('total-final-display').textContent = '$' + totalFinal.toLocaleString('es-CO', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function buscarCodigo() {
        let inputVal = document.getElementById("codigo").value;
        let suggestionsBox = document.getElementById("suggestions");
        if (inputVal.length < 2) { 
            suggestionsBox.style.display = 'none'; 
            return; 
        }

        // NUEVO: La URL ahora apunta a este mismo archivo con un parámetro 'accion'
        fetch(`prueba.php?accion=buscar_cliente&codigo=${inputVal}`)
            .then(response => response.json())
            .then(data => {
                suggestionsBox.innerHTML = "";
                if (data.length > 0) {
                    suggestionsBox.style.display = "block";
                    data.forEach(user => {
                        let div = document.createElement("div");
                        div.textContent = `${user.codigo} - ${user.nombre}`;
                        div.onclick = () => seleccionarCodigo(user);
                        suggestionsBox.appendChild(div);
                    });
                } else {
                    suggestionsBox.style.display = "none";
                }
            });
    }

    function seleccionarCodigo(user) {
        document.getElementById("codigo").value = user.codigo;
        document.getElementById("nombre").value = user.nombre;
        document.getElementById("apellido").value = user.apellido;
        document.getElementById("telefono").value = user.telefono;
        document.getElementById("correo").value = user.correo;
        document.getElementById("tipo_doc").value = user.identificacion;
        document.getElementById("suggestions").style.display = "none";
    }

    function guardarFactura() {
        // 1. Recopilar información del cliente y productos (igual que antes)
        const codigo = document.getElementById("codigo").value;
        const nombre = document.getElementById("nombre").value;
        // ... recolectar todos los campos del cliente

        if (!codigo || !nombre) { // Simplificando la validación
            Swal.fire('Advertencia', 'Faltan datos del cliente.', 'warning');
            return;
        }

        const productos = Array.from(document.querySelectorAll(".tabla-productos tbody tr")).map(row => ({
            id: row.dataset.id,
            cantidad: parseInt(row.cells[0].textContent),
            nombre: row.cells[1].textContent,
            precio: parseFloat(row.cells[2].textContent.replace(/[$,]/g, ""))
        }));

        // 2. Métodos de pago (igual que antes)
        const metodos_pago = []; // Llenar con la lógica que ya tenías

        // 3. NUEVO: Cálculo de totales incluyendo descuento
        const descuento = parseFloat(document.getElementById('descuento').value) || 0;
        const totalFinal = totalOriginal - descuento;
        const totalPagado = metodos_pago.reduce((acc, m) => acc + m.valor, 0);
        const cambio = totalPagado - totalFinal;

        if (totalPagado < totalFinal) {
            Swal.fire('Advertencia', `El monto pagado ($${totalPagado}) es menor al total a pagar ($${totalFinal}).`, 'warning');
            return;
        }

        // 4. Preparar body para la petición
        const body = {
            codigo: codigo,
            tipoDoc: document.getElementById('tipo_doc').value,
            nombre: nombre,
            apellido: document.getElementById('apellido').value,
            telefono: document.getElementById('telefono').value,
            correo: document.getElementById('correo').value,
            productos: productos,
            metodos_pago: metodos_pago,
            total: totalFinal,
            descuento: descuento,
            cambio: cambio
        };

        // 5. Enviar petición AJAX a este mismo archivo (que manejará el POST)
        fetch("prueba.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(body)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: '¡Éxito!',
                    html: `Factura <strong>${data.consecutivo}</strong> registrada correctamente.`,
                    icon: 'success'
                }).then(() => {
                    // Limpiar sessionStorage y redirigir
                    sessionStorage.removeItem('carritoProductos');
                    sessionStorage.removeItem('carritoTotal');
                    // Opcional: Redirigir a una página para imprimir el recibo
                    // window.location.href = `recibo.php?factura_id=${data.factura_id}`;
                    window.location.href = 'ventas.php'; // Volver a la página de ventas
                });
            } else {
                Swal.fire('Error', `Ocurrió un error: ${data.error}`, 'error');
            }
        })
        .catch(error => {
            console.error("Error en fetch:", error);
            Swal.fire('Error de Conexión', 'No se pudo comunicar con el servidor.', 'error');
        });
    }
    // ... Aquí van el resto de tus funciones JS como AgregarOtraTarjeta, etc.
    </script>
</body>
</html>