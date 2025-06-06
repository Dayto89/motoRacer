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

// Iconos para agregar/quitar
$icono1 = '
<animated-icons class="icono-accion"
src="https://animatedicons.co/get-icon?name=plus&style=minimalistic&token=3a3309ff-41ae-42ce-97d0-5767a4421b43"
trigger="click"
attributes=\'{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#158E05FF","background":"#FFFFFF"}}\'
height="50"
width="50"></animated-icons>';

$icono2 = ' 
<animated-icons class="icono-accion"
src="https://animatedicons.co/get-icon?name=minus&style=minimalistic&token=8e4bd16d-969c-4151-b056-fee12950fb23"
trigger="click"
attributes=\'{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#FF0000FF","background":"#FFFFFF"}}\'
height="50"
width="50"></animated-icons>';

// Si el usuario hace clic en “Cobrar”, guardamos en sesión los productos y total
if (isset($_POST['cobrar'])) {
    $productos = [];
    $total = 0;

    foreach ($_POST['productos'] as $producto) {
        $productos[] = [
            'nombre'   => $producto['nombre'],
            'precio'   => $producto['precio'],
            'cantidad' => $producto['cantidad'],
            'id'       => $producto['id']
        ];
        $total += ($producto['precio'] * $producto['cantidad']);
    }

    $_SESSION['productos'] = $productos;
    $_SESSION['total']     = $total;

    // Redirigir a prueba.php (o a la página de pago)
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
    <link rel="stylesheet" href="../css/alertas.css">
    <link rel="stylesheet" href="../componentes/header.php">
    <link rel="stylesheet" href="../componentes/header.css">
    <script src="../js/header.js"></script>
    <script src="../js/index.js"></script>
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <style>
        :root {
            --icon-bg: #FFFFFF;
        }
        body.modo-alto-contraste {
            --icon-bg: #000000;
        }
        body.modo-claro {
            --icon-bg: #FFFFFF;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div id="menu"></div>
    </div>

    <div class="main">
        <h1 class="titulo">Ventas</h1>
        <div class="search-bar">
            <form method="GET" action="ventas.php">
                <button class="search-icon" type="submit" aria-label="Buscar" title="Buscar">
                    <i class="bx bx-search-alt-2 icon"></i>
                </button>
                <input class="form-control" type="text" name="busqueda" placeholder="Buscar por nombre o código">
            </form>
        </div>

        <div class="barraModulos" style="position: relative; max-width: 1360px; border-radius: 5px; height: 63px; display: flex; align-items: center; border-color:aqua 2px solid;">
            <!-- Botón izquierda -->
            <button id="btnLeft" onclick="scrollCategorias(-200)">
                <img src="../imagenes/material-symbols--keyboard-backspace-rounded.svg" alt="Botón izquierda" id="icono-flecha-izquierda">
            </button>

            <!-- Categorías con scroll horizontal -->
            <ul id="categoriaScroll" class="breadcrumb" style="max-width: 1250px; overflow-x: auto; white-space: nowrap; scroll-behavior: smooth; display: flex;">
                <?php
                $stmt = $conexion->prepare("SELECT * FROM categoria");
                $stmt->execute();
                $resultado = $stmt->get_result();

                if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<li><a class='brand' name='categoria' href='ventas.php?categoria=" . htmlspecialchars($fila['codigo']) . "'>" . htmlspecialchars($fila['nombre']) . "</a></li>";
                    }
                } else {
                    echo "<li>No hay categorías disponibles</li>";
                }
                $stmt->close();
                ?>
            </ul>

            <!-- Botón derecha -->
            <button id="btnRight" onclick="scrollCategorias(200)">
                <img src="../imagenes/material-symbols--east-rounded.svg" alt="Botón derecha" id="icono-flecha-derecha">
            </button>
        </div>

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
                $consulta  = "SELECT * FROM producto";
                $resultado = mysqli_query($conexion, $consulta);
            }

            if ($resultado->num_rows > 0) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
    $disabledClass = $fila['cantidad'] <= 0 ? 'disabled' : '';
    echo "<div class='card $disabledClass' 
                data-id='{$fila['codigo1']}' 
                data-nombre='" . htmlspecialchars($fila['nombre']) . "' 
                data-cantidad='{$fila['cantidad']}'
                data-precio2='{$fila['precio2']}' 
                data-precio3='{$fila['precio3']}'>
            <span class='contador-producto'>0</span>
            <div class='card-header'>
                <p class='product-id'>" . htmlspecialchars($fila['nombre']) . "</p>
            </div>

            <!-- Select para escoger precio -->
            <label for='select-precio-{$fila['codigo1']}' class='sr-only'>Seleccionar precio</label>
            <select id='select-precio-{$fila['codigo1']}' class='price-selector'>
                <option value='{$fila['precio2']}'>
                    Precio Taller – $" . number_format($fila['precio2']) . "
                </option>
                <option value='{$fila['precio3']}'>
                    Precio Público – $" . number_format($fila['precio3']) . "
                </option>
            </select>

            <p class='product-cantidad'>Cantidad: {$fila['cantidad']}</p>

            <div class='iconos-container'>
                <div class='icono-accion btn-add' onclick='agregarAlResumen(this.parentNode.parentNode)'>
                    <img class='plus' src='../imagenes/material-symbols--add-2.svg' alt='Agregar al resumen'>
                </div>
                <div class='icono-accion btn-remove' onclick='quitarDelResumen(this.parentNode.parentNode)'>
                    <img class='minus' src='../imagenes/material-symbols--check-indeterminate-small-rounded.svg' alt='Quitar del resumen'>
                </div>
            </div>
        </div>";
}

            } else {
                echo "<script>
                    Swal.fire({
                        title: '<span class=\"titulo-alerta error\">Error</span>',
                        html: `
                            <div class=\"custom-alert\">
                                <div class=\"contenedor-imagen\">
                                    <img src=\"../imagenes/llave.png\" alt=\"Error\" class=\"llave\">
                                </div>
                                <p>No se encontraron resultados.</p>
                            </div>
                        `,
                        background: '#ffffffdb',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#dc3545',
                        customClass: {
                            popup: 'swal2-border-radius',
                            confirmButton: 'btn-aceptar',
                            container: 'fondo-oscuro'
                        }
                    }).then(() => {
                        window.location.href = 'ventas.php';
                    });
                </script>";
            }

            mysqli_close($conexion);
            ?>
        </div>
    </div>

    <div class="sidebar-right">
        <h3>Resumen</h3>

        <!-- Contenedor con scroll -->
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
        const scrollContainer = document.getElementById('categoriaScroll');
        const btnLeft = document.getElementById('btnLeft');
        const btnRight = document.getElementById('btnRight');

        function scrollCategorias(amount) {
            scrollContainer.scrollLeft += amount;
            updateButtonVisibility();
        }

        function updateButtonVisibility() {
            const maxScrollLeft = scrollContainer.scrollWidth - scrollContainer.clientWidth;
            btnLeft.style.display = scrollContainer.scrollLeft > 0 ? 'block' : 'none';
            btnRight.style.display = scrollContainer.scrollLeft < maxScrollLeft ? 'block' : 'none';
        }

        window.addEventListener('resize', updateButtonVisibility);
        scrollContainer.addEventListener('scroll', updateButtonVisibility);
        window.addEventListener('load', updateButtonVisibility);

        // Función cobrar abre modal de metodo de pago
        function cobrar() {
            const items = document.querySelectorAll("#listaResumen li");
            if (items.length === 0) {
                Swal.fire({
                    title: `<span class="titulo-alerta error">Error</span>`,
                    html: `
                        <div class="custom-alert">
                            <div class="contenedor-imagen">
                                <img src="../imagenes/llave.png" class="llave">
                            </div>
                            <p>No hay productos en la orden de venta.</p>
                        </div>
                    `,
                    background: '#ffffffdb',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#dc3545',
                    customClass: {
                        popup: 'swal2-border-radius',
                        confirmButton: 'btn-aceptar',
                        container: 'fondo-oscuro'
                    }
                });
                return;
            }

            let productos = [];
            items.forEach(item => {
                let id       = item.getAttribute("data-id")?.trim();
                let nombre   = item.getAttribute("data-nombre");
                let precio   = parseFloat(item.getAttribute("data-precio"));
                let cantidad = parseInt(item.getAttribute("data-cantidad"));
                productos.push({ id, nombre, precio, cantidad });
            });

            // Crear formulario dinámico
            let form = document.createElement("form");
            form.method = "POST";
            form.action = "ventas.php";

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
            form.submit();
        }

        function abrirModal() {
            const modal = document.getElementById("modalPaymentMethod");
            const btnAbrirModal = document.getElementById("btnAbrirModal");
            modal.style.display = "flex";
            btnAbrirModal.style.display = "none";
        }

        function cerrarModal() {
            const modal = document.getElementById("modalPaymentMethod");
            const btnAbrirModal = document.getElementById("btnAbrirModal");
            modal.style.display = "none";
            btnAbrirModal.style.display = "block";
        }

        function openModal() {
            const modal = document.getElementById("modalConfirm");
            const btnAbrirModal = document.getElementById("btnAbrirModal");
            modal.style.display = "flex";
            btnAbrirModal.style.display = "none";
        }

        function closeModal() {
            const modal = document.getElementById("modalConfirm");
            const btnAbrirModal = document.getElementById("btnAbrirModal");
            modal.style.display = "none";
            btnAbrirModal.style.display = "block";
        }

        document.getElementById("cancelButton")?.addEventListener("click", function(event) {
            event.preventDefault();
            closeModal();
        });

        function agregarAlResumen(elemento) {
    if (elemento.classList.contains("disabled")) {
        Swal.fire({
            title: '<span class="titulo-alerta advertencia">Advertencia</span>',
            html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                    </div>
                    <p>Este producto está agotado.</p>
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

    let id = elemento.getAttribute("data-id");
    let nombre = elemento.getAttribute("data-nombre");

    // ------ AQUÍ cambiamos para leer el precio desde el <select> ------
    let selectPrecio = elemento.querySelector(".price-selector");
    let precio = parseFloat(selectPrecio.value);
    // -----------------------------------------------------------------

    let contadorElemento = elemento.querySelector(".contador-producto");
    let cantidElement = elemento.querySelector('.product-cantidad');
    let cantidActual = parseInt(elemento.getAttribute('data-cantidad'));

    if (cantidActual <= 0) {
        Swal.fire({
            title: '<span class="titulo-alerta advertencia">Advertencia</span>',
            html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                    </div>
                    <p>No hay más stock disponible.</p>
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
            btnQuitar.style.pointerEvents = "auto";
            btnQuitar.style.opacity = "1";
            btnQuitar.style.position = "relative";
        }
    }

    // Actualizar lista de resumen
    let listaResumen = document.getElementById("listaResumen");
    let items = listaResumen.getElementsByTagName("li");
    let encontrado = false;

    for (let i = 0; i < items.length; i++) {
        // Comparamos nombre y precio para distinguir variantes
        if (items[i].getAttribute("data-nombre") === nombre && 
            parseFloat(items[i].getAttribute("data-precio")) === precio
        ) {
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
                        btnQuitar.style.pointerEvents = "auto";
                        btnQuitar.style.opacity = "1";
                    }
                }

                if (contador > 0) {
                    contador--;
                    contadorElemento.textContent = contador;
                    if (contador === 0) contadorElemento.style.display = "none";
                }
            }

            // Ajustar íconos por modo (alto contraste / claro)
            function actualizarIconosPorModo() {
                const modoOscuro = document.body.classList.contains('modo-alto-contraste');
                document.querySelectorAll('animated-icons').forEach(icono => {
                    const nuevoIcono = icono.cloneNode(true);
                    const attrs = JSON.parse(nuevoIcono.getAttribute('attributes'));
                    if (modoOscuro) {
                        attrs.defaultColours = {
                            "group-1": "#FFFFFF",
                            "group-2": icono.src.includes('plus') ? "#158E05FF" : "#FF0000FF",
                            "background": "#000000"
                        };
                    } else {
                        attrs.defaultColours = {
                            "group-1": "#000000",
                            "group-2": icono.src.includes('plus') ? "#158E05FF" : "#FF0000FF",
                            "background": "#FFFFFF"
                        };
                    }
                    nuevoIcono.setAttribute('attributes', JSON.stringify(attrs));
                    icono.parentNode.replaceChild(nuevoIcono, icono);
                });
            }

            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        actualizarIconosPorModo();
                    }
                });
            });

            observer.observe(document.body, { attributes: true });

            document.addEventListener('DOMContentLoaded', function() {
                actualizarIconosPorModo();
            });
        }
    </script>

    <div class="userInfo">
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

    <!-- ======= BLOQUE PARA “RESTAURAR” DESDE $_SESSION AL CARGAR ======= -->
    <?php if (!empty($_SESSION['productos'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Leemos el arreglo de PHP a JS
            let productosEnSesion = <?php echo json_encode($_SESSION['productos'], JSON_UNESCAPED_UNICODE); ?>;
            let totalEnSesion    = <?php echo (int) $_SESSION['total']; ?>;
            // Asignamos el total global
            total = totalEnSesion;
            document.getElementById('total-price').innerText = `$${totalEnSesion.toLocaleString()}`;

            // Recorremos cada producto y lo insertamos en la lista
            let listaResumen = document.getElementById('listaResumen');
            productosEnSesion.forEach(item => {
                // 1) Crear <li> en el resumen
                let li = document.createElement('li');
                li.setAttribute('data-id', item.id);
                li.setAttribute('data-nombre', item.nombre);
                li.setAttribute('data-precio', item.precio);
                li.setAttribute('data-cantidad', item.cantidad);
                li.innerHTML = `${item.nombre} x${item.cantidad} - $${(item.precio * item.cantidad).toLocaleString()}`;
                listaResumen.appendChild(li);

                // 2) Ajustar contador y stock en la “card” correspondiente
                let selectorCard = `.products .card[data-id='${item.id}']`;
                let card = document.querySelector(selectorCard);
                if (card) {
                    // a) Mostrar la cantidad en el contador
                    let contadorElemento = card.querySelector('.contador-producto');
                    contadorElemento.textContent = item.cantidad;
                    contadorElemento.style.display = "block";

                    // b) Reducir stock en data-cantidad y actualizar el texto
                    let cantidElement = card.querySelector('.product-cantidad');
                    let stockActual = parseInt(card.getAttribute('data-cantidad')) - item.cantidad;
                    card.setAttribute('data-cantidad', stockActual);
                    cantidElement.textContent = `Cantidad: ${stockActual}`;

                    // c) Si el stock quedó en 0, deshabilitamos la tarjeta
                    if (stockActual <= 0) {
                        card.classList.add('disabled');
                        card.style.pointerEvents = "none";

                        let btnQuitar = card.querySelector(".btn-remove");
                        if (btnQuitar) {
                            btnQuitar.style.pointerEvents = "auto";
                            btnQuitar.style.opacity = "1";
                            btnQuitar.style.position = "relative";
                        }
                    }
                }
            });
        });
    </script>
    <?php endif; ?>

</body>
</html>
