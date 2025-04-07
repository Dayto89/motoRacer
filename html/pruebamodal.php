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

include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';

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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
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
                    <input type="text" id="telefono" name="telefono" placeholder="Teléfono">
                    <input type="email" id="correo" name="correo" placeholder="Correo Electrónico">
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
                                        <option value=""></option>
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
                            <div class="barra-1">
                                <div class="otro-content">
                                    <select name="tipo_otro">
                                        <option value=""></option>
                                        <option value="transferencia">Transferencia</option>
                                    </select>
                                    <input type="text" name="valor_otro" placeholder="$0.00" oninput="actualizarSaldoPendiente()">

                                </div>
                            </div>
                        </div>
                        <div class="notes">
                            <h3>Observaciones</h3>
                            <textarea name="observaciones" placeholder="Ingrese observaciones..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="summary-section">
                    <h3>Información de pago</h3>
                    <?php if (!empty($productos)): ?>
                        <h3>Productos:</h3>

                        <ul>
                            <?php foreach ($productos as $producto): ?>
                                <li data-id="<?php echo $producto['id']; ?>">
                                    <p><?php echo $producto['cantidad'] . " x " . $producto['nombre'] . " - <span class='precio'>$" . number_format($producto['precio'], 2) . "</span>"; ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>


                        <p id="saldoPendiente">Saldo pendiente: $0.00</p>

                        <h3>Total a pagar:</h3>

                        <div class="contenedor-precio">
                            <p>$<?php echo number_format($total, 2); ?></p>
                        </div>
                        <button onclick="guardarFactura()">Pagar</button>
                    <?php else: ?>
                        <p>No hay productos en el resumen.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    </div>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Metal Mania", system-ui;
            background-image: url('fondoMotoRacer.png');
            background-size: cover;
            background-position: center;
        }

        body::before {
            position: fixed;
            width: 200%;
            height: 200%;
            z-index: -1;
            background: black;
            opacity: 0.6;
        }

        .container {
            /* background-color: rgba(174, 174, 174, 0.59); */
            /* border-radius: 10px; */
            justify-content: space-between;
            width: 1698px;
            /* height: 901px; */
            margin: auto;
            transition: margin-left 0.3s ease, background-color 0.3s ease;
        }


        .sidebar {
            width: 100px;
            height: 100vh;
            background: linear-gradient(180deg, #1167CC, #083972, #000000);
            transition: width 0.3s ease;
            overflow: hidden;
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar:hover {
            width: 270px;
        }

        /* Ajuste de contenido cuando el menú se expande */
        .sidebar:hover~.container {
            margin-left: 270px !important;
        }

        /* Ajuste cuando el menú se expande */
        .sidebar:hover~.main-content {
            padding-left: 290px;
            /* Mantiene la misma distancia cuando el menú se despliega */
            transition: padding-left 0.3s ease;
        }

        /* Mantener la distancia de los lados */
        .main-content {
            transition: padding-left 0.3s ease;
            width: calc(100% - 150px);
            margin: auto;
            margin-top: 72px;
            margin-right: 62px;
            padding-left: 179px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            gap: 21px;
        }

        .user-info h2 {
            text-align: start;
            margin-left: 10px;
            font-size: 41px;
            margin-top: 23px;
            font-family: metal mania;
            text-shadow: rgb(28, 81, 160) 7px -1px 0px, rgb(28, 81, 160) 1px -1px 0px, rgb(28, 81, 160) -1px 1px 0px, rgb(28, 81, 160) 3px 5px 0px;
        }

        .form-grid {

            grid-template-columns: repeat(2, 1fr);
            row-gap: 19px;
            margin-left: 323px;
            margin: 0;
            margin-top: 27px;
            padding: 19px;
            column-gap: -19px;

        }

        .payment-section {
            margin-top: 100px;

        }

        .payment-section h2 {
            text-align: start;
            margin-left: 10px;
            font-size: 41px;
            font-family: metal mania;
            text-shadow: rgb(28, 81, 160) 7px -1px 0px, rgb(28, 81, 160) 1px -1px 0px, rgb(28, 81, 160) -1px 1px 0px, rgb(28, 81, 160) 3px 5px 0px;
        }


        .summary-section {
            margin-top: 80px;
            background-color: white;
            border-radius: 10px;
            width: 300px;
            height: 300px;
            margin-right: 310px;

        }

        input {

            height: 45px;
            width: 20%;
            font-size: 15px;
            border-radius: 5px;
        }

        .user-info label,
        .payment-methods h3 {
            font-size: 20px;
            text-shadow: -1px 1px 0 rgb(85 170 239);
            font-family: arial;
            margin-top: 10%;
            font-weight: normal;
            /* <- ESTO ayuda a igualar el grosor */
        }

        #tipo_doc {
            /* margin-top: 55px; */
            /* margin-left: 1px; */
            height: 44px;
            width: 100%;
            font-size: 15px;
            border-radius: 9px;
        }


        .payment-methods {
            margin-right: 100px;
            margin-left: 0px;
        }

        .efectivo-row {
            display: flex;
            align-items: flex-end;
            gap: 8px;
            width: 100%;
        }

        .efectivo-row input {
            flex: 1;
            min-width: 153px;

        }



        .content {
            display: flex;
            justify-content: space-evenly;
            margin-left: -200px;
        }

        button {
            flex-shrink: 0;
            background-color: #5496c3;
            cursor: pointer;
            width: 74px;
            height: 40px;
            color: white;
            border-radius: 15px;
            margin-top: 20px;
        }



        .payment-box {
            width: 500px;
        }

        .payment-box select {
            width: 19%;
            height: 40px;
            font-size: 15px;
            border-radius: 8px;
        }


        .payment-box input {
            height: 40px;
            width: 140px;
            font-size: 15px;
            border-radius: 5px;
            margin-left: 20px;

        }

        input[name="valor_tarjeta"] {
            margin-left: 6px;
            width: 140px;
        }

        .notes h3 {
            font-size: 25px;
            font-weight: normal;
            margin-left: 30px;
            margin-top: 35px;
            text-shadow:
                -1px -1px 0 rgb(0, 140, 255),
                1px -1px 0 rgb(0, 140, 255),
                -1px 1px 0 rgb(0, 140, 255),
                1px 1px 0 rgb(0, 140, 255);

        }

        textarea[name="observaciones"] {
            margin-left: 20px;
            width: 33%;
            height: 100px;
        }

        .summary-section h3 {
            margin-top: 20px;
            border-radius: 10px;
            width: 300px;
            margin-left: 30px;
            text-shadow:
                -1px -1px 0 rgb(255, 251, 0),
                1px -1px 0 rgb(255, 251, 0),
                -1px 1px 0 rgb(255, 251, 0),
                1px 1px 0 rgb(255, 251, 0);
            margin-right: 310px;
        }

        p {
            font-size: 16px;
            color: #333;
            margin: 5px 0;
            margin-left: 30px;
            margin-top: 10px;
        }

        p span {
            font-weight: bold;
            /* Hacer que los valores sean más visibles */
            color: #007bff;
            /* Azul para resaltar los montos */
            margin-left: 10px;
            /* Espacio entre el texto y el monto */
        }

        .total {
            margin-left: 90px;
        }

        .save-btn {
            margin-left: 70px;
            margin-top: 10px;
            width: 150px;
            height: 40px;
        }

        button:hover {
            background-color: #0056b3;
            /* Azul más oscuro */
        }

        .plus-icon h3 {
            font-family: Arial, sans-serif;
            font-weight: normal;
            margin: 0;
        }

        .plus-icon {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            margin-top: 29px;
        }

        .plus-icon img {
            width: 20px;
            /* o el tamaño que prefieras */
            height: 20px;
            cursor: pointer;
            margin-left: 10px;
            /* ajusta si lo ves muy pegado al texto */
        }


        .payment-box img {
            width: 30px;
            height: 30px;
        }

        .barra {
            max-height: 90px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            padding: 0;
            margin: 0;
            width: 100%;
            box-sizing: border-box;
        }


        .tarjeta-content,
        .otro-content {

            display: flex;
            gap: 5px;
            align-items: center;
            flex-wrap: nowrap;
            /* evita salto */
            width: 100%;

        }

        .tarjeta-content input,
        .tarjeta-content select {
            flex: 1;
            min-width: 0;
            box-sizing: border-box;
        }

        .summary-section ul {
            list-style-type: none;
            /* Elimina las viñetas */
            padding-left: 0;
            /* Ajusta el espacio izquierdo */
        }

        .contenedor-preciom p {
            margin-left: 50px;
        }

        .content>div {
            flex: 1;
            margin-right: 40px;
            padding: 43px;
        }

        .user-info input,
        .user-info select {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            box-sizing: border-box;
            border-radius: 9px;
        }

        .user-info,
        .payment-box,
        .summary-section {
            background-color: rgb(255 255 255 / 52%);
            border-radius: 10px;
        }

        #tarjeta,
        #otro.payment-box {
            background: #fdfdfd00;
        }

        .input-group {
            position: relative;
            /* clave para posicionar las sugerencias debajo del input */
            width: 100%;
        }

        #codigo {
            width: 100%;
            padding: 10px;
            font-size: 15px;
        }

        .suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: white;
            border: 1px solid #ccc;
            border-top: none;
            max-height: 150px;
            overflow-y: auto;
            z-index: 1000;
            font-size: 13px;
            font-family: arial;
            margin-left: 1px;
        }

        .icono-eliminar {
            color: white;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .icono-eliminar:hover {
            color: red;
        }
    </style>
    <script>
        function guardarFactura() {
            let codigo = document.getElementById("codigo").value;
            let tipoDoc = document.getElementById("tipo_doc").value;
            let nombre = document.getElementById("nombre").value;
            let apellido = document.getElementById("apellido").value;
            let telefono = document.getElementById("telefono").value;
            let correo = document.getElementById("correo").value;
            let total = parseFloat(document.querySelector(".contenedor-precio p").textContent.replace("$", "").replace(",", ""));

            //Verificar si saldo pendiente es cero
            saldoPendiente = calcularSaldoRestante();
            if (saldoPendiente > 0) {
                alert("Falta ingresar valores para pagar");
                return;

            } else {


                // Obtener productos de la factura
                let productos = [];
                document.querySelectorAll(".summary-section ul li").forEach(li => {
                    let partes = li.textContent.split(" x ");
                    let cantidad = parseInt(partes[0].trim());
                    let nombreProducto = partes[1].split(" - $")[0].trim();
                    let precio = parseFloat(partes[1].split("$")[1].replace(",", ""));
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
                                alert("Selecciona un tipo de pago para 'otro'");
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
                            alert("Factura registrada correctamente con ID: " + data.factura_id);
                            window.location.href = "recibo.php?factura_id=" + data.factura_id;
                        } else {
                            alert("Error al registrar factura: " + (data.error || ""));
                        }
                    })
                    .catch(error => {
                        console.error("Error al registrar:", error);
                        alert("Error al registrar factura. Por favor, inténtalo de nuevo.");
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


            let eliminar = document.createElement("i");
            eliminar.className = "fa-solid fa-trash";
            eliminar.style.cursor = "pointer";
            eliminar.onclick = function() {
                clone.remove();
            };

            clone.appendChild(eliminar);
            tarjeta.insertAdjacentElement("afterend", clone);
        }

        function AgregarOtroPago() {
            let otro = document.querySelector("#otro .otro-content");
            let clone = otro.cloneNode(true);

            // Crear botón de eliminar solo para clones
            let eliminar = document.createElement("img");
            eliminar.src = "../imagenes/delete.svg";
            eliminar.alt = "Eliminar";
            eliminar.style.cursor = "pointer";
            eliminar.style.marginLeft = "10px"; // Espaciado
            eliminar.onclick = function() {
                clone.remove();
            };

            // Añadir el botón dentro del clon (después del input)
            clone.appendChild(eliminar);

            // Insertar el clon después del elemento original
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
</body>

</html>