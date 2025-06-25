<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);
ini_set('error_log', 'C:\xampp\htdocs\php_errors.log'); // Windows
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.php");
  exit();
}

// require_once $_SERVER['DOCUMENT_ROOT'] . '../html/verificar_permisos.php';

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
  die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

// ——————————————————————————————————————————————————————————
// 1) TRAER TODOS LOS PRODUCTOS (sin FILTROS ni PAGINACIÓN) 
// ——————————————————————————————————————————————————————————
$consulta = "SELECT 
  p.codigo1,
  p.codigo2, 
  p.nombre, 
  p.precio1, 
  p.precio2, 
  p.precio3, 
  p.cantidad, 
  p.Categoria_codigo    AS categoria_id,
  c.nombre              AS categoria,
  p.Marca_codigo        AS marca_id,
  m.nombre              AS marca,
  p.UnidadMedida_codigo AS unidad_id,
  u.nombre              AS unidadmedida,
  p.Ubicacion_codigo    AS ubicacion_id,
  ub.nombre             AS ubicacion,
  p.proveedor_nit       AS proveedor_id,
  pr.nombre             AS proveedor
FROM producto p
LEFT JOIN categoria c ON p.Categoria_codigo = c.codigo
LEFT JOIN marca m ON p.Marca_codigo = m.codigo
LEFT JOIN unidadmedida u ON p.UnidadMedida_codigo = u.codigo
LEFT JOIN ubicacion ub ON p.Ubicacion_codigo = ub.codigo
LEFT JOIN proveedor pr ON p.proveedor_nit = pr.nit
ORDER BY p.nombre ASC";

$resultado = mysqli_query($conexion, $consulta);
if (!$resultado) {
  die("Error en consulta: " . mysqli_error($conexion));
}

// Construimos un array PHP con TODAS las filas
$todosLosDatos = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
  $todosLosDatos[] = $fila;
}

// ——————————————————————————————————————————————————————————
// 2) ACTUALIZAR (POST) Y ELIMINAR (AJAX) SIN CAMBIOS
// ——————————————————————————————————————————————————————————

if (isset($_POST['codigo1'])) {
  $codigo1 = mysqli_real_escape_string($conexion, $_POST['codigo1']);
  $codigo2 = mysqli_real_escape_string($conexion, $_POST['codigo2']);
  $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
  $precio1 = mysqli_real_escape_string($conexion, $_POST['precio1']);
  $precio2 = mysqli_real_escape_string($conexion, $_POST['precio2']);
  $precio3 = mysqli_real_escape_string($conexion, $_POST['precio3']);
  $cantidad = mysqli_real_escape_string($conexion, $_POST['cantidad']);
  $categoria = mysqli_real_escape_string($conexion, $_POST['categoria-id']);
  $marca = mysqli_real_escape_string($conexion, $_POST['marca-id']);
  $unidadmedida = mysqli_real_escape_string($conexion, $_POST['unidadmedida-id']);
  $ubicacion = mysqli_real_escape_string($conexion, $_POST['ubicacion-id']);
  $proveedor = mysqli_real_escape_string($conexion, $_POST['proveedor-id']);

  $consulta_update = "UPDATE producto SET 
        codigo1 = '$codigo1', 
        codigo2 = '$codigo2', 
        nombre = '$nombre', 
        precio1 = '$precio1', 
        precio2 = '$precio2', 
        precio3 = '$precio3', 
        cantidad = '$cantidad', 
        Categoria_codigo = '$categoria', 
        Marca_codigo = '$marca', 
        UnidadMedida_codigo = '$unidadmedida', 
        Ubicacion_codigo = '$ubicacion', 
        Proveedor_nit = '$proveedor' 
        WHERE codigo1 = '$codigo1'";

  if (mysqli_query($conexion, $consulta_update)) {
    header("Location: listaproductos.php?actualizado=1");
    exit;
  } else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              title: '<span class=\"titulo-alerta error\">Error</span>',
              html: \`
                <div class=\"custom-alert\">
                  <div class=\"contenedor-imagen\">
                    <img src=\"../imagenes/llave.png\" alt=\"Error\" class=\"llave\">
                  </div>
                  <p>Error al actualizar los datos.</p>
                </div>
              \`,
              background: '#ffffffdb',
              confirmButtonText: 'Aceptar',
              confirmButtonColor: '#dc3545',
              customClass: {
                popup: 'swal2-border-radius',
                confirmButton: 'btn-aceptar',
                container: 'fondo-oscuro'
              }
            });
          });
        </script>";
  }
}

// Eliminación individual por AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'], $_POST['codigo'])) {
  header('Content-Type: application/json');

  if (!$conexion) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión']);
    exit;
  }

  $codigo = $_POST['codigo'];
  $stmt = $conexion->prepare("DELETE FROM producto WHERE codigo1 = ?");
  $stmt->bind_param("s", $codigo);

  if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
    exit;
  }

  if ($stmt->affected_rows === 0) {
    echo json_encode(['success' => false, 'error' => 'Producto no encontrado']);
    exit;
  }

  echo json_encode(['success' => true]);
  exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
?>

<?php if (isset($_GET['actualizado']) && $_GET['actualizado'] == 1): ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      Swal.fire({
        title: '<span class="titulo-alerta confirmacion">Éxito</span>',
        html: `
          <div class='alerta'>
              <div class='contenedor-imagen'>
                  <img src='../imagenes/moto.png' alt="Éxito" class='moto'>
              </div>
              <p>Los datos se actualizaron con éxito.</p>
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
    });
  </script>
