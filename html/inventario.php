<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inventario</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link rel="stylesheet" href="../css/inventario.css" />
    <link rel="stylesheet" href=" ../componentes/header.html">
    <link rel="stylesheet" href="../componentes/header.css">
    <script src="/js/index.js"></script>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap");
    </style>
  </head>
  <body>
    <!-- Aquí se cargará el header -->
    <div id="menu"></div>


     <!--Barra de búsqueda fija con efecto deslizante -->
     <div class="search-bar">
      <form class="d-flex" role="search">
        <button
          class="search-icon"
          type="submit"
          aria-label="Buscar"
          title="Buscar" >
          <i class="bx bx-search-alt-2 icon"></i
          >
        </button>
        <input class="form-control" type="search" placeholder="Buscar" />
      </form>
    </div>

    <!-- Contenido principal -->
    <div class="main-content">
      
      <!-- Sección del Inventario -->

      <div id="inventario" class="form-section">
        <h1>Inventario</h1>
        <table>
          <thead>
            <tr>
              <th>Código</th>
              <th>Nombre</th>
              <th>Iva</th>
              <th>Precio 1</th>
              <th>Precio 2</th>
              <th>Precio 3</th>
              <th>Cantidad</th>
              <th>Descripción</th>
              <th>Categoria</th>
              <th>Marca</th>
              <th>Unidad Medida</th>
              <th>Ubicación</th>
              <th>Proveedor</th>
              <th class="text-center">
                <input type="checkbox" />
              </th>
            </tr>
          </thead>
          <tbody>
            <?php include("prueba.php") ?>
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>
