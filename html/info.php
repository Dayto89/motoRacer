<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de Usuario</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <link rel="stylesheet" href="../css/info.css"> <!-- Archivo CSS externo -->
    <script src="/js/index.js"></script>
</head>

<body>
<div id="menu"></div>
    <!-- Información del usuario -->
    <div class="container">
        <div class="form-container">
            <h1>Usuario</h1>
            <div class="profile-pic">
                <img src="https://via.placeholder.com/100" alt="Usuario">
            </div>
            <div class="info-group">
                <label for="nombre">Nombre</label>
                <span id="nombre">Juan</span>
            </div>
            <div class="info-group">
                <label for="apellido">Apellido</label>
                <span id="apellido">Pérez</span>
            </div>
            <div class="info-group">
                <label for="estado">Estado</label>
                <span id="estado">Activo</span>
            </div>
            <div class="info-group">
                <label for="celular">Celular</label>
                <span id="celular">+123456789</span>
            </div>
            <div class="info-group">
                <label for="descripcion">Descripción</label>
                <span id="descripcion">Administrador del sistema.</span>
            </div>
            <div class="info-group">
                <label for="correo">Correo Electrónico</label>
                <span id="correo">juan.perez@correo.com</span>
            </div>
            <div class="info-group">
                <label for="cargo">Cargo</label>
                <span id="cargo">Gerente</span>
            </div>
            <div class="info-group">
                <label for="password">Contraseña</label>
                <span id="password">********</span>
            </div>

            <!-- Botón para abrir el popup -->
            <button class="btn-abrir" onclick="abrirPopup()">+ Editar</button>
        </div>
    </div>

    <!-- Popup -->
    <div class="overlay" id="overlay">
        <div class="popup">
            <h2>Editar Usuario</h2>
            <form>
                <input type="text" placeholder="Nombre" value="Juan">
                <input type="text" placeholder="Apellido" value="Pérez">
                <input type="text" placeholder="Estado" value="Activo">
                <input type="text" placeholder="Celular" value="+123456789">
                <input type="text" placeholder="Descripción" value="Administrador del sistema.">
                <input type="email" placeholder="Correo Electrónico" value="juan.perez@correo.com">
                <input type="text" placeholder="Cargo" value="Gerente">
                <input type="password" placeholder="Nueva Contraseña">
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
        }

        // Cerrar el popup
        function cerrarPopup() {
            document.getElementById('overlay').style.display = 'none';
        }
    </script>
</body>

</html>





 


