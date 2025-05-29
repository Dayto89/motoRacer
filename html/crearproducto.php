<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '../html/verificar_permisos.php';

//Almacenar informacion producto en la base de datos

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');

if (!$conexion) {
    die("alert('No se pudo conectar a la base de datos');");
};

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
    </style>
</head>

<body>

    <!-- Aquí se cargará el header -->
    <div id="menu"></div>

    <!-- Sección para Crear Producto -->
    <div id="crearProducto" class="form-section">
        <h1>Crear Producto</h1>
        <!-- Abrir modal para subir el archivo -->
        <button type="submit" class="icon-button" aria-label="Importar archivo" title="Importar archivo" onclick="document.getElementById('modalConfirm').style.display='block'">
            <i class="fas fa-file-excel"></i>
            <label>Importar archivo</label>
        </button>

        <!-- Modal para subir el archivo -->
        <div id="modalConfirm" class="modal hidden">
            <div class="modal-content">
                <!-- Formulario para subir el archivo -->
                <form method="post" enctype="multipart/form-data" action="/html/importar_excel.php">
                    <label>Selecciona el archivo Excel:</label>
                    <label for="archivoExcel" class="custom-file-upload">
                        <i class="fas fa-cloud-upload-alt"></i><br>
                        <span>Haz clic para seleccionar un archivo</span>
                    </label>
                    <input id="archivoExcel" type="file" name="archivoExcel" accept=".xlsx, .xls" required />
                    <input id="archivoExcel" type="file" name="archivoExcel" accept=".xlsx, .xls" required hidden>

                    <button type="submit" name="importar" onclick="closeModal()">Importar</button>
                    <button type="button" onclick="closeModal()">Cancelar</button>
                      <a href="../componentes/formato_productos.xlsx" download class="download-link">
                    <i class="fas fa-file-download"></i> Descargar formato de Excel
                </a>
                </form>

            </div>
        </div>


        <!-- Contenedor principal -->
        <div class="container">

            <form id="product-form" method="POST" action="">


                <div class="campo">
                    <label for="codigo1">Código 1:</label>
                    <input type="text" id="codigo1" name="codigo1" required><br>
                </div>
                <div class="campo">
                    <label for="codigo2">Código 2:</label>
                    <input type="text" id="codigo2" name="codigo2" required><br>
                </div>
                <div class="campo">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required><br>
                </div>

                <div class="campo">
                    <label for="iva">IVA:</label>
                    <input type="text" id="iva" name="iva" required
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" /><br>
                </div>

                <div class="campo">
                    <label for="precio1">Precio 1:</label>
                    <input type="text" id="precio1" name="precio1" required
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" /><br>
                </div>

                <div class="campo">
                    <label for="precio2">Precio 2:</label>
                    <input type="text" id="precio2" name="precio2"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" /><br>
                </div>

                <div class="campo">
                    <label for="precio3">Precio 3:</label>
                    <input type="text" id="precio3" name="precio3"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" /><br>
                </div>

                <div class="campo">
                    <label for="cantidad">Cantidad:</label>
                    <input type="text" id="cantidad" name="cantidad" required
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" /><br>
                </div>


                <div class="campo">
                    <label for="categoria">Categoria:</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Seleccione una categoría</option>
                        <?php while ($fila = $categorias->fetch_assoc()) { ?>
                            <option value="<?php echo $fila['codigo']; ?>">
                                <?php echo $fila['nombre']; ?>
                            </option>
                        <?php } ?>
                    </select><br>
                </div>
                <div class="campo">
                    <label for="marca">Marca:</label>
                    <select name="marca" id="marca" required>
                        <option value="">Seleccione una marca</option>
                        <?php while ($fila = $marcas->fetch_assoc()) { ?>
                            <option value="<?php echo $fila['codigo']; ?>">
                                <?php echo $fila['nombre']; ?>
                            </option>
                        <?php } ?>
                    </select><br>
                </div>
                <div class="campo">
                    <label for="unidadMedida">Unidad de Medida:</label>
                    <select name="unidadMedida" id="unidadMedida" required>
                        <option value="">Seleccione una unidad de medida</option>
                        <?php while ($fila = $unidades->fetch_assoc()) { ?>
                            <option value="<?php echo $fila['codigo']; ?>">
                                <?php echo $fila['nombre']; ?>
                            </option>
                        <?php } ?>
                    </select><br>
                </div>
                <div class="campo">
                    <label for="ubicacion">Ubicación:</label>
                    <select name="ubicacion" id="ubicacion" required>
                        <option value="">Seleccione una ubicación</option>
                        <?php while ($fila = $ubicaciones->fetch_assoc()) { ?>
                            <option value="<?php echo $fila['codigo']; ?>">
                                <?php echo $fila['nombre']; ?>
                            </option>
                        <?php } ?>
                    </select><br>
                </div>

                <div class="campo">
                    <label for="proveedor">Proveedor:</label>
                    <select name="proveedor" id="proveedor" required>
                        <option value="">Seleccione un proveedor</option>
                        <?php while ($fila = $proveedores->fetch_assoc()) { ?>
                            <option value="<?php echo $fila['nit']; ?>">
                                <?php echo $fila['nombre']; ?>
                            </option>
                        <?php } ?>
                    </select><br>
                </div>
                <div class="campo descrip">
                    <label for="descripcion">Descripción:</label>
                    <input type="text" id="descripcion" name="descripcion"><br>
                </div>
                <div class="button-container">
                    <div class="boton">
                        <button type="submit" name="guardar">Guardar</button>
                    </div>
                </div>



                <!-- Modal de confirmación -->
                <div id="modalConfirm" class="modal hidden">
                    <div class="modal-content">
                        <h2 id="modalTitle">Confirmación</h2>
                        <p id="modalMessage">¿Estás seguro de que quieres guardar este producto?</p>
                        <div id="modalButtons" class="modal-buttons">
                            <button class="btn-cancel" onclick="closeModal()">Cancelar</button>
                            <button type="submit" name="guardar">Guardar</button>
                        </div>
                    </div>
                </div>

            </form>


        </div>

    </div>


    <?php

    $mensaje = null;  // Variable para almacenar el estado del mensaje

    if ($_POST) {
        if (!$conexion) {
            die("<script>alert('No se pudo conectar a la base de datos');</script>");
        };
        $codigo1 = $_POST['codigo1'];
        $codigo2 = $_POST['codigo2'];
        $nombre = $_POST['nombre'];
        $iva = $_POST['iva'];
        $precio1 = $_POST['precio1'];
        $precio2 = $_POST['precio2'];
        $precio3 = $_POST['precio3'];
        $cantidad = $_POST['cantidad'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];
        $marca = $_POST['marca'];
        $unidadMedida = $_POST['unidadMedida'];
        $ubicacion = $_POST['ubicacion'];
        $proveedor = $_POST['proveedor'];

        $query = "INSERT INTO producto (codigo1, codigo2, nombre, iva, precio1, precio2, precio3, cantidad, descripcion, Categoria_codigo, Marca_codigo, UnidadMedida_codigo, Ubicacion_codigo, proveedor_nit) VALUES ('$codigo1', '$codigo2', '$nombre', '$iva', '$precio1', '$precio2', '$precio3', '$cantidad', '$descripcion', '$categoria', '$marca', '$unidadMedida', '$ubicacion', '$proveedor')";

        echo $query;

        $resultado = mysqli_query($conexion, $query);

        if ($resultado) {
            $mensaje = 'producto_agregado';
        } else {
            $mensaje = 'error_al_agregar';
        }
    }

    ?>

    <script>
        // Función para abrir el modal de subir archivo
        function openModal() {
            const modal = document.getElementById("modalConfirm");
            const btnAbrirModal = document.getElementById("btnAbrirModal");
            modal.style.display = "flex"; // Mostrar el modal con flexbox
            btnAbrirModal.style.display = "none"; // Ocultar el botón de abrir modal
        }

        // Función para cerrar el modal de subir archivo
        function closeModal() {
            const modal = document.getElementById("modalConfirm");
            const btnAbrirModal = document.getElementById("btnAbrirModal");
            modal.style.display = "none"; // Ocultar el modal
            btnAbrirModal.style.display = "block"; // Mostrar el botón de abrir modal
        }


        //llamar la variable mensaje y alertas

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
                </div>
            `,
                background: 'hsl(0deg 0% 100% / 76%)',
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
                </div>
            `,
                background: 'hsl(0deg 0% 100% / 76%)',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#007bff',
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    container: 'fondo-oscuro'
                }
            });
        }
    </script>
      <div class="userInfo">
    <!-- Nombre y apellido del usuario y rol -->
    <!-- Consultar datos del usuario -->
    <?php
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

</body>

</html>