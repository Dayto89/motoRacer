<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

$ref = $_SERVER['HTTP_REFERER'] ?? '';
if (
    !isset($_POST['cobrar']) &&
    strpos($ref, 'pagos.php') === false &&
    strpos($ref, 'ventas.php') === false
) {
    // Llegaste desde fuera del flujo Ventas↔Pago → limpia el carrito
    unset($_SESSION['productos'], $_SESSION['total']);
}

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

$result = mysqli_query($conexion, "SELECT p.codigo1, p.nombre, p.cantidad, p.precio2, p.precio3, p.Categoria_codigo
                                     FROM producto p");
$allProducts = mysqli_fetch_all($result, MYSQLI_ASSOC);


// Procesar "Cobrar": guardar carrito en sesión y redirigir sin emitir salida
if (isset($_POST['cobrar'])) {
    $productos = [];
    $total = 0;
    if (!empty($_POST['productos']) && is_array($_POST['productos'])) {
        foreach ($_POST['productos'] as $producto) {
            $id       = $producto['id'];
            $nombre   = $producto['nombre'];
            $precio   = (float) $producto['precio'];
            $cantidad = (int)   $producto['cantidad'];
            $tipo     = $producto['tipo'];
            $productos[] = [
                'id'       => $id,
                'nombre'   => $nombre,
                'precio'   => $precio,
                'cantidad' => $cantidad,
                'tipo'     => $tipo
            ];
            $total += $precio * $cantidad;
        }
    }
    $_SESSION['productos'] = $productos;
    $_SESSION['total']     = $total;
    header("Location: pagos.php");
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
    <link rel="stylesheet" href="../componentes/header.css">
    <script src="../componentes/header.php"></script>
    <script src="../js/header.js"></script>
    <script src="../js/index.js"></script>
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <style>

        .card-header p.product-id {
            white-space: normal;
            /* Permite que el texto se divida en varias líneas */
            overflow-wrap: break-word;
            /* Rompe palabras largas si es necesario */
            max-width: 100%;
            /* Limita el ancho al contenedor padre */
            margin: 0;
            /* Elimina márgenes adicionales para mejor control */
            font-size: 14px;
            /* Ajusta el tamaño de fuente si es necesario */
        }
    </style>
</head>

<body>
    <?php include 'boton-ayuda.php'; ?>
    <script>
        // Esto estará disponible para filtrar en cliente:
        const allProducts = <?php echo json_encode($allProducts, JSON_HEX_TAG); ?>;
    </script>
    <div id="menu"></div>
    <nav class="barra-navegacion">
        <div class="ubica"> Factura / Ventas </div>
        <div class="userContainer">
            <div class="userInfo">
                <?php
                // Es buena práctica no reabrir conexiones. Usaremos la que ya está abierta.
                // Sin embargo, para no alterar tu código, lo dejamos como está.
                $conexion_user = new mysqli('localhost', 'root', '', 'inventariomotoracer');
                $id_usuario = $_SESSION['usuario_id'];
                $sqlUsuario = "SELECT nombre, apellido, rol, foto FROM usuario WHERE identificacion = ?";
                $stmtUsuario = $conexion_user->prepare($sqlUsuario);
                $stmtUsuario->bind_param("i", $id_usuario);
                $stmtUsuario->execute();
                $resultUsuario = $stmtUsuario->get_result();
                $rowUsuario = $resultUsuario->fetch_assoc();
                $nombreUsuario = $rowUsuario['nombre'];
                $apellidoUsuario = $rowUsuario['apellido'];
                $rol = $rowUsuario['rol'];
                $foto = $rowUsuario['foto'];
                $stmtUsuario->close();
                $conexion_user->close();
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
    </nav>
    <div class="main">
        <div class="container-general">
        </div>
        <h1 class="titulo">Ventas</h1>
        <div class="search-bar">
            <i class="bx bx-search-alt-2 icon"></i>
            <input class="form-control" type="text" name="busqueda" placeholder="Buscar por nombre o código">
        </div>
        <div class="container-general">
        </div>
        <div class="barraModulos" style="position: relative;
    max-width: 100%;
    border-radius: 10px;
    height: 7%;
    display: flex;
    align-items: center;
    margin-left: 3%;
    width: 94.5%;
    border: 1px solid black;
    justify-content: space-evenly;
 ">
            <button id="btnLeft" onclick="scrollCategorias(-200)">
                <img src="../imagenes/material-symbols--keyboard-backspace-rounded.svg" alt="Botón izquierda" id="icono-flecha-izquierda">
            </button>
            <ul id="categoriaScroll" class="breadcrumb" style="max-width: 1250px; overflow-x: auto; white-space: nowrap; scroll-behavior: smooth; display: flex;">
                <li>
                    <a href="#" id="btnTodas" class="brand">Todos</a>
                </li>
                <?php
                $stmt = $conexion->prepare(
                    "SELECT c.codigo, c.nombre
                     FROM categoria c
                     JOIN producto p ON p.Categoria_codigo = c.codigo
                     GROUP BY c.codigo, c.nombre
                     HAVING COUNT(p.codigo1) > 0"
                );
                $stmt->execute();
                $resultado = $stmt->get_result();

                if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<li>
                                <a data-categoria='" . htmlspecialchars($fila['codigo']) . "' class='brand'
                                   name='categoria' 
                                   href='ventas.php?categoria=" . htmlspecialchars($fila['codigo']) . "'>
                                  " . htmlspecialchars($fila['nombre']) . "
                                </a>
                              </li>";
                    }
                } else {
                    echo "<li>No hay categorías con productos disponibles</li>";
                }
                $stmt->close();
                ?>
            </ul>
            <button id="btnRight" onclick="scrollCategorias(200)">
                <img src="../imagenes/material-symbols--east-rounded.svg" alt="Botón derecha" id="icono-flecha-derecha">
            </button>
        </div>

        <div class="products" id="productsContainer">
        </div>

    </div>

    <div class="sidebar-right">
        <div class="side-container">
            <h3>Resumen</h3>
            <div class="resumen-scroll">
                <ul id="listaResumen" class="listaResumen"></ul>
            </div>
            <div class="total"><span>Total:</span> <span id="total-price">$0.00</span></div>
            <div class="resumen-botones">
                <button class="btn-cobrar" id="btnCobrar" onclick="cobrar()">Cobrar</button>
            </div>
        </div>
    </div>
                  <!-- Footer con derehcos de autor -->
