<?php
// prueba.php
// Este archivo cumple doble función:
//  1) Mostrar la pantalla de pago (al llegar desde ventas.php)
//  2) Recibir el POST AJAX para registrar la factura y responder JSON

// 1) Inicio de sesión y validación de usuario
session_start();
if (!isset($_SESSION['usuario_id'])) {
    // Si no hay usuario logueado, devolver error o redirigir
    header("Location: ../index.php");
    exit();
}


// 2) Conexión a la base de datos
$servername = "localhost";
$username  = "root";
$password  = "";
$database  = "inventariomotoracer";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    // Si falla la conexión, respondemos JSON de error (en caso de POST) o mostramos mensaje (en GET)
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "error" => "Conexión fallida: " . $conn->connect_error]);
        exit;
    } else {
        die("Conexión fallida: " . $conn->connect_error);
    }
}

if (isset($_GET['codigo'])) {
    // Agregar el wildcard (%) para la búsqueda
    $codigoBusqueda = $_GET['codigo'] . '%';
    $sql = "SELECT codigo, identificacion, nombre, apellido, telefono, correo 
            FROM cliente 
            WHERE codigo LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $codigoBusqueda);
    $stmt->execute();
    $result = $stmt->get_result();

    $clientes = [];
    while ($fila = $result->fetch_assoc()) {
        $clientes[] = $fila;
    }
    header('Content-Type: application/json');
    echo json_encode($clientes);
    exit();
}

