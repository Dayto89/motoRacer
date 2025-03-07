<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');

if (!$conexion) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}


$icono1 = '
<animated-icons class= "icono-accion"
  src="https://animatedicons.co/get-icon?name=plus&style=minimalistic&token=3a3309ff-41ae-42ce-97d0-5767a4421b43"
  trigger="click"
  attributes=\'{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#158E05FF","background":"#FFFFFF"}}\'
  height="50"
  width="50"

></animated-icons>';

$icono2 = '
<animated-icons class="icono-accion"
  src="https://animatedicons.co/get-icon?name=minus&style=minimalistic&token=8e4bd16d-969c-4151-b056-fee12950fb23"
  trigger="click"
  attributes=\'{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#FF0000FF","background":"#FFFFFF"}}\'
  height="50"
  width="50"

  ></animated-icons>';


// Guardar informacion de cliente en la base de datos

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');

if (!$conexion) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

if (isset($_POST['guardar'])) {
    $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);
    $identificacion = mysqli_real_escape_string($conexion, $_POST['identificacion']);
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
    $cliente = mysqli_real_escape_string($conexion, $_POST['cliente']);

    $consulta = "INSERT INTO cliente ( codigo, identificacion, nombre, apellido, email, telefono, direccion, cliente) VALUES ('$codigo', '$identificacion', '$nombre', '$apellido', '$email', '$telefono', '$direccion', '$cliente')";

    if (mysqli_query($conexion, $consulta)) {
        echo "Datos guardados correctamente.";
    } else {
        echo "Error al guardar los datos: " . mysqli_error($conexion);
    }
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="stylesheet" href="../css/factura.css">
    <link rel="stylesheet" href="../componentes/header.css">
    <script src="../js/index.js"></script>
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <style>

    </style>
</head>

