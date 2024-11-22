<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/info.css">
    <link rel="stylesheet" href="/componentes/header.html">
    <link rel="stylesheet" href="/componentes/header.css">
    <script src="/js/index.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
</head>

<body>
    <!-- Aquí se cargará el header -->
    <div id="menu"></div>

    <!-- Formulario -->
    <div class="container">
        <div class="form-container">
            <h1>Usuario</h1>
            <div class="profile-pic">
                <img src="https://via.placeholder.com/100" alt="Usuario">
            </div>
            <form action="#" method="POST">
                <div class="input-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre">
                </div>
                <div class="input-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido" placeholder="Ingresa tu apellido">
                </div>
                <div class="input-group">
                    <label for="estado">Estado</label>
                    <input type="text" id="estado" name="estado" placeholder="Estado actual">
                </div>
                <div class="input-group">
                    <label for="celular">Celular</label>
                    <input type="tel" id="celular" name="celular" placeholder="Número de celular">
                </div>
                <div class="input-group">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" placeholder="Agrega una descripción"></textarea>
                </div>
                <div class="input-group">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" id="correo" name="correo" placeholder="ejemplo@correo.com">
                </div>
                <div class="input-group">
                    <label for="cargo">Cargo</label>
                    <input type="text" id="cargo" name="cargo" placeholder="Cargo">
                </div>
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="********">
                </div>
                <button type="submit" class="btn">Guardar</button>
            </form>
        </div>
    </div>
</body>

</html>

 


