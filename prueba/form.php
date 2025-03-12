<?php
session_start();

$conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');

if ($conexion->connect_error) {
  die("No se pudo conectar a la base de datos: " . $conexion->connect_error);
}

// Obtener los permisos disponibles desde la base de datos
$sqlPermisos = "SELECT seccion, sub_seccion, permitido FROM accesos WHERE id_usuario = ?";
$stmt = $conexion->prepare($sqlPermisos);
$stmt->bind_param("i", $_SESSION['usuario_id']); // Asume que el ID del usuario está en la sesión
$stmt->execute();
$resultPermisos = $stmt->get_result();

$permisos = [];
while ($row = $resultPermisos->fetch_assoc()) {
  $permisos[$row['seccion']][] = [
    'sub_seccion' => $row['sub_seccion'],
    'permitido' => $row['permitido']
  ];
}

$stmt->close();
?>

<div id="modalPermisos" class="modal">
  <div class="modal-content">
    <span class="close" onclick="cerrarModal()">&times;</span>
    <h2>Configurar Permisos</h2>
    <form id="formPermisos" method="POST">
      <input type="hidden" id="identificacion" name="identificacion" value="<?php echo $_SESSION['usuario_id']; ?>">

      <?php foreach ($permisos as $seccion => $subsecciones): ?>
        <div>
          <label>
            <input type="checkbox" id="<?php echo $seccion; ?>_todo" onclick="toggleSeccion('<?php echo $seccion; ?>', '<?php echo $seccion; ?>_todo'), toggleSeccionAll('<?php echo $seccion; ?>_todo', '<?php echo $seccion; ?>')">
            <strong><?php echo ucfirst($seccion); ?></strong>
          </label><br>
          <div id="<?php echo $seccion; ?>_subsecciones" style="display: none; margin-left: 20px;">
            <?php foreach ($subsecciones as $subseccion): ?>
              <label>
                <input type="checkbox" class="<?php echo $seccion; ?>" name="permisos[]" value="<?php echo $seccion . '_' . str_replace(' ', '_', strtolower($subseccion['sub_seccion'])); ?>" <?php echo $subseccion['permitido'] ? 'checked' : ''; ?> onclick="verificarSubPermisos('<?php echo $seccion; ?>_todo', '<?php echo $seccion; ?>')">
                <?php echo $subseccion['sub_seccion']; ?>
              </label><br>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>

      <button type="button" onclick="guardarPermisos()">Guardar Permisos</button>
    </form>
  </div>
</div>
<script>
function guardarPermisos() {
  var formData = new FormData(document.getElementById("formPermisos"));
  fetch("guardar_permisos.php", {
    method: "POST",
    body: formData
  })
    .then(response => response.text())
    .then(data => {
      alert(data); // Muestra un mensaje de éxito o error
      cerrarModal(); // Cierra el modal
    })
    .catch(error => console.error("Error:", error));
}
</script>
