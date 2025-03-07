<?php
print_r($_POST);
exit;

include '../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario']?? null;
    $seccion = $_POST['seccion'] ?? null;
    if ($id_usuario === null || $seccion === null) {
        die("Error: Faltan datos en el formulario.");
    }
    $sub_seccion = !empty($_POST['sub_seccion']) ? $_POST['sub_seccion'] : NULL;
    $permitido = isset($_POST['permitido']) ? 1 : 0;

    try {
        $sql = "INSERT INTO usuario_permisos (id_usuario, seccion, sub_seccion, permitido) 
                VALUES (:id_usuario, :seccion, :sub_seccion, :permitido)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':seccion', $seccion, PDO::PARAM_STR);
        $stmt->bindParam(':sub_seccion', $sub_seccion, PDO::PARAM_STR);
        $stmt->bindParam(':permitido', $permitido, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Permiso guardado correctamente.";
        } else {
            echo "Error al guardar el permiso.";
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
}
?>
