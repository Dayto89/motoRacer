<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

$conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
if ($conexion->connect_error) {
    die("No se pudo conectar a la base de datos: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = trim($conexion->real_escape_string($_POST['identificacion']));

    // Verificar si el usuario existe en la tabla usuario
    $result = $conexion->query("SELECT identificacion FROM usuario WHERE identificacion = '$id_usuario'");
    if ($result->num_rows == 0) {
        error_log("Error: Usuario con ID $id_usuario no existe en la tabla usuario.");
        echo json_encode(["success" => false, "error" => "El usuario no existe."]);
        exit();
    }

    // Eliminar permisos previos del usuario
    $conexion->query("DELETE FROM accesos WHERE id_usuario = '$id_usuario'");

    if (isset($_POST['permisos']) && is_array($_POST['permisos'])) {
        foreach ($_POST['permisos'] as $permiso => $valor) {
            list($seccion, $sub_seccion) = explode('_', $permiso, 2);
            $seccion = $conexion->real_escape_string($seccion);
            $sub_seccion = $conexion->real_escape_string(str_replace('_', ' ', $sub_seccion));
            $permitido = ($valor == 1) ? 1 : 0;

            $query = "INSERT INTO accesos (id_usuario, seccion, sub_seccion, permitido) 
                      VALUES ('$id_usuario', '$seccion', '$sub_seccion', '$permitido')";
            $conexion->query($query);
        }
    }

    echo json_encode(["success" => true]);
    exit();
}

echo json_encode(["success" => false]);
?>
