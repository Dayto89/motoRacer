<?php

$conexion = mysqli_connect("localhost", "root", "", "simr");

if (!$conexion) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

$consulta = "SELECT * FROM producto";
$resultado = mysqli_query($conexion, $consulta);

if (!$resultado) {
    die("No se pudo ejecutar la consulta: " . mysqli_error($conexion));
}


while ($fila = mysqli_fetch_assoc($resultado)) {
    echo "<tr>";
    echo "<td>" . $fila["codigo"] . "</td>";
    echo "<td>" . $fila["nombre"] . "</td>";
    echo "<td>" . $fila["iva"] . "</td>";
    echo "<td>" . $fila["precio"] . "</td>";
    echo "<td>" . $fila["cantidad"] . "</td>";
    echo "<td>" . $fila["descripcion"] . "</td>";
    echo "<td>" . $fila["Categoria_codigo"] . "</td>";
    echo "<td>" . $fila["Marca_codigo"] . "</td>";
    echo "<td>" . $fila["UnidadMedida_codigo"] . "</td>";
    echo "<td>" . $fila["Ubicacion_codigo"] . "</td>";
    echo "<td class='text-center'>";
    echo "<i class='fa-regular fa-pen-to-square'></i>";
    echo "<i class='fa-solid fa-trash'></i>";
    echo "</td>";
    echo "</tr>";
}

echo "</table>";

mysqli_close($conexion);

?>