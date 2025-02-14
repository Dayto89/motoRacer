<?php
session_start();


$conexion = mysqli_connect("localhost", "root", "", "inventariomotoracer");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mostrar_pregunta'])) {
    header('Content-Type: application/json');
    $identificacion = trim($_POST['identificacion']);

    $query = "SELECT preguntaSeguridad FROM usuario WHERE identificacion = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $identificacion);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($preguntaSeguridad);
        $stmt->fetch();
        $_SESSION['identificacion_recuperacion'] = $identificacion;
        echo json_encode(["pregunta" => $preguntaSeguridad]);
    } else {
        echo json_encode(["error" => "Identificación no encontrada"]);
    }

    $stmt->close();
    exit; // Detiene la ejecución
}


// Verificar respuesta de seguridad
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verificar_respuesta'])) {
    $respuestaSeguridad = trim($_POST['respuestaSeguridad']);
    $identificacion = $_SESSION['identificacion_recuperacion'] ?? '';

    // Verificar la respuesta de seguridad
    $query = "SELECT respuestaSeguridad FROM usuario WHERE identificacion = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $identificacion);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($respuesta_correcta);
        $stmt->fetch();

        if ($respuestaSeguridad === $respuesta_correcta) {
            echo "<script>alert('Respuesta correcta');</script>";
            $_SESSION['respuesta_correcta'] = true;
            echo "Respuesta correcta";
        } else {
            echo "Respuesta incorrecta";
        }
    } else {
        echo "Error al verificar respuesta";
    }

    $stmt->close();
    exit;
}


// Cambiar contraseña
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_contrasena'])) {
    $nuevacontrasena = password_hash(trim($_POST['contrasena']), PASSWORD_DEFAULT);
    $identificacion = $_SESSION['identificacion_recuperacion'] ?? '';

    if ($_SESSION['respuesta_correcta'] ?? false) {
        // Actualizar la contraseña en la base de datos
        $query = "UPDATE usuario SET contrasena = ? WHERE identificacion = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ss", $nuevacontrasena, $identificacion);

        if ($stmt->execute()) {
            echo "Contraseña cambiada con éxito";
            session_unset();
            session_destroy();
        } else {
            echo "Error al actualizar la contraseña";
        }

        $stmt->close();
    } else {
        echo "Respuesta de seguridad no verificada";
    }

    exit;
}

mysqli_close($conexion);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>olvidar Contraseña - Moto Racer</title>
    <link rel="stylesheet" href="/css/olvidar.css">
</head>
<body>
    <div class="container">
        <h1>olvidar CONTRASEÑA</h1>

        <!-- Formulario para Mostrar Pregunta -->
<form id="formMostrarPregunta">
    <input type="text" name="identificacion" id="identificacion" placeholder="Ingrese su identificación" required>
    <input type="hidden" name="mostrar_pregunta" value="1">
    <button type="submit">Mostrar Pregunta</button>
</form>

<!-- Campo para Pregunta de Seguridad -->
<input type="text" id="preguntaSeguridad" placeholder="Pregunta de seguridad" readonly>

<!-- Formulario para Responder Pregunta -->
<form id="formVerificarRespuesta" style="display:none;">
    <input type="text" name="respuesta" id="respuesta" placeholder="Ingrese su respuesta" required>
    <button type="submit">Verificar</button>
</form>

        <!-- Formulario para cambiar la contraseña -->
        <form id="formCambioContraseña" method="post" style="display:none;">
            <label for="password">Nueva Contraseña: </label>
            <input type="password" name="contrasena" required>
            <button type="onsubmit" name="cambiar_contrasena">Cambiar Contraseña</button>
        </form>

        <script>
         document.getElementById("formMostrarPregunta").onsubmit = async function(event) {
    event.preventDefault(); // Evita recargar la página

    const formData = new FormData(this);

    try {
        const response = await fetch('html/olvidar.php', {
            method: 'POST',
            body: formData
        });

        // Verifica si la respuesta es JSON
        const data = await response.json();

        if (data.pregunta) {
            document.getElementById("preguntaSeguridad").value = data.pregunta;
            document.getElementById("formMostrarPregunta").style.display = "none";
            document.getElementById("formVerificarRespuesta").style.display = "block";
        } else if (data.error) {
            alert(data.error);
        }
    } catch (error) {
        alert('Error al conectar con el servidor.');
        console.error('Error:', error);
    }
};


        </script>
    </div>
</body>
</html> 