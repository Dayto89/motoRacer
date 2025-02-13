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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>proveedor</title>
  <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
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
  <div id="actualizarProveedor" class="form-section">
    <h1>Actualizar Proveedor</h1>
    <form id="actualizar-proveedor-form" method="POST" action="">
      <div class="campo">
        <label for="selectProveedor">Seleccionar Proveedor:</label>
        <select id="selectProveedor" name="selectProveedor" onchange="this.form.submit()">
          <option value="">Selecciona un proveedor</option>
          <?php
          $conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");
          $consulta = "SELECT nit, nombre FROM proveedor";
          $resultado = mysqli_query($conexion, $consulta);

          // Retener el valor seleccionado
          $codigoSeleccionado = isset($_POST['selectProveedor']) ? $_POST['selectProveedor'] : '';

          while ($fila = mysqli_fetch_assoc($resultado)) {
            $selected = ($fila['nit'] == $codigoSeleccionado) ? 'selected' : '';
            echo "<option value='" . $fila['nit'] . "' $selected>" . $fila['nombre'] . "</option>";
          }

          mysqli_close($conexion);
          ?>
        </select>
      </div>

      <?php
      $nit = $nombre = $telefono = $direccion = $correo = $estado = '';

      if (!empty($codigoSeleccionado)) {
        $conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");
        $consulta = "SELECT * FROM proveedor WHERE nit = '$codigoSeleccionado'";
        $resultado = mysqli_query($conexion, $consulta);

        if ($fila = mysqli_fetch_assoc($resultado)) {
          $nit = $fila['nit'];
          $nombre = $fila['nombre'];
          $telefono = $fila['telefono'];
          $direccion = $fila['direccion'];
          $correo = $fila['correo'];
          $estado = $fila['estado'];
        }
        mysqli_close($conexion);
      }
      ?>
      <div class="campo">
        <label for="nit">NIT:</label>
        <input type="text" id="nit" name="nit" value="<?php echo $nit; ?>" required><br>
      </div>
      <div class="campo">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required><br>
      </div>
      <div class="campo">
        <label for="telefono">Telefono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo $telefono; ?>" required><br>
      </div>
      <div class="campo">
        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" value="<?php echo $direccion; ?>" required><br>
      </div>
      <div class="campo">
        <label for="correo">Correo:</label>
        <input type="text" id="correo" name="correo" value="<?php echo $correo; ?>" required><br>
      </div>
      <div class="campo">
        <label for="estado">Estado:</label>
        <input type="text" id="estado" name="estado" value="<?php echo $estado; ?>" required><br>
      </div>
      <div class="button-container">
        <div class="boton">
          <button type="submit" name="guardar">Guardar</button>
        </div>
      </div>
    </form>
  </div>
  <!-- Actualizar Proveedor al pulsar el botón Guardar -->
  <?php

  /* Si el boton Guardar es presionado */

  if (isset($_POST['guardar'])) {
    $conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");
    if (isset($_POST['selectProveedor']) != "") {
      $nit = $_POST['nit'];
      $nombre = $_POST['nombre'];
      $telefono = $_POST['telefono'];
      $direccion = $_POST['direccion'];
      $correo = $_POST['correo'];
      $estado = $_POST['estado'];

      $consulta = "UPDATE proveedor SET nit = '$nit', nombre = '$nombre', telefono = '$telefono', direccion = '$direccion', correo = '$correo', estado = '$estado' WHERE nit = '$nit'";
      $resultado = mysqli_query($conexion, $consulta);
      if ($resultado) {
        echo "<script>alert('Proveedor actualizado con éxito!')</script>";
      } else {
        echo "<script>alert('Error al actualizar el proveedor!')</script>";
      }
    }
    mysqli_close($conexion);
  }


  ?>
</body>

</html>