<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

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
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);

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
        echo "<script>alert('Datos actualizados con éxito!'); </script>";
        echo "<script>window.location.reload(info.php);</script>";
    } else {
        echo "<script>alert('Error al actualizar los datos: " . mysqli_error($conexion) . "');</script>";
    } 
    
}

mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de Usuario</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <link rel="stylesheet" href="../css/info.css"> <!-- Archivo CSS externo -->
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
    <link rel="stylesheet" href="../componentes/header.php">
    <link rel="stylesheet" href="../componentes/header.css">
    <script src="../js/header.js"></script>
    <script src="/js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div id="menu"></div>
    <!-- Información del usuario -->
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

            <!-- Botón para abrir el popup -->
            <div class="boton-editar">
                <button class="btn-abrir" onclick="abrirPopup()"><i class='bx bx-plus bx-tada'></i>Editar</button>
            </div>

        </div>
    </div>

    <!-- Popup -->
    <div class="overlay" id="overlay">
        <div class="popup">
            <h2>Editar Usuario</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="profile-pic">
                    <div class="profile-pic">
                        <?php if (!empty($usuario['foto'])): ?>
                            <img id="profilePic" src="data:image/jpeg;base64,<?php echo base64_encode($usuario['foto']); ?>" alt="Usuario">
                        <?php else: ?>
                            <img id="profilePic" src="../imagenes/icono.png" alt="Usuario por defecto">
                        <?php endif; ?>
                    </div>
                    <input type="file" name="foto" id="imageInput" accept="image/*">
                </div>
                <input type="text" name="nombre" placeholder="Nombre" value="<?php echo $nombre; ?>">
                <input type="text" name="apellido" placeholder="Apellido" value="<?php echo $apellido; ?>">
                <input type="text" name="celular" placeholder="Celular" value="<?php echo $celular; ?>">
                <input type="email" name="correo" placeholder="Correo Electrónico" value="<?php echo $correo; ?>">
                <div>
                    <button type="button" class="btn-cancelar" onclick="cerrarPopup()">Cancelar</button>
                    <button type="submit" class="btn-guardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        // Mostrar el popup
        function abrirPopup() {
            document.getElementById('overlay').style.display = 'block';
            // Copiar la imagen de perfil al popup
            document.getElementById('popupProfilePic').src = document.getElementById('profilePic').src;
        }

        // Cerrar el popup
        function cerrarPopup() {
            document.getElementById('overlay').style.display = 'none';
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
    </script>
</body>

</html>