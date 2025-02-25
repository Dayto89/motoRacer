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
                    echo "<li><a class='brand'>" . htmlspecialchars($fila['nombre']) . "</a></li>";
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
            } else {
                $consulta = "SELECT * FROM producto";
                $resultado = mysqli_query($conexion, $consulta);
            }

            if ($resultado->num_rows > 0) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<div class='card' data-id='{$fila['codigo1']}' data-nombre='" . htmlspecialchars($fila['nombre']) . "' data-precio='{$fila['precio3']}'>
                    <span class='contador-producto'>0</span>
                    <div class='card-header'>
                        <span class='product-id'>" . htmlspecialchars($fila['codigo1']) . "</span>
                        <button class='more-btn'>⋮</button>
                    </div>
                    <p class='product-name'>" . htmlspecialchars($fila['nombre']) . "</p>
                    <p class='product-code'>" . htmlspecialchars($fila['precio2']) . "</p>
                    <p class='product-price'>$" . number_format($fila['precio3'], 2) . "</p>
                    <div class='iconos-container'>
                        <!-- ✅ Icono Agregar (+) -->
                        <div class='icono-accion agregar' onclick='agregarAlResumen(this.parentNode.parentNode)'>
                            <animated-icons
                                src='https://animatedicons.co/get-icon?name=plus&style=minimalistic&token=3a3309ff-41ae-42ce-97d0-5767a4421b43'
                                trigger='click'
                                height='50'
                                width='50'
                                attributes='{
                                    \"defaultColours\": {
                                        \"group-1\": \"#000000\", /* Borde negro */
                                        \"group-2\": \"#6EFE53\", /* SÍMBOLO + VERDE */
                                        \"background\": \"#F0F0F0\" /* Fondo gris claro */
                                    }
                                }'
                            ></animated-icons>
                        </div>
            
                        <!-- ❌ Icono Quitar (-) -->
                        <div class='icono-accion quitar' onclick='quitarDelResumen(this.parentNode.parentNode)'>
                            <animated-icons
                                src='https://animatedicons.co/get-icon?name=minus&style=minimalistic&token=8e4bd16d-969c-4151-b056-fee12950fb23'
                                trigger='click'
                                height='50'
                                width='50'
                                attributes='{
                                    \"defaultColours\": {
                                        \"group-1\": \"#000000\", /* Borde negro */
                                        \"group-2\": \"#FF4B4B\", /* SÍMBOLO - ROJO */
                                        \"background\": \"#F0F0F0\" /* Fondo gris claro */
                                    }
                                }'
                            ></animated-icons>
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
        <ul id="listaResumen"></ul>
        <div class="total">
            <span>Total:</span>
            <span id="total-price">$0.00</span>
        </div>
        <button class="btn pay-btn">Cobrar</button>
    </div>

    <script>
        let total = 0;

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
            let contadorElemento = elemento.querySelector(".contador-producto");
            let contador = parseInt(contadorElemento.textContent) || 0;

            if (contador > 0) {
                contador--;
                contadorElemento.textContent = contador;
                if (contador === 0) contadorElemento.style.display = "none";
            }

        }
    </script>

</body>

</html>