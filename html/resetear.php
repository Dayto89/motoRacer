<?php
session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: ../index.php");
    exit;
}
$mensaje = null;  // Variable para almacenar el estado del mensaje

if ($_POST) {
    $correo = $_SESSION['correo'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Validar parámetros de seguridad de la contraseña
    $cumpleRequisitos = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $nueva_contrasena);

    if ($nueva_contrasena === $confirmar_contrasena) {
        if ($cumpleRequisitos) {
            $nueva_contrasena_hashed = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

            $conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
            $sql = "UPDATE usuario SET contraseña='$nueva_contrasena_hashed', codigo_recuperacion=NULL WHERE correo='$correo'";
            if ($conexion->query($sql) === TRUE) {
                $mensaje = 'exito_restablecer_contrasena';
                session_unset();
                session_destroy();
            } else {
                $mensaje = 'error_restablecer_contrasena';
            }
            $conexion->close();
        } else {
            $mensaje = 'contrasena_invalida';
        }
    } else {
        $mensaje = 'sin_coincidencia_contrasenas';
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Restablecer Contraseña</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <link rel="stylesheet" href="/css/resetear.css">
    <link rel="stylesheet" href="../css/alertas.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');

        .requisitos {
            list-style-type: disc;
            margin-top: 10px;
            margin-left: 20px;
            color: #444;
            font-size: 14px;
            line-height: 1.6;
        }

        .requisitos li {
            text-decoration: none;
        }

        .requisitos li.validado {
            color: green;
            text-decoration: underline;
        }

        #mensaje-seguridad {
            font-weight: bold;
            color: green;
            margin-left: 20px;
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="../imagenes/motoracer.png" alt="Fondo" class="fondo">
        <img src="../imagenes/LOGO.png" alt="Logo" class="logo_inicio"
            style="filter: drop-shadow(0 0 0.5rem rgb(255, 255, 255))">
        <div class="barra"></div>

        <h1>RESTABLECER CONTRASEÑA</h1>
        <form name="formulario" method="post" action="">

            <div class="campo" style="position: relative;">
                <label for="nueva_contrasena">Nueva Contraseña:</label>
                <input type="password" name="nueva_contrasena" id="nueva_contrasena" required>
                <i id="togglePassword" class='bx bx-hide' style="position: absolute; right: 12rem; left: 15rem; top: 67%; transform: translateY(-50%); cursor: pointer; color:black; font-size: 1.5rem; width: 20px; height: 20px;"></i>

                <!-- Ventana flotante -->
                <div id="tooltip-requisitos" class="ventana-requisitos" style="display: none;">
                    <ul class="requisitos">
                        <li id="min-caracteres">✔ Mínimo 8 caracteres</li>
                        <li id="letra-mayus">✔ Al menos una letra mayúscula</li>
                        <li id="letra-minus">✔ Al menos una letra minúscula</li>
                        <li id="numero">✔ Al menos un número</li>
                        <li id="simbolo">✔ Al menos un símbolo especial</li>
                    </ul>
                    <p id="mensaje-seguridad">✔ Contraseña segura</p>
                </div>
            </div>

            <div class="campo"><label for="confirmar_contrasena">Confirmar Nueva Contraseña:</label>
                <input type="password" name="confirmar_contrasena" id="confirmar_contrasena" required>
                <i id="togglePassword2"
                    class='bx bx-hide'
                    style="position: absolute; right: 12rem; left: 15rem; top: 54%; transform: translateY(-50%); cursor: pointer; color:black; font-size: 1.5rem; width: 20px; height: 20px;">
                </i>
            </div>

            <div class="button_container">
                <button type="submit" name="restablecer" class="boton">Restablecer Contraseña</button>
            </div>

        </form>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const togglePassword2 = document.querySelector('#togglePassword2');
        const passwordInput = document.querySelector('#nueva_contrasena');
        const passwordInput2 = document.querySelector('#confirmar_contrasena');
        const tooltip = document.getElementById("tooltip-requisitos");
        const mensajeSeguridad = document.getElementById("mensaje-seguridad");

        const reglas = {
            minCaracteres: document.getElementById("min-caracteres"),
            mayus: document.getElementById("letra-mayus"),
            minus: document.getElementById("letra-minus"),
            numero: document.getElementById("numero"),
            simbolo: document.getElementById("simbolo")
        };

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            togglePassword.classList.toggle('bx-show');
            togglePassword.classList.toggle('bx-hide');
        });

        togglePassword2.addEventListener('click', () => {
            const type = passwordInput2.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput2.setAttribute('type', type);
            togglePassword2.classList.toggle('bx-show');
            togglePassword2.classList.toggle('bx-hide');
        });

        passwordInput.addEventListener("focus", () => {
            tooltip.style.display = "block";
        });

        passwordInput.addEventListener("blur", () => {
            setTimeout(() => {
                tooltip.style.display = "none";
            }, 200);
        });

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

            mensajeSeguridad.style.display = (cumpleMin && tieneMayus && tieneMinus && tieneNumero && tieneSimbolo) ? "block" : "none";
        });

        const mensaje = "<?php echo $mensaje; ?>";

        if (mensaje === "exito_restablecer_contrasena") {
            Swal.fire({
                title: '<span class="titulo-alerta confirmacion">Éxito</span>',
                html: `<div class="custom-alert"><div class="contenedor-imagen"><img src="../imagenes/moto.png" alt="Confirmacion" class="moto"></div><p>Contraseña actualizada exitosamente.</p></div>`,
                background: 'hsl(0deg 0% 100% / 76%)',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#007bff',
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    container: 'fondo-oscuro'
                }
            }).then(() => {
                window.location.href = '../index.php';
            });
        } else if (mensaje === "error_restablecer_contrasena" || mensaje === "parametros_invalidos") {
            Swal.fire({
                title: '<span class="titulo-alerta error">Error</span>',
                html: `<div class="custom-alert"><div class="contenedor-imagen"><img src="../imagenes/llave.png" alt="Error" class="llave"></div><p>Error al actualizar la contraseña.</p></div>`,
                background: 'hsl(0deg 0% 100% / 76%)',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#007bff',
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    container: 'fondo-oscuro'
                }
            });
        } else if (mensaje === "sin_coincidencia_contrasenas") {
            Swal.fire({
                title: '<span class="titulo-alerta error">Error</span>',
                html: `<div class="custom-alert"><div class="contenedor-imagen"><img src="../imagenes/llave.png" alt="Error" class="llave"></div><p>Las contraseñas no coinciden. Inténtelo de nuevo.</p></div>`,
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
</body>

</html>