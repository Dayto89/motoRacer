<?php
// Funcion para validar usuario y contraseña
function validarUsuario($usuario, $contrasena) {
    // Conexión a la base de datos
    $conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');

    // Consulta para obtener el usuario y la contraseña
    $consulta = "SELECT * FROM usuario WHERE nombre = '$usuario' AND contraseña = '$contrasena'";

    // Ejecuta la consulta
    $resultado = mysqli_query($conexion, $consulta);

    // Verifica si la consulta ha devuelto resultados
    if (mysqli_num_rows($resultado) > 0) {
        // Si hay resultados, devuelve true
        return true;
    } else {
        // Si no hay resultados, devuelve false
        return false;
    }
}
?>