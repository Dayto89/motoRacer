<?php
session_start();
if (!isset($_SESSION['correo_para_resetear'])) {
    header("Location: ../index.php");
    exit;
}
$mensaje = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_SESSION['correo_para_resetear'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    $cumpleRequisitos = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $nueva_contrasena);

    if ($nueva_contrasena !== $confirmar_contrasena) {
        $mensaje = 'sin_coincidencia_contrasenas';
    } elseif (!$cumpleRequisitos) {
        $mensaje = 'contrasena_invalida';
    } else {
        $nueva_contrasena_hashed = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        
        $conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $stmt = $conexion->prepare("UPDATE usuario SET contrasena = ?, codigo_recuperacion = NULL WHERE correo = ?");
        $stmt->bind_param("ss", $nueva_contrasena_hashed, $correo);

        if ($stmt->execute()) {
            $mensaje = 'exito_restablecer_contrasena';
            session_unset();
            session_destroy();
        } else {
            $mensaje = 'error_restablecer_contrasena';
        }
        $stmt->close();
        $conexion->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - Moto Racer</title>
    <link rel="stylesheet" href="../css/resetear.css">
    <link rel="stylesheet" href="../css/alertas.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
</head>
<body>
    <div class="container">
        <div class="login-panel panel-logo">
            <img src="../imagenes/LOGO.png" alt="Logo Moto Racer" class="logo_inicio">
        </div>
        <div class="login-panel panel-form">
            <h1>RESTABLECER CONTRASEÑA</h1>
            <form name="formulario" method="post" action="">
                
                <div class="form-group-relative">
                    <div class="input-wrapper">
                        <i class='bx bx-lock-alt'></i>
                        <input type="password" placeholder="Nueva Contraseña" name="nueva_contrasena" id="nueva_contrasena" required />
                        <i id="togglePassword" class='bx bx-hide'></i>
                    </div>
                    <div id="tooltip-requisitos" class="ventana-requisitos">
                        <ul>
                            <li id="min-caracteres">Mínimo 8 caracteres</li>
                            <li id="letra-mayus">Una letra mayúscula</li>
                            <li id="letra-minus">Una letra minúscula</li>
                            <li id="numero">Un número</li>
                            <li id="simbolo">Un símbolo especial</li>
                        </ul>
                    </div>
                </div>

                <div class="form-group-relative">
                    <div class="input-wrapper">
                        <i class='bx bx-lock-alt'></i>
                        <input type="password" placeholder="Confirmar Nueva Contraseña" name="confirmar_contrasena" id="confirmar_contrasena" required />
                        <i id="togglePassword2" class='bx bx-hide'></i>
                    </div>
                     <div id="tooltip-confirmar" class="ventana-requisitos">
                        <p id="mensaje-confirmar"></p>
                    </div>
                </div>

                <button type="submit" name="restablecer" class="boton">Restablecer Contraseña</button>
            </form>
        </div>
    </div>
    <script>
        const passwordInput = document.querySelector('#nueva_contrasena');
        const confirmPasswordInput = document.querySelector('#confirmar_contrasena');
        const togglePassword = document.querySelector('#togglePassword');
        const togglePassword2 = document.querySelector('#togglePassword2');

        const tooltipRequisitos = document.getElementById("tooltip-requisitos");
        const tooltipConfirmar = document.getElementById("tooltip-confirmar");
        const mensajeConfirmar = document.getElementById("mensaje-confirmar");
        
        const requisitos = {
            minCaracteres: document.getElementById("min-caracteres"),
            mayus: document.getElementById("letra-mayus"),
            minus: document.getElementById("letra-minus"),
            numero: document.getElementById("numero"),
            simbolo: document.getElementById("simbolo")
        };

        function setupToggle(toggleElement, inputElement) {
            toggleElement.addEventListener('click', () => {
                const type = inputElement.getAttribute('type') === 'password' ? 'text' : 'password';
                inputElement.setAttribute('type', type);
                toggleElement.classList.toggle('bx-show');
                toggleElement.classList.toggle('bx-hide');
            });
        }
        setupToggle(togglePassword, passwordInput);
        setupToggle(togglePassword2, confirmPasswordInput);

        // --- Lógica para mostrar/ocultar tooltips ---
        passwordInput.addEventListener("focus", () => { tooltipRequisitos.style.display = "block"; });
        passwordInput.addEventListener("blur", () => { tooltipRequisitos.style.display = "none"; });

        confirmPasswordInput.addEventListener("focus", () => {
            tooltipConfirmar.style.display = "block";
            actualizarConfirmacion();
        });
        confirmPasswordInput.addEventListener("blur", () => { tooltipConfirmar.style.display = "none"; });

        // --- Lógica de validación ---
        passwordInput.addEventListener("input", () => {
            const valor = passwordInput.value;
            requisitos.minCaracteres.classList.toggle("validado", valor.length >= 8);
            requisitos.mayus.classList.toggle("validado", /[A-Z]/.test(valor));
            requisitos.minus.classList.toggle("validado", /[a-z]/.test(valor));
            requisitos.numero.classList.toggle("validado", /\d/.test(valor));
            requisitos.simbolo.classList.toggle("validado", /[\W_]/.test(valor));
            actualizarConfirmacion();
        });

        confirmPasswordInput.addEventListener("input", actualizarConfirmacion);

        function actualizarConfirmacion() {
            const valor1 = passwordInput.value;
            const valor2 = confirmPasswordInput.value;

            if (!valor2) {
                mensajeConfirmar.textContent = "Confirme la contraseña.";
                mensajeConfirmar.style.color = "#333";
                return;
            }
            if (valor1 === valor2) {
                mensajeConfirmar.textContent = "Las contraseñas coinciden.";
                mensajeConfirmar.style.color = "#28a745";
            } else {
                mensajeConfirmar.textContent = "Las contraseñas no coinciden.";
                mensajeConfirmar.style.color = "#ff5c5c";
            }
        }
        
        // Lógica de SweetAlert2 (sin cambios)
        const mensajePHP = "<?php echo $mensaje; ?>";
        if (mensajePHP) {
            let config = {
                background: '#ffffffdb',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#007bff',
                customClass: {
                    popup: 'swal2-border-radius', confirmButton: 'btn-aceptar', container: 'fondo-oscuro'
                }
            };
            if (mensajePHP === "exito_restablecer_contrasena") {
                config.title = '<span class="titulo-alerta confirmacion">Éxito</span>';
                config.html = '<div class="custom-alert"><div class="contenedor-imagen"><img src="../imagenes/moto.png" alt="Confirmacion" class="moto"></div><p>Contraseña actualizada exitosamente.</p></div>';
                Swal.fire(config).then(() => window.location.href = '../index.php');
            } else {
                if (mensajePHP === "sin_coincidencia_contrasenas") {
                    config.title = '<span class="titulo-alerta error">Error</span>';
                    config.html = '<div class="custom-alert"><div class="contenedor-imagen"><img src="../imagenes/llave.png" alt="Error" class="llave"></div><p>Las contraseñas no coinciden. Inténtelo de nuevo.</p></div>';
                } else if (mensajePHP === "contrasena_invalida") {
                    config.title = '<span class="titulo-alerta advertencia">Advertencia</span>';
                    config.html = '<div class="custom-alert"><div class="contenedor-imagen"><img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo"></div><p>La contraseña no cumple con los requisitos de seguridad.</p></div>';
                } else {
                    config.title = '<span class="titulo-alerta error">Error</span>';
                    config.html = '<div class="custom-alert"><div class="contenedor-imagen"><img src="../imagenes/llave.png" alt="Error" class="llave"></div><p>Hubo un problema al actualizar la contraseña.</p></div>';
                }
                Swal.fire(config);
            }
        }
    </script>
</body>
</html>