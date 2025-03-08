<?php
// session_start() debe ser lo primero
session_start();
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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $_SESSION["resumen"] = $data;
        echo "Datos recibidos correctamente";
    } else {
        echo "No se recibieron datos";
    }
}
// Recuperar datos para mostrar en prueba.php
$productos = $_SESSION['productos'] ?? [];
$total = $_SESSION['total'] ?? 0;

// Limpiar los datos de la sesión después de usarlos
unset($_SESSION['productos']);
unset($_SESSION['total']);
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
            width: 150px;
            max-height: 150px;
            overflow-y: auto;
            display: none;
            margin-left: 27%;
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
                </select>
                <input type="text" id="codigo" name="codigo" onfocus="buscarCodigo()" oninput="buscarCodigo()">
                <div id="suggestions" class="suggestions"></div>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre">
                <input type="text" id="apellido" name="apellido" placeholder="Apellido">
                <input type="text" id="telefono" name="telefono" placeholder="Teléfono">
                <input type="email" id="correo" name="correo" placeholder="Correo Electrónico">
            </div>
            <div class="payment-section">
                <h2>Registrar Pago</h2>
                <div class="content">
                    <div class="payment-methods">
                        <div class="payment-box">
                            <h3>Pagos en efectivo</h3>
                            <button onclick="llenarValor('efectivo', 30000)">$30,000</button>
                            <button onclick="llenarValor('efectivo', 50000)">$50,000</button>
                            <button onclick="llenarValor('efectivo', 100000)">$100,000</button>
                            <input type="text" name="valor_efectivo" placeholder="Valor">
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
                                    <input type="text" name="valor_tarjeta" placeholder="$0.00">

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
                                        <option value=""></option>
                                        <option value="transferencia">Transferencia</option>
                                    </select>
                                    <input type="text" name="valor_otro" placeholder="$0.00">

                                </div>
                            </div>
                        </div>
                        <div class="notes">
                            <h3>Observaciones</h3>
                            <textarea name="observaciones" placeholder="Ingrese observaciones..."></textarea>
                        </div>
                    </div>
                    <div id="summary-section" class="summary-section">
                        <h3>Informacion de pago</h3>
                        <?php if (!empty($productos)): ?>
                            <h3>Productos:</h3>

                            <ul>
                                <?php foreach ($productos as $producto): ?>
                                    <li>
                                        <p><?php echo $producto['cantidad'] . " x " . $producto['nombre'] . " - <span>$" . number_format($producto['precio'], 2) . "</span>"; ?></p>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <p>
                            <h3>Total a pagar:</h3> $<?php echo number_format($total, 2); ?></p>
                            <button onclick="pagar()">Pagar</button>
                        <?php else: ?>
                            <p>No hay productos en el resumen.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function AgregarOtraTarjeta() {
            let tarjeta = document.querySelector("#tarjeta .tarjeta-content");
            let clone = tarjeta.cloneNode(true);

            // Crear botón de eliminar solo para clones
            let eliminar = document.createElement("img");
            eliminar.src = "../imagenes/delete.svg";
            eliminar.alt = "Eliminar";
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

            // Limpiar los valores de los inputs clonados
            clone.querySelector("select").value = "";
            clone.querySelector("input").value = "";

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

            // Crear y disparar el evento input manualmente
            let event = new Event("input", {
                bubbles: true
            });
            input.dispatchEvent(event);
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

        document.addEventListener("DOMContentLoaded", function() {
            let efectivoInput = document.querySelector("input[name='valor_efectivo']");

            let tarjetaSelect = document.querySelector("select[name='tipo_tarjeta']");
            let tarjetaInput = document.querySelector("input[name='valor_tarjeta']");
            let voucherInput = document.querySelector("input[name='voucher']");
            let grupoTarjeta = [tarjetaSelect, tarjetaInput, voucherInput];

            let otroSelect = document.querySelector("select[name='tipo_otro']");
            let otroInput = document.querySelector("input[name='valor_otro']");
            let grupoOtro = [otroSelect, otroInput];

            function disableGroups(selectedGroup) {
                let allGroups = [efectivoInput, grupoTarjeta, grupoOtro];

                allGroups.forEach(group => {
                    if (group === selectedGroup) {
                        enableGroup(group); // Habilita el grupo seleccionado
                    } else {
                        disableGroup(group); // Deshabilita los demás grupos
                    }
                });
            }

            function disableGroup(group) {
                if (Array.isArray(group)) {
                    group.forEach(input => {
                        input.disabled = true;
                        input.value = "";
                    });
                } else {
                    group.disabled = true;
                    group.value = "";
                }
            }

            function enableGroup(group) {
                if (Array.isArray(group)) {
                    group.forEach(input => input.disabled = false);
                } else {
                    group.disabled = false;
                }
            }

            function checkEmptyAndEnable() {
                if (!efectivoInput.value.trim() &&
                    !tarjetaInput.value.trim() &&
                    !otroInput.value.trim() &&
                    tarjetaSelect.value === "" &&
                    otroSelect.value === "") {
                    enableGroup(efectivoInput);
                    enableGroup(grupoTarjeta);
                    enableGroup(grupoOtro);
                }
            }

            efectivoInput.addEventListener("input", () => {
                if (efectivoInput.value.trim() !== "") {
                    disableGroups(efectivoInput);
                } else {
                    checkEmptyAndEnable();
                }
            });

            tarjetaInput.addEventListener("input", () => {
                if (tarjetaInput.value.trim() !== "") {
                    disableGroups(grupoTarjeta);
                } else {
                    checkEmptyAndEnable();
                }
            });

            tarjetaSelect.addEventListener("change", () => {
                if (tarjetaSelect.value !== "") {
                    disableGroups(grupoTarjeta);
                } else {
                    checkEmptyAndEnable();
                }
            });

            otroInput.addEventListener("input", () => {
                if (otroInput.value.trim() !== "") {
                    disableGroups(grupoOtro);
                } else {
                    checkEmptyAndEnable();
                }
            });

            otroSelect.addEventListener("change", () => {
                if (otroSelect.value !== "") {
                    disableGroups(grupoOtro);
                } else {
                    checkEmptyAndEnable();
                }
            });
        });
    </script>
</body>

</html>