<?php
ini_set('display_errors',  1);
ini_set('log_errors', 1);
error_reporting(E_ALL);
ini_set('error_log', 'C:\xampp\htdocs\php_errors.log');
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}



$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

// Inicializar el arreglo de filtros
$filtros = [];
$valor = isset($_GET['valor']) ? mysqli_real_escape_string($conexion, $_GET['valor']) : '';

if (!empty($valor) && isset($_GET['criterios']) && is_array($_GET['criterios'])) {
    $criterios = $_GET['criterios'];
    foreach ($criterios as $criterio) {
        $criterio = mysqli_real_escape_string($conexion, $criterio);
        switch ($criterio) {
            case 'codigo':
                $filtros[] = "codigo LIKE '%$valor%'";
                break;
            case 'identificacion':
                $filtros[] = "identificacion LIKE '%$valor%'";
                break;
            case 'nombre':
                $filtros[] = "nombre LIKE '%$valor%'";
                break;
            case 'apellido':
                $filtros[] = "apellido LIKE '%$valor%'";
                break;
            case 'telefono':
                $filtros[] = "telefono LIKE '%$valor%'";
                break;
            case 'correo':
                $filtros[] = "correo LIKE '%$valor%'";
                break;
        }
    }
}

$consulta = "SELECT * FROM cliente WHERE 1=1";

if (!empty($filtros)) {
    $consulta .= " AND (" . implode(" OR ", $filtros) . ")";
}

$resultado = mysqli_query($conexion, $consulta);

if (!$resultado) {
    die("No se pudo ejecutar la consulta: " . mysqli_error($conexion));
}

