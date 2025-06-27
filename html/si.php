<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

//require_once $_SERVER['DOCUMENT_ROOT'] . '../html/verificar_permisos.php';
// Obtener datos del usuario para mostrarlos en la página
$usuarioId = $_SESSION['usuario_id'];
$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');

if (!$conexion) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

$consulta = "SELECT * FROM usuario WHERE identificacion = '$usuarioId'";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
    $usuario = $resultado->fetch_assoc();
    $nombre = $usuario['nombre'];
    $apellido = $usuario['apellido'];
    $estado = $usuario['estado'];
    $celular = $usuario['telefono'];
    $correo = $usuario['correo'];
    $cargo = $usuario['rol'];
    $foto = $usuario['foto'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
    $celular = mysqli_real_escape_string($conexion, $_POST['celular']);
    if (empty($_POST['correo'])) {
        // usamos el correo que cargamos al inicio ($usuario['correo'])
        $correo = $usuario['correo'];
    } else {
        $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    }
    // Chequear duplicado de correo en otros usuarios
    $check = mysqli_query($conexion, "SELECT COUNT(*) AS cnt FROM usuario WHERE correo = '$correo' AND identificacion <> '$usuarioId'");
    $rowCheck = mysqli_fetch_assoc($check);

    if ($rowCheck['cnt'] > 0) {
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
                        <p>No puedes registrar ese correo porque ya existe en otro usuario.</p>
                    </div>
                `,
                background: '#ffffffdb',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#3085d6',
            customClass: {
                popup: 'swal2-border-radius',
                confirmButton: 'btn-aceptar',
                container: 'fondo-oscuro'
            },
            allowOutsideClick: false,
            allowEscapeKey: false

            }).then(() => {
                window.location.href = 'información.php';
            });
        });
    </script>";
        mysqli_close($conexion);
        exit();
    }


    // Verificar si se subió una imagen
    if (!empty($_FILES['foto']['tmp_name'])) {
        $imagen = file_get_contents($_FILES['foto']['tmp_name']); // Convertir a binario
        $imagen = mysqli_real_escape_string($conexion, $imagen);
        $consulta = "UPDATE usuario SET 
            nombre = '$nombre',
            apellido = '$apellido',
            estado = '$estado',
            telefono = '$celular',
            correo = '$correo',
            rol = '$cargo',
            foto = '$imagen'
            WHERE identificacion = '$usuarioId'";
    } else {
        $consulta = "UPDATE usuario SET 
            nombre = '$nombre',
            apellido = '$apellido',
            estado = '$estado',
            telefono = '$celular',
            correo = '$correo',
            rol = '$cargo'
            WHERE identificacion = '$usuarioId'";
    }

    $resultado = mysqli_query($conexion, $consulta);



    if ($resultado) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: `<span class='titulo-alerta confirmacion'>Datos actualizados</span>`,
                    html: `
                        <div class='alerta'>
                           <div class=\"contenedor-imagen\">
                                <img src=\"../imagenes/moto.png\" alt=\"Confirmación\" class=\"moto\">
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
                }).then(() => {
                    window.location.href = 'información.php'; // Redirige después de cerrar el alert
                });
            });
        </script>";
    } else {

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
                                        <p>Error al actualizar los datos.</p>
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
    }
}

mysqli_close($conexion);
include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/accesibilidad-widget.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de Usuario</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <link rel="stylesheet" href="../css/info.css"> <link rel="stylesheet" href="../css/alertas.css">
    <link rel="stylesheet" href="../componentes/header.php">
    <link rel="stylesheet" href="../componentes/header.css">
    <script src="../js/header.js"></script>
    <script src="/js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .required::after {
            content: " *";
            color: red;
        }

/* --- INICIO DE ESTILOS RESPONSIVE --- */

