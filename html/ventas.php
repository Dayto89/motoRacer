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

// Almacenar los productos y el total en la sesión antes de redirigir
if (isset($_POST['cobrar'])) {
    $productos = [];
    $total = 0;
    
    // Recorrer los productos en el resumen y almacenarlos en un array
    foreach ($_POST['productos'] as $producto) {
        $productos[] = [
            'nombre' => $producto['nombre'],
            'precio' => $producto['precio'],
            'cantidad' => $producto['cantidad'],
            'id' => $producto['id']
        ];
        $total += $producto['precio'] * $producto['cantidad'];
    }
    
    // Guardar los productos y el total en la sesión
    $_SESSION['productos'] = $productos;
    $_SESSION['total'] = $total;
    
    // Redirigir a prueba.php
    header("Location: prueba.php");
    exit();
}


include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
?>
<!DOCTYPE html>
<html lang="es">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ventas</title>
        <link rel="stylesheet" href="../css/factura.css">
        <link rel="stylesheet" href="../componentes/header.php">
        <link rel="stylesheet" href="../componentes/header.css">
        <script src="../js/header.js"></script>
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
            <form method="GET" action="ventas.php">
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
                    echo "<li><a class='brand' name='categoria' href='ventas.php?categoria=" . htmlspecialchars($fila['codigo']) . "'>" . htmlspecialchars($fila['nombre']) . "</a></li>";
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
                    $disabledClass = $fila['cantidad'] <= 0 ? 'disabled' : '';
                    echo "<div class='card $disabledClass' data-id='{$fila['codigo1']}' data-nombre='" . htmlspecialchars($fila['nombre']) . "' data-precio='{$fila['precio2']}' data-cantidad='{$fila['cantidad']}'>
                    <span class='contador-producto'>0</span>
                    <div class='card-header'>
                        <p class='product-id'>" . htmlspecialchars($fila['nombre']) . "</p>
                    </div>
                <p class='product-price'>$" . number_format($fila['precio2']) . "</p>
                <p class='product-price'>$" . number_format($fila['precio3']) . "</p>
                <p class='product-cantidad'>Cantidad: {$fila['cantidad']}</p>
                <div class='iconos-container'>
                    <div class='icono-accion btn-add' onclick='agregarAlResumen(this.parentNode.parentNode)'>
                        $icono1
                    </div>
                    <div class='icono-accion btn-remove' onclick='quitarDelResumen(this.parentNode.parentNode)'>
                        $icono2
                    </div>
                </div>
            </div>";
                }
            } else {
                echo "<script>alert('No se encontraron resultados')</script>";
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
            if (document.querySelectorAll("#listaResumen li").length === 0) {
                alert("No hay productos en el resumen.");
            } else {
                let productos = [];
                let items = document.querySelectorAll("#listaResumen li");

                items.forEach(item => {
                    let id = item.getAttribute("data-id")?.trim();

                    let nombre = item.getAttribute("data-nombre");
                    let precio = parseFloat(item.getAttribute("data-precio"));
                    let cantidad = parseInt(item.getAttribute("data-cantidad"));

                    console.log(id);


                    productos.push({
                        id: id,
                        nombre: nombre,
                        precio: precio,
                        cantidad: cantidad
                    });
                });

                // Crear formulario dinámico
                let form = document.createElement("form");
                form.method = "POST";
                form.action = "ventas.php"; // Asegúrate de que la ruta sea correcta

                // Campo para indicar que se está cobrando
                let inputCobrar = document.createElement("input");
                inputCobrar.type = "hidden";
                inputCobrar.name = "cobrar";
                form.appendChild(inputCobrar);

                // Agregar productos como campos ocultos
                productos.forEach((producto, index) => {
                    let inputNombre = document.createElement("input");
                    inputNombre.type = "hidden";
                    inputNombre.name = `productos[${index}][nombre]`;
                    inputNombre.value = producto.nombre;
                    form.appendChild(inputNombre);

                    let inputPrecio = document.createElement("input");
                    inputPrecio.type = "hidden";
                    inputPrecio.name = `productos[${index}][precio]`;
                    inputPrecio.value = producto.precio;
                    form.appendChild(inputPrecio);

                    let inputCantidad = document.createElement("input");
                    inputCantidad.type = "hidden";
                    inputCantidad.name = `productos[${index}][cantidad]`;
                    inputCantidad.value = producto.cantidad;
                    form.appendChild(inputCantidad);

                    let inputId = document.createElement("input");
                    inputId.type = "hidden";
                    inputId.name = `productos[${index}][id]`;
                    inputId.value = producto.id;
                    form.appendChild(inputId);
                });

                document.body.appendChild(form);
                form.submit(); // Enviar el formulario
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
            if (elemento.classList.contains("disabled")) {
                alert("Este producto está agotado.");
                return;
            }

            let id = elemento.getAttribute("data-id");
            let nombre = elemento.getAttribute("data-nombre");
            let precio = parseFloat(elemento.getAttribute("data-precio"));
            let contadorElemento = elemento.querySelector(".contador-producto");
            let cantidElement = elemento.querySelector('.product-cantidad');
            let cantidActual = parseInt(elemento.getAttribute('data-cantidad'));

            if (cantidActual <= 0) {
                alert("No hay más stock disponible.");
                return;
            }

            // Actualizar contador visual
            let contador = parseInt(contadorElemento.textContent) || 0;
            contador++;
            contadorElemento.textContent = contador;
            contadorElemento.style.display = "block";

            // Reducir stock y actualizar visualmente
            cantidActual--;
            elemento.setAttribute('data-cantidad', cantidActual);
            cantidElement.textContent = `Cantidad: ${cantidActual}`;

            if (cantidActual === 0) {
                elemento.classList.add('disabled');
                elemento.style.pointerEvents = "none";
                let btnQuitar = elemento.querySelector(".btn-remove");
                if (btnQuitar) {
                    btnQuitar.style.pointerEvents = "auto"; // Mantener activo
                    btnQuitar.style.opacity = "1"; // Mantener visible
                    btnQuitar.style.position = "relative"; // Mantener posición
                }

            }

            // Actualizar lista de resumen
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
                item.setAttribute("data-id", id);
                item.setAttribute("data-nombre", nombre);
                item.setAttribute("data-precio", precio);
                item.setAttribute("data-cantidad", 1);
                item.innerHTML = `${nombre} x1 - $${precio.toLocaleString()}`;
                listaResumen.appendChild(item);
            }

            // Actualizar total
            total += precio;
            document.getElementById("total-price").innerText = `$${total.toLocaleString()}`;
        }


        function quitarDelResumen(elemento) {
            let nombre = elemento.getAttribute("data-nombre");
            let precio = parseFloat(elemento.getAttribute("data-precio"));
            let contadorElemento = elemento.querySelector(".contador-producto");

            let contador = parseInt(contadorElemento.textContent) || 0;
            let listaResumen = document.getElementById("listaResumen");
            let items = listaResumen.getElementsByTagName("li");
            let encontrado = false;

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

                    encontrado = true;
                    break;
                }
            }

            // Solo aumentar la cantidad si el producto estaba en el resumen
            if (encontrado) {
                let cantidElement = elemento.querySelector('.product-cantidad');
                let cantidActual = parseInt(elemento.getAttribute('data-cantidad'));

                if (!isNaN(cantidActual)) {
                    cantidActual++; // Aumentar stock
                    elemento.setAttribute('data-cantidad', cantidActual);
                    cantidElement.textContent = `Cantidad: ${cantidActual}`;
                }

                // Habilitar nuevamente el producto si estaba deshabilitado
                if (cantidActual > 0) {
                    elemento.classList.remove('disabled');
                    elemento.style.pointerEvents = "auto";
                    elemento.style.opacity = "1";

                    let btnQuitar = elemento.querySelector(".btn-remove");
                    if (btnQuitar) {
                        btnQuitar.style.pointerEvents = "auto"; // Mantener activo
                        btnQuitar.style.opacity = "1"; // Mantener visible
                    }
                }

                // Reducir el contador si es mayor a 0
                if (contador > 0) {
                    contador--;
                    contadorElemento.textContent = contador;
                    if (contador === 0) contadorElemento.style.display = "none";
                }
            }
        }
    </script>

</body>

</html>