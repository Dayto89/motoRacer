<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}
//require_once $_SERVER['DOCUMENT_ROOT'] . '../html/verificar_permisos.php';

// Conexión
$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("alert('No se pudo conectar a la base de datos');");
}

// 1) AJAX check código
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['accion']) &&
    $_POST['accion'] === 'check_codigo'
) {
    header('Content-Type: application/json');
    $codigo = $_POST['codigo1'] ?? '';
    $stmt = $conexion->prepare("SELECT 1 FROM producto WHERE codigo1 = ?");
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $stmt->store_result();
    $existe = $stmt->num_rows > 0;
    echo json_encode(['exists' => $existe]);
    $stmt->close();
    $conexion->close();
    exit;
}

// 2a) AJAX handler para agregar categoría y devolver JSON
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['accion']) &&
    $_POST['accion'] === 'add_categoria'
) {
    header('Content-Type: application/json');
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $query  = "INSERT INTO categoria (nombre) VALUES ('$nombre')";
    if (mysqli_query($conexion, $query)) {
        $id = mysqli_insert_id($conexion);
        echo json_encode([
            'success' => true,
            'id'      => $id,
            'nombre'  => $nombre
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error'   => mysqli_error($conexion)
        ]);
    }
    exit;
}
// 2b) AJAX handler para agregar ubicación
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['accion']) &&
    $_POST['accion'] === 'add_ubicacion'
) {
    header('Content-Type: application/json');
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $query  = "INSERT INTO ubicacion (nombre) VALUES ('$nombre')";
    if (mysqli_query($conexion, $query)) {
        $id = mysqli_insert_id($conexion);
        echo json_encode([
            'success' => true,
            'id'      => $id,
            'nombre'  => $nombre
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error'   => mysqli_error($conexion)
        ]);
    }
    exit;
}

// 2c) AJAX handler para agregar marca
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['accion']) &&
    $_POST['accion'] === 'add_marca'
) {
    header('Content-Type: application/json');
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $query  = "INSERT INTO marca (nombre) VALUES ('$nombre')";
    if (mysqli_query($conexion, $query)) {
        $id = mysqli_insert_id($conexion);
        echo json_encode([
            'success' => true,
            'id'      => $id,
            'nombre'  => $nombre
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error'   => mysqli_error($conexion)
        ]);
    }
    exit;
}

// 2d) AJAX handler para agregar proveedor
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['accion']) &&
    $_POST['accion'] === 'add_proveedor'
) {
    header('Content-Type: application/json');
    // Escapa el nombre y demás campos que quieras capturar:
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $nit    = mysqli_real_escape_string($conexion, $_POST['nit']);
    // Puedes capturar más campos si tu tabla los tiene
    $query  = "INSERT INTO proveedor (nit, nombre) VALUES ('$nit', '$nombre')";
    if (mysqli_query($conexion, $query)) {
        $id = $nit; // aquí tu clave primaria es nit
        echo json_encode([
            'success' => true,
            'id'      => $id,
            'nombre'  => $nombre
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error'   => mysqli_error($conexion)
        ]);
    }
    exit;
}

// 1a) Check nombre de categoría
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'check_categoria') {
    header('Content-Type: application/json');
    $n = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $r = mysqli_query($conexion, "SELECT 1 FROM categoria WHERE nombre='$n' LIMIT 1");
    echo json_encode(['exists' => (mysqli_num_rows($r) > 0)]);
    exit;
}

// 1b) Check nombre de ubicación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'check_ubicacion') {
    header('Content-Type: application/json');
    $n = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $r = mysqli_query($conexion, "SELECT 1 FROM ubicacion WHERE nombre='$n' LIMIT 1");
    echo json_encode(['exists' => (mysqli_num_rows($r) > 0)]);
    exit;
}

// 1c) Check nombre de marca
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'check_marca') {
    header('Content-Type: application/json');
    $n = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $r = mysqli_query($conexion, "SELECT 1 FROM marca WHERE nombre='$n' LIMIT 1");
    echo json_encode(['exists' => (mysqli_num_rows($r) > 0)]);
    exit;
}

// Consultas de selects
$marcas      = $conexion->query("SELECT codigo, nombre FROM marca");
$categorias  = $conexion->query("SELECT codigo, nombre FROM categoria");
$proveedores = $conexion->query("SELECT nit, nombre FROM proveedor");
$ubicaciones = $conexion->query("SELECT codigo, nombre FROM ubicacion");
$unidades    = $conexion->query("SELECT codigo, nombre FROM unidadmedida");