/* --- ESTILOS PARA MÓVILES (Hasta 767px de ancho) --- */
@media screen and (max-width: 767px) {
    
    :root {
        --ancho-menu-lateral: 70px;
    }

    /* 1. Estructura del body se mantiene */
    body {
        display: block;
        position: relative;
        padding-left: var(--ancho-menu-lateral);
        box-sizing: border-box;
        background-attachment: fixed;
    }

    /* 2. Barra superior se mantiene */
    .barra-navegacion {
        position: fixed;
        top: 0;
        left: var(--ancho-menu-lateral);
        width: calc(100% - var(--ancho-menu-lateral));
        z-index: 5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 15px;
        box-sizing: border-box;
        min-height: 60px;
        background-color: #0d47a1;
    }

    /* 3. Volvemos al contenedor con scroll interno completo */
    .container {
        width: 95%; 
        max-width: 500px; 
        margin: 80px auto 30px auto; 
        max-height: calc(100vh - 120px); 
        padding: 25px; 
        box-sizing: border-box;
        background: rgb(211 210 210 / 84%);
        border-radius: 15px;
        box-shadow: 0 4px 20px #0b111a;
        
        /* El scroll vuelve a estar en todo el contenedor */
        overflow-y: auto; 
        
        /* !! LA SOLUCIÓN MÁGICA: Evita el "rebote" al final del scroll !! */
        overscroll-behavior-y: contain;
    }
    
    /* El resto de estilos vuelve a la versión anterior */
    h1 {
        font-size: 28px;
        text-align: center;
        margin-left: 0;
        margin-top: 0;
        margin-bottom: 20px;
    }

    .form-container {
        /* Ya no necesita estilos de flexbox ni scroll */
    }

    .profile-pic {
        margin-bottom: 20px;
    }

    .info-group {
        width: 100%;
        margin-left: 0;
        margin-top: 20px;
        align-items: center;
    }

    .info-group span {
        width: 90%;
        text-align: center;
    }

    .btn-abrir {
        margin: 25px auto 15px auto;
        display: block;
        width: 50%;
        min-width: 150px;
        padding: 12px;
    }

    /* --- POPUP DE EDICIÓN RESPONSIVO --- */
    .popup {
        width: 90%;
        max-height: 85vh;
        padding: 20px 15px;
        overflow-y: auto;
    }
    
    .popup h2 { font-size: 24px; }
    .popup .campo, .popup .input-group { width: 100%; margin-left: 0; }
    .popup input { width: 90%; margin: 0 auto 12px auto; display: block; }
    .popup label { text-align: center; display: block; margin-bottom: 8px; }
    .btn-verificar-correo { width: 90%; margin: 10px auto; display: block; }
    #verificacionWrapper { width: 100%; }
    .input-group input { width: 100%; margin-left: 0; }
    .input-group p { margin-left: 0; width: 100%; }
    .button_container { display: flex; flex-direction: column; gap: 10px; align-items: center; width: 100%; }
    .btn-guardar1, .btn-cancelar1 { width: 80%; padding: 12px; }
}

/* --- ESTILOS PARA TABLETS --- */
@media screen and (min-width: 768px) and (max-width: 1024px) {
    .container {
        width: 80%;
        max-width: 80%;
        margin: 20px auto;
    }

    .popup {
        width: 70%;
    }
}
    </style>
</head>

