<?php
// —— AJAX check_correo — solo responde JSON y sale
if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  && isset($_GET['action'])
  && $_GET['action'] === 'check_correo' // <-- Nueva acción
) {
  header('Content-Type: application/json');
  require '../conexion/conexion.php'; // Asegúrate que la ruta es correcta

  $raw  = file_get_contents('php://input');
  $data = json_decode($raw, true);
  $correo = trim($data['correo'] ?? '');

  if ($correo === '') {
    echo json_encode(['exists' => false, 'error' => 'No se recibió el correo']);
    exit;
  }

  $stmt = $conexion->prepare("SELECT COUNT(*) FROM usuario WHERE correo = ?");
  $stmt->bind_param("s", $correo);
  $stmt->execute();
  $stmt->bind_result($count);
  $stmt->fetch();
  $stmt->close();
  $conexion->close();

  echo json_encode(['exists' => $count > 0]);
  exit; // Importantísimo: cortamos aquí para no enviar el resto del HTML
}


// —— AJAX check_identificacion — solo responde JSON y sale
if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  && isset($_GET['action'])
  && $_GET['action'] === 'check_identificacion'
) {
  header('Content-Type: application/json');
  require '../conexion/conexion.php';

  $raw  = file_get_contents('php://input');
  $data = json_decode($raw, true);
  $ident = trim($data['identificacion'] ?? '');

  if ($ident === '') {
    echo json_encode(['error' => 'No se recibió identificación']);
    exit;
  }

  $stmt = $conexion->prepare("SELECT COUNT(*) FROM usuario WHERE identificacion = ?");
  $stmt->bind_param("s", $ident);
  $stmt->execute();
  $stmt->bind_result($count);
  $stmt->fetch();
  $stmt->close();
  $conexion->close();

  echo json_encode(['exists' => $count > 0]);
  exit;  // importantísimo: cortamos aquí
}

session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.php");
  exit();
}

// consultar rol de usuario
$conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
$sql = "SELECT rol FROM usuario WHERE identificacion = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $_SESSION['usuario_id']);
$stmt->execute();
$resultado = $stmt->get_result();
$row = $resultado->fetch_assoc();
$rol = $row['rol'];
$stmt->close();
$conexion->close();

if ($rol == 'gerente') {
  header("Location: ../html/acceso_denegado.php");
  exit();
}


require '../conexion/conexion.php'; // archivo con la conexión a BD y las librerías
require '../vendor/autoload.php';   // si usas composer para Mailjet
use \Mailjet\Resources;


// require_once $_SERVER['DOCUMENT_ROOT'] . '../html/verificar_permisos.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';

$mensaje = null; // Variable para almacenar el estado del mensaje
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Crear usuario</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link rel="stylesheet" href="/css/registro.css" />
  <link rel="stylesheet" href="../css/alertas.css">
  <link rel="stylesheet" href="/componentes/header.php" />
  <link rel="stylesheet" href="/componentes/header.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Merriweather&family=Metal+Mania&display=swap');
  </style>
  <script src="/js/index.js"></script>
  <script src="../js/header.js"></script>
  <style>
    .required::after {
      content: " *";
      color: red;
    }

    
  </style>
</head>

