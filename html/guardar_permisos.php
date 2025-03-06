<?php
include '../conexion.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['identificacion']; // ID del gerente
    $permisos = isset($_POST['permisos']) ? $_POST['permisos'] : []; // Permisos seleccionados

    // Eliminar permisos anteriores del gerente
    $sqlDelete = "DELETE FROM accesos WHERE id_usuario = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("i", $id_usuario);
    $stmtDelete->execute();
    $stmtDelete->close();

    // Insertar los nuevos permisos seleccionados
    $sqlInsert = "INSERT INTO accesos (id_usuario, seccion, sub_seccion, permitido) VALUES (?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);

    foreach ($permisos as $permiso) {
        list($seccion, $sub_seccion, $permitido) = explode('|', $permiso); // Separar seccion, subseccion y permiso
        $stmtInsert->bind_param("isss", $id_usuario, $seccion, $sub_seccion, $permitido);
        $stmtInsert->execute();
    }

    $stmtInsert->close();
    $conn->close();

    echo "Permisos actualizados correctamente";
} else {
    echo "Acceso no autorizado";
}
?>