<body>
    <?php include 'boton-ayuda.php'; ?>

    <div id="menu"></div>
    <nav class="barra-navegacion">
        <div class="ubica"> Usuario / Información </div>
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
    <div class="fondo-opaco"></div>
    <div class="container">


        <h1>Usuario</h1>
        <div class="profile-pic">
            <?php if (!empty($usuario['foto'])): ?>
                <img id="profilePic" src="data:image/jpeg;base64,<?php echo base64_encode($usuario['foto']); ?>" alt="Usuario">
            <?php else: ?>
                <img id="profilePic" src="../imagenes/icono.jpg" alt="Usuario por defecto">
            <?php endif; ?>
        </div>
        <div class="form-container">
            <div class="info-group">
                <label for="nombre">Nombre</label>
                <span id="nombre"><?php echo $nombre; ?></span>
            </div>
            <div class="info-group">
                <label for="apellido">Apellido</label>
                <span id="apellido"><?php echo $apellido; ?></span>
            </div>
            <div class="info-group">
                <label for="estado">Estado</label>
                <span id="estado"><?php echo $estado; ?></span>
            </div>
            <div class="info-group">
                <label for="celular">Celular</label>
                <span id="celular"><?php echo $celular; ?></span>
            </div>
            <div class="info-group">
                <label for="correo">Correo Electrónico</label>
                <span id="correo"><?php echo $correo; ?></span>
            </div>
            <div class="info-group">
                <label for="cargo">Cargo</label>
                <span id="cargo"><?php echo $cargo; ?></span>
            </div>

            <div class="boton-editar">
                <button class="btn-abrir" onclick="abrirPopup()">Editar</button>
            </div>

        </div>
    </div>

    <div class="overlay" id="overlay">
        <div class="popup" id="popup">
            <h2>Editar Usuario</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="image-upload-container">
                    <div class="avatar-upload">
                        <img id="popupProfilePic" class="preview"
                            src="data:image/jpeg;base64,<?php echo base64_encode($usuario['foto']); ?>"
                            alt="Previsualización">
                        <input type="file" name="foto" id="imageInput" accept="image/*" />
                        <label for="imageInput" class="upload-overlay"> <span class="upload-text">Seleccionar imagen</span>
                            <i class="bx bx-camera"></i>
                        </label>
                    </div>
                </div>
                <div class="campo"><label class="required" for="nombre">Nombre: </label>
                    <input type="text" name="nombre" placeholder="Nombre" value="<?php echo $nombre; ?>">
                </div>
                <div class="campo"><label class="required" for="apellido">Apellido: </label>
                    <input type="text" name="apellido" placeholder="Apellido" value="<?php echo $apellido; ?>">
                </div>
                <div class="campo">
                    <label class="required" for="telefono">Teléfono: </label>
                    <input type="text" name="celular" placeholder="Celular"
                        value="<?php echo $celular; ?>"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>

                <div id="correoContenedor"></div>
                <button type="button"
                    id="btnAbrirModalCorreo"
                    class="btn-verificar-correo">
                    Cambiar correo
                </button>
                <div id="verificacionWrapper" class="hidden">
                    <p id="mensajeModal">Por favor ingrese el correo para continuar con el proceso de registro.</p>

                    <div id="correoSection">
                        <div class="input-group">
                            <input type="email"
                                id="inputCorreo"
                                placeholder="Ingresa tu correo">
                        </div>
                        <div id="correoSectionButtons" class="modal-actions">
                            <button type="button"
                                id="btnEnviarCodigo"
                                class="btn-guardar">
                                Enviar código
                            </button>
                        </div>
                    </div>

                    <div id="codigoSection" class="hidden">
                        <div class="input-group">
                            <p>Ingresa el código recibido:</p>
                            <input type="text"
                                id="inputCodigo"
                                placeholder="Código">
                        </div>
                        <div class="modal-actions">
                            <button type="button"
                                id="btnVerificarCodigo"
                                class="btn-guardar">
                                Verificar código
                            </button>
                        </div>
                    </div>
                </div>
                <div class="button_container">
                    <button type="button"
                        class="btn-cancelar1"
                        onclick="cerrarPopup()">
                        Cancelar
                    </button>
                    <button type="submit" class="btn-guardar1">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // -----------------------------
            // 1) REFERENCIAS A ELEMENTOS
            // -----------------------------
            const btnAbrirModal = document.getElementById('btnAbrirModalCorreo');
            const verificacionWrapper = document.getElementById('verificacionWrapper');
            const btnEnviarCodigo = document.getElementById('btnEnviarCodigo');
            const btnVerificarCodigo = document.getElementById('btnVerificarCodigo');

            const inputCorreo = document.getElementById('inputCorreo');
            const inputCodigo = document.getElementById('inputCodigo');
            const mensajeModal = document.getElementById('mensajeModal');

            const correoSectionButtons = document.getElementById('correoSectionButtons');
            const codigoSection = document.getElementById('codigoSection');

            // Donde se mostrará el input final de correo verificado:
            const contenedorCorreoFinal = document.getElementById('correoContenedor');
            const overlay = document.getElementById('overlay');
            const popup = document.getElementById('popup');


            // -----------------------------
            // 2) FUNCIONES AUXILIARES
            // -----------------------------
            function resetearVerificacion() {
                mensajeModal.textContent = 'Por favor ingrese el correo para continuar con el proceso de registro.';
                mensajeModal.style.color = 'black';
                mensajeModal.style.fontWeight = 'bold';

                inputCorreo.value = '';
                inputCodigo.value = '';

                // Mostrar sección "Correo" y ocultar "Código"
                codigoSection.classList.add('hidden');
                correoSectionButtons.classList.remove('hidden');

                inputCorreo.disabled = false;
                btnEnviarCodigo.disabled = false;
            }

            function mostrarSeccionCorreo() {
                correoSectionButtons.classList.remove('hidden');
                codigoSection.classList.add('hidden');
                inputCorreo.disabled = false;
                btnEnviarCodigo.disabled = false;
            }

            function mostrarSeccionCodigo() {
                correoSectionButtons.classList.add('hidden');
                codigoSection.classList.remove('hidden');
            }

            // -----------------------------
            // 3) ABRIR / CERRAR “SECCIÓN” DE VERIFICACIÓN
            // -----------------------------
            btnAbrirModal.addEventListener('click', () => {
                // Oculta la sección final de correo si hubiera quedado algo
                contenedorCorreoFinal.innerHTML = '';
                // Muestra el bloque de verificación
                verificacionWrapper.classList.remove('hidden');
                resetearVerificacion();
            });
            // -----------------------------
            // 4) ENVIAR CÓDIGO AL CORREO
            // -----------------------------
            btnEnviarCodigo.addEventListener('click', () => {
                const correo = inputCorreo.value.trim();
                const regexCorreo = /^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|hotmail\.com|yahoo\.com)$/;

                if (!correo) {
                    mensajeModal.textContent = 'Por favor ingresa un correo.';
                    mensajeModal.style.color = 'red';
                    return;
                }
                if (!regexCorreo.test(correo)) {
                    mensajeModal.textContent = 'Por favor, ingresa un correo válido. Sugerencia: use @gmail.com, @outlook.com, @hotmail.com o @yahoo.com.';
                    mensajeModal.style.color = 'red';
                    return;
                }

                btnEnviarCodigo.disabled = true;
                mensajeModal.textContent = 'Enviando código...';
                mensajeModal.style.color = 'black';

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
                            mostrarSeccionCodigo();
                            inputCorreo.disabled = true;
                        } else {
                            mensajeModal.textContent = data.message || 'Error al enviar código.';
                            mensajeModal.style.color = '#df2f2f';
                            btnEnviarCodigo.disabled = false;
                        }
                    })
                    .catch(() => {
                        mensajeModal.textContent = 'Error en la conexión.';
                        mensajeModal.style.color = '#df2f2f';
                        btnEnviarCodigo.disabled = false;
                    });
            });

            // -----------------------------
            // 5) VERIFICAR CÓDIGO INGRESADO
            // -----------------------------
            btnVerificarCodigo.addEventListener('click', () => {
                const correo = inputCorreo.value.trim();
                const codigo = inputCodigo.value.trim();

                if (!codigo) {
                    mensajeModal.textContent = 'Por favor ingresa el código.';
                    mensajeModal.style.color = 'red';
                    return;
                }
                mensajeModal.textContent = 'Verificando código...';
                mensajeModal.style.color = 'black';

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
                            verificacionWrapper.classList.add('hidden');
                            btnAbrirModal.classList.add('hidden');
                            // Creamos un contenedor 'campo' como en el resto de tu formulario
                            const campoCorreo = document.createElement('div');
                            campoCorreo.classList.add('campo');

                            // Creamos y configuramos la etiqueta
                            const labelFinal = document.createElement('label');
                            labelFinal.setAttribute('for', 'correoVerificado');
                            labelFinal.textContent = 'Correo:';

                            const inputFinal = document.createElement('input');
                            inputFinal.type = 'email';
                            inputFinal.name = 'correo';
                            inputFinal.id = 'correoVerificado';
                            inputFinal.value = correo;
                            inputFinal.readOnly = true;
                            inputFinal.classList.add('input-group');
                            campoCorreo.appendChild(labelFinal);
                            campoCorreo.appendChild(inputFinal);
                            contenedorCorreoFinal.appendChild(campoCorreo);
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


        function abrirPopup() {
            const overlay = document.getElementById('overlay');
            const popup = document.getElementById('popup');

            overlay.style.display = 'flex';
            // Quitar clase 'closing' en caso de que exista
            popup.classList.remove('closing');
            // Forzar reflow para reiniciar animación si fuese necesario
            void popup.offsetWidth;
            // Añadir clase de apertura
            popup.classList.add('open');
        }

        function cerrarPopup() {
            const overlay = document.getElementById('overlay');
            const popup = document.getElementById('popup');

            // Quitar la clase de apertura
            popup.classList.remove('open');
            // Añadir la clase de cierre
            popup.classList.add('closing');

            // Cuando termine la animación de cierre, ocultamos el overlay
            popup.addEventListener('animationend', function handler() {
                overlay.style.display = 'none';
                // limpiamos clases para la próxima apertura
                popup.classList.remove('closing');
                popup.removeEventListener('animationend', handler);
            });
        }

        // Función para subir imagen
        function uploadImage() {
            const imageInput = document.getElementById('imageInput');
            const popupProfilePic = document.getElementById('popupProfilePic');
            const profilePic = document.getElementById('profilePic');

            if (imageInput.files && imageInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    popupProfilePic.src = e.target.result;
                    profilePic.src = e.target.result;
                }
                reader.readAsDataURL(imageInput.files[0]);
            }
        }
        document.getElementById('imageInput').addEventListener('change', uploadImage);
        overlay.addEventListener('click', e => {
            if (e.target === overlay) {
                cerrarPopup();
            }
        });
    </script>
</body>


</html>