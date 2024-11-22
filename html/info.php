<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/css/info.css">
    <link rel="stylesheet" href="/componentes/header.html">
    <link rel="stylesheet" href="/componentes/header.css">
    <script src="../js/index.js"></script>
    <style>
        body {
            font-family: 'Merriweather', sans-serif;
            background-color: #222;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            position: relative;
            width: 300px;
            text-align: center;
        }

        
    .user-icon {
        position: absolute;
        top: -160px;
    left: 140px;  
        transform: translateX(-50%);
        background-color: #fff;
        border-radius: 50%;
        width: 150px; /* Cambia el tamaño aquí */
        height: 150px; /* Cambia el tamaño aquí */
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    .user-icon img {
        width: 100px; /* Ajusta el tamaño del ícono dentro del círculo */
        height: 100px; /* Opcional para mantener la proporción */
    }



        .user-card {
            background-color: #fff;
            color: #000;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            position: relative;
            top: 50px;
            right: 60px;
        }

        .user-card h3 {
            margin-top: 20px;
        }

        .user-card p {
            margin: 5px 0;
        }

    </style>
</head>

<body>
<div id="menu"></div>
    <div class="container">
        <!-- Ícono centrado arriba -->
        <div class="user-icon">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAArhJREFUSEu1lUnIT2EUxn8fdoYsZPjMbEzFZ542IgtKFAoLpD4Zig1lnikUFkohU0lImRdkY4jMc8ocIkpENsJ5vs6r977+9/5t/m/dbvfe97zPeZ7znHOrqPCqqvD5lAOoB4wG+gM1QF9P6AZwG7gKnAV+5SVaBNAeOAgMLsPyCjAZeFVqXx7ADGAb0BC4BuwDHgEP/ZAeQDdgGtAP+A7MA3anIKUApgJ7gZ92LTWQTQUSSMJFduhKoAGg2P0xSArQDngANAKGAqKv1cauXcAgf74EzATe+PMQ4CLwzZmF95kiC0wHDgTWWNbLPbgauAs0S+h/BHoB7/z9OmAxcMHAhoe9MQM5RXrfB3q7RNp32LSf4AxWGHh9QHfV6YjVZqIfJonkrp4eL5dlGMwHtlhGtcDOKNvPQFMrYNtIkk7AM+AD0DLaOxvYDsz1ewYgZCrtL0dBOqS5FU+HvvD3eQDDXCLZe0rK4LVnqQLLdmEFYLFa7axXme+nA4eASdHeFsB7s+9Ls3bHFOAr0Bho5ZtCnJ5vJVLom4qrWolhWDLEW+CLy5qR6LFl1MVHw5nEMU2AhU77N3AA2JgwVcgYGynHgXte7AzAHu/MJcD6CEBOk89lyWDVTz6LZGsBhiXpZO8dxmxWKtEoa/vTXsjuwA+zoe4nvMAJqbrHp5612Kt2Gidy20hL6lwKIH/Lx8pUdl3mB8iG0vW8F09xHYARZufWXovOBrAZmGMSX7cJOyAwS0dFaDYdctTGxnjgZjSmYxaKVTOpscJeje0+wJ2wsdSwUw3WRiepcCdL6WMjZBxwLPq2wJn8fZU3ruV3SaQlfTWGNWOeWy9oggaJ1AtdfZ/m0IY0kaIfjv5eW91BOQTqXqvrNWZUv39WuV+mAsZ6b6hH5CrprB/PE3fYqSL0/wEoii/7reIAfwA4LocZGRNE4QAAAABJRU5ErkJggg==" 
                alt="Ícono Usuario" width="40" height="40">
        </div>

        <!-- Recuadro del usuario -->
        <div class="user-card">
            <h3>Juan Pérez</h3>
            <p><strong>Correo:</strong> juan.perez@example.com</p>
            <p><strong>Teléfono:</strong> +123 456 789</p>
        </div>
    </div>
</body>

</html>


