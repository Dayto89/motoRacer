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
    <script src="https://kit.fontawesome.com/d6f1e7ff1f.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
</head>

<body>
    <div id="menu"></div>
    <h1>Usuario</h1>
    <div class="icono">
        <i class='bx bx-user-circle'></i>
    </div>
    <div class="container_forms">
        <div class="form1">

            <form action="" method="post">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" placeholder="Nombre" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="cargo">cargo</label>
                    <input type="text" id="cargo" placeholder="Cargo" required>
                </div>

        </div>
        <div class="form2">
            
            <form action="" method="post">
                <div class="form-group">
                    <label for="celular">celular</label>
                    <input type="text" id="celular" placeholder="Celular" required>
                </div>
                <div class="form-group">
                    <label for="estado">estado</label>
                    <input type="text" id="estado" placeholder="Estado" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">descripción</label>
                    <input type="text" id="descripcion" placeholder="Descripcion" required>
                </div>
                <script src="/js/index.js"></script>
        </div>
    </div>
</body>

</html>