<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

$ref = $_SERVER['HTTP_REFERER'] ?? '';
if (
    !isset($_POST['cobrar']) &&
    strpos($ref, 'prueba.php') === false &&
    strpos($ref, 'ventas.php') === false
) {
    // Llegaste desde fuera del flujo Ventas↔Pago → limpia el carrito
    unset($_SESSION['productos'], $_SESSION['total']);
}

require_once $_SERVER['DOCUMENT_ROOT'] . '../html/verificar_permisos.php';

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
    <link rel="stylesheet" href="../componentes/header.css">
    <script src="../componentes/header.php"></script>
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

        ul {
            list-style-type: none;
            padding-left: 0;
            /* opcional: elimina el espacio donde estaban los puntos */
        }

        #categoriaScroll a.brand.active {
            background-color: #007bff;
            color: white;
            border-radius: 4px;
        }

        #categoriaScroll a.brand:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>

<body>
    <?php include 'boton-ayuda.php'; ?>
    <script>
        // Esto estará disponible para filtrar en cliente:
        const allProducts = <?php echo json_encode($allProducts, JSON_HEX_TAG); ?>;
    </script>
    <div class="sidebar">
        <div id="menu"></div>
    </div>

    <div class="main">
        <h1 class="titulo">Ventas</h1>
        <div class="search-bar">

            <i class="bx bx-search-alt-2 icon"></i>
            </button>
            <input class="form-control" type="text" name="busqueda" placeholder="Buscar por nombre o código">

        </div>

        <div class="barraModulos" style="position: relative; max-width: 1360px; border-radius: 5px; height: 63px; display: flex; align-items: center; border-color:aqua 2px solid;">
            <!-- Botón izquierda -->
            <button id="btnLeft" onclick="scrollCategorias(-200)">
                <img src="../imagenes/material-symbols--keyboard-backspace-rounded.svg" alt="Botón izquierda" id="icono-flecha-izquierda">
            </button>
            <!-- Categorías con scroll horizontal -->
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


            <!-- Botón derecha -->
            <button id="btnRight" onclick="scrollCategorias(200)">
                <img src="../imagenes/material-symbols--east-rounded.svg" alt="Botón derecha" id="icono-flecha-derecha">
            </button>
        </div>

        <div class="products" id="productsContainer">
            <!-- aquí metemos los cards via JS -->
        </div>

    </div>

    <div class="sidebar-right">
        <h3>Resumen</h3>
        <div class="resumen-scroll">
            <ul id="listaResumen" class="listaResumen"></ul>
        </div>
        <div class="total"><span>Total:</span> <span id="total-price">$0.00</span></div>
        <div class="resumen-botones"><button class="btn-cobrar" id="btnCobrar" onclick="cobrar()">Cobrar</button></div>
    </div>

    <script>
        let precioTipo = null;
        // 1) Si vienes de ventas.php o de prueba.php, NO borres; 
        //    en cualquier otro caso, sí.
        const ref = document.referrer;
        const fromVentasOrPago = ref.includes('ventas.php') || ref.includes('prueba.php');
        if (!fromVentasOrPago) {
            sessionStorage.clear();
        }

        // 2) JUSTO después de limpiar (o no), vuelca la sesión PHP:
        const serverCart = <?php echo json_encode($_SESSION['productos']  ?? []); ?>;
        const serverTotal = <?php echo json_encode($_SESSION['total']      ?? 0);  ?>;
        if (serverCart.length) {
            sessionStorage.setItem('carritoProductos', JSON.stringify(serverCart));
            sessionStorage.setItem('carritoTotal', serverTotal);
        }

        // 3) Inicializar la variable total con el valor de servidor (si lo hay)
        let total = serverTotal ?? 0;


        const scrollContainer = document.getElementById('categoriaScroll');
        const btnLeft = document.getElementById('btnLeft');
        const btnRight = document.getElementById('btnRight');
        // estado actual
        let currentCategory = null;
        let currentSearch = '';

        // referencia al contenedor
        const productsContainer = document.getElementById('productsContainer');

        // función que dibuja un card
        function renderProduct(p) {
            const div = document.createElement('div');
            div.className = 'card' + (p.cantidad <= 0 ? ' disabled' : '');
            div.dataset.id = p.codigo1;
            div.dataset.nombre = p.nombre;
            div.dataset.cantidad = p.cantidad;
            div.dataset.precio2 = p.precio2;
            div.dataset.precio3 = p.precio3;
            div.innerHTML = `
      <span class="contador-producto">0</span>
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
            // aquí vuelves a enganchar tus event listeners de agregar/quitar...
            // enganchar “Agregar”
            const btnAdd = div.querySelector('.btn-add');
            btnAdd.addEventListener('click', () => agregarAlResumen(div));

            // enganchar “Quitar”
            const btnRemove = div.querySelector('.btn-remove');
            btnRemove.addEventListener('click', () => quitarDelResumen(div));
            return div;
        }

        // función global de render
        function renderProducts() {
            productsContainer.innerHTML = '';
            // filtrar por categoría y texto
            const filtered = allProducts.filter(p => {
                if (currentCategory && p.Categoria_codigo !== currentCategory) return false;
                if (currentSearch) {
                    const q = currentSearch.toLowerCase();
                    return p.nombre.toLowerCase().includes(q) || p.codigo1.toLowerCase().includes(q);
                }
                return true;
            });
            if (filtered.length === 0) {
                productsContainer.innerHTML = `<p>No hay productos para mostrar.</p>`;
            } else {
                filtered.forEach(p => productsContainer.appendChild(renderProduct(p)));
            }
            // (volver a inicializar contador, stock, listeners, etc.)
        }

        // ========== manejo del input de búsqueda ==========
        document.querySelector('.search-bar input[name="busqueda"]')
            .addEventListener('input', e => {
                currentSearch = e.target.value.trim();
                renderProducts();
            });

        // ========== manejo de categorías ==========
        document.querySelectorAll('#categoriaScroll a.brand').forEach(a => {
            a.addEventListener('click', e => {
                e.preventDefault();
                // quitar active de todas
                document.querySelectorAll('#categoriaScroll a.brand').forEach(x => x.classList.remove('active'));
                // marcar la pulsada
                a.classList.add('active');
                currentCategory = a.getAttribute('data-categoria');
                renderProducts();
            });
        });

        function scrollCategorias(amount) {
            scrollContainer.scrollLeft += amount;
            updateButtonVisibility();
        }

        function updateButtonVisibility() {
            const max = scrollContainer.scrollWidth - scrollContainer.clientWidth;
            btnLeft.style.display = scrollContainer.scrollLeft > 0 ? 'block' : 'none';
            btnRight.style.display = scrollContainer.scrollLeft < max ? 'block' : 'none';
        }
        window.addEventListener('resize', updateButtonVisibility);
        scrollContainer.addEventListener('scroll', updateButtonVisibility);
        window.addEventListener('load', updateButtonVisibility);

        function cobrar() {
            const items = document.querySelectorAll("#listaResumen li");
            if (!items.length) {
                Swal.fire({
                    title: '<span class="titulo-alerta error">Error</span>',
                    html: `<p>No hay productos en la orden.</p>`
                });
                return;
            }
            let productos = [];
            items.forEach(li => {
                productos.push({
                    id: li.dataset.id,
                    nombre: li.dataset.nombre,
                    precio: parseFloat(li.dataset.precio),
                    cantidad: parseInt(li.dataset.cantidad),
                    tipo: li.dataset.tipo
                });
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
                    form.innerHTML += `<input type="hidden" name="productos[${i}][tipo]" value="${p.tipo}">`;
            });
            document.body.appendChild(form);
            form.submit();
        }

        function agregarAlResumen(el) {
            if (el.classList.contains('disabled')) return;
            const id = el.dataset.id;
            const nombre = el.dataset.nombre;
            const precio = parseFloat(el.querySelector('.price-selector').value);
            const select = el.querySelector('.price-selector');
            const tipoActual = select.selectedIndex === 0 ? 'taller' : 'publico';
            const precioSel = parseFloat(select.value);
            const listado = document.getElementById('listaResumen');

            console.log(
                '[DEBUG] intentar agregar:',
                'tipoActual=', tipoActual,
                'precioTipo=', precioTipo,
                'itemsEnResumen=', document.getElementById('listaResumen').children.length
            );

            // Si precioTipo no es ni 'taller' ni 'publico', lo inicializamos
            if (precioTipo !== 'taller' && precioTipo !== 'publico') {
                precioTipo = tipoActual;
                console.log('[DEBUG] precioTipo inicializado a', precioTipo);
            } else if (tipoActual !== precioTipo) {
                Swal.fire({
                    icon: 'error',
                    title: 'Tipos de precio mixtos',
                    text: 'No puedes mezclar Precio Taller y Precio Público en la misma venta.'
                });
                return;
            }

            // ③ Si ya hay productos, comprueba contra precioTipo
            const list = document.getElementById('listaResumen');
            if (list.children.length > 0) {
                if (tipoActual !== precioTipo) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tipos de precio mixtos',
                        text: 'No puedes mezclar Precio Taller y Precio Público en la misma venta.'
                    });
                    return;
                }
            } else {
                // ④ Si es el primer producto, inicializa precioTipo
                precioTipo = tipoActual;
            }
            // stock
            let stock = parseInt(el.dataset.cantidad);
            if (!stock) return;
            stock--;
            el.dataset.cantidad = stock;
            el.querySelector('.product-cantidad').textContent = `Cantidad: ${stock}`;
            if (!stock) {
                el.classList.add('disabled');
                el.style.pointerEvents = 'none';
                const btnRem = el.querySelector('.btn-remove');
                btnRem.style.pointerEvents = 'auto';
                btnRem.style.opacity = '1';
            }
            // contador
            const ctr = el.querySelector('.contador-producto');
            let count = parseInt(ctr.textContent) || 0;
            ctr.textContent = ++count;
            ctr.style.display = 'block';
            // resumen
            const lista = document.getElementById('listaResumen');
            let found = false;
            lista.querySelectorAll('li').forEach(li => {
                if (li.dataset.id === id && parseFloat(li.dataset.precio) === precio) {
                    let c = parseInt(li.dataset.cantidad) + 1;
                    li.dataset.cantidad = c;
                    li.dataset.tipo = tipoActual;
                    li.innerHTML = `${nombre} x${c} - $${(precio*c).toLocaleString()}`;
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
                li.innerHTML = `${nombre} x1 - $${precio.toLocaleString()}`;
                lista.appendChild(li);
            }
            total += precio;
            document.getElementById('total-price').innerText = `$${total.toLocaleString()}`;
            guardarEnSessionStorage();
        }

        function quitarDelResumen(el) {
            const id = el.dataset.id;
            const nombre = el.dataset.nombre;
            const select = el.querySelector('.price-selector');
            const tipoActual = select.selectedIndex === 0 ? 'taller' : 'publico';
            const precio = parseFloat(select.value);
            const lista = document.getElementById('listaResumen');
            lista.querySelectorAll('li').forEach(li => {
                if (li.dataset.id === el.dataset.id && parseFloat(li.dataset.precio) === precio) {
                    let c = parseInt(li.dataset.cantidad) - 1;
                    if (c > 0) {
                        li.dataset.cantidad = c;
                        li.innerHTML = `${nombre} x${c} - $${(precio*c).toLocaleString()}`;
                    } else li.remove();

                    total -= precio;
                    document.getElementById('total-price').innerText = `$${total.toLocaleString()}`;

                    // restock tarjeta
                    let stock = parseInt(el.dataset.cantidad) || 0;
                    stock++;
                    el.dataset.cantidad = stock;
                    el.querySelector('.product-cantidad').textContent = `Cantidad: ${stock}`;
                    if (stock > 0) {
                        el.classList.remove('disabled');
                        el.style.pointerEvents = 'auto';
                    }

                    // 👇 ACTUALIZAR CONTADOR VERDE
                    const ctr = el.querySelector('.contador-producto');
                    let count = parseInt(ctr.textContent) || 0;
                    count = Math.max(count - 1, 0);
                    ctr.textContent = count;
                    ctr.style.display = count > 0 ? 'block' : 'none';
                }
            });
            document.getElementById('total-price').innerText = `$${total.toLocaleString()}`;

            // Si ya no quedan productos, reinicia precioTipo
            if (lista.children.length === 0) {
                precioTipo = null;
            }

            guardarEnSessionStorage();
        }


        function guardarEnSessionStorage() {
            const items = Array.from(document.querySelectorAll('#listaResumen li')).map(li => ({
                id: li.dataset.id,
                nombre: li.dataset.nombre,
                precio: parseFloat(li.dataset.precio),
                cantidad: parseInt(li.dataset.cantidad),
                tipo: li.dataset.tipo
            }));
            sessionStorage.setItem('carritoProductos', JSON.stringify(items));
            sessionStorage.setItem('carritoTotal', total);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const data = sessionStorage.getItem('carritoProductos');
            const tot = sessionStorage.getItem('carritoTotal');
            if (data && tot != null) {
                const items = JSON.parse(data);
                total = parseFloat(tot) || 0;
                document.getElementById('total-price').innerText = `$${total.toLocaleString()}`;
                const lista = document.getElementById('listaResumen');
                items.forEach(item => {
                    const li = document.createElement('li');
                    li.dataset.id = item.id;
                    li.dataset.nombre = item.nombre;
                    li.dataset.precio = item.precio;
                    li.dataset.cantidad = item.cantidad;
                    li.dataset.tipo = item.tipo;
                    li.innerHTML = `${item.nombre} x${item.cantidad} - $${(item.precio*item.cantidad).toLocaleString()}`;
                    lista.appendChild(li);
                    // ajustar tarjeta
                    const card = document.querySelector(`.products .card[data-id='${item.id}']`);
                    if (card) {
                        const ctr = card.querySelector('.contador-producto');
                        ctr.textContent = item.cantidad;
                        ctr.style.display = 'block';
                        let stock = parseInt(card.dataset.cantidad) - item.cantidad;
                        card.dataset.cantidad = stock;
                        card.querySelector('.product-cantidad').textContent = `Cantidad: ${stock}`;
                        if (stock <= 0) {
                            card.classList.add('disabled');
                            card.style.pointerEvents = 'none';
                            const btnR = card.querySelector('.btn-remove');
                            btnR.style.pointerEvents = 'auto';
                            btnR.style.opacity = '1';
                        }
                    }
                });
                // ← Fija el precioTipo al tipo del primer <li>
                if (lista.children.length > 0) {
                    precioTipo = lista.children[0].dataset.tipo;
                    console.log('[DEBUG] precioTipo restaurado a', precioTipo);
                }
            }
        });
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-remove')) {
                const card = e.target.closest('.card');
                quitarDelResumen(card);

                // Actualizar el contador verde
                const ctr = card.querySelector('.contador-producto');
                let count = parseInt(ctr.textContent) || 0;
                count = Math.max(count - 1, 0); // evitar que baje de 0
                ctr.textContent = count;
                if (count <= 0) {
                    ctr.style.display = 'none';
                }
            }

        });
        renderProducts();
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