<body>
  <?php include 'boton-ayuda.php'; ?>
  <div id="menu"></div>
  <nav class="barra-navegacion">
  <div class="ubica"> Configuración / Gestión de usuarios / Registro</div>
   <div class="userContainer">
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
  </div>
  </nav>
  <div class="container-general">
  </div>
  <h1>CREAR USUARIO</h1>

  <form name="formulario" method="post" action="">
    <div class="container">
      <div class="form-grid">
        <div class="campo">
          <label class="required" for="identificacion">Identificación: </label>
          <input
            type="number"
            name="identificacion"
            id="identificacion"
            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
            required>
          <div class="small-error-tooltip">Esta identificación ya está registrada.</div>
        </div>


        <div class="campo">
          <label class="required" for="rol">Rol: </label>
          <select name="rol" id="rol" required>
            <option value="gerente" selected>Gerente</option>
          </select>
        </div>

        <div class="campo">
          <label class="required" for="nombre">Nombre: </label>
          <input type="text" name="nombre" id="nombre" required>
        </div>

        <div class="campo">
          <label class="required" for="apellido">Apellido: </label>
          <input type="text" name="apellido" id="apellido" required>
        </div>

        <div class="campo">
          <label class="required" for="telefono">Teléfono: </label>
          <input
            type="number"
            name="telefono"
            id="telefono"
            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
            required>
        </div>

        <div class="campo">
          <label class="required" for="direccion">Dirección: </label>
          <input type="text" name="direccion" id="direccion" required>
        </div>

        <div class="campo" id="contenedorCorreo">
          <label class="required" for="correo">Correo: </label>
          <button type="button" id="btnAbrirModalCorreo">Verificar correo</button>
        </div>

        <div class="campo">
          <label class="required" for="contrasena">Contraseña: </label>
          <input type="password" name="contrasena" id="contrasena" required disabled>
          <i
            id="togglePassword"
            class="bx bx-hide"
            style="position: absolute; right: 12rem; left: 16rem; top: 54.7%; transform: translateY(-50%); cursor: pointer; color: black; font-size: 1.5rem; width: 20px; height: 20px;"></i>
          <div id="tooltip-requisitos" class="ventana-requisitos" style="display: none;">
            <ul class="requisitos" style="list-style: none; padding-left: 0;">
              <li id="min-caracteres"> Mínimo 8 caracteres</li>
              <li id="letra-mayus"> Al menos una letra mayúscula</li>
              <li id="letra-minus"> Al menos una letra minúscula</li>
              <li id="numero"> Al menos un número</li>
              <li id="simbolo"> Al menos un símbolo especial</li>
            </ul>
          </div>
        </div>

        <div class="campo">
          <label class="required" for="confirmar">Confirmar Contraseña: </label>
          <input type="password" name="confirmar" id="confirmar" required disabled>
          <i
            id="togglePassword2"
            class="bx bx-hide"
            style="position: absolute; right: 0rem; left: 16rem; top: 54.7%; transform: translateY(-50%); cursor: pointer; color: black; font-size: 1.5rem; width: 20px; height: 20px;"></i>
          <div id="tooltip-confirmar" class="ventana-requisitos" style="display: none;">
            <p id="mensaje-confirmar" style="margin: 0; padding: 0.5rem;"></p>
          </div>
        </div>
      </div>
    </div>

    <div class="button_container">
      <button type="submit" name="registrar" id="btnRegistrar" class="boton">Registrar</button>

      <a href="../html/gestiondeusuarios.php" class="botonn">Volver</a>
    </div>
  </form>
  <?php
  // Inicializamos variables para mantener valores al mostrar el formulario
  $identificacion = $rol = $nombre = $apellido = $telefono = $direccion = $correo = '';

  if ($_POST && isset($_POST['registrar'])) {
    // Conexión a la base de datos
    $conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
    if ($conexion->connect_error) {
      die("Error de conexión: " . $conexion->connect_error);
    }

    $identificacion = $_POST['identificacion'];
    $rol = $_POST['rol'];
    $contrasena = $_POST['contrasena'];
    $confirmar = $_POST['confirmar'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];

    if (
      empty($identificacion) || empty($contrasena) || empty($confirmar) ||
      empty($nombre) || empty($apellido) || empty($telefono) ||
      empty($direccion) || empty($correo)
    ) {
      echo "<script>alert('Todos los campos son obligatorios');</script>";
      $conexion->close();
      exit;
    }

    if ($contrasena !== $confirmar) {
      echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
      echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: '<span class=\"titulo-alerta error\">Error</span>',
                            html: `<div class=\"custom-alert\">
                                        <div class='contenedor-imagen'>
                                            <img src=\"../imagenes/llave.png\" alt=\"Error\" class=\"llave\">
                                        </div>
                                        <p>Las contraseñas no coinciden.</p>
                                    </div>`,
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
      $conexion->close();
      exit;
    }

    // Verificar si el correo ya existe
    $verificarCorreo = $conexion->prepare("SELECT identificacion FROM usuario WHERE correo = ?");
    $verificarCorreo->bind_param("s", $correo);
    $verificarCorreo->execute();
    $verificarCorreo->store_result();

    if ($verificarCorreo->num_rows > 0) {
      echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
      echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: '<span class=\"titulo-alerta error\">Error</span>',
                            html: `<div class=\"custom-alert\">
                                        <div class='contenedor-imagen'>
                                            <img src=\"../imagenes/llave.png\" alt=\"Error\" class=\"llave\">
                                        </div>
                                        <p>El correo ya está registrado. Intenta con otro.</p>
                                    </div>`,
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
      $verificarCorreo->close();
      $conexion->close();
      exit;
    }
    $verificarCorreo->close();

    // Verificar si el teléfono ya está registrado
    $verificarTelefono = $conexion->prepare("SELECT identificacion FROM usuario WHERE telefono = ?");
    $verificarTelefono->bind_param("s", $telefono);
    $verificarTelefono->execute();
    $resultadoTelefono = $verificarTelefono->get_result();

    if ($resultadoTelefono->num_rows > 0) {
      echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
      echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: '<span class=\"titulo-alerta error\">Error</span>',
                            html: `<div class=\"custom-alert\">
                                        <div class='contenedor-imagen'>
                                            <img src=\"../imagenes/llave.png\" alt=\"Error\" class=\"llave\">
                                        </div>
                                        <p>El número de teléfono ya está registrado. Intenta con otro.</p>
                                    </div>`,
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
      $verificarTelefono->close();
      $conexion->close();
      exit;
    }
    $verificarTelefono->close();

    $contrasenaHashed = password_hash($contrasena, PASSWORD_DEFAULT);
    $estado = 'activo';
    $tipoDocumento = 'cedula de ciudadania';

    $stmt = $conexion->prepare(
      "INSERT INTO usuario 
            (identificacion, tipoDocumento, rol, nombre, apellido, telefono, direccion, correo, contrasena, estado) 
           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    if ($stmt === false) {
      die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmt->bind_param(
      "ssssssssss",
      $identificacion,
      $tipoDocumento,
      $rol,
      $nombre,
      $apellido,
      $telefono,
      $direccion,
      $correo,
      $contrasenaHashed,
      $estado
    );

    if ($stmt->execute()) {
      $resultado = $conexion->query(
        "INSERT INTO accesos
                (id_usuario, seccion, sub_seccion, permitido) VALUES
                ($identificacion, 'PRODUCTO', 'Crear Producto', 0),
                ($identificacion, 'PRODUCTO', 'Categorias', 0),
                ($identificacion, 'PRODUCTO', 'Ubicacion', 0),
                ($identificacion, 'PRODUCTO', 'Marca', 0),
                ($identificacion, 'PROVEEDOR', 'Lista Proveedor', 0),
                ($identificacion, 'INVENTARIO', 'Lista Productos', 0),
                ($identificacion, 'FACTURA', 'Ventas', 0),
                ($identificacion, 'FACTURA', 'Reportes', 0),
                ($identificacion, 'FACTURA', 'Lista Clientes', 0),
                ($identificacion, 'FACTURA', 'Lista Notificaciones', 0),
                ($identificacion, 'USUARIO', 'Información', 1)"
      );

      if ($resultado) {

        echo "<script>
document.addEventListener('DOMContentLoaded', function() {
  Swal.fire({
    title: '<span class=\"titulo-alerta confirmacion\">¡Registro exitoso!</span>',
    html: `
      <div class=\"custom-alert\">
        <div class=\"contenedor-imagen\">
          <img src=\"../imagenes/moto.png\" alt=\"Confirmación\" class=\"moto\">
        </div>
        <p>El usuario fue registrado y los permisos fueron guardados correctamente.</p>
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
</script>";
      } else {
        echo "<script>alert('Registro exitoso, pero error al guardar permisos');</script>";
      }
    } else {
      echo "<script>alert('Error al guardar el usuario');</script>";
    }

    $stmt->close();
    $conexion->close();
  }
  ?>

  <div id="modalVerificacion" class="modal hidden">
    <div class="modal-overlay" id="modalOverlay"></div>
    <div class="modal-container">
      <h2>Verificar Correo</h2>
      <p id="mensajeModal"></p>

      <div id="correoSection">
        <div class="input-group">
          <div id="emailErrorTooltip" class="error-tooltip">Este correo ya está registrado.</div>
          <input type="email" id="inputCorreo">
        </div>
        <div id="correoSectionButtons" class="modal-actions">
          <button id="btnCerrarModal" class="btnCancelar">Cancelar</button>
          <button id="btnEnviarCodigo" class="btn-guardar">Enviar código</button>
        </div>
      </div>

      <div id="codigoSection" class="hidden">
        <div class="input-group">
          <label>Ingrese el código recibido:</label>
          <input type="text" id="inputCodigo">
        </div>
        <div class="modal-actions">
          <button id="btnCerrarModal2" class="btnCancelar">Cancelar</button>
          <button id="btnVerificarCodigo" class="btn-guardar">Verificar código</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // --- Lógica para Contraseñas ---
    const togglePassword = document.querySelector('#togglePassword');
    const togglePassword2 = document.querySelector('#togglePassword2');
    const passwordInput = document.querySelector('#contrasena');
    const passwordInput2 = document.querySelector('#confirmar');
    const tooltip = document.getElementById("tooltip-requisitos");
    const tooltipConfirmar = document.getElementById("tooltip-confirmar");
    const mensajeConfirmar = document.getElementById("mensaje-confirmar");
    const reglas = {
      minCaracteres: document.getElementById("min-caracteres"),
      mayus: document.getElementById("letra-mayus"),
      minus: document.getElementById("letra-minus"),
      numero: document.getElementById("numero"),
      simbolo: document.getElementById("simbolo")
    };


    // Mostrar/ocultar contraseña
    if (togglePassword) togglePassword.addEventListener('click', () => {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      togglePassword.classList.toggle('bx-show');
      togglePassword.classList.toggle('bx-hide');
    });

    if (togglePassword2) togglePassword2.addEventListener('click', () => {
      const type = passwordInput2.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput2.setAttribute('type', type);
      togglePassword2.classList.toggle('bx-show');
      togglePassword2.classList.toggle('bx-hide');
    });

    // Mostrar y ocultar ventana de requisitos al enfocar/desenfocar el campo contraseña
    passwordInput.addEventListener("focus", () => {
      tooltip.style.display = "block";
    });

    passwordInput.addEventListener("blur", () => {
      setTimeout(() => {
        tooltip.style.display = "none";
      }, 200);
    });

    // Validar requisitos de la contraseña dinámicamente
    passwordInput.addEventListener("input", () => {
      const valor = passwordInput.value;
      const cumpleMin = valor.length >= 8;
      const tieneMayus = /[A-Z]/.test(valor);
      const tieneMinus = /[a-z]/.test(valor);
      const tieneNumero = /\d/.test(valor);
      const tieneSimbolo = /[!@#$%^&*(),.?":{}|<>]/.test(valor);

      reglas.minCaracteres.classList.toggle("validado", cumpleMin);
      reglas.mayus.classList.toggle("validado", tieneMayus);
      reglas.minus.classList.toggle("validado", tieneMinus);
      reglas.numero.classList.toggle("validado", tieneNumero);
      reglas.simbolo.classList.toggle("validado", tieneSimbolo);
    });

    // Mostrar y ocultar ventana de confirmación al enfocar/desenfocar el campo confirmar
    passwordInput2.addEventListener("focus", () => {
      tooltipConfirmar.style.display = "block";
      actualizarConfirmacion();
    });

    passwordInput2.addEventListener("blur", () => {
      setTimeout(() => {
        tooltipConfirmar.style.display = "none";
      }, 200);
    });

    // Validar coincidencia de contraseñas dinámicamente
    passwordInput2.addEventListener("input", () => {
      actualizarConfirmacion();
    });

    function actualizarConfirmacion() {
      const valor1 = passwordInput.value;
      const valor2 = passwordInput2.value;

      if (!valor2) {
        mensajeConfirmar.textContent = "Ingrese la contraseña para confirmar.";
        mensajeConfirmar.style.color = "black";
        return;
      }

      if (valor1 === valor2) {
        mensajeConfirmar.textContent = "Las contraseñas coinciden.";
        mensajeConfirmar.style.color = "green";
      } else {
        mensajeConfirmar.textContent = "Las contraseñas no coinciden.";
        mensajeConfirmar.style.color = "red";
      }
    }

    document.addEventListener('DOMContentLoaded', function() {
      // --- INICIO DE LÓGICA DEL MODAL ---
      const modal = document.getElementById('modalVerificacion');
      const btnAbrirModal = document.getElementById('btnAbrirModalCorreo');
      const btnCerrarModal = document.getElementById('btnCerrarModal');
      const btnCerrarModal2 = document.getElementById('btnCerrarModal2');
      const btnEnviarCodigo = document.getElementById('btnEnviarCodigo');
      const btnVerificarCodigo = document.getElementById('btnVerificarCodigo');
      const inputCorreo = document.getElementById('inputCorreo');
      const inputCodigo = document.getElementById('inputCodigo');
      const codigoSection = document.getElementById('codigoSection');
      const mensajeModal = document.getElementById('mensajeModal');
      const correoSectionButtons = document.getElementById('correoSectionButtons');
      const emailErrorTooltip = document.getElementById('emailErrorTooltip');
      let debounceCorreo;

      function abrirModal() {
        modal.classList.remove('hidden');
        // Animación de entrada
        const modalContainer = modal.querySelector('.modal-container');
        modalContainer.style.transform = 'translateY(-50px)';
        modalContainer.style.opacity = '0';
        requestAnimationFrame(() => {
          modalContainer.style.transition = 'transform 0.3s ease-out, opacity 0.3s ease-out';
          modalContainer.style.transform = 'translateY(0)';
          modalContainer.style.opacity = '1';
        });
        resetearModal();
      }

      function cerrarModal() {
        const modalContainer = modal.querySelector('.modal-container');
        modalContainer.style.transform = 'translateY(-50px)';
        modalContainer.style.opacity = '0';
        setTimeout(() => {
          modal.classList.add('hidden');
        }, 300);
      }

      function resetearModal() {
        mensajeModal.textContent = 'Por favor ingrese el correo para continuar con el proceso de registro.';
        mensajeModal.style.color = 'black';
        mensajeModal.style.fontWeight = 'bold';
        if (inputCorreo) {
          inputCorreo.value = '';
          inputCorreo.classList.remove('input-error');
          inputCorreo.disabled = false;
        }
        if (inputCodigo) inputCodigo.value = '';
        if (emailErrorTooltip) emailErrorTooltip.style.display = 'none';
        if (codigoSection) codigoSection.classList.add('hidden');
        if (correoSectionButtons) correoSectionButtons.classList.remove('hidden');
        if (btnEnviarCodigo) btnEnviarCodigo.disabled = true;
      }

      if (btnAbrirModal) btnAbrirModal.addEventListener('click', abrirModal);
      if (btnCerrarModal) btnCerrarModal.addEventListener('click', cerrarModal);
      if (btnCerrarModal2) btnCerrarModal2.addEventListener('click', cerrarModal);
      if (modal) modal.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
          cerrarModal();
        }
      });


      // --- INICIO: LÓGICA DE VALIDACIÓN DE CORREO EN TIEMPO REAL ---
      if (inputCorreo) {
        inputCorreo.addEventListener('input', () => {
          clearTimeout(debounceCorreo);
          inputCorreo.classList.remove('input-error');
          emailErrorTooltip.style.display = 'none';

          const correo = inputCorreo.value.trim();
          const regexCorreo = /^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|hotmail\.com|yahoo\.com)$/;

          if (!regexCorreo.test(correo)) {
            btnEnviarCodigo.disabled = true;
            return;
          }

          debounceCorreo = setTimeout(() => {
            fetch(`${location.pathname}?action=check_correo`, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                  correo: correo
                })
              })
              .then(res => res.json())
              .then(data => {
                if (data.exists) {
                  inputCorreo.classList.add('input-error');
                  emailErrorTooltip.style.display = 'block';
                  btnEnviarCodigo.disabled = true;
                } else {
                  btnEnviarCodigo.disabled = false;
                }
              })
              .catch(err => {
                console.error('Error en la verificación de correo:', err);
                btnEnviarCodigo.disabled = true;
              });
          }, 500);
        });
      }
      // --- FIN: LÓGICA DE VALIDACIÓN DE CORREO EN TIEMPO REAL ---

      // Enviar código al correo
      if (btnEnviarCodigo) btnEnviarCodigo.addEventListener('click', () => {
        const correo = inputCorreo.value.trim();

        btnEnviarCodigo.disabled = true;
        mensajeModal.textContent = 'Enviando código...';
        mensajeModal.style.color = '';

        fetch('../html/enviar_codigo.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              correo
            })
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              mensajeModal.textContent = 'Código enviado. Revisa tu correo.';
              mensajeModal.style.color = '#12521a';
              codigoSection.classList.remove('hidden');
              inputCorreo.disabled = true;
              correoSectionButtons.classList.add('hidden');
            } else {
              mensajeModal.textContent = data.message || 'Error al enviar código.';
              mensajeModal.style.color = '#83abd6';
              btnEnviarCodigo.disabled = false;
            }
          })
          .catch(() => {
            mensajeModal.textContent = 'Error en la conexión.';
            mensajeModal.style.color = '#83abd6';
            btnEnviarCodigo.disabled = false;
          });
      });

      // Verificar código ingresado
      if (btnVerificarCodigo) btnVerificarCodigo.addEventListener('click', () => {
        const correo = inputCorreo.value.trim();
        const codigo = inputCodigo.value.trim();

        if (!codigo) {
          mensajeModal.textContent = 'Por favor ingresa el código.';
          mensajeModal.style.color = 'red';
          return;
        }

        mensajeModal.textContent = 'Verificando código...';
        mensajeModal.style.color = '';

        fetch('../html/verificar_codigo_correo.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              correo,
              codigo
            })
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              mensajeModal.textContent = 'Código verificado correctamente.';
              mensajeModal.style.color = 'green';

              setTimeout(() => {
                cerrarModal();
              }, 1000); // Cierra el modal 1 segundo después

              // Habilitar campos de contraseña
              document.getElementById('contrasena').disabled = false;
              document.getElementById('confirmar').disabled = false;

              // Reemplazar botón por campo correo readonly
              const contenedorCorreo = document.getElementById('contenedorCorreo');
              contenedorCorreo.innerHTML = `
                <label class="required" for="correo">Correo: </label>
                <input type="email" id="correo" name="correo" value="${correo}" readonly required>
              `;
            } else {
              mensajeModal.textContent = data.message || 'Código incorrecto.';
              mensajeModal.style.color = 'red';
            }
          })
          .catch(() => {
            mensajeModal.textContent = 'Error en la conexión.';
            mensajeModal.style.color = 'red';
          });
      });
      // --- FIN DE LÓGICA DEL MODAL ---
    });

    // --- LÓGICA PARA VALIDACIÓN DE REQUISITOS DE CONTRASEÑA ---
    document.addEventListener('DOMContentLoaded', () => {
      const form = document.querySelector('form[name="formulario"]');
      const pwd = document.getElementById('contrasena');
      const pwd2 = document.getElementById('confirmar');

      if (form) form.addEventListener('submit', function(e) {
        // Solo valida si los campos de contraseña están habilitados
        if (pwd.disabled) return;

        const valor = pwd.value;
        const valor2 = pwd2.value;
        const reglasCumplidas = {
          min: valor.length >= 8,
          upper: /[A-Z]/.test(valor),
          lower: /[a-z]/.test(valor),
          num: /\d/.test(valor),
          sym: /[!@#$%^&*(),.?":{}|<>]/.test(valor)
        };

        const todas = Object.values(reglasCumplidas).every(v => v === true);

        if (!todas || valor !== valor2) {
          e.preventDefault();
          let mensajes = [];
          if (!reglasCumplidas.min) mensajes.push('– Mínimo 8 caracteres');
          if (!reglasCumplidas.upper) mensajes.push('– Al menos una letra mayúscula');
          if (!reglasCumplidas.lower) mensajes.push('– Al menos una letra minúscula');
          if (!reglasCumplidas.num) mensajes.push('– Al menos un número');
          if (!reglasCumplidas.sym) mensajes.push('– Al menos un símbolo especial');
          if (valor !== valor2) mensajes.push('– Las contraseñas no coinciden');

          Swal.fire({
            title: '<span class="titulo-alerta error">Error</span>',
            html: `
              <div class="custom-alert">
                <div class="contenedor-imagen">
                  <img src="../imagenes/llave.png" alt="Error" class="llave">
                </div>
                <p style="font-family: Arial, sans-serif; color: black; font-size: 14px;">
                  La contraseña no cumple con los requisitos. Por favor corrige lo siguiente:
                </p>
                <ul style="
                    font-family: Arial, sans-serif;
                    font-size: 14px;
                    color: black;
                    text-align: left;
                    padding-left: 1rem;
                    list-style: none;
                  ">
                  ${mensajes.map(m => `<li style="margin-bottom: .25rem;">${m}</li>`).join('')}
                </ul>
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
        }
      });
    });


    // --- LÓGICA PARA VERIFICAR SI IDENTIFICACIÓN YA ESTÁ REGISTRADA ---
    document.addEventListener('DOMContentLoaded', () => {
      const inputIdent = document.getElementById('identificacion');
      const tooltip = document.querySelector('.small-error-tooltip');
      const btnReg = document.getElementById('btnRegistrar');
      let debounce;

      if (inputIdent) {
        // Al arrancar, bloquea el botón
        btnReg.disabled = true;

        inputIdent.addEventListener('input', () => {
          clearTimeout(debounce);
          debounce = setTimeout(() => {
            const val = inputIdent.value.trim();
            if (!val) {
              inputIdent.classList.remove('input-error');
              tooltip.style.display = 'none';
              btnReg.disabled = true;
              return;
            }

            fetch(`${location.pathname}?action=check_identificacion`, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                  identificacion: val
                })
              })
              .then(res => res.json())
              .then(data => {
                if (data.exists) {
                  inputIdent.classList.add('input-error');
                  tooltip.style.display = 'block';
                  btnReg.disabled = true;
                } else {
                  inputIdent.classList.remove('input-error');
                  tooltip.style.display = 'none';
                  btnReg.disabled = false;
                }
              })
              .catch(err => {
                console.error('Fetch error:', err);
                inputIdent.classList.add('input-error');
                tooltip.textContent = 'Error de conexión.';
                tooltip.style.display = 'block';
                btnReg.disabled = true;
              });
          }, 500);
        });
      }
    });
  </script>
</body>

</html>