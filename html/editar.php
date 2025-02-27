<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

$id = $_GET['id'];

$query = "SELECT * FROM producto WHERE id = $id";
$result = mysqli_query($conexion, $query);
$producto = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $precio1 = $_POST['precio1'];

    $updateQuery = "UPDATE producto SET nombre='$nombre', precio1='$precio1' WHERE id=$id";
    mysqli_query($conexion, $updateQuery);
    header("Location: inventario.php");
    exit();
}
?>

<form method="POST">
    <input type="text" name="nombre" value="<?= $producto['nombre']; ?>">
    <input type="text" name="precio1" value="<?= $producto['precio1']; ?>">
    <button type="submit">Actualizar</button>
</form>