// ————————————————————————————————————————————————
// 3) Bloque para manejar el POST AJAX que guarda la factura
// ————————————————————————————————————————————————
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Leemos JSON enviado por fetch()
    $data = json_decode(file_get_contents("php://input"), true);
    header('Content-Type: application/json');

    if (!$data) {
        echo json_encode(["success" => false, "error" => "No se recibieron datos"]);
        exit;
    }

    // Validar campos requeridos
    $requiredFields = ["codigo", "tipoDoc", "nombre", "apellido", "telefono", "correo", "productos", "metodos_pago", "total"];
    foreach ($requiredFields as $f) {
        if (!isset($data[$f])) {
            echo json_encode(["success" => false, "error" => "Falta el campo: $f"]);
            exit;
        }
    }

    // 3.1) Obtener datos del vendedor (usuario logueado)
    $sqlUsr = "SELECT nombre, apellido FROM usuario WHERE identificacion = ?";
    $stmtUsr = $conn->prepare($sqlUsr);
    $stmtUsr->bind_param("s", $_SESSION["usuario_id"]);
    $stmtUsr->execute();
    $resUsr = $stmtUsr->get_result();
    $rowUsr = $resUsr->fetch_assoc();
    $nameUser     = $rowUsr["nombre"];
    $apellidoUser = $rowUsr["apellido"];
    $stmtUsr->close();

    // 3.2) Asignar valores del cliente y factura
    $codigo     = $data["codigo"];
    $tipoDoc    = $data["tipoDoc"];
    $nombre     = $data["nombre"];
    $apellido   = $data["apellido"];
    $telefono   = $data["telefono"];
    $correo     = $data["correo"];
    $productos  = $data["productos"];    // arreglo de productos
    $metodos_pago = $data["metodos_pago"]; // arreglo de métodos { tipo, valor }
    $cambio     = $data["cambio"];
    $total      = $data["total"];

    // 3.3) Verificar si el cliente existe; si no, insertarlo
    $sqlCl = "SELECT codigo FROM cliente WHERE codigo = ?";
    $stmtCl = $conn->prepare($sqlCl);
    $stmtCl->bind_param("s", $codigo);
    $stmtCl->execute();
    $resCl = $stmtCl->get_result();

    if ($resCl->num_rows === 0) {
        $sqlInsertCl = "INSERT INTO cliente (codigo, identificacion, nombre, apellido, telefono, correo) 
                        VALUES (?, ?, ?, ?, ?, ?)";
        $stmtInsertCl = $conn->prepare($sqlInsertCl);
        $stmtInsertCl->bind_param("ssssss", $codigo, $tipoDoc, $nombre, $apellido, $telefono, $correo);
        $stmtInsertCl->execute();
        $cliente_id = $stmtInsertCl->insert_id;
        $stmtInsertCl->close();
    } else {
        $rowCl      = $resCl->fetch_assoc();
        $cliente_id = $rowCl["codigo"];
    }
    $stmtCl->close();

    // 3.4) Registrar factura
    $sqlFac = "INSERT INTO factura 
               (fechaGeneracion, Usuario_identificacion, nombreUsuario, apellidoUsuario, Cliente_codigo, 
                nombreCliente, apellidoCliente, telefonoCliente, identificacionCliente, cambio, precioTotal) 
               VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtFac = $conn->prepare($sqlFac);
    $usuario_id = $_SESSION["usuario_id"];
    $stmtFac->bind_param(
        "ississssdd",
        $usuario_id,
        $nameUser,
        $apellidoUser,
        $cliente_id,
        $nombre,
        $apellido,
        $telefono,
        $codigo,
        $cambio,
        $total
    );
    $stmtFac->execute();
    $factura_id = $stmtFac->insert_id;
    $stmtFac->close();

    // 3.5) Registrar métodos de pago
    foreach ($metodos_pago as $m) {
        $sqlMP = "INSERT INTO factura_metodo_pago (Factura_codigo, metodoPago, monto) VALUES (?, ?, ?)";
        $stmtMP = $conn->prepare($sqlMP);
        $stmtMP->bind_param("isd", $factura_id, $m["tipo"], $m["valor"]);
        $stmtMP->execute();
        $stmtMP->close();
    }

    // 3.6) Registrar productos en la factura y descontar stock
    foreach ($productos as $prod) {
        $sqlPF = "INSERT INTO producto_factura 
                  (Factura_codigo, Producto_codigo, nombreProducto, cantidad, precioUnitario) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmtPF = $conn->prepare($sqlPF);
        $stmtPF->bind_param(
            "issid",
            $factura_id,
            $prod["id"],
            $prod["nombre"],
            $prod["cantidad"],
            $prod["precio"]
        );
        $stmtPF->execute();
        $stmtPF->close();

        // Descontar stock
        $sqlUp = "UPDATE producto SET cantidad = cantidad - ? WHERE codigo1 = ?";
        $stmtUp = $conn->prepare($sqlUp);
        $stmtUp->bind_param("ii", $prod["cantidad"], $prod["id"]);
        $stmtUp->execute();
        $stmtUp->close();
    }

    // 3.7) Verificar notificaciones de stock bajo (opcional)
    $min_quantity = 0;
    $stmtConf = $conn->prepare("SELECT min_quantity FROM configuracion_stock ORDER BY id DESC LIMIT 1");
    if ($stmtConf->execute()) {
        $resConf = $stmtConf->get_result();
        if ($fila = $resConf->fetch_assoc()) {
            $min_quantity = (int) $fila['min_quantity'];
        }
    }
    $stmtConf->close();

    if ($min_quantity > 0) {
        $stmtChk = $conn->prepare("
            SELECT codigo1, nombre, cantidad
            FROM producto 
            WHERE cantidad < ?
        ");
        $stmtChk->bind_param("i", $min_quantity);
        if ($stmtChk->execute()) {
            $resChk = $stmtChk->get_result();
            while ($prodBajo = $resChk->fetch_assoc()) {
                $mensaje = sprintf(
                    "Producto %s bajo mínimo! Stock actual: %d",
                    $prodBajo['nombre'],
                    $prodBajo['cantidad']

                );
                try {
                    $prodBajo5 = "nose";
                    $insertNotif = $conn->prepare("INSERT INTO notificaciones (mensaje, descripcion, fecha) VALUES (?, ?, NOW())");
                    $insertNotif->bind_param("ss", $mensaje, $prodBajo5);
                    $insertNotif->execute();
                    $insertNotif->close();
                } catch (Exception $e) {
                    error_log("Error al insertar notificación: " . $e->getMessage());
                }
            }
        }
        $stmtChk->close();
    }

    // 3.8) Almacenar factura_id en sesión por si lo necesitas luego
    $_SESSION['factura_id'] = $factura_id;

    // 3.9) BORRAR SOLO AQUÍ las variables de sesión 'productos' y 'total',
    // porque la factura ya se registró correctamente.
    unset($_SESSION['productos']);
    unset($_SESSION['total']);

    // 3.10) Responder JSON de éxito
    echo json_encode(["success" => true, "factura_id" => $factura_id]);
    exit;
}
// ————————————————————————————————————————————————
// Si NO es POST, continuo con la parte del HTML (pantalla de pago)
// ————————————————————————————————————————————————

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar Factura</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">

    <link rel="stylesheet" href="../componentes/header.css">
    <link rel="stylesheet" href="../componentes/header.php">
    <link rel="stylesheet" href="../css/pago.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/header.js"></script>
    <script src="/js/index.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
