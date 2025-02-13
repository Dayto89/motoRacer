<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Factura</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link rel="stylesheet" href="../css/factura.css" />
    <link rel="stylesheet" href="/componentes/header.html" />
    <link rel="stylesheet" href="/componentes/header.css" />
    <script src="/js/index.js"></script>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap");
    </style>
  </head>
  <body>
    <!-- Aquí se cargará el header -->
    <div id="menu"></div>

    <!-- Contenido principal -->
    <div class="main-content">
      <!-- Sección de Facturas -->
      <div id="facturas" class="form-section" style="display: block">
        <h1>Facturas</h1>
        <div class="submenu">
          <button onclick="showForm('listaProductos')">
            Lista de productos
          </button>
          <button onclick="showForm('descargarLista')">Descargar lista</button>
        </div>
      </div>

      <!-- Sección para Lista de productos -->
      <div id="listaProductos" class="form-section" style="display: none">
        <h1>Lista de productos</h1>

        <table>
          <thead>
            <tr>
              <th>Código</th>
              <th>Nombre</th>
              <th>Fecha</th>
              <th class="text-center">
                <input type="checkbox" />
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>001</td>
              <td>Producto 1</td>
              <td>12/09/2024</td>
              <td class="text-center">
                <i class="fa-solid fa-trash"></i>
              </td>
            </tr>
            <tr>
              <td>002</td>
              <td>Producto 2</td>
              <td>13/09/2024</td>
              <td class="text-center">
                <i class="fa-solid fa-trash"></i>
              </td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td class="text-center">
                <i class="fa-solid fa-trash"></i>
              </td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td class="text-center">
                <i class="fa-solid fa-trash"></i>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- Sección para Descargar lista -->
      <div id="descargarLista" class="form-section" style="display: none;">
        <h1>Descargar lista</h1>
        <p></p>
    </div>
    </div>
  </body>
</html>
