<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "inventariomotoracer";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener usuarios para autocompletar
if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'] . "%"; // Filtrar solo por los que comienzan con el código ingresado
    $sql = "SELECT codigo, identificacion, nombre, apellido, telefono, correo FROM cliente WHERE codigo LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $result = $stmt->get_result();

    $clientes = [];
    while ($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
    echo json_encode($clientes);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <link rel="stylesheet" href="../css/pago.css">
    <link rel="stylesheet" href="../componentes/header.css">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="/js/index.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');

        .suggestions {
            position: absolute;
            background: white;
            border: 1px solid #ccc;
            width: 200px;
            max-height: 150px;
            overflow-y: auto;
            display: none;
        }

        .suggestions div {
            padding: 10px;
            cursor: pointer;
        }

        .suggestions div:hover {
            background: #f0f0f0;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div id="menu"></div>
    </div>
    <div class="main-content">
        <div class="container">
            <div class="user-info">
                <h2>Información del Usuario</h2>
                <label for="tipo_doc">Tipo de Documento:</label>
                <select id="tipo_doc" name="tipo_doc">
                    <option value="CC">Cédula de Ciudadanía</option>
                    <option value="TI">Tarjeta de Identidad</option>
                    <option value="NIT">NIT</option>
                </select>>
                <input type="text" id="codigo" name="codigo" onfocus="buscarCodigo()" oninput="buscarCodigo()">
                <div id="suggestions" class="suggestions"></div>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre">
                <input type="text" id="apellido" name="apellido" placeholder="Apellido">
                <input type="text" id="telefono" name="telefono" placeholder="Teléfono">
                <input type="email" id="correo" name="correo" placeholder="Correo Electrónico">

                <!-- Botón para llenar datos automáticamente -->
                <button onclick="fillDefaultUser()">Llenar Datos</button>
            </div>
    <!-- Traer datos de factura.php y mostrar los datos en la página -->
            <div class="payment-section">
                <h2>Registrar Pago</h2>
                <div class="content">
                    <div class="payment-methods">
                        <div class="payment-box">
                            <h3>Pagos en efectivo</h3>
                            <button>$30,000</button>
                            <button>$50,000</button>
                            <button>$100,000</button>
                            <input type="text" name="valor_efectivo" placeholder="Valor">
                        </div>
                        <div class="payment-box">
                            <h3>Pagos con tarjeta</h3>
                            <select name="tipo_tarjeta">
                                <option>Tipo</option>
                            </select>
                            <input type="text" name="voucher" placeholder="Nro. voucher">
                            <input type="text" name="valor_tarjeta" placeholder="$0.00">
                        </div>
                        <div class="payment-box">
                            <h3>Otros pagos</h3>
                            <select name="tipo_otro">
                                <option>Tipo</option>
                            </select>
                            <input type="text" name="valor_otro" placeholder="$0.00">
                        </div>
                        <div class="notes">
                            <h3>Observaciones</h3>
                            <textarea name="observaciones" placeholder="Ingrese observaciones..."></textarea>
                        </div>
                    </div>
                    <div class="summary-section">
                        <h3>Información de pago</h3>
                        <p>Total bruto: <span>$25,210.08</span></p>
                        <p>Descuento aplicado: <span>$0.00</span></p>
                        <p>Subtotal: <span>$25,210.08</span></p>
                        <p>Total IVA: <span>$4,789.92</span></p>
                        <h3>Total a pagar</h3>
                        <p class="total">$30,000.00</p>
                        <button class="save-btn">Guardar y enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function fillDefaultUser() {
            document.getElementById("tipo_doc").value = "CC";
            document.getElementById("cedula").value = "0000000000";
            document.getElementById("nombre").value = "Consumidor";
            document.getElementById("apellido").value = "Final";
            document.getElementById("telefono").value = "0000000000";
            document.getElementById("correo").value = "consumidorfinal@email.com";
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
    </script>
</body>

</html>