include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Crear Producto</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <link rel="stylesheet" href="../css/producto.css">
    <link rel="stylesheet" href="../css/alertas.css">
    <link rel="stylesheet" href="/componentes/header.php">
    <link rel="stylesheet" href="/componentes/header.css">
    <script src="../js/header.js"></script>
    <script src="/js/index.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');

        .required::after {
            content: " *";
            color: red;
        }

        /* Estilo del botón de cierre */
        .close-button {
            position: absolute;
            top: 8px;
            right: 12px;
            font-size: 2.2rem;
            font-weight: bold;
            color: #333;
            cursor: pointer;
            user-select: none;
        }

        /* Opcional: cambio de color al pasar el ratón */
        .close-button:hover {
            color: red;
        }
    </style>
</head>

<!-- Aquí se cargará el header -->
<div id="menu"></div>
<nav class="barra-navegacion">
    <div class="ubica"> Producto / Crear producto</div>
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
</nav>
<div class="container-general"></div>
<!-- Sección para Crear Producto -->
<div id="crearProducto" class="form-section">
    <h1>Crear Producto</h1>
    <!-- Abrir modal para subir el archivo -->
    <button
        type="button"
        class="icon-button"
        aria-label="Importar archivo"
        title="Importar archivo"
        id="btnAbrirModalImport">
        <i class="fas fa-file-excel"></i>
        <label>Importar archivo</label>
    </button>
    <!-- **Nuevo** modal de importación -->
    <div id="modalImport" class="modal">
        <div class="modal-content">
            <span class="close-button" id="btnCerrarModalImport">&times;</span>

            <form
                method="post"
                enctype="multipart/form-data"
                action="/html/importar_excel.php">
                <label>Selecciona el archivo Excel:</label>
                <label for="archivoExcel" class="custom-file-upload">
                    <i class="fas fa-cloud-upload-alt"></i><br>
                    <span>Haz clic para seleccionar un archivo</span>
                </label>

                <input
                    id="archivoExcel"
                    type="file"
                    name="archivoExcel"
                    accept=".xlsx,.xls"
                    required
                    data-max-size="2097152"
                    hidden />

                <div class="modal-buttons">
                    <button type="submit" name="importar">Importar</button>
                    <a href="../componentes/formato_productos.xlsx" download>
                        <i class="fas fa-file-download"></i> Descargar formato
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Contenedor principal -->
<div class="container">

    <form id="product-form" method="POST" action="">


        <div class="campo">
            <label class="required" for="codigo1">Código 1:</label>
            <input type="text" id="codigo1" name="codigo1" required><br>
        </div>
        <div class="campo">
            <label for="codigo2">Código 2:</label>
            <input type="text" id="codigo2" name="codigo2" value="0"><br>
        </div>
        <div class="campo">
            <label class="required" for="nombre">Producto:</label>
            <input type="text" id="nombre" name="nombre" required><br>
        </div>

        <div class="campo">
            <label class="required" for="precio1">Precio llegada:</label>
            <input type="text" id="precio1" name="precio1" required
                oninput="this.value = this.value.replace(/[^0-9]/g, '')" /><br>
        </div>

        <div class="campo">
            <label class="required" for="precio2">Precio taller:</label>
            <input type="text" id="precio2" name="precio2"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')" /><br>
        </div>

        <div class="campo">
            <label class="required" for="precio3">Precio publico:</label>
            <input type="text" id="precio3" name="precio3"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')" /><br>
                
        </div>

        <div class="campo">
              <label class="required" for="cantidad">Cantidad:</label>
              <input type="number"
                         id="cantidad"
                         name="cantidad"
                         required
                         min="0"
                         max="999"
                         oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)" /><br>
        </div>


        <!-- CATEGORÍA -->
        <div class="campo">
            <div class="label-with-button" style="display:flex;align-items:center;">
                <label class="required" for="categoria">Categoría:</label>
                <button type="button"
                    class="add-button-cat"
                    onclick="openModalCategoria()"
                    aria-label="Agregar categoría">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="fake-select" data-for="categoria">
                <div class="fs-selected">— Seleccione —</div>
                <div class="fs-options-wrap">
                    <ul class="fs-options">
                        <?php while ($fila = $categorias->fetch_assoc()) { ?>
                            <li data-value="<?= $fila['codigo'] ?>"><?= $fila['nombre'] ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="categoria" id="categoria">
        </div>

        <!-- MARCA -->
        <div class="campo">
            <div class="label-with-button">
                <label class="required" for="marca">Marca:</label>
                <button type="button"
                    class="add-button-mar"
                    onclick="openModalMarca()"
                    aria-label="Agregar marca">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="fake-select" data-for="marca">
                <div class="fs-selected">— Seleccione —</div>
                <div class="fs-options-wrap">
                    <ul class="fs-options">
                        <?php while ($fila = $marcas->fetch_assoc()) { ?>
                            <li data-value="<?= $fila['codigo'] ?>"><?= $fila['nombre'] ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="marca" id="marca">
        </div>

        <!-- UNIDAD DE MEDIDA (CLASE) -->
        <div class="campo">
            <label class="required" for="unidadMedida">Clase:</label>
            <div class="fake-select" data-for="unidadMedida">
                <div class="fs-selected">— Seleccione —</div>
                <div class="fs-options-wrap">
                    <ul class="fs-options">
                        <?php while ($fila = $unidades->fetch_assoc()) { ?>
                            <li data-value="<?= $fila['codigo'] ?>"><?= $fila['nombre'] ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="unidadMedida" id="unidadMedida">
        </div>

        <!-- UBICACIÓN -->
        <div class="campo">
            <div class="label-with-button">
                <label for="ubicacion">Ubicación:</label>
                <button
                    type="button"
                    class="add-button-ubi"
                    onclick="openModalUbicacion()"
                    aria-label="Agregar ubicación"
                    title="Agregar ubicación">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="fake-select" data-for="ubicacion">
                <div class="fs-selected">— Seleccione —</div>
                <div class="fs-options-wrap">
                    <ul class="fs-options">
                        <?php while ($fila = $ubicaciones->fetch_assoc()) { ?>
                            <li data-value="<?= $fila['codigo'] ?>"><?= $fila['nombre'] ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="ubicacion" id="ubicacion">
        </div>

        <!-- PROVEEDOR -->
        <div class="campo">
            <label class="required" for="proveedor">Proveedor:</label>
            <div class="fake-select" data-for="proveedor">
                <div class="fs-selected">— Seleccione —</div>
                <div class="fs-options-wrap">
                    <ul class="fs-options">
                        <?php while ($fila = $proveedores->fetch_assoc()) { ?>
                            <li data-value="<?= $fila['nit'] ?>"><?= $fila['nombre'] ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="proveedor" id="proveedor">
        </div>

        <div class="button-container">
            <div class="boton">
                <button type="submit" name="guardar">Guardar</button>
            </div>
        </div>

    </form>


</div>

</div>

<!-- Modal Nueva Categoría -->
<div id="modalCategoria" class="modal_nueva_categoria">
    <div class="modal-content-nueva">
        <span class="close-button" onclick="closeModal(modalCat)">&times;</span>
        <h2>Nueva categoría</h2>
        <form id="formAddCategoria" action="" method="POST">
            <div class="form-group" style="position: relative;">
                <label for="inputNombreCategoria">Ingrese el nombre de la categoría:</label>
                <input
                    type="text"
                    id="inputNombreCategoria"
                    name="nombre"
                    required
                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" />
                <span class="input-error-message">
                    Este nombre ya está registrado.
                </span>
            </div>
            <div class="modal-buttons">
                <button type="button" id="btnCancelarCategoria">Cancelar</button>
                <button type="submit" id="btnGuardarCategoria" disabled>Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Nueva Ubicación -->
<div id="modalUbicacion" class="modal_nueva_categoria">
    <div class="modal-content-nueva">
        <span class="close-button" onclick="closeModal(modalUbic)">&times;</span>
        <h2>Nueva ubicación</h2>
        <form id="formAddUbicacion" method="POST" action="">
            <div class="form-group" style="position: relative;">
                <label for="inputNombreUbicacion">Ingrese el nombre de la ubicación:</label>
                <input
                    type="text"
                    id="inputNombreUbicacion"
                    name="nombre"
                    required />
                <span class="input-error-message">
                    Este nombre ya está registrado.
                </span>
            </div>
            <div class="modal-buttons">
                <button type="button" id="btnCancelarUbicacion">Cancelar</button>
                <button type="submit" id="btnGuardarUbicacion" disabled>Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Nueva Marca -->
<div id="modalMarca" class="modal_nueva_categoria">
    <div class="modal-content-nueva">
        <span class="close-button" onclick="closeModal(modalMarca)">&times;</span>
        <h2>Nueva marca</h2>
        <form id="formAddMarca" method="POST" action="">
            <div class="form-group" style="position: relative;">
                <label for="inputNombreMarca">Ingrese el nombre de la marca:</label>
                <input
                    type="text"
                    id="inputNombreMarca"
                    name="nombre"
                    required
                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" />
                <span class="input-error-message">
                    Este nombre ya está registrado.
                </span>
            </div>
            <div class="modal-buttons">
                <button type="button" id="btnCancelarMarca">Cancelar</button>
                <button type="submit" id="btnGuardarMarca" disabled>Guardar</button>
            </div>
        </form>
    </div>
</div>


<?php

$mensaje = null;  // Variable para almacenar el estado del mensaje
define('CANTIDAD_MAX', 99);


if ($_POST) {
    if (!$conexion) {
        die("<script>alert('No se pudo conectar a la base de datos');</script>");
    };
    $codigo1 = $_POST['codigo1'];
    $codigo2 = $_POST['codigo2'];
    $nombre = $_POST['nombre'];
    $iva = 19;
    $precio1 = $_POST['precio1'];
    $precio2 = $_POST['precio2'];
    $precio3 = $_POST['precio3'];
    $cantidad = (int) $_POST['cantidad'];
    if ($cantidad < 0 || $cantidad > CANTIDAD_MAX) {
        die("<script>alert('La cantidad debe estar entre 0 y " . CANTIDAD_MAX . "'); window.history.back();</script>");
    }

    $categoria = $_POST['categoria'];
    $marca = $_POST['marca'];
    $unidadMedida = $_POST['unidadMedida'];
    $ubicacion = $_POST['ubicacion'];
    $proveedor = $_POST['proveedor'];

    $query = "INSERT INTO producto (codigo1, codigo2, nombre, iva, precio1, precio2, precio3, cantidad, Categoria_codigo, Marca_codigo, UnidadMedida_codigo, Ubicacion_codigo, proveedor_nit) VALUES ('$codigo1', '$codigo2', '$nombre', '$iva', '$precio1', '$precio2', '$precio3', '$cantidad', '$categoria', '$marca', '$unidadMedida', '$ubicacion', '$proveedor')";



    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $mensaje = 'producto_agregado';
    } else {
        $mensaje = 'error_al_agregar';
    }
}

?>



<script>
    function openModal(modal) {
        modal.classList.add('show');
        void modal.offsetWidth; // fuerza reflow para animación
        modal.classList.add('opening');
    }

    function closeModal(modal) {
        modal.classList.remove('opening');
        modal.classList.add('closing');
        const contenido = modal.querySelector('.modal-content');
        contenido.addEventListener('transitionend', function handler() {
            contenido.removeEventListener('transitionend', handler);
            modal.classList.remove('show', 'closing');
        });
    }
    document.querySelector('form[action="/html/importar_excel.php"]').addEventListener('submit', e => {
        const inp = document.getElementById('archivoExcel');
        const file = inp.files[0];
        if (!file) return; // el required ya avisa
        const ext = file.name.split('.').pop().toLowerCase();
        if (!['xlsx', 'xls'].includes(ext)) {
            Swal.fire('Error', 'Formato no permitido. Usa .xlsx o .xls', 'error');
            e.preventDefault();
            return;
        }
        const max = parseInt(inp.dataset.maxSize, 10);
        if (file.size > max) {
            Swal.fire('Error', `El archivo no puede pesar más de ${max/1024/1024} MiB`, 'error');
            e.preventDefault();
            return;
        }
    });

    // ——— Modal de subir archivo ———
    function openConfirmModal() {
        const modal = document.getElementById("modalConfirm");
        const btnAbrir = document.getElementById("btnAbrirModal");
        modal.style.display = "flex";
        btnAbrir.style.display = "none";
    }

    function closeConfirmModal() {
        const modal = document.getElementById("modalConfirm");
        const btnAbrir = document.getElementById("btnAbrirModal");
        modal.style.display = "none";
        btnAbrir.style.display = "block";
    }


    // ——— SweetAlert según mensaje PHP ———
    const mensaje = "<?php echo $mensaje; ?>";
    if (mensaje === "producto_agregado") {
        Swal.fire({
            title: '<span class="titulo-alerta confirmacion">Producto Agregado</span>',
            html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/moto.png" alt="Confirmacion" class="moto">
                    </div>
                    <p>Producto agregado con éxito al inventario.</p>
                </div>`,
            background: 'hsl(0deg 0% 100% / 0.76)',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#007bff',
            customClass: {
                popup: 'swal2-border-radius',
                confirmButton: 'btn-aceptar',
                container: 'fondo-oscuro'
            }
        });
    } else if (mensaje === "error_al_agregar") {
        Swal.fire({
            title: '<span class="titulo-alerta error">Error</span>',
            html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/llave.png" alt="Error" class="llave">
                    </div>
                    <p>Error al agregar el producto.</p>
                </div>`,
            background: 'hsl(0deg 0% 100% / 0.76)',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#007bff',
            customClass: {
                popup: 'swal2-border-radius',
                confirmButton: 'btn-aceptar',
                container: 'fondo-oscuro'
            }
        });
    }

    // ——— Validación código duplicado ———
    document.addEventListener('DOMContentLoaded', () => {
        const inputCodigo = document.getElementById('codigo1');
        const submitBtn = document.querySelector('#product-form button[type="submit"]');
        const campo = inputCodigo.closest('.campo');
        let tooltip = campo.querySelector('.small-error-tooltip');

        if (!tooltip) {
            tooltip = document.createElement('div');
            tooltip.className = 'small-error-tooltip';
            tooltip.textContent = 'Este código ya está registrado.';
            campo.appendChild(tooltip);
        }

        inputCodigo.addEventListener('blur', () => {
            const val = inputCodigo.value.trim();
            if (!val) {
                inputCodigo.classList.remove('error');
                tooltip.style.display = 'none';
                submitBtn.disabled = false;
                return;
            }
            fetch('crearproducto.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'accion=check_codigo&codigo1=' + encodeURIComponent(val)
                })
                .then(r => r.json())
                .then(data => {
                    if (data.exists) {
                        inputCodigo.classList.add('error');
                        tooltip.style.display = 'block';
                        submitBtn.disabled = true;
                    } else {
                        inputCodigo.classList.remove('error');
                        tooltip.style.display = 'none';
                        submitBtn.disabled = false;
                    }
                })
                .catch(() => {
                    inputCodigo.classList.remove('error');
                    tooltip.style.display = 'none';
                    submitBtn.disabled = false;
                });
        });
    });

    // ——— Funciones genéricas para los modales con animación ———
    function openModal(modal) {
        // Mostrar overlay y arrancar apertura
        modal.classList.add('show');
        void modal.offsetWidth; // fuerza reflow
        modal.classList.add('opening');
    }

    function closeModal(modal) {
        // Arrancar cierre
        modal.classList.remove('opening');
        modal.classList.add('closing');
        // Cuando termine la transición, ocultar por completo
        const contenido = modal.querySelector('.modal-content-nueva');
        contenido.addEventListener('transitionend', function handler() {
            contenido.removeEventListener('transitionend', handler);
            modal.classList.remove('show', 'closing');
        });
    }

    // ——— Asociar cada modal y sus eventos ———
    const modalCat = document.getElementById('modalCategoria');
    const modalUbic = document.getElementById('modalUbicacion');
    const modalMarca = document.getElementById('modalMarca');

    // Cerrar al hacer clic fuera del contenido
    [modalCat, modalUbic, modalMarca].forEach(modalEl => {
        modalEl.addEventListener('click', e => {
            if (e.target === modalEl) closeModal(modalEl);
        });
    });

    // ——— Modal Categoría ———
    document.getElementById('btnCancelarCategoria')
        .addEventListener('click', () => closeModal(modalCat));

    function openModalCategoria() {
        openModal(modalCat);
        document.getElementById('inputNombreCategoria').focus();
    }
    formAddCategoria.addEventListener('submit', e => {
        e.preventDefault();
        const nombre = document.getElementById('inputNombreCategoria').value.trim();
        if (!nombre) return;
        fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    accion: 'add_categoria',
                    nombre
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const opt = document.createElement('option');
                    opt.value = data.id;
                    opt.text = data.nombre;
                    opt.selected = true;
                    document.getElementById('categoria').appendChild(opt);
                    closeModal(modalCat);
                    formAddCategoria.reset();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.error
                    });
                }
            });
    });


    // ——— Modal Ubicación ———
    document.getElementById('btnCancelarUbicacion')
        .addEventListener('click', () => closeModal(modalUbic));

    function openModalUbicacion() {
        openModal(modalUbic);
        document.getElementById('inputNombreUbicacion').focus();
    }
    formAddUbicacion.addEventListener('submit', e => {
        e.preventDefault();
        const nombre = document.getElementById('inputNombreUbicacion').value.trim();
        if (!nombre) return;
        fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    accion: 'add_ubicacion',
                    nombre
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const opt = document.createElement('option');
                    opt.value = data.id;
                    opt.text = data.nombre;
                    opt.selected = true;
                    document.getElementById('ubicacion').appendChild(opt);
                    closeModal(modalUbic);
                    formAddUbicacion.reset();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.error
                    });
                }
            });
    });

    // ——— Modal Marca ———
    document.getElementById('btnCancelarMarca')
        .addEventListener('click', () => closeModal(modalMarca));

    function openModalMarca() {
        openModal(modalMarca);
        document.getElementById('inputNombreMarca').focus();
    }
    formAddMarca.addEventListener('submit', e => {
        e.preventDefault();
        const nombre = document.getElementById('inputNombreMarca').value.trim();
        if (!nombre) return;
        fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    accion: 'add_marca',
                    nombre
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const opt = document.createElement('option');
                    opt.value = data.id;
                    opt.text = data.nombre;
                    opt.selected = true;
                    document.getElementById('marca').appendChild(opt);
                    closeModal(modalMarca);
                    formAddMarca.reset();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.error
                    });
                }
            });
    });

    // referencias
    const modalImport = document.getElementById('modalImport');
    const btnAbrirImport = document.getElementById('btnAbrirModalImport');
    const btnCerrarImport = document.getElementById('btnCerrarModalImport');

    // abrir
    btnAbrirImport.addEventListener('click', () => {
        openModal(modalImport);
    });

    // cerrar con la “X”
    btnCerrarImport.addEventListener('click', () => {
        closeModal(modalImport);
    });

    // cerrar al clicar fuera de .modal-content
    modalImport.addEventListener('click', e => {
        if (e.target === modalImport) {
            closeModal(modalImport);
        }
    });

    // Helper genérico
    async function checkExists(accion, nombre) {
        const body = new URLSearchParams({
            accion,
            nombre: nombre.trim()
        });
        const resp = await fetch('', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: body.toString()
        });
        const json = await resp.json();
        return json.exists;
    }

    // Crea un listener para un modal dado:
    function setupModalValidation({
        inputId,
        btnGuardarId,
        accion
    }) {
        const inp = document.getElementById(inputId);
        const btn = document.getElementById(btnGuardarId);
        const span = inp.nextElementSibling; // asume el span justo después
        inp.addEventListener('input', async () => {
            const val = inp.value.trim();
            const exists = val ? await checkExists(accion, val) : false;
            inp.classList.toggle('invalid', exists);
            btn.disabled = exists || !val;
        });
    }

    // Inicializa las tres validaciones
    setupModalValidation({
        inputId: 'inputNombreCategoria',
        btnGuardarId: 'btnGuardarCategoria',
        accion: 'check_categoria'
    });
    setupModalValidation({
        inputId: 'inputNombreUbicacion',
        btnGuardarId: 'btnGuardarUbicacion',
        accion: 'check_ubicacion'
    });
    setupModalValidation({
        inputId: 'inputNombreMarca',
        btnGuardarId: 'btnGuardarMarca',
        accion: 'check_marca'
    });
</script>
<script>
    //scroll select
    document.querySelectorAll('.fake-select').forEach(fs => {
        const sel = fs.querySelector('.fs-selected');
        const opts = fs.querySelector('.fs-options');
        const hidden = document.getElementById(fs.dataset.for);

        // abrir / cerrar
        sel.addEventListener('click', e => {
            fs.classList.toggle('open');
        });
        // escoger opción
        opts.addEventListener('click', e => {
            if (e.target.tagName === 'LI') {
                sel.textContent = e.target.textContent;
                hidden.value = e.target.dataset.value;
                fs.classList.remove('open');
            }
        });
        // cerrar al clicar afuera
        document.addEventListener('click', e => {
            if (!fs.contains(e.target)) fs.classList.remove('open');
        });
    });
</script>
</body>

</html>