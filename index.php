<?php
session_start();

$mensaje = null;  // Variable para almacenar el estado del mensaje

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identificacion = htmlspecialchars(trim($_POST['identificacion']));
    $contrasena = trim($_POST['contrasena']);

    if (empty($identificacion) || empty($contrasena)) {
        $mensaje = 'campos_vacios';
    } else {
        $conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");

        if (!$conexion) {
            die("Error en la conexión: " . mysqli_connect_error());
        }

        $stmt = $conexion->prepare("SELECT * FROM usuario WHERE identificacion = ?");
        $stmt->bind_param("s", $identificacion);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            if (password_verify($contrasena, $usuario['contrasena'])) {
                $_SESSION['usuario_id'] = $usuario['identificacion'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];

                header("Location: ../html/inicio.php");
                exit;
            } else {
                $mensaje = 'contrasena_incorrecta';
            }
        } else {
            $mensaje = 'usuario_no_encontrado';
        }
        $stmt->close();
        mysqli_close($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">

    <title>Moto Racer</title>
    <link rel="stylesheet" href="../style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
</head>

<body>

    <div class="container">
        <img src="/imagenes/motoracer.webp" alt="Fondo" class="fondo">
        <img src="/imagenes/LOGO.png" alt="Logo" class="logo_inicio"
            style="filter: drop-shadow(0 0 0.5rem rgb(255, 255, 255))">
        <div class="barra"></div>
        <h1>INICIAR SESIÓN</h1>
        <form name="formulario" method="post" action="">
            <div class="input-wrapper">
                <i class='bx bx-user-circle'></i>
                <input type="text" placeholder="Identificación" name="identificacion" require
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
            </div>
            <div class="input-wrapper">
                <i class='bx bx-lock-alt'></i>
                <input type="password" placeholder="Contraseña" id="password" name="contrasena" require />
                <i id="togglePassword"
                    class='bx bx-hide'
                    style="position: absolute; right: 0rem; left: 85%; top: 50%; transform: translateY(-50%); cursor: pointer; color:black;">
                </i>
            </div>

            <button type="submit" class="boton">Iniciar Sesión</button>
            <div class="container_boton">
                <a href="../html/olvidar.php" class="boton">¿Olvidaste tu Contraseña?</a>
            </div>
    </div>
    </form>
    </div>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', () => {
            // Alterna el tipo de input
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Cambia el icono: de ojo abierto a ojo cerrado
            togglePassword.classList.toggle('bx-show');
            togglePassword.classList.toggle('bx-hide');
        });


        const mensaje = "<?php echo $mensaje; ?>";

        if (mensaje === "campos_vacios") {
            Swal.fire({
                title: '<span class="titulo-alerta advertencia">Advertencia</span>',
                html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                    </div>
                    <p>Por favor, llena todos los campos.</p>
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
        } else if (mensaje === "contrasena_incorrecta") {
            Swal.fire({
                title: '<span class="titulo-alerta error">Error</span>',
                html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/llave.png" alt="Error" class="llave">
                    </div>
                    <p>Contraseña incorrecta.</p>
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
        } else if (mensaje === "usuario_no_encontrado") {
            Swal.fire({
                title: '<span class="titulo-alerta error">Error</span>',
                html: `
                <div class="custom-alert">
                    <div class="contenedor-imagen">
                        <img src="../imagenes/llave.png" alt="Error" class="llave">
                    </div>
                    <p>Usuario no encontrado.</p>
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
        }
    </script>






</body>

</html>