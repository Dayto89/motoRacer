<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../index.php");
  exit();
}
require '../conexion/conexion.php'; // archivo con la conexión a BD y las librerías
require '../vendor/autoload.php'; // si usas composer para Mailjet
use \Mailjet\Resources;

include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';

//****************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'sendCode') {
  $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

  if (!$email) {
    echo json_encode(['success' => false, 'message' => 'Correo no válido.']);
    exit;
  }

  // Verificar que el correo no exista en la tabla usuario
  $stmt = $conn->prepare("SELECT COUNT(*) FROM usuario WHERE correo = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->bind_result($count);
  $stmt->fetch();
  $stmt->close();

  if ($count > 0) {
    echo json_encode(['success' => false, 'message' => 'El correo ya está registrado.']);
    exit;
  }

  // Generar código numérico de 6 dígitos
  $codigo = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

  // Eliminar códigos anteriores para ese correo
  $stmt = $conn->prepare("DELETE FROM verificaciones WHERE correo = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->close();

  // Insertar nuevo código
  $stmt = $conn->prepare("INSERT INTO verificaciones (correo, codigo) VALUES (?, ?)");
  $stmt->bind_param("ss", $email, $codigo);
  $stmt->execute();
  $stmt->close();

  // Enviar el código por correo
  $mj = new \Mailjet\Client('API_KEY', 'API_SECRET', true, ['version' => 'v3.1']);
  $body = [
    'Messages' => [
      [
        'From' => [
          'Email' => "tu_correo@empresa.com",
          'Name' => "Nombre de tu empresa"
        ],
        'To' => [
          [
            'Email' => $email,
            'Name' => "Usuario"
          ]
        ],
        'Subject' => "Código de verificación",
        'TextPart' => "Tu código de verificación es: $codigo",
        'HTMLPart' => "<h3>Tu código de verificación es: <strong>$codigo</strong></h3>"
      ]
    ]
  ];

  $response = $mj->post(Resources::$Email, ['body' => $body]);

  if ($response->success()) {
    echo json_encode(['success' => true, 'message' => 'Código enviado al correo.']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Error al enviar el correo.']);
  }
  exit;
}


//*************** */
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
</head>

<body>
  <div id="menu"></div>

  <h1>CREAR USUARIO</h1>

  <form name="formulario" method="post" action="">
    <div class="container">
      <div class="form-grid">
        <div class="campo"><label for="identificacion">Identificación: </label><input type="number" name="identificacion" id="identificacion" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')" required></div>
        <div class="campo"><label for="rol">Rol: </label><select name="rol" id="rol" required>
            <option value="gerente" selected>Gerente </option>
          </select></div>
        <div class="campo"><label for="nombre">Nombre: </label><input type="text" name="nombre" id="nombre" required></div>
        <div class="campo"><label for="apellido">Apellido: </label><input type="text" name="apellido" id="apellido" required></div>
        <div class="campo"><label for="telefono">Teléfono: </label><input type="number" name="telefono" id="telefono" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
            required></div>
        <div class="campo"><label for="direccion">Dirección: </label><input type="text" name="direccion" id="direccion" required></div>
        <div class="campo" id="contenedorCorreo"><label for="correo">Correo: </label>
          <button type="button" id="btnAbrirModalCorreo">Verificar correo</button>
        </div>
        <!-- Cambia en el formulario: -->
        <div class="campo">
          <label for="contrasena">Contraseña: </label>
          <input type="password" name="contrasena" id="contrasena" required disabled>
          <i id="togglePassword"
            class='bx bx-hide'
            style="position: absolute; right: 12rem; left: 70.5rem; top: 59.7%; transform: translateY(-50%); cursor: pointer; color:black; font-size: 1.5rem; width: 20px; height: 20px;">
          </i>
        </div>
        <div class="campo">
          <label for="confirmar">Confirmar Contraseña: </label>
          <input type="password" name="confirmar" id="confirmar" required disabled>
          <i id="togglePassword2"
            class='bx bx-hide'
            style="position: absolute; right: 0rem; left: 92.2rem; top: 59.7%; transform: translateY(-50%); cursor: pointer; color:black; font-size: 1.5rem; width: 20px; height: 20px;">
          </i>
        </div>
      </div>
    </div>
    <div class="button_container">
      <button type="submit" name="registrar" class="boton">Registrar</button>
      <a href="../html/gestiondeusuarios.php" class="botonn">Volver</a>

    </div>
  </form>

  <?php
  // Inicializamos variables para mantener valores al mostrar el formulario
  $identificacion = $rol = $nombre = $apellido = $telefono = $direccion = $correo = '';
  $mostrar_form = true; // controla si se muestra el formulario (para no duplicar) 

  if ($_POST && isset($_POST['registrar'])) {
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

    if (empty($identificacion) || empty($contrasena) || empty($confirmar) || empty($nombre) || empty($apellido) || empty($telefono) || empty($direccion) || empty($correo)) {
      echo "<script>alert('Todos los campos son obligatorios');</script>";
      exit;
    }

    if ($contrasena !== $confirmar) {
      echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
      echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                         title: '<span class=\"titulo-alerta error\">Error</span>',
                            html: `
                                <div class=\"custom-alert\">
                                    <div class='contenedor-imagen'>
                                          <img src=\"../imagenes/llave.png\" alt=\"Error\" class=\"llave\">
                                    </div>
                                    <p>Las contraseñas no coinciden.</p>
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
                        } );
                                    });
                                    </script>";
      exit;
    }
    // Validar seguridad de la contraseña
    if (
      strlen($contrasena) < 8 ||
      !preg_match('/[A-Z]/', $contrasena) ||      // Al menos una mayúscula
      !preg_match('/[a-z]/', $contrasena) ||      // Al menos una minúscula
      !preg_match('/[\d\W]/', $contrasena)
    ) {     // Al menos un número o símbolo

      echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
      echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '<span class=\"titulo-alerta error\">Contraseña inválida</span>',
                html: `
                    <div class=\"custom-alert\">
                        <div class='contenedor-imagen'>
                            <img src=\"../imagenes/llave.png\" alt=\"Error\" class=\"llave\">
                        </div>
                        <p>La contraseña debe tener mínimo 8 caracteres, una letra mayúscula, una minúscula y un número o símbolo.</p>
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
        });
    </script>";
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
                html: `
                    <div class=\"custom-alert\">
                        <div class='contenedor-imagen'>
                            <img src=\"../imagenes/llave.png\" alt=\"Error\" class=\"llave\">
                        </div>
                        <p>El correo ya está registrado. Intenta con otro.</p>
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
    $resultadoTelefono = $verificarTelefono->get_result(); // ✅ Obtener correctamente el resultado

    if ($resultadoTelefono->num_rows > 0) {
      echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
      echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '<span class=\"titulo-alerta error\">Error</span>',
                html: `
                    <div class=\"custom-alert\">
                        <div class='contenedor-imagen'>
                            <img src=\"../imagenes/llave.png\" alt=\"Error\" class=\"llave\">
                        </div>
                        <p>El número de teléfono ya está registrado. Intenta con otro.</p>
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

    $stmt = $conexion->prepare("INSERT INTO usuario (identificacion, tipoDocumento, rol, nombre, apellido, telefono, direccion, correo, contraseña, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
      die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmt->bind_param("ssssssssss", $identificacion, $tipoDocumento, $rol, $nombre, $apellido, $telefono, $direccion, $correo, $contrasenaHashed, $estado);


    if ($stmt->execute()) {
      $resultado = $conexion->query("INSERT INTO accesos (id_usuario, seccion, sub_seccion, permitido) VALUES
                ($identificacion, 'PRODUCTO', 'Crear Producto', 0),
                ($identificacion, 'PRODUCTO', 'Actualizar Producto', 0),
                ($identificacion, 'PRODUCTO', 'Categorias', 0),
                ($identificacion, 'PRODUCTO', 'Ubicacion', 0),
                ($identificacion, 'PRODUCTO', 'Marca', 0),
                ($identificacion, 'PROVEEDOR', 'Lista Proveedor', 0),
                ($identificacion, 'INVENTARIO', 'Lista de Productos', 0),
                ($identificacion, 'FACTURA', 'Ventas', 0),
                ($identificacion, 'FACTURA', 'Reportes', 0),
                ($identificacion, 'FACTURA', 'Lista Clientes', 0),
                ($identificacion, 'FACTURA', 'Lista de Notificaciones', 0),
                ($identificacion, 'USUARIO', 'Información', 1)");

      if ($resultado) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
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

  <!-- Modal Verificacion-->
  <div id="modalVerificacion" class="hidden">
    <div class="modal-content">
      <button id="btnCerrarModal">X</button>
      <p id="mensajeModal"></p>
      <input type="email" id="inputCorreo" placeholder="Correo electrónico">
      <button id="btnEnviarCodigo">Enviar código</button>

      <div id="codigoSection" class="hidden">
        <input type="text" id="inputCodigo" placeholder="Código recibido">
        <button id="btnVerificarCodigo">Verificar código</button>
      </div>
    </div>
  </div>

  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#contrasena');

    togglePassword.addEventListener('click', () => {
      // Alterna el tipo de input
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);

      // Cambia el icono: de ojo abierto a ojo cerrado
      togglePassword.classList.toggle('bx-show');
      togglePassword.classList.toggle('bx-hide');
    });

    const togglePassword2 = document.querySelector('#togglePassword2');
    const passwordInput2 = document.querySelector('#confirmar');

    togglePassword2.addEventListener('click', () => {
      // Alterna el tipo de input
      const type = passwordInput2.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput2.setAttribute('type', type);

      // Cambia el icono: de ojo abierto a ojo cerrado
      togglePassword2.classList.toggle('bx-show');
      togglePassword2.classList.toggle('bx-hide');
    });

    document.addEventListener('DOMContentLoaded', function() {
      const modal = document.getElementById('modalVerificacion');
      const btnAbrirModal = document.getElementById('btnAbrirModalCorreo');
      const btnCerrarModal = document.getElementById('btnCerrarModal');
      const btnEnviarCodigo = document.getElementById('btnEnviarCodigo');
      const btnVerificarCodigo = document.getElementById('btnVerificarCodigo');
      const inputCorreo = document.getElementById('inputCorreo');
      const inputCodigo = document.getElementById('inputCodigo');
      const codigoSection = document.getElementById('codigoSection');
      const mensajeModal = document.getElementById('mensajeModal');

      // Mostrar modal al hacer clic en botón "Verificar correo"
      btnAbrirModal.addEventListener('click', () => {
        modal.classList.remove('hidden');
        mensajeModal.textContent = '';
        mensajeModal.style.color = '';
        inputCorreo.value = '';
        inputCodigo.value = '';
        codigoSection.classList.add('hidden');
        inputCorreo.disabled = false;
        btnEnviarCodigo.disabled = false;
      });

      // Cerrar modal
      btnCerrarModal.addEventListener('click', () => {
        modal.classList.add('hidden');
      });

      // Enviar código al correo
      btnEnviarCodigo.addEventListener('click', () => {
        const correo = inputCorreo.value.trim();
        const regexCorreo = /^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|hotmail.com|yahoo.com)$/;

        if (!correo) {
          mensajeModal.textContent = 'Por favor ingresa un correo.';
          mensajeModal.style.color = 'red';
          return;
        }

        if (!regexCorreo.test(correo)) {
          mensajeModal.textContent = 'Por favor, ingresa un correo válido. Sugerencia: usa uno que termine en @gmail.com, @outlook.com, @hotmail.com o @yahoo.com.';
          mensajeModal.style.color = 'red';
          return;
        }

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
              mensajeModal.style.color = 'green';
              codigoSection.classList.remove('hidden');
              inputCorreo.disabled = true;
            } else {
              mensajeModal.textContent = data.message || 'Error al enviar código.';
              mensajeModal.style.color = 'red';
              btnEnviarCodigo.disabled = false;
            }
          })
          .catch(() => {
            mensajeModal.textContent = 'Error en la conexión.';
            mensajeModal.style.color = 'red';
            btnEnviarCodigo.disabled = false;
          });
      });

      // Verificar código ingresado
      btnVerificarCodigo.addEventListener('click', () => {
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
              modal.classList.add('hidden');

              // Habilitar campos de contraseña
              document.getElementById('contrasena').disabled = false;
              document.getElementById('confirmar').disabled = false;

              // Reemplazar botón por campo correo readonly
              const contenedorCorreo = btnAbrirModal.parentElement;
              contenedorCorreo.innerHTML = '';

              const labelCorreo = document.createElement('label');
              labelCorreo.setAttribute('for', 'correo');
              labelCorreo.textContent = 'Correo: ';
              contenedorCorreo.appendChild(labelCorreo);

              const inputCorreoReadonly = document.createElement('input');
              inputCorreoReadonly.type = 'email';
              inputCorreoReadonly.id = 'correo';
              inputCorreoReadonly.name = 'correo';
              inputCorreoReadonly.value = correo;
              inputCorreoReadonly.readOnly = true;
              contenedorCorreo.appendChild(inputCorreoReadonly);
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
    });
  </script>


</body>

</html>