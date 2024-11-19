<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/css/categorias.css">
    <link rel="stylesheet" href="/componentes/header.html">
    <link rel="stylesheet" href="/componentes/header.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
</head>

<body>
    <!-- Aquí se cargará el header -->
    <div id="menu"></div>

    <div id="categorias" class="form-section">
        <h1>Categorías</h1>

        <!-- Contenedor principal -->
        <div class="container">


            <!-- Botón para agregar nueva categoría -->
            <div class="actions">
                <a href="../html/nuevacategoria.html" class="btn-nueva-categoria">Nueva categoría</a>

            </div>

            <!-- Tabla de categorías -->
            <table class="category-table">
                <thead>
                    <tr>

                        <th>Lista de categorías</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Motos</td>


                        <td class="options">
                            <button class="btn-list">Lista de productos</button>
                            <button class="btn-delete">Eliminar</button>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>


        <script src="../js/index.js"></script>
</body>

</html>