<?php endif; ?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

  <title>Inventario</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>

  <link rel="stylesheet" href="../css/alertas.css">
  <link rel="stylesheet" href="../componentes/header.css">
  <script src="../js/header.js"></script>
  <script src="/js/index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    /* --- NUEVO: Animación para el modal de filtros --- */

    /* Estado base del popup de filtros */
    .filtros-popup {
      /* Forzamos que sea un bloque para poder animarlo.
       Esto sobreescribirá cualquier 'display: none' de un CSS externo. */
      display: block;

      /* Estado inicial: invisible, movido hacia arriba y no interactivo */
      opacity: 0;
      transform: translateY(-20px);
      pointer-events: none;
      visibility: hidden;
      /* Ocultamiento más robusto */

      /* La transición suave que queremos */
      transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out, visibility 0.3s;
      border: black solid 1px;
    }

    /* Estado activo: cuando el popup debe ser visible */
    .filtros-popup.active {
      opacity: 1;
      transform: translateY(0);
      pointer-events: auto;
      /* Se puede interactuar de nuevo */
      visibility: visible;
    }
    /* --- RESET BÁSICO Y ESTILOS GLOBALES --- */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* ================================================================== */
/* ESTILOS ORIGINALES (BASE PARA ESCRITORIO) CON LIGEROS AJUSTES      */
/* ================================================================== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-image: url("fondoMotoRacer.png"); /* Asegúrate de que esta ruta es correcta */
    background-size: cover;
    background-position: center;
    background-attachment: fixed; /* Mantiene el fondo quieto al hacer scroll */
    color: white;
}

/* Capa de oscurecimiento sobre el fondo */
body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: black;
    opacity: 0.6;
    z-index: -1;
}

/* Contenedor general de la página */
.container-general {
    display: flex; /* Usamos flexbox para el layout principal */
}

/* Barra lateral (tu #menu) */
.sidebar {
    width: 85px; /* Ancho inicial del menú */
    background-color: #0b111a; /* Un color de fondo para el menú */
    transition: width 0.3s ease;
    height: 100vh; /* Ocupa toda la altura */
    position: sticky; /* Se queda fijo al hacer scroll */
    top: 0;
    /* Aquí irían los estilos de tu menú real (#menu) */
}

.sidebar:hover {
    width: 270px; /* Ancho al pasar el mouse */
}

/* Contenido Principal */
.main-content {
    flex-grow: 1; /* Ocupa el resto del espacio */
    padding: 20px 40px;
    height: 100%;
    min-height: 100vh;
    background: rgb(211 210 210 / 84%);
    border-radius: 10px;
    margin: 20px;
    box-shadow: 0 4px 20px #0b111a;
}

.ubica {
    margin-bottom: 20px;
    font-size: 0.9em;
    color: #333;
}

h1 {
    color: white;
    text-align: center;
    margin-bottom: 30px;
    font-family: "Metal Mania", system-ui;
    font-size: 70px;
    text-shadow: 7px -1px 0 #1c51a0, 1px -1px 0 #1c51a0, -1px 1px 0 #1c51a0, 3px 5px 0 #1c51a0;
}

/* Barra superior con filtros y búsqueda */
.barra-superior {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
    flex-wrap: wrap; /* Permite que los elementos pasen a la siguiente línea si no caben */
}

.search-input {
    font-size: 16px;
    padding: 9px 15px;
    border-radius: 9px;
    border: 1px solid #ccc;
    width: 300px;
}

/* --- ESTILOS DE LA TABLA --- */
.table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto; /* La clave para el responsive de la tabla */
    -webkit-overflow-scrolling: touch; /* Scroll suave en iOS */
    border: 1px solid #ddd;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
}

#productTable {
    width: 100%;
    min-width: 1800px; /* Ancho mínimo para que todas las columnas se vean bien */
    border-collapse: collapse;
    color: #333; /* Texto oscuro para mejor lectura sobre fondo claro */
}

#productTable th,
#productTable td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: center;
    white-space: nowrap;
}

#productTable th {
    background-color: rgb(32, 69, 113);
    color: white;
    font-weight: bold;
    position: sticky; /* Cabecera pegajosa */
    top: 0;
}

#productTable td {
    background-color: #f9f9f9;
}
#productTable tbody tr:nth-child(even) td {
    background-color: #f1f1f1;
}
#productTable tbody tr:hover td {
    background-color: #e2e2e2;
}

.acciones button, #delete-selected {
    background: none; border: none; cursor: pointer; color: #555; font-size: 18px; margin: 0 5px;
}
.edit-button:hover { color: #007bff; }
.delete-button:hover, #delete-selected:hover { color: #dc3545; }

/* --- ESTILOS DEL MODAL DE EDICIÓN --- */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(4px);
    justify-content: center;
    align-items: center;
    padding: 20px;
}
.modal.show { display: flex; }

