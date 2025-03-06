<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "inventariomotoracer";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener usuarios para autocompletar
if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'] . "%"; // Filtrar solo por los que comienzan con el código ingresado
    $sql = "SELECT codigo, identificacion, nombre, apellido, telefono, correo FROM cliente WHERE codigo LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $clientes = [];
    while ($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
    echo json_encode($clientes);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago</title>
    <style>
        .suggestions {
            position: absolute;
            background: white;
            border: 1px solid #ccc;
            width: 200px;
            max-height: 150px;
            overflow-y: auto;
            display: none;
        }
        .suggestions div {
            padding: 10px;
            cursor: pointer;
        }
        .suggestions div:hover {
            background: #f0f0f0;
        }
    </style>
</head>
<body>
    <label for="codigo">Código:</label>
    <input type="text" id="codigo" name="codigo" onfocus="buscarCodigo()" oninput="buscarCodigo()">
    <div id="suggestions" class="suggestions"></div>
    
    <script>
        function buscarCodigo() {
            let input = document.getElementById("codigo").value;
            let suggestionsBox = document.getElementById("suggestions");

            fetch(`?codigo=${input}`)
                .then(response => response.json())
                .then(data => {
                    suggestionsBox.innerHTML = "";
                    if (data.length > 0) {
                        suggestionsBox.style.display = "block";
                        data.forEach(user => {
                            let div = document.createElement("div");
                            div.textContent = user.codigo + " - " + user.nombre;
                            div.onclick = () => seleccionarCodigo(user);
                            suggestionsBox.appendChild(div);
                        });
                    } else {
                        suggestionsBox.style.display = "none";
                    }
                })
                .catch(error => console.error("Error al obtener datos:", error));
        }

        function seleccionarCodigo(user) {
            document.getElementById("codigo").value = user.codigo;
            document.getElementById("suggestions").style.display = "none";
        }
    </script>
</body>
</html>
