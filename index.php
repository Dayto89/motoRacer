<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moto Racer</title>
    <link rel="stylesheet" href="./style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
        </style>
</head>

<body>
    <div class="container">
        <img src="/imagenes/motoracer.png" alt="Fondo" class="fondo">
        <img src="/imagenes/LOGO.png" alt="Logo" class="logo_inicio">
        <div class="barra"></div>
        <h1>INICIAR SESIÓN</h1>
        <form name="formulario" method="post" action="/send/">
            <div class="input-wrapper">     
                <i class='bx bx-user-circle'></i>
                <input type="text" placeholder="Usuario" />
            </div>
            <div class="input-wrapper">
                <i class='bx bx-lock-alt'></i>
                <input type="password" placeholder="Contraseña" />
            </div>
            <div class="guardar">
                <input type="checkbox" name="username"> Guardar Contraseña
            </div>
            <a href="/html/inicio.html" class="boton">Ingresar</a>
            <a href="/html/registro.html" class="boton">Registrarse</a>
            <div class="container_boton">
               <a href="/html/olvidar.html" class="boton">¿ Olvidaste tu Contraseña ?</a>
               
            </div>
        </form>
    </div>
</body>
</html>