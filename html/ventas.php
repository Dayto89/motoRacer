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
            $productos[] = [
                'id'       => $id,
                'nombre'   => $nombre,
                'precio'   => $precio,
                'cantidad' => $cantidad
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
                <a class='brand' 
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

        <div class="products">
            <?php
            if (isset($_GET['busqueda'])) {
                $buscar = "%" . $_GET['busqueda'] . "%";
                $stmt = $conexion->prepare("SELECT * FROM producto WHERE nombre LIKE ? OR codigo1 LIKE ?");
                $stmt->bind_param("ss", $buscar, $buscar);
                $stmt->execute();
                $resultado = $stmt->get_result();
            } elseif (isset($_GET['categoria'])) {
                $categoria = $_GET['categoria'];
                $stmt = $conexion->prepare("SELECT * FROM producto WHERE Categoria_codigo = ?");
                $stmt->bind_param("s", $categoria);
                $stmt->execute();
                $resultado = $stmt->get_result();
            } else {
                $resultado = mysqli_query($conexion, "SELECT * FROM producto");
            }

            if ($resultado->num_rows > 0) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    $disabledClass = $fila['cantidad'] <= 0 ? 'disabled' : '';
                    echo "<div class='card $disabledClass' data-id='{$fila['codigo1']}' data-nombre='" . htmlspecialchars($fila['nombre']) . "' data-cantidad='{$fila['cantidad']}' data-precio2='{$fila['precio2']}' data-precio3='{$fila['precio3']}'>";
                    echo "<span class='contador-producto'>0</span>";
                    echo "<div class='card-header'><p class='product-id'>" . htmlspecialchars($fila['nombre']) . "</p></div>";
                    echo "<select id='select-precio-{$fila['codigo1']}' class='price-selector'>";
                    echo "<option value='{$fila['precio2']}'>Precio Taller – $" . number_format($fila['precio2']) . "</option>";
                    echo "<option value='{$fila['precio3']}'>Precio Público – $" . number_format($fila['precio3']) . "</option>";
                    echo "</select>";
                    echo "<p class='product-cantidad'>Cantidad: {$fila['cantidad']}</p>";
                    echo "<div class='iconos-container'>";
                    echo "<div class='icono-accion btn-add' onclick='agregarAlResumen(this.parentNode.parentNode)'><img class='plus' src='../imagenes/material-symbols--add-2.svg' alt='Agregar'></div>";
                    echo "<div class='icono-accion btn-remove' onclick='quitarDelResumen(this.parentNode.parentNode)'><img class='minus' src='../imagenes/material-symbols--check-indeterminate-small-rounded.svg' alt='Quitar'></div>";
                    echo "</div></div>";
                }
            } else {
                echo "<script>Swal.fire({ title: '<span class=\"titulo-alerta error\">Error</span>', html: `<p>No se encontraron resultados.</p>`, confirmButtonText: 'Aceptar' }).then(()=> window.location.href='ventas.php');</script>";
            }
            mysqli_close($conexion);
            ?>
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
        let total = 0;
        const scrollContainer = document.getElementById('categoriaScroll');
        const btnLeft = document.getElementById('btnLeft');
        const btnRight = document.getElementById('btnRight');

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
                    cantidad: parseInt(li.dataset.cantidad)
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
            });
            document.body.appendChild(form);
            form.submit();
        }

        function agregarAlResumen(el) {
            if (el.classList.contains('disabled')) return;
            const id = el.dataset.id;
            const nombre = el.dataset.nombre;
            const precio = parseFloat(el.querySelector('.price-selector').value);
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
                    li.innerHTML = `${nombre} x${c} - $${(precio*c).toLocaleString()}`;
                    found = true;
                }
            });
            if (!found) {
                const li = document.createElement('li');
                li.dataset.id = id;
                li.dataset.nombre = nombre;
                li.dataset.precio = precio;
                li.dataset.cantidad = 1;
                li.innerHTML = `${nombre} x1 - $${precio.toLocaleString()}`;
                lista.appendChild(li);
            }
            total += precio;
            document.getElementById('total-price').innerText = `$${total.toLocaleString()}`;
            guardarEnLocalStorage();
        }

        function quitarDelResumen(el) {
    const id = el.dataset.id;
    const nombre = el.dataset.nombre;
    const precio = parseFloat(el.querySelector('.price-selector').value);
    const lista = document.getElementById('listaResumen');
    lista.querySelectorAll('li').forEach(li => {
        if (li.dataset.id === id) {
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

    guardarEnLocalStorage();
}

        

        function guardarEnLocalStorage() {
            const items = Array.from(document.querySelectorAll('#listaResumen li')).map(li => ({
                id: li.dataset.id,
                nombre: li.dataset.nombre,
                precio: parseFloat(li.dataset.precio),
                cantidad: parseInt(li.dataset.cantidad)
            }));
            localStorage.setItem('carritoProductos', JSON.stringify(items));
            localStorage.setItem('carritoTotal', total);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const data = localStorage.getItem('carritoProductos');
            const tot = localStorage.getItem('carritoTotal');
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
            }
        });
         document.addEventListener('click', function (e) {
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
    </script>
    

    <div class="userInfo">
        <?php
        $conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
        $id_usuario = $_SESSION['usuario_id'];
        $stmtUsuario = $conexion->prepare("SELECT nombre, apellido, rol, foto FROM usuario WHERE identificacion = ?");
        $stmtUsuario->bind_param("i", $id_usuario);
        $stmtUsuario->execute();
        $rowUsuario = $stmtUsuario->get_result()->fetch_assoc();
        $stmtUsuario->close();
        ?>
        <p class="nombre"><?= htmlspecialchars($rowUsuario['nombre']) ?> <?= htmlspecialchars($rowUsuario['apellido']) ?></p>
        <p class="rol">Rol: <?= htmlspecialchars($rowUsuario['rol']) ?></p>
    </div>
    <div class="profilePic">
        <?php if (!empty($rowUsuario['foto'])): ?>
            <img src="data:image/jpeg;base64,<?= base64_encode($rowUsuario['foto']) ?>" alt="Usuario">
        <?php else: ?>
            <img src="../imagenes/icono.jpg" alt="Usuario por defecto">
        <?php endif; ?>
    </div>
</body>

</html>