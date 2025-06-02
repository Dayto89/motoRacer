<?php
// Iniciar el buffer de salida
ob_start();

// session_start() debe ser lo primero
session_start();
if (!isset($_SESSION['usuario_id'])) {
    // Si no está autorizado, devolver un JSON de error
    ob_end_clean(); // Limpiar el buffer
    header('Content-Type: application/json');
    echo json_encode(["success" => false, "error" => "No autorizado"]);
    exit();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "inventariomotoracer";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    ob_end_clean(); // Limpiar el buffer
    header('Content-Type: application/json');
    echo json_encode(["success" => false, "error" => "Conexión fallida: " . $conn->connect_error]);
    exit;
}

// Manejar solicitudes GET para autocompletar
if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'] . "%";
    $sql = "SELECT codigo, identificacion, nombre, apellido, telefono, correo FROM cliente WHERE codigo LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $result = $stmt->get_result();

    $clientes = [];
    while ($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
    ob_end_clean(); // Limpiar el buffer
    header('Content-Type: application/json');
    echo json_encode($clientes);
    exit;
}

// Manejar solicitudes POST para guardar la factura
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    ob_end_clean(); // Limpiar el buffer
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data) {
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "error" => "No se recibieron datos"]);
        exit;
    }

    // Validar datos recibidos
    if (!isset($data["codigo"], $data["tipoDoc"], $data["nombre"], $data["apellido"], $data["telefono"], $data["correo"], $data["productos"], $data["metodos_pago"], $data["total"])) {
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "error" => "Datos incompletos"]);
        exit;
    }

    // Asignar valores
    $codigo = $data["codigo"];
    $tipoDoc = $data["tipoDoc"];
    $nombre = $data["nombre"];
    $apellido = $data["apellido"];
    $telefono = $data["telefono"];
    $correo = $data["correo"];
    $productos = $data["productos"];
    $metodos_pago = $data["metodos_pago"];
    $total = $data["total"];

    // Verificar si el cliente existe
    $sql = "SELECT codigo FROM cliente WHERE codigo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Registrar cliente si no existe
        $sql = "INSERT INTO cliente (codigo, identificacion, nombre, apellido, telefono, correo) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $codigo, $tipoDoc, $nombre, $apellido, $telefono, $correo);
        $stmt->execute();
        $cliente_id = $stmt->insert_id;
    } else {
        $cliente = $result->fetch_assoc();
        $cliente_id = $cliente["codigo"];
    }

    // Registrar factura
    $sql = "INSERT INTO factura (fechaGeneracion, Usuario_identificacion, Cliente_codigo, precioTotal) VALUES (NOW(), ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $usuario_id = $_SESSION["usuario_id"] ?? null;
    $stmt->bind_param("ssd", $usuario_id, $cliente_id, $total);
    $stmt->execute();
    $factura_id = $stmt->insert_id;

    // Registrar métodos de pago
    foreach ($metodos_pago as $metodo) {
        $sql = "INSERT INTO factura_metodo_pago (Factura_codigo, metodoPago, monto) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isd", $factura_id, $metodo["tipo"], $metodo["valor"]);
        $stmt->execute();
    }

    // Registrar productos en la factura
    foreach ($productos as $producto) {
        $sql = "INSERT INTO producto_factura (Factura_codigo, Producto_codigo, cantidad, precioUnitario) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiid", $factura_id, $producto["id"], $producto["cantidad"], $producto["precio"]);
        $stmt->execute();

        // Descontar stock del producto
        $sql = "UPDATE producto SET cantidad = cantidad - ? WHERE codigo1 = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $producto["cantidad"], $producto["id"]);
        $stmt->execute();
    }

    $min_quantity = 0;

    // 1. Usar $conn en lugar de $conexion
    $stmt = $conn->prepare("SELECT min_quantity FROM configuracion_stock ORDER BY id DESC LIMIT 1");
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $min_quantity = (int)$row['min_quantity'];
        }
    }

    // 2. Verificar solo si hay cantidad mínima configurada
    if ($min_quantity > 0) {
        $stmt = $conn->prepare("
            SELECT codigo1, nombre, cantidad 
            FROM producto 
            WHERE cantidad < ?
        ");
        $stmt->bind_param("i", $min_quantity);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($producto = $result->fetch_assoc()) {
                $mensaje = sprintf(
                    "Producto %s bajo mínimo! Stock actual: %d",
                    $producto['nombre'],
                    $producto['cantidad']
                );

                // 3. Manejo seguro de errores
                try {
                    $insert = $conn->prepare("INSERT INTO notificaciones (mensaje, fecha) VALUES (?, NOW())");
                    $insert->bind_param("s", $mensaje);
                    $insert->execute();
                } catch (Exception $e) {
                    error_log("Error en notificación: " . $e->getMessage());
                }
            }
        }
    }
    $_SESSION['factura_id'] = $factura_id;
    // Respuesta JSON
    header('Content-Type: application/json');
    echo json_encode(["success" => true, "factura_id" => $factura_id]);
    exit;
}

