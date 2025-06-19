<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/componentes/header.php';
// Datos de usuario para el bloque fijo
$id = $_SESSION['usuario_id'];
$sql = "SELECT nombre, apellido, rol, foto FROM usuario WHERE identificacion = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aceso Denegado</title>
  <link rel="stylesheet" href="../componentes/header.css">
  <link rel="stylesheet" href="../css/acceso_denegado.css">
</head>

<body>
  <div class="acceso-denegado-overlay">
    <div class="card-container">
      <h2 class="card-title">Acceso Denegado</h2>
      <div class="card">
        <div class="icon-warning">
          <animated-icons
            src="https://animatedicons.co/get-icon?name=Grab%20Attention&style=minimalistic&token=4ff92fe8-3f2e-471b-beff-2c28789b1813"
            trigger="loop"
            attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#0056B3FF","background":"#FFFFFFFF"}}'
            height="300"
            width="300"></animated-icons>
        </div>
        <p>¡Ups! Parece que no tienes permisos para acceder a esta página</p>
        <a href="../html/inicio.php" class="btn">Volver al Inicio</a>
      </div>
    </div>
  </div>
</body>

</html>