</head>

<body>
    <script>
        // Al cargar la pantalla de pago, borramos el carrito de ventas del sessionStorage
        sessionStorage.removeItem('carritoProductos');
        sessionStorage.removeItem('carritoTotal');
        </script>
    <div class="sidebar">
        <div id="menu"></div>
    </div>
    <div class="container">
        <div class="main-content">
            <div class="content">
                <div class="user-info">
                    <h2>Información del Cliente</h2>
                    <label for="tipo_doc">Tipo de Documento:</label>
                    <select id="tipo_doc" name="tipo_doc">
                        <option value="CC">Cédula de Ciudadanía</option>
                        <option value="TI">Tarjeta de Identidad</option>
                        <option value="NIT">NIT</option>
                    </select>
                    <div class="input-group">
                        <input
                            type="text"
                            id="codigo"
                            name="codigo"
                            onfocus="buscarCodigo()"
                            oninput="
                            this.value = this.value.replace(/[^0-9]/g, '');
                            buscarCodigo();"
                            inputmode="numeric"
                             autocomplete="off">
                        <div id="suggestions" class="suggestions"></div>
                    </div>

                    <input type="text" id="nombre" name="nombre" placeholder="Nombre"
                        oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '')">
                    <input type="text" id="apellido" name="apellido" placeholder="Apellido"
                        oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '')">
                    <input type="text" id="telefono" name="telefono" placeholder="Teléfono"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                    <input type="email" id="correo" name="correo" placeholder="Correo Electrónico"
                        pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$"
                        title="Ingresa un correo válido (debe contener @ y un dominio)." />
                </div>

                <div class="payment-box">
                    <div class="payment-section">
                        <h2>Registrar Pago</h2>
                        <div class="payment-methods">
                            <h3>Pagos en efectivo</h3>
                            <div class="efectivo-row">
                                <button onclick="llenarValor('efectivo', 30000)">$30,000</button>
                                <button onclick="llenarValor('efectivo', 50000)">$50,000</button>
                                <button onclick="llenarValor('efectivo', 100000)">$100,000</button>
                                <input type="text" class="efectivo-input" name="valor_efectivo" placeholder="Valor" oninput="actualizarSaldoPendiente()">
                            </div>
                        </div>
                        <div class="payment-box" id="tarjeta">
                            <div class="plus-icon">
                                <h3>Pagos con tarjeta</h3>
                                <img src="../imagenes/plus.svg" onclick="AgregarOtraTarjeta()" alt="">
                            </div>
                            <div class="barra">
                                <div class="tarjeta-content">
                                    <select name="tipo_tarjeta">
                                        <option value="">Opciones</option>
                                        <option value="credito">Crédito</option>
                                        <option value="debito">Débito</option>
                                    </select>
                                    <input type="text" name="voucher" placeholder="Nro. voucher">
                                    <input type="text" name="valor_tarjeta" placeholder="$0.00" oninput="actualizarSaldoPendiente()">
                                </div>
                            </div>
                        </div>
                        <div class="payment-box" id="otro">
                            <div class="plus-icon">
                                <h3>Otros pagos</h3>
                                <img src="../imagenes/plus.svg" alt="" onclick="AgregarOtroPago()">
                            </div>
                            <div class="barra">
                                <div class="otro-content">
                                    <select name="tipo_otro">
                                        <option value="">Opciones</option>
                                        <option value="transferencia">Transferencia</option>
                                    </select>
                                    <input type="text" name="valor_otro" placeholder="$0.00" oninput="actualizarSaldoPendiente()">
                                </div>
                            </div>
                        </div>
                        <div class="notes">
                            <label for="observaciones">Observaciones:</label><br>
                            <input type="text" id="observaciones" name="observaciones" placeholder="Ingrese observaciones...">
                        </div>
                    </div>
                </div>
                
                <div class="summary-section">
                    <h3>Información de pago</h3>
                    
                    <?php
                    // 4) Recuperar productos y total desde sesión (sin borrarlos)
                    $productos = $_SESSION['productos'] ?? [];
                    $total     = $_SESSION['total'] ?? 0;
                    ?>

