<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Cambio Contraseña/Moto Racer</title>
    <link rel="stylesheet" href="/css/olvidar.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
        </style>
</head>

<body>
    <div class="container">
        <img src="/imagenes/motoracer.png" alt="Fondo" class="fondo">
        <img src="/imagenes/LOGO.png" alt="Logo" class="logo_inicio" style="filter: drop-shadow(0 0 0.5rem rgb(255, 255, 255))">
        <div class="barra"></div>
        <h1>CAMBIO CONTRASEÑA</h1>
        <form name="formulario" method="post" action="/send/">
            <div class="input-wrapper">
                <i class ='bx bx-user-circle'></i>
                <input type="text" placeholder="Usuario" />
            </div>
            <div class="input-wrapper">
                <i class = 'bx bx-lock-alt'></i>
                <input type="password" placeholder="Nueva Contraseña" />
            </div>
            <div class="container_boton">
                <a href="../index.php" class="iniciar">Iniciar Sesión</a>
                <a href="../index.php" class="iniciar">Actualizar</a>
            </div>

        </form>
    </div>
</body>

</html>