<body>
    <div class="sidebar">
        <div id="menu"></div>
    </div>

    <div class="main">
        <div class="search-bar">
            <form method="GET" action="factura.php">
                <button class="search-icon" type="submit" aria-label="Buscar" title="Buscar">
                    <i class="bx bx-search-alt-2 icon"></i>
                </button>
                <input class="form-control" type="text" name="busqueda" placeholder="Buscar por nombre o código">
            </form>
        </div>

        <ul class="breadcrumb">
            <?php
            $stmt = $conexion->prepare("SELECT * FROM categoria");
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    // Al ser presionado alguna categoria se muestra los productos de esa categoria
                    echo "<li><a class='brand' name='categoria' href='factura.php?categoria=" . htmlspecialchars($fila['codigo']) . "'>" . htmlspecialchars($fila['nombre']) . "</a></li>";
                }
            } else {
                echo "<li>No hay categorías disponibles</li>";
            }

            $stmt->close();
            ?>
        </ul>

        <div class="products">
            <?php
            if (isset($_GET['busqueda'])) {
                $buscar = "%" . $_GET['busqueda'] . "%";
                $stmt = $conexion->prepare("SELECT * FROM producto WHERE nombre LIKE ? OR codigo1 LIKE ?");
                $stmt->bind_param("ss", $buscar, $buscar);
                $stmt->execute();
                $resultado = $stmt->get_result();
            } else if (isset($_GET['categoria'])) {
                $categoria = $_GET['categoria'];
                $stmt = $conexion->prepare("SELECT * FROM producto WHERE Categoria_codigo = ?");
                $stmt->bind_param("s", $categoria);
                $stmt->execute();
                $resultado = $stmt->get_result();
            } else {
                $consulta = "SELECT * FROM producto";
                $resultado = mysqli_query($conexion, $consulta);
            }

            if ($resultado->num_rows > 0) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<div class='card' data-id='{$fila['codigo1']}' data-nombre='" . htmlspecialchars($fila['nombre']) . "' data-precio='{$fila['precio2']}'>
                    <span class='contador-producto'>0</span>
                    <div class='card-header'>
                        <p class='product-id'>" . htmlspecialchars($fila['nombre']) . "</p>
                    </div>
                    <p class='product-price'>$" . number_format($fila['precio2']) . "</p>
                    <p class='product-price'>$" . number_format($fila['precio3']) . "</p>
                    <div class='iconos-container'>
                        <div class='icono-accion' onclick='agregarAlResumen(this.parentNode.parentNode)'>
                            $icono1
                        </div>
                        <div class='icono-accion' onclick='quitarDelResumen(this.parentNode.parentNode)'>
                            $icono2
                        </div>
                    </div>
                </div>";
                }
            } else {
                echo "<h2>No hay productos en la base de datos.</h2>";
            }

            mysqli_close($conexion);
            ?>
        </div>
    </div>

    <div class="sidebar-right">

        <h3>Resumen</h3>

        <!-- Contenedor con Scroll -->

        <div class="resumen-scroll">
            <ul id="listaResumen" class="listaResumen"></ul>
        </div>

        <div class="total">
            <span>Total:</span>
            <span id="total-price">$0.00</span>
        </div>

        <div class="resumen-botones">
            <button class="btn-cobrar" id="btnCobrar" onclick="cobrar()">Cobrar</button>
        </div>
    </div>

    <script>
        let total = 0;

        // Funcion cobrar abre modal de metodo de pago
        function cobrar() {
            if (document.querySelectorAll("#summary-section ul li").length === 0) {
                alert("No hay productos en el resumen.");
            }
        }


        function abrirModal() {
            const modal = document.getElementById("modalPaymentMethod");
            const btnAbrirModal = document.getElementById("btnAbrirModal");
            modal.style.display = "flex"; // Mostrar el modal con flexbox
            btnAbrirModal.style.display = "none"; // Ocultar el botón de abrir modal
        }

        function cerrarModal() {
            const modal = document.getElementById("modalPaymentMethod");
            const btnAbrirModal = document.getElementById("btnAbrirModal");
            modal.style.display = "none"; // Ocultar el modal
            btnAbrirModal.style.display = "block"; // Mostrar el botón de abrir modal
        }

        // Función para abrir el modal de información de cliente
        function openModal() {
            const modal = document.getElementById("modalConfirm");
            const btnAbrirModal = document.getElementById("btnAbrirModal");
            modal.style.display = "flex"; // Mostrar el modal con flexbox
            btnAbrirModal.style.display = "none"; // Ocultar el botón de abrir modal
        }

        // Función para cerrar el modal de información de cliente
        function closeModal() {
            const modal = document.getElementById("modalConfirm");
            const btnAbrirModal = document.getElementById("btnAbrirModal");
            modal.style.display = "none"; // Ocultar el modal
            btnAbrirModal.style.display = "block"; // Mostrar el botón de abrir modal
        }

        // Prevenir el envío del formulario al hacer clic en "Cancelar"
        document.getElementById("cancelButton").addEventListener("click", function(event) {
            event.preventDefault(); // Evitar el envío del formulario
            closeModal(); // Cerrar el modal
        });



        function agregarAlResumen(elemento) {
            let nombre = elemento.getAttribute("data-nombre");
            let precio = parseFloat(elemento.getAttribute("data-precio"));
            let contadorElemento = elemento.querySelector(".contador-producto");

            let contador = parseInt(contadorElemento.textContent) || 0;
            contador++;
            contadorElemento.textContent = contador;
            contadorElemento.style.display = "block";

            let listaResumen = document.getElementById("listaResumen");
            let items = listaResumen.getElementsByTagName("li");
            let encontrado = false;

            for (let i = 0; i < items.length; i++) {
                if (items[i].getAttribute("data-nombre") === nombre) {
                    let cantidad = parseInt(items[i].getAttribute("data-cantidad")) + 1;
                    items[i].setAttribute("data-cantidad", cantidad);
                    items[i].innerHTML = `${nombre} x${cantidad} - $${(precio * cantidad).toLocaleString()}`;
                    encontrado = true;
                    break;
                }
            }

            if (!encontrado) {
                let item = document.createElement("li");
                item.setAttribute("data-nombre", nombre);
                item.setAttribute("data-precio", precio);
                item.setAttribute("data-cantidad", 1);
                item.innerHTML = `${nombre} x1 - $${precio.toLocaleString()}`;
                listaResumen.appendChild(item);
            }

            total += precio;
            document.getElementById("total-price").innerText = `$${total.toLocaleString()}`;
        }

        function quitarDelResumen(elemento) {
            let nombre = elemento.getAttribute("data-nombre");
            let precio = parseFloat(elemento.getAttribute("data-precio"));
            let contadorElemento = elemento.querySelector(".contador-producto");

            let contador = parseInt(contadorElemento.textContent) || 0;
            if (contador > 0) {
                contador--;
                contadorElemento.textContent = contador;
                if (contador === 0) contadorElemento.style.display = "none";
            }

            let listaResumen = document.getElementById("listaResumen");
            let items = listaResumen.getElementsByTagName("li");

            for (let i = 0; i < items.length; i++) {
                if (items[i].getAttribute("data-nombre") === nombre) {
                    let cantidad = parseInt(items[i].getAttribute("data-cantidad")) - 1;

                    if (cantidad > 0) {
                        items[i].setAttribute("data-cantidad", cantidad);
                        items[i].innerHTML = `${nombre} x${cantidad} - $${(precio * cantidad).toLocaleString()}`;
                    } else {
                        listaResumen.removeChild(items[i]);
                    }

                    total -= precio;
                    document.getElementById("total-price").innerText = `$${total.toLocaleString()}`;
                    break;
                }
            }
        }
    </script>

</body>

</html>