.modal-content {
    background-color: rgba(230, 230, 230, 0.95);
    width: 70%;
    max-width: 850px;
    padding: 30px;
    border-radius: 18px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
    position: relative;
    max-height: 90vh;
    overflow-y: auto;
}
.modal-content h2 { /* Estilos de tu h2 original */ }
.modal .close { position: absolute; top: 15px; right: 20px; font-size: 24px; cursor: pointer; color: #555; }

#editForm {
    display: grid;
    grid-template-columns: 1fr 1fr; /* Dos columnas por defecto */
    gap: 20px;
}
.campo { display: flex; flex-direction: column; }
.campo label { margin-bottom: 5px; color: #333; font-weight: bold; }
.campo input, .campo select { width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc; }
.modal-boton { grid-column: 1 / -1; text-align: right; } /* Ocupa todo el ancho */

/* --- Estilos de botones, paginación, etc. (Tomados de tu CSS) --- */
/* (Aquí irían los estilos de .btn-principal, .pagination-dinamica, .filtros-popup, etc. que no cambian mucho) */
.btn-principal, .btn-exportar, .btn-secundario {
    padding: 9px 15px; border-radius: 9px; border: none; cursor: pointer; font-weight: bold; color: white;
}
.btn-principal { background-color: #007bff; }
.btn-exportar { background-color: #1f5917; }
.btn-secundario { background-color: #6c757d; }

.pagination-dinamica { display: flex; justify-content: center; margin-top: 25px; gap: 8px; }
.pagination-dinamica button { /* Tus estilos de paginación */ }


/* ================================================================== */
/* AJUSTES RESPONSIVE PARA MÓVILES Y TABLETS                          */
/* ================================================================== */

/* Para pantallas de 992px o menos (Tablets y móviles) */
@media (max-width: 992px) {
    body {
        background-attachment: scroll; /* El fondo se mueve con el scroll en móvil */
    }
    
    .sidebar {
        display: none; /* Ocultamos el menú lateral para dar espacio */
    }

    .main-content {
        margin: 0; /* Eliminamos los márgenes para que ocupe todo */
        padding: 15px; /* Reducimos el padding */
        border-radius: 0; /* Sin bordes redondeados en la vista completa */
        min-height: 100vh;
    }

    h1 {
        font-size: 40px; /* Hacemos el título un poco más pequeño */
        text-shadow: 4px -1px 0 #1c51a0, 1px -1px 0 #1c51a0, -1px 1px 0 #1c51a0, 2px 3px 0 #1c51a0;
    }

    /* Barra superior adaptable */
    .barra-superior {
        flex-direction: column; /* Apilamos los elementos */
        align-items: stretch; /* Hacemos que ocupen todo el ancho */
        gap: 10px;
    }
    .barra-superior .search-input,
    .barra-superior .export-form,
    .barra-superior button {
        width: 100%; /* Ancho completo para fácil acceso */
    }

    /* Filtros popup */
    .filtros-popup .filtros-container {
        flex-direction: column;
    }

    /* Modal de edición adaptable */
    .modal-content {
        width: 95%; /* Ocupa casi todo el ancho de la pantalla */
        padding: 20px;
    }

    #editForm {
        grid-template-columns: 1fr; /* UNA sola columna para los campos del formulario */
    }
    .modal-boton {
        text-align: center; /* Centramos el botón de guardar */
    }
    #modal-boton {
        width: 100%; /* El botón ocupa todo el ancho */
    }
}
  </style>
</head>

<body>
    <div id="menu"></div>
   <div class="container-general">
        <div class="sidebar">
            </div>
        <div class="main-content">
            <div class="ubica">Inventario / Lista de Productos</div>
            <h1>Inventario</h1>

            <div class="barra-superior">
                <button id="filtros-btn" class="btn-principal"><i class="fas fa-filter"></i> Mostrar Filtros</button>
                <input type="text" id="searchRealtime" class="search-input" placeholder="Buscar en resultados..." autocomplete="off">
                <form action="exportar_excel.php" method="post" class="export-form">
                    <button type="submit" class="btn-exportar" aria-label="Exportar a Excel" title="Exportar a Excel">
                        <i class="fas fa-file-excel"></i><span> Exportar</span>
                    </button>
                </form>
            </div>

            <div id="filtros-popup" class="filtros-popup">
                <div class="filtros-container">
                    <div class="filtro">
                        <button class="filtro-titulo">Categorías <i class="fa fa-chevron-down"></i></button>
                        <div class="filtro-opciones">
                            <?php $resCat = mysqli_query($conexion, "SELECT codigo, nombre FROM categoria ORDER BY nombre");
                            while ($cat = mysqli_fetch_assoc($resCat)): ?>
                            <label><input type="checkbox" name="filtrosCat[]" value="<?= htmlspecialchars($cat['codigo']) ?>"> <?= htmlspecialchars($cat['nombre']) ?></label>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <div class="filtro">
                        <button class="filtro-titulo">Marcas <i class="fa fa-chevron-down"></i></button>
                        <div class="filtro-opciones">
                             <?php $resMar = mysqli_query($conexion, "SELECT codigo, nombre FROM marca ORDER BY nombre");
                             while ($mar = mysqli_fetch_assoc($resMar)): ?>
                            <label><input type="checkbox" name="filtrosMarca[]" value="<?= htmlspecialchars($mar['codigo']) ?>"> <?= htmlspecialchars($mar['nombre']) ?></label>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <div class="filtro">
                        <button class="filtro-titulo">Ubicaciones <i class="fa fa-chevron-down"></i></button>
                        <div class="filtro-opciones">
                            <?php $resUb = mysqli_query($conexion, "SELECT codigo, nombre FROM ubicacion ORDER BY nombre");
                            while ($ub = mysqli_fetch_assoc($resUb)): ?>
                            <label><input type="checkbox" name="filtrosUbic[]" value="<?= htmlspecialchars($ub['codigo']) ?>"> <?= htmlspecialchars($ub['nombre']) ?></label>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <div class="filtro">
                        <button class="filtro-titulo">Proveedores <i class="fa fa-chevron-down"></i></button>
                        <div class="filtro-opciones">
                            <?php $resProv = mysqli_query($conexion, "SELECT nit, nombre FROM proveedor ORDER BY nombre");
                            while ($prov = mysqli_fetch_assoc($resProv)): ?>
                            <label><input type="checkbox" name="filtrosProv[]" value="<?= htmlspecialchars($prov['nit']) ?>"> <?= htmlspecialchars($prov['nombre']) ?></label>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <div class="filtro clear-btn">
                        <button id="btnClear" class="btn-secundario">Limpiar Filtros</button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="productTable">
                    <thead>
                        <tr>
                            <th data-col="0">Código<span class="sort-arrow"></span></th>
                            <th data-col="1">Código 2<span class="sort-arrow"></span></th>
                            <th data-col="2">Nombre<span class="sort-arrow"></span></th>
                            <th data-col="3">Precio 1<span class="sort-arrow"></span></th>
                            <th data-col="4">Precio 2<span class="sort-arrow"></span></th>
                            <th data-col="5">Precio 3<span class="sort-arrow"></span></th>
                            <th data-col="6">Cantidad<span class="sort-arrow"></span></th>
                            <th data-col="7">Categoría<span class="sort-arrow"></span></th>
                            <th data-col="8">Marca<span class="sort-arrow"></span></th>
                            <th data-col="9">Clase<span class="sort-arrow"></span></th>
                            <th data-col="10">Ubicación<span class="sort-arrow"></span></th>
                            <th data-col="11">Proveedor<span class="sort-arrow"></span></th>
                            <th>Acciones</th>
                            <th>
                                <button id="delete-selected" class="btn-icon-danger" style="display: none;" title="Eliminar seleccionados">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        </tbody>
                </table>
            </div>

            <div id="paginationContainer" class="pagination-dinamica"></div>
        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <button class="close"><i class="fa-solid fa-x"></i></button>
            <h2>Editar Producto</h2>
            <form id="editForm" method="post" action="listaproductos.php">
                <input type="hidden" id="editCodigo1" name="codigo1">
                <div class="campo">
                    <label for="editCodigo1Visible">Código:</label>
                    <input type="text" id="editCodigo1Visible" disabled>
                </div>
                <div class="campo">
                    <label for="editCodigo2">Código 2:</label>
                    <input type="text" id="editCodigo2" name="codigo2" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                <div class="campo">
                    <label class="required" for="editNombre">Nombre:</label>
                    <input type="text" id="editNombre" name="nombre" required>
                </div>
                <div class="campo">
                    <label class="required" for="editPrecio1">Precio 1:</label>
                    <input type="text" id="editPrecio1" name="precio1" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                </div>
                <div class="campo">
                    <label class="required" for="editPrecio2">Precio 2:</label>
                    <input type="text" id="editPrecio2" name="precio2" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                </div>
                <div class="campo">
                    <label class="required" for="editPrecio3">Precio 3:</label>
                    <input type="text" id="editPrecio3" name="precio3" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                </div>
                <div class="campo">
                    <label class="required" for="editCantidad">Cantidad:</label>
                    <input type="text" id="editCantidad" name="cantidad" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                </div>
                <div class="campo">
                    <label class="required" for="editCategoria">Categoría:</label>
                    <select name="categoria-id" id="editCategoria" required>
                        <option value="">Seleccione una categoría</option>
                        <?php
                        $resultadoCategorias = mysqli_query($conexion, "SELECT codigo, nombre FROM categoria ORDER BY nombre");
                        while ($filaCategoria = mysqli_fetch_assoc($resultadoCategorias)) {
                            echo "<option value='" . htmlspecialchars($filaCategoria['codigo']) . "'>" . htmlspecialchars($filaCategoria['nombre']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="campo">
                    <label class="required" for="editMarca">Marca:</label>
                    <select name="marca-id" id="editMarca" required>
                        <option value="">Seleccione una marca</option>
                        <?php
                        $resultadoMarcas = mysqli_query($conexion, "SELECT codigo, nombre FROM marca ORDER BY nombre");
                        while ($filaMarca = mysqli_fetch_assoc($resultadoMarcas)) {
                            echo "<option value='" . htmlspecialchars($filaMarca['codigo']) . "'>" . htmlspecialchars($filaMarca['nombre']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="campo">
                    <label class="required" for="editUnidadMedida">Clase:</label>
                    <select name="unidadmedida-id" id="editUnidadMedida" required>
                        <option value="">Seleccione una clase</option>
                        <?php
                        $resultadoUnidadesMedidas = mysqli_query($conexion, "SELECT codigo, nombre FROM unidadmedida ORDER BY nombre");
                        while ($filaUnidadMedida = mysqli_fetch_assoc($resultadoUnidadesMedidas)) {
                            echo "<option value='" . htmlspecialchars($filaUnidadMedida['codigo']) . "'>" . htmlspecialchars($filaUnidadMedida['nombre']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="campo">
                    <label class="required" for="editUbicacion">Ubicación:</label>
                    <select name="ubicacion-id" id="editUbicacion" required>
                        <option value="">Seleccione una ubicación</option>
                        <?php
                        $resultadoUbicaciones = mysqli_query($conexion, "SELECT codigo, nombre FROM ubicacion ORDER BY nombre");
                        while ($filaUbicacion = mysqli_fetch_assoc($resultadoUbicaciones)) {
                           echo "<option value='" . htmlspecialchars($filaUbicacion['codigo']) . "'>" . htmlspecialchars($filaUbicacion['nombre']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="campo">
                    <label class="required" for="editProveedor">Proveedor:</label>
                    <select name="proveedor-id" id="editProveedor" required>
                         <option value="">Seleccione un proveedor</option>
                        <?php
                        $resultadoProveedores = mysqli_query($conexion, "SELECT nit, nombre FROM proveedor ORDER BY nombre");
                        while ($filaProveedor = mysqli_fetch_assoc($resultadoProveedores)) {
                            echo "<option value='" . htmlspecialchars($filaProveedor['nit']) . "'>" . htmlspecialchars($filaProveedor['nombre']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="modal-boton">
                    <button type="submit" id="modal-boton" class="btn-principal">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

  <!-- —————————————————————————————————————————————————————————— -->
  <!-- 3) SCRIPT DE JAVASCRIPT: paginación / filtrado / ordenamiento / selección -->
  <!-- —————————————————————————————————————————————————————————— -->
  <script>
    const selectedProductIds = new Set();
    // — sub‑dropdown toggle
    document.querySelectorAll('.filtro-titulo').forEach(btn => {
      btn.addEventListener('click', e => {
        const parent = btn.parentElement;
        parent.classList.toggle('active');
        // cierra los demás
        document.querySelectorAll('.filtro').forEach(f => {
          if (f !== parent) f.classList.remove('active');
        });
      });
    });

    // cierra si clic fuera
    document.addEventListener('click', e => {
      if (!e.target.closest('.filtro')) {
        document.querySelectorAll('.filtro').forEach(f => f.classList.remove('active'));
      }
    });
    // Convertimos el array PHP $todosLosDatos a JSON para JS
    const allData = <?php echo json_encode($todosLosDatos, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;

    // Variables de estado para paginación y filtrado
    let filteredData = [...allData];
    const rowsPerPage = 10;
    let currentPage = 1;

    const tableBody = document.querySelector('#productTable tbody');
    const paginationContainer = document.getElementById('paginationContainer');
    const inputBusqueda = document.getElementById('searchRealtime');

    // Devuelve el valor “limpio” de una fila según criterio
    function getFieldValue(rowObj, criterion) {
      switch (criterion) {
        case 'codigo1':
          return rowObj.codigo1.toString().toLowerCase();
        case 'codigo2':
          return rowObj.codigo2.toString().toLowerCase();
        case 'nombre':
          return rowObj.nombre.toLowerCase();
        case 'precio1':
          return rowObj.precio1.toString().toLowerCase();
        case 'precio2':
          return rowObj.precio2.toString().toLowerCase();
        case 'precio3':
          return rowObj.precio3.toString().toLowerCase();
        case 'categoria':
          return rowObj.categoria.toLowerCase();
        case 'marca':
          return rowObj.marca.toLowerCase();
        case 'ubicacion':
          return rowObj.ubicacion.toLowerCase();
        case 'proveedor':
          return rowObj.proveedor.toLowerCase();
        default:
          return '';
      }
    }

    // Función para ordenar filteredData por columna
    function getCellValueForSort(rowObj, colIndex) {
      switch (colIndex) {
        case 0:
          return rowObj.codigo1.toLowerCase();
        case 1:
          return rowObj.codigo2.toLowerCase();
        case 2:
          return rowObj.nombre.toLowerCase();
        case 3:
          return parseFloat(rowObj.precio1) || 0;
        case 4:
          return parseFloat(rowObj.precio2) || 0;
        case 5:
          return parseFloat(rowObj.precio3) || 0;
        case 6:
          return parseFloat(rowObj.cantidad) || 0;
        case 7:
          return rowObj.descripcion.toLowerCase();
        case 8:
          return rowObj.categoria.toLowerCase();
        case 9:
          return rowObj.marca.toLowerCase();
        case 10:
          return rowObj.unidadmedida.toLowerCase();
        case 11:
          return rowObj.ubicacion.toLowerCase();
        case 12:
          return rowObj.proveedor.toLowerCase();
        default:
          return '';
      }
    }

    function sortData(colIndex, asc = true) {
      filteredData.sort((a, b) => {
        const valA = getCellValueForSort(a, colIndex);
        const valB = getCellValueForSort(b, colIndex);
        if (valA < valB) return asc ? -1 : 1;
        if (valA > valB) return asc ? 1 : -1;
        return 0;
      });
    }

    // Renderiza la tabla según página actual
    function renderTable() {
      const start = (currentPage - 1) * rowsPerPage;
      const end = start + rowsPerPage;
      const pageData = filteredData.slice(start, end);

      tableBody.innerHTML = '';
      pageData.forEach(rowObj => {
        const tr = document.createElement('tr');

        // 1) Código
        let td = document.createElement('td');
        td.textContent = rowObj.codigo1;
        tr.appendChild(td);

        // 2) Código 2
        td = document.createElement('td');
        td.textContent = rowObj.codigo2;
        tr.appendChild(td);

        // 3) Nombre
        td = document.createElement('td');
        td.textContent = rowObj.nombre;
        tr.appendChild(td);

        // 5) Precio 1
        td = document.createElement('td');
        td.textContent = rowObj.precio1;
        tr.appendChild(td);

        // 6) Precio 2
        td = document.createElement('td');
        td.textContent = rowObj.precio2;
        tr.appendChild(td);

        // 7) Precio 3
        td = document.createElement('td');
        td.textContent = rowObj.precio3;
        tr.appendChild(td);

        // 8) Cantidad
        td = document.createElement('td');
        td.textContent = rowObj.cantidad;
        tr.appendChild(td);

        // 10) Categoría
        td = document.createElement('td');
        td.textContent = rowObj.categoria;
        td.setAttribute('data-categoria-id', rowObj.categoria_id);
        tr.appendChild(td);

        // 11) Marca
        td = document.createElement('td');
        td.textContent = rowObj.marca;
        td.setAttribute('data-marca-id', rowObj.marca_id);
        tr.appendChild(td);

        // 12) Clase (unidadmedida)
        td = document.createElement('td');
        td.textContent = rowObj.unidadmedida;
        td.setAttribute('data-unidadmedida-id', rowObj.unidad_id);
        tr.appendChild(td);

        // 13) Ubicación
        td = document.createElement('td');
        td.textContent = rowObj.ubicacion;
        td.setAttribute('data-ubicacion-id', rowObj.ubicacion_id);
        tr.appendChild(td);

        // 14) Proveedor
        td = document.createElement('td');
        td.textContent = rowObj.proveedor;
        td.setAttribute('data-proveedor-id', rowObj.proveedor_id);
        tr.appendChild(td);

        // 15) Acciones (editar / eliminar individual)
        td = document.createElement('td');
        td.classList.add('acciones');
        // Botón editar
        const btnEdit = document.createElement('button');
        btnEdit.className = 'edit-button';
        btnEdit.setAttribute('data-id', rowObj.codigo1);
        btnEdit.innerHTML = "<i class='fa-solid fa-pen-to-square'></i>";
        td.appendChild(btnEdit);
        // Botón eliminar
        const btnDelete = document.createElement('button');
        btnDelete.className = 'delete-button';
        btnDelete.setAttribute('onclick', `eliminarProducto('${rowObj.codigo1}')`);
        btnDelete.innerHTML = "<i class='fa-solid fa-trash'></i>";
        td.appendChild(btnDelete);
        tr.appendChild(td);

        // 16) Checkbox selección múltiple
        td = document.createElement('td');
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.className = 'select-product';
        checkbox.value = rowObj.codigo1;
        if (selectedProductIds.has(rowObj.codigo1)) {
          checkbox.checked = true;
        }
        td.appendChild(checkbox);
        tr.appendChild(td);

        // Resaltar fila al clic
        //tr.addEventListener('click', () => {
        // tr.classList.toggle('selected');
        //});

        tableBody.appendChild(tr);
      });

      renderPaginationControls();
      attachEditButtonListeners();
      attachCheckboxListeners();
    }

    // Renderiza los botones de paginación
    function renderPaginationControls() {
      paginationContainer.innerHTML = '';
      const totalPages = Math.ceil(filteredData.length / rowsPerPage);
      if (totalPages <= 1) return;

      // « Primera
      const btnFirst = document.createElement('button');
      btnFirst.textContent = '« Primera';
      btnFirst.disabled = (currentPage === 1);
      btnFirst.addEventListener('click', () => {
        currentPage = 1;
        renderTable();
      });
      if (currentPage === 1) btnFirst.classList.add('active');
      paginationContainer.appendChild(btnFirst);

      // ‹ Anterior
      const btnPrev = document.createElement('button');
      btnPrev.textContent = '‹ Anterior';
      btnPrev.disabled = (currentPage === 1);
      btnPrev.addEventListener('click', () => {
        if (currentPage > 1) currentPage--;
        renderTable();
      });
      if (currentPage === 1) btnPrev.classList.add('active');
      paginationContainer.appendChild(btnPrev);

      // Números de página (hasta 5 alrededor)
      let startPage = Math.max(1, currentPage - 2);
      let endPage = Math.min(totalPages, currentPage + 2);
      if (currentPage <= 2) {
        endPage = Math.min(5, totalPages);
      }
      if (currentPage >= totalPages - 1) {
        startPage = Math.max(1, totalPages - 4);
      }

      if (startPage > 1) {
        const ellipsis = document.createElement('button');
        ellipsis.textContent = '…';
        ellipsis.disabled = true;
        paginationContainer.appendChild(ellipsis);
      }

      for (let i = startPage; i <= endPage; i++) {
        const btnPage = document.createElement('button');
        btnPage.textContent = i;
        if (i === currentPage) btnPage.classList.add('active');
        btnPage.addEventListener('click', () => {
          currentPage = i;
          renderTable();
        });
        paginationContainer.appendChild(btnPage);
      }

      if (endPage < totalPages) {
        const ellipsis2 = document.createElement('button');
        ellipsis2.textContent = '…';
        ellipsis2.disabled = true;
        paginationContainer.appendChild(ellipsis2);
      }

      // Siguiente ›
      const btnNext = document.createElement('button');
      btnNext.textContent = 'Siguiente ›';
      btnNext.disabled = (currentPage === totalPages);
      btnNext.addEventListener('click', () => {
        if (currentPage < totalPages) currentPage++;
        renderTable();
      });
      if (currentPage === totalPages) btnNext.classList.add('active');
      paginationContainer.appendChild(btnNext);

      // Última »
      const btnLast = document.createElement('button');
      btnLast.textContent = 'Última »';
      btnLast.disabled = (currentPage === totalPages);
      btnLast.addEventListener('click', () => {
        currentPage = totalPages;
        renderTable();
      });
      if (currentPage === totalPages) btnLast.classList.add('active');
      paginationContainer.appendChild(btnLast);
    }

    // función de filtrado (tú ya la tienes, aquí solo agregas lectura de checks)
    function applyFilter() {
      const q = document.getElementById('searchRealtime').value.trim().toLowerCase();
      const selCats = Array.from(document.querySelectorAll('input[name="filtrosCat[]"]:checked')).map(cb => cb.value);
      const selMarcas = Array.from(document.querySelectorAll('input[name="filtrosMarca[]"]:checked')).map(cb => cb.value);
      const selUbics = Array.from(document.querySelectorAll('input[name="filtrosUbic[]"]:checked')).map(cb => cb.value);
      const selProvs = Array.from(document.querySelectorAll('input[name="filtrosProv[]"]:checked')).map(cb => cb.value);

      filteredData = allData.filter(item => {
        // búsqueda global
        const comp = (
          item.codigo1 + ' ' +
          item.codigo2 + ' ' +
          item.nombre + ' ' +
          item.categoria + ' ' +
          item.marca + ' ' +
          item.ubicacion + ' ' +
          item.proveedor
        ).toLowerCase();
        if (!comp.includes(q)) return false;

        if (selCats.length && !selCats.includes(item.categoria_id)) return false;
        if (selMarcas.length && !selMarcas.includes(item.marca_id)) return false;
        if (selUbics.length && !selUbics.includes(item.ubicacion_id)) return false;
        if (selProvs.length && !selProvs.includes(item.proveedor_id)) return false;

        return true;
      });

      currentPage = 1;
      renderTable();
    }

    // listeners
    document.getElementById('searchRealtime')
      .addEventListener('input', applyFilter);

    document.querySelectorAll(
      'input[name="filtrosCat[]"], ' +
      'input[name="filtrosMarca[]"], ' +
      'input[name="filtrosUbic[]"], ' +
      'input[name="filtrosProv[]"]'
    ).forEach(cb => cb.addEventListener('change', applyFilter));

    // limpiar
    document.getElementById('btnClear').addEventListener('click', () => {
      document.querySelectorAll(
        'input[name="filtrosCat[]"], ' +
        'input[name="filtrosMarca[]"], ' +
        'input[name="filtrosUbic[]"], ' +
        'input[name="filtrosProv[]"]'
      ).forEach(cb => cb.checked = false);
      document.getElementById('searchRealtime').value = '';
      applyFilter();
    });
    // ============================================================
    // 4) ORDENAMIENTO POR COLUMNAS: clic en <th>
    // ============================================================
    document.addEventListener('DOMContentLoaded', function() {
      const thead = document.querySelector('#productTable thead');
      const sortStates = {};

      thead.querySelectorAll('th').forEach(th => {
        const colIndex = parseInt(th.getAttribute('data-col'), 10);
        const type = th.getAttribute('data-type');
        if (!type || type === 'none') return;

        sortStates[colIndex] = true; // ascendente inicial

        th.addEventListener('click', () => {
          sortStates[colIndex] = !sortStates[colIndex];
          sortData(colIndex, sortStates[colIndex]);

          // Limpiar flechas de otros encabezados
          thead.querySelectorAll('th .sort-arrow').forEach(span => {
            span.textContent = '';
          });
          // Poner flecha en el clicado
          th.querySelector('.sort-arrow').textContent = sortStates[colIndex] ? '▲' : '▼';

          renderTable();
        });
      });
    });

    // ============================================================
    // 5) RESALTADO DE FILA: listener en cada <tr>
    // ============================================================
    //function attachRowHighlightListeners() {
    //  const rows = document.querySelectorAll('#productTable tbody tr');
    //  rows.forEach(row => {
    //    row.addEventListener('click', () => {
    //      row.classList.toggle('selected');
    //    });
    //  });
    //}

    // ============================================================
    // 6) SELECCIÓN MÚLTIPLE: activar botón Eliminar Múltiple
    // ============================================================
    function attachCheckboxListeners() {
      // Recolectamos checkboxes y botón de cabecera
      const checkboxes = document.querySelectorAll(".select-product");
      const deleteBtn = document.getElementById("delete-selected");

      // Cada vez que cambie cualquier checkbox, actualizamos visibilidad
      checkboxes.forEach(cb => {
        cb.addEventListener("change", () => {
          const id = cb.value;
          if (cb.checked) {
            selectedProductIds.add(id);
          } else {
            selectedProductIds.delete(id);
          }
          // persistir (opcional)

          // y actualizar visibilidad del botón
          toggleDeleteButtonVisibility();
        });
      });
      // Inicializamos estado al cargar
      toggleDeleteButtonVisibility();

      // Al hacer clic en eliminar seleccionados...
      deleteBtn.addEventListener("click", () => {
        const selected = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);
        if (selected.length < 2) return; // redundante, pero seguro

        Swal.fire({
          title: '<span class="titulo-alerta advertencia">¿Eliminar seleccionados?</span>',
          html: `
          <div class="custom-alert">
                <div class="contenedor-imagen">
                    <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                </div>
          <p>Se eliminarán ${selected.length} productos.</p>
          </div>`,
          background: '#ffffffdb',
          showCancelButton: true,
          confirmButtonText: "Sí, eliminar",
          cancelButtonText: "Cancelar",
          customClass: {
            popup: "custom-alert",
            confirmButton: "btn-eliminar",
            cancelButton: "btn-cancelar",
            container: 'fondo-oscuro'
          }
        }).then(result => {
          if (!result.isConfirmed) return;
          // tu fetch a eliminar_productos.php con { codigos: selected }
          fetch("eliminar_productos.php", {
              method: "POST",
              headers: {
                "Content-Type": "application/json"
              },
              body: JSON.stringify({
                codigos: selected
              })
            })
            .then(r => r.json())
            .then(data => {
              if (data.success) {
                Swal.fire({
                    title: '<span class="titulo-alerta confirmacion">Éxito</span>',
                    html: `
          <div class="custom-alert">
                <div class="contenedor-imagen">
                    <img src="../imagenes/moto.png" alt="Confirmacion" class="moto">
                </div>
          <p>Los proveedores se eliminaron correctamente.</p>
          </div>`,
                    background: '#ffffffdb',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#007bff',
                    customClass: {
                      popup: 'swal2-border-radius',
                      confirmButton: 'btn-aceptar',
                      container: 'fondo-oscuro'
                    }
                  })
                  .then(() => location.reload());
              } else {
                Swal.fire("Error", data.error || "No se pudo eliminar.", "error");
              }
            })
            .catch(() => Swal.fire("Error", "Fallo comunicación.", "error"));
        });
      });
    }

    function toggleDeleteButtonVisibility() {
      const checkedCount = document.querySelectorAll(".select-product:checked").length;
      const deleteBtn = document.getElementById("delete-selected");
      // Mostramos solo si hay 2 o más
      deleteBtn.style.display = checkedCount >= 2 ? "inline-block" : "none";
    }

    // ============================================================
    // 7) MÓDULO DE EDICIÓN: animación drop-in / drop-out
    // ============================================================

    // — Funciones genéricas para animar modales —
    function openModal(modalEl) {
      modalEl.classList.add('show');
      void modalEl.offsetWidth; // fuerza reflow
      modalEl.classList.add('opening');
    }

    function closeModal(modalEl) {
      modalEl.classList.remove('opening');
      modalEl.classList.add('closing');
      const content = modalEl.querySelector('.modal-content');
      content.addEventListener('transitionend', function handler() {
        content.removeEventListener('transitionend', handler);
        modalEl.classList.remove('show', 'closing');
      });
    }

    // — Selección del modal de edición y su botón “×” —
    const editModal = document.getElementById('editModal');
    const editCloseBtn = editModal.querySelector('.close');

    // Cerrar al hacer clic en la “X”
    editCloseBtn.addEventListener('click', () => closeModal(editModal));

    // Cerrar al hacer clic fuera del contenido
    editModal.addEventListener('click', e => {
      if (e.target === editModal) closeModal(editModal);
    });

    // — Adjuntar listeners a los botones editar —
    function attachEditButtonListeners() {
      const editButtons = document.querySelectorAll('.edit-button');

      editButtons.forEach(button => {
        button.addEventListener('click', function(e) {
          e.stopPropagation();
          const row = this.closest('tr');
          // Rellenas los campos…
          document.getElementById('editCodigo1').value = row.cells[0].innerText.trim();
          document.getElementById('editCodigo1Visible').value = row.cells[0].innerText.trim();
          document.getElementById('editCodigo2').value = row.cells[1].innerText.trim();
          document.getElementById('editNombre').value = row.cells[2].innerText.trim();
          document.getElementById('editPrecio1').value = row.cells[3].innerText.trim();
          document.getElementById('editPrecio2').value = row.cells[4].innerText.trim();
          document.getElementById('editPrecio3').value = row.cells[5].innerText.trim();
          document.getElementById('editCantidad').value = row.cells[6].innerText.trim();
          document.getElementById('editCategoria').value = row.cells[7].getAttribute('data-categoria-id');
          document.getElementById('editMarca').value = row.cells[8].getAttribute('data-marca-id');
          document.getElementById('editUnidadMedida').value = row.cells[9].getAttribute('data-unidadmedida-id');
          document.getElementById('editUbicacion').value = row.cells[10].getAttribute('data-ubicacion-id');
          document.getElementById('editProveedor').value = row.cells[11].getAttribute('data-proveedor-id');

          // EN LUGAR DE modal.style.display = 'block';
          openModal(editModal);
        });
      });
    }
    // ============================================================
    // 8) ELIMINACIÓN INDIVIDUAL: SweetAlert2 + AJAX
    // ============================================================
    function eliminarProducto(codigo) {
      Swal.fire({
        title: '<span class="titulo-alerta advertencia">¿Estás Seguro?</span>',
        html: `
            <div class="custom-alert">
                <div class="contenedor-imagen">
                    <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                </div>
                <p>¿Quieres eliminar el producto <strong>${codigo}</strong>?</p>
            </div>
        `,
        background: '#ffffffdb',
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
        customClass: {
          popup: "custom-alert",
          confirmButton: "btn-eliminar",
          cancelButton: "btn-cancelar",
          container: 'fondo-oscuro'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          fetch('listaproductos.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              },
              body: `eliminar=1&codigo=${encodeURIComponent(codigo)}`
            })
            .then(response => {
              if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
              return response.json();
            })
            .then(data => {
              if (data.success) {
                Swal.fire({
                  title: '<span class="titulo-alerta confirmacion">Producto Eliminado</span>',
                  html: `
                            <div class="custom-alert">
                                <div class="contenedor-imagen">
                                    <img src="../imagenes/moto.png" alt="Confirmación" class="moto">
                                </div>
                                 <p>El producto <strong>${codigo}</strong> ha sido eliminado correctamente.</p>
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
                }).then(() => {
                  location.reload();
                });
              } else {
                Swal.fire("Error", data.error || "No se pudo completar la eliminación", "error");
              }
            })
            .catch(error => {
              console.error('Error:', error);
              Swal.fire("Error", "Error al conectar con el servidor", "error");
            });
        }
      });
    }

    // ============================================================
    // 9) CERRAR DROPDOWN SI SE HACE CLIC FUERA
    // ============================================================
    document.addEventListener('click', function(event) {
      const filterDropdown = document.querySelector('.filter-dropdown');
      if (filterDropdown.hasAttribute('open') && !filterDropdown.contains(event.target)) {
        filterDropdown.removeAttribute('open');
      }
    });

    // ============================================================
    // 10) INICIALIZACIÓN: aplicamos ordenamiento, filtrado y paginación
    // ============================================================
    document.addEventListener('DOMContentLoaded', function() {
      // Al cargar, pintamos la primera página
      renderTable();

      // Al escribir en el input de búsqueda en tiempo real
      inputBusqueda.addEventListener('input', function() {
        applyFilter();
      });
    });
    document.getElementById('filtros-btn').onclick = function() {
      document.getElementById('filtros-popup').classList.toggle('active');
    };
    // Cierra el popup al hacer clic fuera
    document.addEventListener('click', function(event) {
      const popup = document.getElementById('filtros-popup');
      const btn = document.getElementById('filtros-btn');
      if (popup.classList.contains('active') && !popup.contains(event.target) && event.target !== btn) {
        popup.classList.remove('active');
      }
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