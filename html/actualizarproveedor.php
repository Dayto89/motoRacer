<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>proveedor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/proveedor.css">
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

 <!-- Sección para Actualizar Proveedor -->
 <div id="actualizarProveedor" class="form-section" >
    <h1>Actualizar Proveedor</h1>
    <form id="actualizar-proveedor-form">
      <div class="campo">
        <label for="codigoProveedorActualizar">Código:</label>
        <input
          type="text"
          id="codigoProveedorActualizar"
          name="codigoProveedor"
          required
        /><br />
      </div>
      <div class="campo">
        <label for="nombreProveedorActualizar">Nombre:</label>
        <input
          type="text"
          id="nombreProveedorActualizar"
          name="nombreProveedor"
          required
        /><br />
      </div>
      <div class="button-container">
        <div class="boton">
          <button type="submit">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
</body>
</html>