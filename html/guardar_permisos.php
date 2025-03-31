<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
error_reporting(E_ALL); 
ini_set('display_errors', 1);

$conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
if ($conexion->connect_error) {
    echo json_encode(["success" => false, "error" => "Error en la conexión: " . $conexion->connect_error]);
    exit();
}

// Verifica que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['identificacion']) || empty($_POST['identificacion'])) {
        echo json_encode(["success" => false, "error" => "ID de usuario no recibido."]);
        exit();
    }

    $id_usuario = trim($conexion->real_escape_string($_POST['identificacion']));

    // Verificar si el usuario existe en la tabla usuario
    $result = $conexion->query("SELECT identificacion FROM usuario WHERE identificacion = '$id_usuario'");
    if ($result->num_rows == 0) {
        echo json_encode(["success" => false, "error" => "El usuario no existe."]);
        exit();
    }

    // Eliminar permisos previos del usuario
    if (!$conexion->query("DELETE FROM accesos WHERE id_usuario = '$id_usuario'")) {
        echo json_encode(["success" => false, "error" => "Error al eliminar permisos: " . $conexion->error]);
        exit();
    }

    // Si hay permisos, los insertamos
    if (isset($_POST['permisos']) && is_array($_POST['permisos'])) {
        $stmt = $conexion->prepare("INSERT INTO accesos (id_usuario, seccion, sub_seccion, permitido) VALUES (?, ?, ?, ?)");

        foreach ($_POST['permisos'] as $permiso => $valaor) {
            $permitido = ($valor == 1) ? 1 : 0;  // Si el checkbox está marcado, es 1; si no, es 0

            list($seccion, $sub_seccion) = explode('_', $permiso, 2);
            $seccion = $conexion->real_escape_string($seccion);
            $sub_seccion = $conexion->real_escape_string(str_replace('_', ' ', $sub_seccion));

            $stmt->bind_param("issi", $id_usuario, $seccion, $sub_seccion, $permitido);
            if (!$stmt->execute()) {
                echo json_encode(["success" => false, "error" => "Error al insertar permisos: " . $stmt->error]);
                exit();
            }
        }
        $stmt->close();
    }

    echo json_encode(["success" => true]);
    exit();
}

echo json_encode(["success" => false, "error" => "Método no permitido."]);
?>
