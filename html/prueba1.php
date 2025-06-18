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
$marcas = $conexion->query("SELECT codigo, nombre FROM marca");
$categorias = $conexion->query("SELECT codigo, nombre FROM categoria");
$proveedores = $conexion->query("SELECT nit, nombre FROM proveedor");
$ubicaciones = $conexion->query("SELECT codigo, nombre FROM ubicacion");
$unidades = $conexion->query("SELECT codigo, nombre FROM unidadmedida");

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

<body>

    <!-- Aquí se cargará el header -->
    <div id="menu"></div>

    <!-- Sección para Crear Producto -->
    <div id="crearProducto" class="form-section">
        <h1>Crear Producto</h1>
        <!-- Botón para abrir modal de importar -->
        <button type="submit" class="icon-button" aria-label="Importar archivo" title="Importar archivo" onclick="openModal('modalImport')">
            <i class="fas fa-file-excel"></i>
            <label>Importar archivo</label>
        </button>

        <!-- Modal Importar Archivo -->
        <div id="modalImport" class="modal_nueva_categoria hidden">
            <div class="modal-content-nueva">
                <span class="close-button" onclick="closeModal('modalImport')">&times;</span>
                <h2>Importar Archivo</h2>
                <form method="post" enctype="multipart/form-data" action="/html/importar_excel.php">
                    <div class="form-group">
                        <label>Selecciona el archivo Excel:</label>
                        <label for="archivoExcel" class="custom-file-upload">
                            <i class="fas fa-cloud-upload-alt"></i><br>
                            <span>Haz clic para seleccionar un archivo</span>
                        </label>
                        <input id="archivoExcel" type="file" name="archivoExcel" accept=".xlsx, .xls" required hidden>
                    </div>
                    <div class="modal-buttons">
                        <button type="button" onclick="closeModal('modalImport')">Cancelar</button>
                        <button type="submit">Importar</button>
                    </div>
                    <a href="../componentes/formato_productos.xlsx" download class="download-link">
                        <i class="fas fa-file-download"></i> Descargar formato
                    </a>
                </form>
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
                        max="99"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" /><br>
                </div>


               <!-- Campo Categoría con botón para agregar nueva -->
                <div class="campo">
                    <div class="label-with-button">
                        <label class="required" for="categoria">Categoría:</label>
                        <button type="button" class="add-button" onclick="openModal('modalCategoria')">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <select id="categoria" name="categoria" required>
                        <?php while ($fila = $categorias->fetch_assoc()) { ?>
                            <option value="<?= $fila['codigo'] ?>"><?= $fila['nombre'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Campo Marca con botón para agregar nueva -->
                <div class="campo">
                    <div class="label-with-button">
                        <label class="required" for="marca">Marca:</label>
                        <button type="button" class="add-button" onclick="openModal('modalMarca')">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <select id="marca" name="marca" required>
                        <?php while ($fila = $marcas->fetch_assoc()) { ?>
                            <option value="<?= $fila['codigo'] ?>"><?= $fila['nombre'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="campo">
                    <label class="required" for="unidadMedida">Clase:</label>
                    <select name="unidadMedida" id="unidadMedida" required>
                        <?php while ($fila = $unidades->fetch_assoc()) { ?>
                            <option value="<?php echo $fila['codigo']; ?>">
                                <?php echo $fila['nombre']; ?>
                            </option>
                        <?php } ?>
                    </select><br>
                </div>
               <!-- Campo Ubicación con botón para agregar nueva -->
                <div class="campo">
                    <div class="label-with-button">
                        <label for="ubicacion">Ubicación:</label>
                        <button type="button" class="add-button" onclick="openModal('modalUbicacion')">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <select id="ubicacion" name="ubicacion">
                        <?php while ($fila = $ubicaciones->fetch_assoc()) { ?>
                            <option value="<?= $fila['codigo'] ?>"><?= $fila['nombre'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="campo">
                    <label class="required" for="proveedor">Proveedor:</label>
                    <select name="proveedor" id="proveedor" required>
                        <?php while ($fila = $proveedores->fetch_assoc()) { ?>
                            <option value="<?php echo $fila['nit']; ?>">
                                <?php echo $fila['nombre']; ?>
                            </option>
                        <?php } ?>
                    </select><br>
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
    <div id="modalCategoria" class="modal_nueva_categoria hidden">
        <div class="modal-content-nueva">
            <span class="close-button" onclick="closeModal('modalCategoria')">&times;</span>
            <h2>Nueva categoría</h2>
            <form id="formAddCategoria">
                <div class="form-group">
                    <label for="inputNombreCategoria">Nombre de la categoría:</label>
                    <input type="text" id="inputNombreCategoria" name="nombre" required>
                    <span class="input-error-message">Este nombre ya está registrado.</span>
                </div>
                <div class="modal-buttons">
                    <button type="button" onclick="closeModal('modalCategoria')">Cancelar</button>
                    <button type="submit" id="btnGuardarCategoria">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Nueva Ubicación -->
    <div id="modalUbicacion" class="modal_nueva_categoria hidden">
        <div class="modal-content-nueva">
            <span class="close-button" onclick="closeModal('modalUbicacion')">&times;</span>
            <h2>Nueva ubicación</h2>
            <form id="formAddUbicacion">
                <div class="form-group">
                    <label for="inputNombreUbicacion">Nombre de la ubicación:</label>
                    <input type="text" id="inputNombreUbicacion" name="nombre" required>
                    <span class="input-error-message">Este nombre ya está registrado.</span>
                </div>
                <div class="modal-buttons">
                    <button type="button" onclick="closeModal('modalUbicacion')">Cancelar</button>
                    <button type="submit" id="btnGuardarUbicacion">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Nueva Marca -->
    <div id="modalMarca" class="modal_nueva_categoria hidden">
        <div class="modal-content-nueva">
            <span class="close-button" onclick="closeModal('modalMarca')">&times;</span>
            <h2>Nueva marca</h2>
            <form id="formAddMarca">
                <div class="form-group">
                    <label for="inputNombreMarca">Nombre de la marca:</label>
                    <input type="text" id="inputNombreMarca" name="nombre" required>
                    <span class="input-error-message">Este nombre ya está registrado.</span>
                </div>
                <div class="modal-buttons">
                    <button type="button" onclick="closeModal('modalMarca')">Cancelar</button>
                    <button type="submit" id="btnGuardarMarca">Guardar</button>
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
    // ========= FUNCIONES PARA MODALES =========

    // Función mejorada para abrir cualquier modal con animación
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        const content = modal.querySelector('.modal-content, .modal-content-nueva');
        
        // Resetear estado de animación
        content.style.transform = 'translateY(-20px)';
        content.style.opacity = '0';
        
        // Mostrar modal
        modal.classList.remove('hidden');
        modal.classList.add('show');
        
        // Forzar reflow para activar la animación
        void modal.offsetWidth;
        
        // Iniciar animación
        modal.classList.add('opening');
        content.style.transform = 'translateY(0)';
        content.style.opacity = '1';
        
        // Enfocar el primer input si existe
        const input = content.querySelector('input');
        if (input) input.focus();
    }

    // Función mejorada para cerrar cualquier modal con animación
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        const content = modal.querySelector('.modal-content, .modal-content-nueva');
        
        // Iniciar animación de cierre
        modal.classList.remove('opening');
        modal.classList.add('closing');
        content.style.transform = 'translateY(-20px)';
        content.style.opacity = '0';
        
        // Ocultar completamente después de la animación
        setTimeout(() => {
            modal.classList.remove('show', 'closing');
            modal.classList.add('hidden');
        }, 300); // 300ms = duración de la animación
    }

    // ========= MODAL DE IMPORTAR ARCHIVO =========
    function openImportModal() {
        openModal('modalConfirm');
    }

    function closeImportModal() {
        closeModal('modalConfirm');
    }

    // ========= SWEETALERT MENSAJES PHP =========
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

    // ========= VALIDACIÓN CÓDIGO DUPLICADO =========
    function setupCodeValidation() {
        const inputCodigo = document.getElementById('codigo1');
        const submitBtn = document.querySelector('#product-form button[type="submit"]');
        const campo = inputCodigo?.closest('.campo');
        
        if (campo) {
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
        }
    }

    // ========= FUNCIONES PARA MODALES DE CATEGORÍA, MARCA Y UBICACIÓN =========

    // Helper genérico para verificar existencia
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

    // Configuración de validación para cada modal
    function setupModalValidation({ inputId, btnGuardarId, accion }) {
        const inp = document.getElementById(inputId);
        const btn = document.getElementById(btnGuardarId);
        const span = inp.nextElementSibling;
        
        inp.addEventListener('input', async () => {
            const val = inp.value.trim();
            const exists = val ? await checkExists(accion, val) : false;
            inp.classList.toggle('invalid', exists);
            btn.disabled = exists || !val;
            span.style.display = exists ? 'block' : 'none';
        });
    }

    // Manejar envío de formularios de modales
    function handleModalFormSubmit(form, accion, selectId) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const input = this.querySelector('input');
            const nombre = input.value.trim();
            
            if (!nombre) return;

            const response = await fetch('', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: new URLSearchParams({ accion, nombre })
            });

            const data = await response.json();
            
            if (data.success) {
                // Actualizar el select correspondiente
                const select = document.getElementById(selectId);
                
                const option = document.createElement('option');
                option.value = data.id;
                option.textContent = data.nombre;
                option.selected = true;
                
                select.appendChild(option);
                closeModal('modal' + form.id.replace('formAdd', ''));
                this.reset();
            } else {
                Swal.fire('Error', data.error || 'Ocurrió un error', 'error');
            }
        });
    }

    // ========= INICIALIZACIÓN CUANDO EL DOM ESTÁ LISTO =========
    document.addEventListener('DOMContentLoaded', () => {
        // Configurar eventos para cerrar modales al hacer clic fuera
        document.querySelectorAll('.modal_nueva_categoria, .modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(this.id);
                }
            });
        });
        
        // Configurar eventos específicos para cada modal
        document.getElementById('btnCancelarCategoria')?.addEventListener('click', () => closeModal('modalCategoria'));
        document.getElementById('btnCancelarUbicacion')?.addEventListener('click', () => closeModal('modalUbicacion'));
        document.getElementById('btnCancelarMarca')?.addEventListener('click', () => closeModal('modalMarca'));
        
        // Cerrar modal de importación al enviar el formulario
        document.querySelector('#modalConfirm form')?.addEventListener('submit', () => closeModal('modalConfirm'));

        // Configurar validación de código duplicado
        setupCodeValidation();

        // Configurar validaciones para modales
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

        // Configurar envío de formularios de modales
        const formAddCategoria = document.getElementById('formAddCategoria');
        const formAddUbicacion = document.getElementById('formAddUbicacion');
        const formAddMarca = document.getElementById('formAddMarca');

        if (formAddCategoria) {
            handleModalFormSubmit(formAddCategoria, 'add_categoria', 'categoria');
        }

        if (formAddUbicacion) {
            handleModalFormSubmit(formAddUbicacion, 'add_ubicacion', 'ubicacion');
        }

        if (formAddMarca) {
            handleModalFormSubmit(formAddMarca, 'add_marca', 'marca');
        }

        // Funciones específicas para abrir modales
        window.openModalCategoria = function() {
            openModal('modalCategoria');
            document.getElementById('inputNombreCategoria').focus();
        };

        window.openModalUbicacion = function() {
            openModal('modalUbicacion');
            document.getElementById('inputNombreUbicacion').focus();
        };

        window.openModalMarca = function() {
            openModal('modalMarca');
            document.getElementById('inputNombreMarca').focus();
        };
    });
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