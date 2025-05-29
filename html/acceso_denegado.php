<?php


include_once $_SERVER['DOCUMENT_ROOT'].'/componentes/header.php';
?>

<style>
    .container {
        margin-top: 100px;
    }

    p {
        font-size: 30px;
        color: white;
    }
</style>

<div class="container">
    <h2>Acceso Denegado</h2>
    <p>No tienes permisos para acceder a esta sección.</p>
    <a href="dashboard.php" class="btn btn-primary">Volver al Inicio</a>
</div>
  <div class="userInfo">
    <!-- Nombre y apellido del usuario y rol -->
    <!-- Consultar datos del usuario -->
    <?php
    $id_usuario = $_SESSION['usuario_id'];
    $sqlUsuario = "SELECT nombre, apellido, rol, foto FROM usuario WHERE identificacion = ?";
    $stmtUsuario = $conexion->prepare($sqlUsuario);
    $stmtUsuario->bind_param("i", $id_usuario);
    $stmtUsuario->execute();
    $resultUsuario = $stmtUsuario->get_result();
    $rowUsuario = $resultUsuario->fetch_assoc();
    $nombreUsuario = $rowUsuario['nombre'];
    $apellidoUsuario = $rowUsuario['apellido'];
    $rol = $rowUsuario['rol'];
    $foto = $rowUsuario['foto'];
    $stmtUsuario->close();
    ?>
    <p class="nombre"><?php echo $nombreUsuario; ?> <?php echo $apellidoUsuario; ?></p>
    <p class="rol">Rol: <?php echo $rol; ?></p>

  </div>
  <div class="profilePic">
    <?php if (!empty($rowUsuario['foto'])): ?>
      <img id="profilePic" src="data:image/jpeg;base64,<?php echo base64_encode($foto); ?>" alt="Usuario">
    <?php else: ?>
      <img id="profilePic" src="../imagenes/icono.jpg" alt="Usuario por defecto">
    <?php endif; ?>
  </div>