<footer class="footer" id="footer">
  <div class="footer-item datos">© 2025 MotoRacer</div>
  <div class="footer-item">
    Desarrollado por:
    <strong>Mariana Castillo</strong> ·
    <strong>Daniel López</strong> ·
    <strong>Deicy Caro</strong> ·
    <strong>Marlen Salcedo</strong>
    <span class="version">v1.0</span>
  </div>
</footer>
    <script>
        let precioTipo = null;
        const ref = document.referrer;
        const fromVentasOrPago = ref.includes('ventas.php') || ref.includes('pagos.php');
        if (!fromVentasOrPago) {
            sessionStorage.clear();
        }

        const serverCart = <?php echo json_encode($_SESSION['productos']  ?? []); ?>;
        const serverTotal = <?php echo json_encode($_SESSION['total']      ?? 0);  ?>;
        if (serverCart.length) {
            sessionStorage.setItem('carritoProductos', JSON.stringify(serverCart));
            sessionStorage.setItem('carritoTotal', serverTotal);
        }

        let total = serverTotal ?? 0;

        const scrollContainer = document.getElementById('categoriaScroll');
        const btnLeft = document.getElementById('btnLeft');
        const btnRight = document.getElementById('btnRight');
        let currentCategory = null;
        let currentSearch = '';
        const productsContainer = document.getElementById('productsContainer');
        const listaResumen = document.getElementById('listaResumen');

        // --- INICIO DE LAS FUNCIONES MODIFICADAS Y NUEVAS ---

        // NUEVA FUNCIÓN para solicitar cantidad manual
        function solicitarCantidadManual(cardElement) {
            const id = cardElement.dataset.id;
            const nombre = cardElement.dataset.nombre;
            const stockActual = parseInt(cardElement.dataset.cantidad);

            const ctr = cardElement.querySelector('.contador-producto');
            const cantidadEnCarrito = parseInt(ctr.textContent) || 0;
            const stockDisponible = stockActual + cantidadEnCarrito;

            Swal.fire({
                title: `<span class="titulo-alerta text">Añadir: ${nombre}</span>`,
                html: `
        <div class="custom-alert">
            <label for="cantidad-input">Cantidad (disponible: ${stockDisponible})</label>
            <input id="cantidad-input" type="number" min="1" max="${stockDisponible}" value="1" class="swal2-input">
        </div>`,
                background: 'hsl(0deg 0% 100% / 0.76)',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    cancelButton: 'btn-cancelar',
                    container: 'fondo-oscuro'
                },
                preConfirm: () => {
                    const value = parseInt(document.getElementById('cantidad-input').value);
                    if (!value || value <= 0) {
                        Swal.showValidationMessage('Por favor, ingrese un número válido mayor a cero.');
                        return false;
                    }
                    if (value > stockDisponible) {
                        Swal.showValidationMessage(`No puede exceder el stock disponible de ${stockDisponible} unidades.`);
                        return false;
                    }
                    return value;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const cantidadDeseada = parseInt(result.value);
                    const diferencia = cantidadDeseada - cantidadEnCarrito;

                    if (diferencia > 0) { // Añadir más items
                        for (let i = 0; i < diferencia; i++) {
                            agregarAlResumen(cardElement);
                        }
                    } else if (diferencia < 0) { // Quitar items
                        for (let i = 0; i < Math.abs(diferencia); i++) {
                            quitarDelResumen(cardElement);
                        }
                    }
                }
            });
        }

        function renderProduct(p) {
            const div = document.createElement('div');
            div.className = 'card' + (p.cantidad <= 0 ? ' disabled' : '');
            div.dataset.id = p.codigo1;
            div.dataset.nombre = p.nombre;
            div.dataset.cantidad = p.cantidad; // Este es el stock que va cambiando
            div.dataset.stockOriginal = p.cantidad; // Guardamos el stock original
            div.dataset.precio2 = p.precio2;
            div.dataset.precio3 = p.precio3;
            div.innerHTML = `
                <span class="contador-producto" title="Editar cantidad">0</span>
                <div class="card-header">
                    <p class="product-id">${p.nombre}</p>
                </div>
                <select class="price-selector">
                    <option value="${p.precio2}">Precio Taller – $${Number(p.precio2).toLocaleString()}</option>
                    <option value="${p.precio3}">Precio Público – $${Number(p.precio3).toLocaleString()}</option>
                </select>
                <p class="product-cantidad">Cantidad: ${p.cantidad}</p>
                <div class="iconos-container">
                    <div class="icono-accion btn-add"><img class="plus" src="../imagenes/material-symbols--add-2.svg" alt="Agregar"></div>
                    <div class="icono-accion btn-remove"><img class="minus" src="../imagenes/material-symbols--check-indeterminate-small-rounded.svg" alt="Quitar"></div>
                </div>`;

            // Enganchar listeners
            div.querySelector('.btn-add').addEventListener('click', () => agregarAlResumen(div));
            div.querySelector('.btn-remove').addEventListener('click', () => quitarDelResumen(div));
            // NUEVO: Listener para el contador
            div.querySelector('.contador-producto').addEventListener('click', () => solicitarCantidadManual(div));

            return div;
        }

        // FUNCIÓN MODIFICADA: Ahora actualiza la lista del resumen con botones
        function agregarAlResumen(el) {
            if (el.classList.contains('disabled')) return;
            const id = el.dataset.id;
            const nombre = el.dataset.nombre;
            const precio = parseFloat(el.querySelector('.price-selector').value);
            const tipoActual = el.querySelector('.price-selector').selectedIndex === 0 ? 'taller' : 'publico';

            if (precioTipo && tipoActual !== precioTipo) {
                Swal.fire('Error', 'No puedes mezclar Precio Taller y Precio Público en la misma venta.', 'error');
                return;
            } else if (!precioTipo) {
                precioTipo = tipoActual;
            }

            let stock = parseInt(el.dataset.cantidad);
            if (stock <= 0) return;
            stock--;
            el.dataset.cantidad = stock;
            el.querySelector('.product-cantidad').textContent = `Cantidad: ${stock}`;
            if (stock <= 0) {
                el.classList.add('disabled');
            }

            const ctr = el.querySelector('.contador-producto');
            let count = parseInt(ctr.textContent) || 0;
            ctr.textContent = ++count;
            ctr.style.display = 'block';

            let found = false;
            listaResumen.querySelectorAll('li').forEach(li => {
                if (li.dataset.id === id) {
                    let c = parseInt(li.dataset.cantidad) + 1;
                    li.dataset.cantidad = c;
                    li.querySelector('.item-quantity').textContent = c;
                    li.querySelector('.summary-item-info').innerHTML = `${nombre} <br> <small>$${(precio * c).toLocaleString()}</small>`;
                    found = true;
                }
            });

            if (!found) {
                const li = document.createElement('li');
                li.dataset.id = id;
                li.dataset.nombre = nombre;
                li.dataset.precio = precio;
                li.dataset.tipo = tipoActual;
                li.dataset.cantidad = 1;
                li.innerHTML = `
                    <div class="summary-item-info">${nombre} <br> <small>$${precio.toLocaleString()}</small></div>
                    <div class="summary-item-controls">
                        <button class="summary-btn-remove" data-id="${id}">-</button>
                        <span class="item-quantity">1</span>
                        <button class="summary-btn-add" data-id="${id}">+</button>
                        <button class="delete-item" data-id="${id}" title="Eliminar item">
                            <box-icon name='trash' color='#c53929' size='xs'></box-icon>
                        </button>
                    </div>`;
                listaResumen.appendChild(li);
            }
            total += precio;
            document.getElementById('total-price').innerText = `$${total.toLocaleString()}`;
            guardarEnSessionStorage();
        }

        // FUNCIÓN MODIFICADA: Ahora actualiza la lista del resumen con botones
        function quitarDelResumen(el) {
            const id = el.dataset.id;
            let itemEnResumen = listaResumen.querySelector(`li[data-id='${id}']`);
            if (!itemEnResumen) return;

            const precio = parseFloat(itemEnResumen.dataset.precio);
            const nombre = itemEnResumen.dataset.nombre;

            let c = parseInt(itemEnResumen.dataset.cantidad) - 1;
            if (c > 0) {
                itemEnResumen.dataset.cantidad = c;
                itemEnResumen.querySelector('.item-quantity').textContent = c;
                itemEnResumen.querySelector('.summary-item-info').innerHTML = `${nombre} <br> <small>$${(precio * c).toLocaleString()}</small>`;
            } else {
                itemEnResumen.remove();
            }

            total -= precio;
            document.getElementById('total-price').innerText = `$${total.toLocaleString()}`;

            let stock = parseInt(el.dataset.cantidad) || 0;
            stock++;
            el.dataset.cantidad = stock;
            el.querySelector('.product-cantidad').textContent = `Cantidad: ${stock}`;
            if (stock > 0) {
                el.classList.remove('disabled');
            }

            const ctr = el.querySelector('.contador-producto');
            let count = parseInt(ctr.textContent) || 0;
            count = Math.max(count - 1, 0);
            ctr.textContent = count;
            if (count <= 0) {
                ctr.style.display = 'none';
            }

            if (listaResumen.children.length === 0) {
                precioTipo = null;
            }
            guardarEnSessionStorage();
        }

        // --- FIN DE FUNCIONES MODIFICADAS ---

        // Listener para los nuevos botones en el resumen
        listaResumen.addEventListener('click', function(e) {
            const target = e.target.closest('button');
            if (!target) return;

            const productId = target.dataset.id;
            const cardElement = document.querySelector(`.card[data-id='${productId}']`);
            if (!cardElement) return;

            if (target.classList.contains('summary-btn-add')) {
                agregarAlResumen(cardElement);
            } else if (target.classList.contains('summary-btn-remove')) {
                quitarDelResumen(cardElement);
            } else if (target.classList.contains('delete-item')) {
                const itemEnResumen = listaResumen.querySelector(`li[data-id='${productId}']`);
                const cantidadARemover = parseInt(itemEnResumen.dataset.cantidad);
                for (let i = 0; i < cantidadARemover; i++) {
                    quitarDelResumen(cardElement);
                }
            }
        });

        // El resto de tu JavaScript original permanece igual
        function renderProducts() {
            productsContainer.innerHTML = "";
            const filtered = allProducts.filter(p => {
                if (currentCategory && p.Categoria_codigo !== currentCategory) return !1;
                if (currentSearch) {
                    const q = currentSearch.toLowerCase();
                    return p.nombre.toLowerCase().includes(q) || p.codigo1.toLowerCase().includes(q)
                }
                return !0
            });
            if (filtered.length === 0) {
                productsContainer.innerHTML = `<p>No hay productos para mostrar.</p>`
            } else {
                filtered.forEach(p => productsContainer.appendChild(renderProduct(p)))
            }
            actualizarContadoresDesdeSession()
        }
        document.querySelector('.search-bar input[name="busqueda"]').addEventListener('input', e => {
            currentSearch = e.target.value.trim();
            renderProducts()
        });
        document.querySelectorAll('#categoriaScroll a.brand').forEach(a => {
            a.addEventListener('click', e => {
                e.preventDefault();
                document.querySelectorAll('#categoriaScroll a.brand').forEach(x => x.classList.remove('active'));
                a.classList.add('active');
                if (a.id === "btnTodas") {
                    currentCategory = null
                } else {
                    currentCategory = a.getAttribute('data-categoria')
                }
                renderProducts()
            })
        });

        function scrollCategorias(amount) {
            scrollContainer.scrollLeft += amount;
            updateButtonVisibility()
        }

        function updateButtonVisibility() {
            const max = scrollContainer.scrollWidth - scrollContainer.clientWidth;
            btnLeft.style.display = scrollContainer.scrollLeft > 0 ? 'block' : 'none';
            btnRight.style.display = scrollContainer.scrollLeft < max ? 'block' : 'none'
        }
        window.addEventListener('resize', updateButtonVisibility);
        scrollContainer.addEventListener('scroll', updateButtonVisibility);
        window.addEventListener('load', updateButtonVisibility);

        function cobrar() {
            const items = Array.from(listaResumen.querySelectorAll("li"));
            if (!items.length) {
                Swal.fire({
                    title: '<span class="titulo-alerta error">Error</span>',
                    html: `<div class="custom-alert"><div class="contenedor-imagen"><img src="../imagenes/llave.png" alt="Error" class="llave"></div><p>No hay productos en la orden.</p></div>`,
                    background: '#ffffffdb',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#007bff',
                    customClass: {
                        popup: 'swal2-border-radius',
                        confirmButton: 'btn-aceptar',
                        container: 'fondo-oscuro'
                    }
                });
                return
            }
            let productos = [];
            items.forEach(li => {
                productos.push({
                    id: li.dataset.id,
                    nombre: li.dataset.nombre,
                    precio: parseFloat(li.dataset.precio),
                    cantidad: parseInt(li.dataset.cantidad),
                    tipo: li.dataset.tipo
                })
            });
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = 'ventas.php';
            form.innerHTML = `<input type="hidden" name="cobrar" value="1">`;
            productos.forEach((p, i) => {
                form.innerHTML += `<input type="hidden" name="productos[${i}][id]" value="${p.id}">`;
                form.innerHTML += `<input type="hidden" name="productos[${i}][nombre]" value="${p.nombre}">`;
                form.innerHTML += `<input type="hidden" name="productos[${i}][precio]" value="${p.precio}">`;
                form.innerHTML += `<input type="hidden" name="productos[${i}][cantidad]" value="${p.cantidad}">`;
                form.innerHTML += `<input type="hidden" name="productos[${i}][tipo]" value="${p.tipo}">`
            });
            document.body.appendChild(form);
            form.submit()
        }

        function guardarEnSessionStorage() {
            const items = Array.from(listaResumen.querySelectorAll("li")).map(li => ({
                id: li.dataset.id,
                nombre: li.dataset.nombre,
                precio: parseFloat(li.dataset.precio),
                cantidad: parseInt(li.dataset.cantidad),
                tipo: li.dataset.tipo
            }));
            sessionStorage.setItem('carritoProductos', JSON.stringify(items));
            sessionStorage.setItem('carritoTotal', total)
        }

        function actualizarContadoresDesdeSession() {
            const data = sessionStorage.getItem('carritoProductos');
            if (!data) return;
            const items = JSON.parse(data);
            items.forEach(item => {
                const card = document.querySelector(`.products .card[data-id='${item.id}']`);
                if (card) {
                    const ctr = card.querySelector('.contador-producto');
                    ctr.textContent = item.cantidad;
                    ctr.style.display = 'block';
                    let stockOriginal = parseInt(card.dataset.stockOriginal);
                    card.dataset.cantidad = stockOriginal - item.cantidad;
                    card.querySelector('.product-cantidad').textContent = `Cantidad: ${card.dataset.cantidad}`;
                    if (parseInt(card.dataset.cantidad) <= 0) {
                        card.classList.add('disabled')
                    }
                }
            })
        }
        document.addEventListener('DOMContentLoaded', () => {
            const data = sessionStorage.getItem('carritoProductos');
            const tot = sessionStorage.getItem('carritoTotal');
            if (data && tot != null) {
                const items = JSON.parse(data);
                total = parseFloat(tot) || 0;
                document.getElementById('total-price').innerText = `$${total.toLocaleString()}`;
                items.forEach(item => {
                    const li = document.createElement('li');
                    li.dataset.id = item.id;
                    li.dataset.nombre = item.nombre;
                    li.dataset.precio = item.precio;
                    li.dataset.cantidad = item.cantidad;
                    li.dataset.tipo = item.tipo;
                    li.innerHTML = `<div class="summary-item-info">${item.nombre} <br> <small>$${(item.precio*item.cantidad).toLocaleString()}</small></div><div class="summary-item-controls"><button class="summary-btn-remove" data-id="${item.id}">-</button><span class="item-quantity">${item.cantidad}</span><button class="summary-btn-add" data-id="${item.id}">+</button><button class="delete-item" data-id="${item.id}" title="Eliminar item"><box-icon name='trash' color='#c53929' size='xs'></box-icon></button></div>`;
                    listaResumen.appendChild(li)
                });
                if (listaResumen.children.length > 0) {
                    precioTipo = listaResumen.children[0].dataset.tipo
                }
            }
            renderProducts()
        });
        renderProducts();
    </script>
    
</body>

</html>