// Si no es una solicitud POST o GET, continuar con la generación del HTML
ob_end_clean(); // Limpiar el buffer antes de generar HTML
// Recuperar datos para mostrar en pago.php
$productos = $_SESSION['productos'] ?? [];
$total = $_SESSION['total'] ?? 0;
// Limpiar los datos de la sesión después de usarlos
unset($_SESSION['productos']);
unset($_SESSION['total']);
include_once $_SERVER['DOCUMENT_ROOT'].'/componentes/accesibilidad-widget.php';
?>
<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">

    <link rel="stylesheet" href="../componentes/header.css">
    <link rel="stylesheet" href="../componentes/header.php">
    <link rel="stylesheet" href="../css/pago.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                        <input type="text" id="codigo" name="codigo" onfocus="buscarCodigo()" oninput="buscarCodigo()">
                        <div id="suggestions" class="suggestions"></div>
                    </div>

                    <input type="text" id="nombre" name="nombre" placeholder="Nombre">
                    <input type="text" id="apellido" name="apellido" placeholder="Apellido">
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
                    <?php if (!empty($productos)): ?>
                        <div class="summary-container">
                            <h2>Productos:</h2>

                            <ul>
                                <?php foreach ($productos as $producto): ?>
                                    <li data-id="<?php echo $producto['id']; ?>">
                                        <p><?php echo $producto['cantidad'] . " x " . $producto['nombre'] . " - <span class='precio'>$" . number_format($producto['precio'], 2) . "</span>"; ?></p>
                                    </li>
                                <?php endforeach; ?>
                            </ul>


                            <p id="saldoPendiente">Saldo pendiente: $0.00</p>

                            <h2>Total a pagar:</h2>

                            <div class="contenedor-precio">
                                <p>$<?php echo number_format($total, 2); ?></p>
                            </div>
                        </div>
                        <button class="btn-pagar" onclick="guardarFactura()">Pagar</button>

                    <?php else: ?>
                        <p>No hay productos en el resumen.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        function guardarFactura() {
            let codigo = document.getElementById("codigo").value;
            let tipoDoc = document.getElementById("tipo_doc").value;
            let nombre = document.getElementById("nombre").value;
            let apellido = document.getElementById("apellido").value;
            let telefono = document.getElementById("telefono").value;
            let correo = document.getElementById("correo").value;
            let total = parseFloat(document.querySelector(".contenedor-precio p").textContent.replace("$", "").replace(/,/g, ""));

            //Verificar si saldo pendiente es cero
            saldoPendiente = calcularSaldoRestante();
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

            } else {


                // Obtener productos de la factura
                let productos = [];
                document.querySelectorAll(".summary-section ul li").forEach(li => {
                    let partes = li.textContent.split(" x ");
                    let cantidad = parseInt(partes[0].trim());
                    let nombreProducto = partes[1].split(" - $")[0].trim();
                    let precio = parseFloat(partes[1].split("$")[1].replace(/,/g, ""));
                    let id = li.getAttribute("data-id");

                    productos.push({
                        nombre: nombreProducto,
                        cantidad,
                        precio,
                        id
                    });
                });

                let metodos_pago = [];
                document.querySelectorAll("input[name='valor_efectivo'], input[name='valor_tarjeta'], input[name='valor_otro']").forEach(input => {
                    let valor = parseFloat(input.value);
                    if (!isNaN(valor) && valor > 0) {
                        let tipo = input.name.replace("valor_", "");
                        if (tipo === "otro") {
                            // Aquí se toma el valor del select correspondiente
                            let tipoOtro = document.querySelector("select[name='tipo_otro']").value;
                            if (tipoOtro) {
                                tipo = tipoOtro; // Se usa el valor seleccionado, ej. "transferencia"
                            } else {
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
                        }
                        metodos_pago.push({
                            tipo,
                            valor
                        });
                    }
                });


                fetch("prueba.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            codigo,
                            tipoDoc,
                            nombre,
                            apellido,
                            telefono,
                            correo,
                            total,
                            productos,
                            metodos_pago
                        })
                    })
                    .then(response => response.json()) // Parsear la respuesta como JSON
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: '<span class="titulo-alerta confirmacion">Éxito</span>',
                                html: `
                <div class=\"custom-alert\">
                    <div class=\"contenedor-imagen\">
                        <img src=\"../imagenes/moto.png\" alt=\"Confirmación\" class=\"moto\">
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
        }


        function actualizarSaldoPendiente() {
            let total = <?php echo $total; ?>; // Total desde PHP
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
            let tarjeta = document.querySelector("#tarjeta .tarjeta-content");
            let clone = tarjeta.cloneNode(true);

            // Crear contenedor del icono
            let contenedorIcono = document.createElement("div");
            contenedorIcono.style.display = "flex";
            contenedorIcono.style.alignItems = "center";
            contenedorIcono.style.justifyContent = "center";
            contenedorIcono.style.marginLeft = "10px";

            let eliminar = document.createElement("i");
            eliminar.className = "fa-solid fa-trash icono-eliminar-circular";
            eliminar.alt = "Eliminar";
            eliminar.style.cursor = "pointer";
            eliminar.onclick = function() {
                clone.remove();
            };

            clone.appendChild(eliminar);
            clone.appendChild(contenedorIcono);

            tarjeta.insertAdjacentElement("afterend", clone);
        }

        function AgregarOtroPago() {
            let otro = document.querySelector("#otro .otro-content");
            let clone = otro.cloneNode(true);

            // Crear botón de eliminar con el mismo estilo que tarjeta
            let eliminar = document.createElement("i");
            eliminar.className = "fa-solid fa-trash icono-eliminar-circular";
            eliminar.alt = "Eliminar";
            eliminar.style.cursor = "pointer";
            eliminar.onclick = function() {
                clone.remove();
            };

            clone.appendChild(eliminar);
            otro.insertAdjacentElement("afterend", clone);
        }


        function EliminarTarjeta() {
            let tarjeta = document.querySelector("#tarjeta .tarjeta-content");
            tarjeta.remove();
        }

        function EliminarOtroPago() {
            let otro = document.querySelector("#otro .otro-content");
            otro.remove();
        }

        function llenarValor(tipoPago, valor) {
            let input = document.querySelector(`input[name='valor_${tipoPago}']`);
            input.value = valor;
            input.dispatchEvent(new Event("input", {
                bubbles: true
            })); // Para disparar el evento
        }


        function buscarCodigo() {
            let input = document.getElementById("codigo").value;
            let suggestionsBox = document.getElementById("suggestions");

            fetch(`?codigo=${input}`)
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
                .catch(error => console.error("Error al obtener datos:", error));
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

        //Deshabilitar solo si el valor total de los productos se completo

        document.addEventListener("DOMContentLoaded", function() {
            function actualizarEstadoInputs() {
                let totalPagar = <?php echo $total; ?>;
                let sumaPagos = 0;

                // Obtener valores de pago ingresados
                let efectivo = parseFloat(document.querySelector("input[name='valor_efectivo']").value) || 0;
                let tarjetas = document.querySelectorAll("input[name='valor_tarjeta']");
                let otros = document.querySelectorAll("input[name='valor_otro']");

                sumaPagos += efectivo;

                tarjetas.forEach(input => {
                    let valor = parseFloat(input.value) || 0;
                    sumaPagos += valor;
                });

                otros.forEach(input => {
                    let valor = parseFloat(input.value) || 0;
                    sumaPagos += valor;
                });

                // Si la suma de los pagos es igual al total, deshabilitar los inputs vacíos
                if (sumaPagos >= totalPagar) {
                    document.querySelectorAll("input[name='valor_efectivo'], input[name='valor_tarjeta'], input[name='valor_otro']").forEach(input => {
                        if (input.value.trim() === "") {
                            input.disabled = true;
                        }
                    });
                } else {
                    // Si la suma aún no llega al total, habilitar todos los inputs
                    document.querySelectorAll("input[name='valor_efectivo'], input[name='valor_tarjeta'], input[name='valor_otro']").forEach(input => {
                        input.disabled = false;
                    });
                }
            }

            // Agregar eventos para verificar en tiempo real
            document.addEventListener("input", actualizarEstadoInputs);
            document.addEventListener("change", actualizarEstadoInputs);
        });
        document.addEventListener("DOMContentLoaded", function() {
            actualizarSaldoPendiente(); // Asegúrate de que esta función se ejecuta al cargar la página.

            // Seleccionar solo los inputs con name específico
            document.querySelectorAll("input[name='valor_efectivo'], input[name='valor_tarjeta'], input[name='valor_otro']").forEach(input => {
                input.addEventListener("click", function() {
                    if (this.value.trim() === "") { // Si el input está vacío
                        let saldoRestante = calcularSaldoRestante(); // Calcula el saldo restante
                        this.value = saldoRestante; // Autocompleta en los inputs específicos

                        // Disparar manualmente el evento 'input' para que cualquier otra lógica lo detecte
                        this.dispatchEvent(new Event("input", {
                            bubbles: true
                        }));
                    }
                });
            });
        });


        function calcularSaldoRestante() {
            let total = <?php echo $total; ?>; // Total desde PHP
            let sumaInputs = 0;

            document.querySelectorAll("input[name='valor_efectivo'], input[name='valor_tarjeta'], input[name='valor_otro']").forEach(input => {
                let valor = parseFloat(input.value) || 0; // Convierte a número o usa 0 si está vacío
                sumaInputs += valor;
            });

            return total - sumaInputs; // Retorna el saldo restante
        }


        document.addEventListener("DOMContentLoaded", actualizarSaldoPendiente);
    </script>
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
</body>

</html>