<?php if (!empty($productos)): ?>
    <div class="summary-container">
        <h2>Productos:</h2>
                            <ul>
                                <?php foreach ($productos as $producto): ?>
                                    <li data-id="<?php echo $producto['id']; ?>">
                                        <p>
                                            <?php echo $producto['cantidad'] . " x " . $producto['nombre']; ?>
                                            –
                                            <span class="precio">
                                                $<?php echo number_format($producto['precio'], 2); ?>
                                            </span>
                                        </p>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                                
                                <p id="saldoPendiente">Saldo pendiente: $0.00</p>
                                <h2>Total a pagar:</h2>
                                <div class="contenedor-precio">
                                    <p>$<?php echo number_format($total, 2); ?></p>
                            </div>
                            
                            <!-- BOTÓN “Editar” -->
                            <button class="btn-editar" onclick="window.location.href='ventas.php'">
                                ✏️ Editar productos
                            </button>
                            
                            <!-- BOTÓN “Pagar” -->
                            <button class="btn-pagar" onclick="guardarFactura()">Pagar</button>
                        </div>
                        <?php else: ?>
                            <p>No hay productos en el resumen.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 5) Scripts JavaScript -->
            <script>
                function guardarFactura() {
                    // 5.1) Recopilar información del cliente
                    let codigo = document.getElementById("codigo").value;
                    let tipoDoc = document.getElementById("tipo_doc").value;
                    let nombre = document.getElementById("nombre").value;
                    let apellido = document.getElementById("apellido").value;
                    let telefono = document.getElementById("telefono").value;
                    let correo = document.getElementById("correo").value;
                    
                    if (!codigo || !tipoDoc || !nombre || !apellido || !telefono || !correo) {
                Swal.fire({
                    title: '<span class="titulo-alerta advertencia">Advertencia</span>',
                    html: `
                    <div class="custom-alert">
                    <div class="contenedor-imagen">
                    <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                    </div>
                    <p>Faltan datos del cliente. Por favor completa todos los campos.</p>
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
                });
                return; // detenemos el proceso
            }
            
            
            // 5.2) Reconstruir arreglo de productos desde el resumen
            let productos = [];
            document.querySelectorAll(".summary-section ul li").forEach(li => {
                let partes = li.textContent.split(" x ");
                let cantidad = parseInt(partes[0].trim());
                let nombreProd = partes[1].split(" – ")[0].trim();
                let precioString = partes[1].split("$")[1].replace(/,/g, "");
                let precioUn = parseFloat(precioString);
                let id = li.getAttribute("data-id");

                productos.push({
                    id: id,
                    nombre: nombreProd,
                    cantidad: cantidad,
                    precio: precioUn
                });
            });

            // 5.3) Reconstruir métodos de pago
            const valEfectivo = parseFloat(document.querySelector("input[name='valor_efectivo']").value) || 0;
            const metodos_pago = [];
            if (valEfectivo > 0) {
                metodos_pago.push({
                    tipo: "efectivo",
                    valor: valEfectivo
                });
            }
            // Tarjetas
            document.querySelectorAll("input[name='valor_tarjeta']").forEach(input => {
                let val = parseFloat(input.value) || 0;
                if (val > 0) {
                    let tipoTarjeta = input.parentNode.querySelector("select[name='tipo_tarjeta']").value || "tarjeta";
                    metodos_pago.push({
                        tipo: tipoTarjeta,
                        valor: val
                    });
                }
            });
            // Otros
            document.querySelectorAll("input[name='valor_otro']").forEach(input => {
                let val = parseFloat(input.value) || 0;
                if (val > 0) {
                    let tipoOtro = input.parentNode.querySelector("select[name='tipo_otro']").value;
                    if (!tipoOtro) {
                        Swal.fire({
                            title: '<span class="titulo-alerta advertencia">Advertencia</span>',
                            html: `
                                <div class="custom-alert">
                                    <div class="contenedor-imagen">
                                        <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                                    </div>
                                    <p>Selecciona un tipo de pago para 'otro'.</p>
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
                        });
                        return;
                    }
                    metodos_pago.push({
                        tipo: tipoOtro,
                        valor: val
                    });
                }
            });

            // Contar métodos
            const conteo = {};
            metodos_pago.forEach(m => {
                conteo[m.tipo] = (conteo[m.tipo] || 0) + 1;
            });

            // Mostrar en pantalla (puedes ajustarlo al contenedor que prefieras)
            const resumenDiv = document.getElementById("resumenPagos");
            if (resumenDiv) resumenDiv.remove();
            const div = document.createElement("div");
            div.id = "resumenPagos";
            div.innerHTML = `<h4>Resumen de pagos:</h4>` +
                Object.entries(conteo)
                .map(([tipo, cant]) => `<p>${cant} pago(s) de <strong>${tipo}</strong></p>`)
                .join("");
            document.querySelector(".summary-section").prepend(div);

            // 5.4) Cálculo de total y cambio
            let total = parseFloat("<?php echo $total; ?>");
            const totalPagado = metodos_pago.reduce((acc, m) => acc + m.valor, 0);
            let saldoPendiente = total - totalPagado;
            let cambio = 0;
            if (saldoPendiente < 0) {
                cambio = Math.abs(saldoPendiente);
            }
            if (saldoPendiente > 0) {
                Swal.fire({
                    title: '<span class="titulo-alerta advertencia">Advertencia</span>',
                    html: `
                        <div class="custom-alert">
                            <div class="contenedor-imagen">
                                <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                            </div>
                            <p>Falta ingresar valores para pagar.</p>
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
                });
                return;
            }

            // 5.5) Preparar body que enviaremos por fetch
            let body = {
                codigo: codigo,
                tipoDoc: tipoDoc,
                nombre: nombre,
                apellido: apellido,
                telefono: telefono,
                correo: correo,
                productos: productos,
                metodos_pago: metodos_pago,
                total: total,
                cambio: cambio
            };


            // 5.6) Enviar petición AJAX a este mismo archivo (prueba.php)
            fetch("prueba.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(body)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: '<span class="titulo-alerta confirmacion">Éxito</span>',
                            html: `
                            <div class="custom-alert">
                                <div class="contenedor-imagen">
                                    <img src="../imagenes/moto.png" alt="Confirmación" class="moto">
                                </div>
                                <p>Factura registrada correctamente con ID: <strong>${data.factura_id}</strong>.</p>
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
                        }).then(() => {
                            sessionStorage.removeItem('carritoProductos');
                            sessionStorage.removeItem('carritoTotal');

                            window.location.href = "recibo.php?factura_id=" + data.factura_id;
                        });
                    } else {
                        Swal.fire({
                            title: '<span class="titulo-alerta error">Error</span>',
                            html: `
                            <div class="custom-alert">
                                <div class="contenedor-imagen">
                                    <img src="../imagenes/llave.png" alt="Error" class="llave">
                                </div>
                                <p>Error al registrar factura.<br><small>${data.error || "Ocurrió un problema."}</small></p>
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
                        });
                    }
                })
                .catch(error => {
                    console.error("Error al registrar:", error);
                    Swal.fire({
                        title: '<span class="titulo-alerta error">Error</span>',
                        html: `
                        <div class="custom-alert">
                            <div class="contenedor-imagen">
                                <img src="../imagenes/llave.png" alt="Error" class="llave">
                            </div>
                            <p>Error al registrar factura. Intenta de nuevo.<br><small>${error.message}</small></p>
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
                    });
                });
        }

        function actualizarSaldoPendiente() {
            let total = <?php echo $total; ?>;
            let efectivo = parseFloat(document.querySelector("input[name='valor_efectivo']").value) || 0;
            let tarjetas = document.querySelectorAll("input[name='valor_tarjeta']");
            let otros = document.querySelectorAll("input[name='valor_otro']");

            let totalPagado = efectivo;
            tarjetas.forEach(input => {
                totalPagado += parseFloat(input.value) || 0;
            });
            otros.forEach(input => {
                totalPagado += parseFloat(input.value) || 0;
            });

            let saldoPendiente = total - totalPagado;
            document.getElementById("saldoPendiente").textContent = "Saldo pendiente: $" + saldoPendiente.toFixed(2);
        }

        function AgregarOtraTarjeta() {
            const contenedor = document.querySelector("#tarjeta");
            let tarjeta = document.querySelector("#tarjeta .tarjeta-content");
            let clone = tarjeta.cloneNode(false);
            clone.innerHTML = tarjeta.innerHTML;
            clone.querySelectorAll("input").forEach(i => i.value = "");
            clone.querySelectorAll("select").forEach(s => s.selectedIndex = 0);
            let eliminar = document.createElement("i");
            eliminar.className = "fa-solid fa-trash icono-eliminar-circular";
            eliminar.alt = "Eliminar";
            eliminar.style.cursor = "pointer";
            eliminar.onclick = function() {
                clone.remove();
                actualizarSaldoPendiente();
                actualizarEstadoInputs();
            };

            clone.appendChild(eliminar);
            contenedor.appendChild(clone);
        }

        function AgregarOtroPago() {
            const contenedor = document.querySelector("#otro");
            let otro = document.querySelector("#otro .otro-content");
            let clone = otro.cloneNode(false);
            clone.innerHTML = otro.innerHTML;
            clone.querySelectorAll("input").forEach(i => i.value = "");
            clone.querySelectorAll("select").forEach(s => s.selectedIndex = 0);

            let eliminar = document.createElement("i");
            eliminar.className = "fa-solid fa-trash icono-eliminar-circular";
            eliminar.alt = "Eliminar";
            eliminar.style.cursor = "pointer";
            eliminar.onclick = function() {
                clone.remove();
                actualizarSaldoPendiente();
                actualizarEstadoInputs();
            };

            clone.appendChild(eliminar);
            contenedor.appendChild(clone);
        }

        function llenarValor(tipoPago, valor) {
            let input = document.querySelector(`input[name='valor_${tipoPago}']`);
            input.value = valor;
            input.dispatchEvent(new Event("input", {
                bubbles: true
            }));
        }

        function buscarCodigo() {
            let inputVal = document.getElementById("codigo").value;
            let suggestionsBox = document.getElementById("suggestions");
            fetch(`?codigo=${inputVal}`)
                .then(response => response.json())
                .then(data => {
                    suggestionsBox.innerHTML = "";
                    if (data.length > 0) {
                        suggestionsBox.style.display = "block";
                        data.forEach(user => {
                            let div = document.createElement("div");
                            div.textContent = user.codigo + " - " + user.nombre;
                            div.onclick = () => seleccionarCodigo(user);
                            suggestionsBox.appendChild(div);
                        });
                    } else {
                        suggestionsBox.style.display = "none";
                    }
                })
                .catch(err => console.error("Error al obtener datos:", err));
        }

        function seleccionarCodigo(user) {
            document.getElementById("codigo").value = user.codigo;
            document.getElementById("suggestions").style.display = "none";
            document.getElementById("tipo_doc").value = user.identificacion;
            document.getElementById("nombre").value = user.nombre;
            document.getElementById("apellido").value = user.apellido;
            document.getElementById("telefono").value = user.telefono;
            document.getElementById("correo").value = user.correo;
        }

        document.addEventListener("DOMContentLoaded", function() {
            const totalPagar = <?php echo $total; ?>;

            function actualizarEstadoInputs() {
                // 1) Todos los inputs de pago
                const inputs = Array.from(document.querySelectorAll(
                    "input[name='valor_efectivo'], input[name='valor_tarjeta'], input[name='valor_otro']"
                ));

                // 2) Habilítalos todos
                inputs.forEach(i => i.disabled = false);

                // 3) Suma de pagos
                const sumaPagos = inputs.reduce((sum, i) => sum + (parseFloat(i.value) || 0), 0);

                // 4) Actualiza el texto de saldo pendiente
                const saldoPendiente = totalPagar - sumaPagos;
                document.getElementById("saldoPendiente").textContent =
                    "Saldo pendiente: $" + saldoPendiente.toFixed(2);

                // 5) Si ya cubriste el total, bloquea sólo los inputs vacíos
                if (sumaPagos >= totalPagar) {
                    inputs.forEach(i => {
                        if (!i.value.trim()) i.disabled = true;
                    });
                }

                // 6) Iconos “➕”
                const canAdd = sumaPagos < totalPagar;
                document.querySelectorAll(".plus-icon img").forEach(img => {
                    img.style.opacity = canAdd ? "1" : "0.5";
                    img.style.pointerEvents = canAdd ? "auto" : "none";
                });
            }
            document.addEventListener("focusin", function(e) {
                // detecta si el foco entró en un input de precio de tarjeta u 'otro'
                if (e.target.matches("input[name='valor_tarjeta'], input[name='valor_otro']")) {
                    // si está vacío, lo llenamos con el saldo pendiente actual
                    if (e.target.value.trim() === "") {
                        // extraemos el número del saldo pendiente de la sección resumen
                        let textoSaldo = document.getElementById("saldoPendiente").textContent;
                        // "Saldo pendiente: $12345.67" → 12345.67
                        let saldo = parseFloat(textoSaldo.replace(/[^0-9.-]/g, ""));
                        e.target.value = saldo.toFixed(2);
                        // disparar input event para recalcular todo
                        e.target.dispatchEvent(new Event("input", {
                            bubbles: true
                        }));
                    }
                }
            });

            document.addEventListener("input", actualizarEstadoInputs);
            document.addEventListener("change", actualizarEstadoInputs);
            actualizarSaldoPendiente();

            // Si el usuario hace clic en un input vacío, autocompletar con saldo restante
            document.querySelectorAll("input[name='valor_efectivo'], input[name='valor_tarjeta'], input[name='valor_otro']").forEach(input => {
                input.addEventListener("click", function() {
                    if (this.value.trim() === "") {
                        let saldoRestante = <?php echo $total; ?> - (
                            (parseFloat(document.querySelector("input[name='valor_efectivo']").value) || 0) +
                            Array.from(document.querySelectorAll("input[name='valor_tarjeta']")).reduce((a, b) => a + (parseFloat(b.value) || 0), 0) +
                            Array.from(document.querySelectorAll("input[name='valor_otro']")).reduce((a, b) => a + (parseFloat(b.value) || 0), 0)
                        );
                        this.value = saldoRestante;
                        this.dispatchEvent(new Event("input", {
                            bubbles: true
                        }));
                    }
                });
            });
            // Función genérica para agregar clon + handler de eliminar
            function creaClon(contenedorSelector, contenidoSelector) {
                const cont = document.querySelector(contenedorSelector);
                const plantilla = cont.querySelector(contenidoSelector);
                const clone = plantilla.cloneNode(true);
                // limpiar valores
                clone.querySelectorAll("input").forEach(i => i.value = "");
                clone.querySelectorAll("select").forEach(s => s.selectedIndex = 0);
                // crear botón de borrar
                const eliminar = document.createElement("i");
                eliminar.className = "fa-solid fa-trash icono-eliminar-circular";
                eliminar.style.cursor = "pointer";
                eliminar.addEventListener("click", () => {
                    clone.remove();
                    // sólo llamamos a ESTA función:
                    actualizarEstadoInputs();
                });
                clone.appendChild(eliminar);
                cont.appendChild(clone);
            }

            // Tus funciones de “➕” ahora llaman a creaClon:
            window.AgregarOtraTarjeta = () => creaClon("#tarjeta", ".tarjeta-content");
            window.AgregarOtroPago = () => creaClon("#otro", ".otro-content");

            // Vincula el recálculo a cambios en cualquier input
            document.addEventListener("input", actualizarEstadoInputs);
            document.addEventListener("change", actualizarEstadoInputs);

            // Arranca el estado correcto al cargar
            actualizarEstadoInputs();
        });
    </script>
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
</body>

</html>