// Actualización de datos
if (isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conexion, $_POST['id']);
    $identificacion = mysqli_real_escape_string($conexion, $_POST['identificacion']);
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);

    $consulta_update = "UPDATE cliente SET 
        identificacion = '$identificacion',
        nombre = '$nombre',
        apellido = '$apellido',
        telefono = '$telefono',
        correo = '$correo'
        WHERE codigo = '$id'";

    if (mysqli_query($conexion, $consulta_update)) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: `<span class='titulo'>Datos Actualizados</span>`,
                        html: `
                            <div class='alerta'>
                                <div class='contenedor-imagen'>
                                    <img src='../imagenes/moto.png' class='moto'>
                                </div>
                                <p>Los datos se actualizaron con éxito.</p>
                            </div>
                        `,
                        showConfirmButton: true,
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            confirmButton: 'btn-aceptar' // Clase personalizada para el botón de aceptar
                        }
                    }).then(() => {
                        window.location.href = 'listaclientes.php'; // Redirige después de cerrar el alert
                    });
                });
            </script>";
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                                  document.addEventListener('DOMContentLoaded', function() {
                                      Swal.fire({
                                title: '<span class=\"titulo\">Error</span>',
                                  html: `
                                      <div class='alerta'>
                                          <div class='contenedor-imagen'>
                                              <img src='../imagenes/llave.png' class='llave'>
                                          </div>
                                          <p>Error al actualizar los datos.</p>
                                      </div>
                                  `,
                                  showConfirmButton: true,
                                  confirmButtonText: 'Aceptar',
                                  customClass: {
                                      confirmButton: 'btn-aceptar'  // Clase personalizada para el botón de aceptar
                                  }
                              } );
                                          });
                                          </script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'], $_POST['codigo'])) {
    header('Content-Type: application/json');

    $codigo = $_POST['codigo'];
    $stmt = $conexion->prepare("DELETE FROM cliente WHERE codigo = ?");
    $stmt->bind_param("s", $codigo);

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
        exit;
    }

    if ($stmt->affected_rows === 0) {
        echo json_encode(['success' => false, 'error' => 'Cliente no encontrado']);
        exit;
    }

    echo json_encode(['success' => true]);
    exit;

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Parámetros POST inválidos']);
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inventario</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <link rel="stylesheet" href="../css/clientes.css" />
    <link rel="stylesheet" href="../componentes/header.css">
    <link rel="stylesheet" href="../componentes/header.php">
    <script src="../js/header.js"></script>
    <script src="/js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="sidebar">
        <div id="menu"></div>
    </div>

    <div class="main-content">
        <h1>Clientes</h1>
        <div class="filter-bar">
            <!-- Filtros adaptados -->
            <details class="filter-dropdown">
                <summary class="filter-button">Filtrar</summary>
                <div class="filter-options">
                    <form method="GET" action="../html/listaclientes.php" class="search-form">
                        <div class="criteria-group">
                            <label><input type="checkbox" name="criterios[]" value="codigo"> Código</label>
                            <label><input type="checkbox" name="criterios[]" value="identificacion"> Identificación</label>
                            <label><input type="checkbox" name="criterios[]" value="nombre"> Nombre</label>
                            <label><input type="checkbox" name="criterios[]" value="apellido"> Apellido</label>
                            <label><input type="checkbox" name="criterios[]" value="telefono"> Teléfono</label>
                            <label><input type="checkbox" name="criterios[]" value="correo"> Correo</label>
                        </div>
                </div>
            </details>
            <input class="form-control" type="text" name="valor" placeholder="Ingrese el valor a buscar">
            <button class="search-button" type="submit">Buscar</button>
            </form>
        </div>

        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Identificación</th>
                        <th>Tipo</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?= htmlspecialchars($fila['codigo']) ?></td>
                            <td><?= htmlspecialchars($fila['identificacion']) ?></td>
                            <td><?= htmlspecialchars($fila['nombre']) ?></td>
                            <td><?= htmlspecialchars($fila['apellido']) ?></td>
                            <td><?= htmlspecialchars($fila['telefono']) ?></td>
                            <td><?= htmlspecialchars($fila['correo']) ?></td>
                            <td class="acciones">
                                <button class="edit-button" data-id="<?= $fila['codigo'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Modal de edición -->
            <div id="editModal" class="modal">
                <div class="modal-content">
                    <span class="close">
                        <i class="fa-solid fa-x"></i>
                    </span>
                    <h2>Editar Cliente</h2>
                    <form id="editForm" method="post">
                        <input type="hidden" id="editId" name="id">
                        <div class="campo">
                            <label for="editIdentificacion">Identificación:</label>
                            <input type="text" id="editIdentificacion" name="identificacion">
                        </div>
                        <div class="campo">
                            <label for="editNombre">Nombre:</label>
                            <input type="text" id="editNombre" name="nombre">
                        </div>
                        <div class="campo">
                            <label for="editApellido">Apellido:</label>
                            <input type="text" id="editApellido" name="apellido">
                        </div>
                        <div class="campo">
                            <label for="editTelefono">Teléfono:</label>
                            <input type="text" id="editTelefono" name="telefono">
                        </div>
                        <div class="campo">
                            <label for="editCorreo">Correo:</label>
                            <input type="email" id="editCorreo" name="correo">
                        </div>
                        <div class="modal-boton">
                            <button type="submit" id="modal-boton">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <p>No se encontraron resultados.</p>
        <?php endif; ?>
    </div>

    <script>
        // JavaScript adaptado
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-button');
            const modal = document.getElementById('editModal');
            const closeModal = modal.querySelector('.close');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    document.getElementById('editId').value = row.cells[0].innerText.trim();
                    document.getElementById('editIdentificacion').value = row.cells[1].innerText.trim();
                    document.getElementById('editNombre').value = row.cells[2].innerText.trim();
                    document.getElementById('editApellido').value = row.cells[3].innerText.trim();
                    document.getElementById('editTelefono').value = row.cells[4].innerText.trim();
                    document.getElementById('editCorreo').value = row.cells[5].innerText.trim();
                    modal.style.display = 'block';
                });
            });

            closeModal.addEventListener('click', function() {
                modal.style.display = 'none';
            });
        });

        function eliminarCliente(codigo) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará al cliente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('listaclientes.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `eliminar=true&codigo=${encodeURIComponent(codigo)}`
            })
            .then(async response => {
                const text = await response.text();
                try {
                    const json = JSON.parse(text);
                    if (json.success) {
                        Swal.fire('Eliminado', 'El cliente ha sido eliminado correctamente.', 'success')
                            .then(() => {
                                location.reload(); // recarga la tabla
                            });
                    } else {
                        Swal.fire('Error', json.error || 'No se pudo eliminar al cliente.', 'error');
                    }
                } catch (e) {
                    // Si no es JSON válido, muestra el contenido HTML devuelto por PHP
                    console.error("Respuesta no JSON:", text);
                    Swal.fire('Error', 'Respuesta no válida del servidor. Ver consola para más detalles.', 'error');
                }
            })
            .catch(error => {
                console.error("Error de red o fetch:", error);
                Swal.fire('Error', 'Error de red al intentar eliminar el cliente.', 'error');
            });
        }
    });
}

    </script>
</body>

</html>