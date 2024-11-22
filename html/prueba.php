 <?php

$conexion = mysqli_connect('localhost','root','', 'inventariomotoracer');

if (!$conexion) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

$busqueda = isset($_GET['busqueda']) ? mysqli_real_escape_string($conexion, $_GET['busqueda']) : '';

$consulta = "
    SELECT 
        p.codigo,
        p.nombre,
        p.iva,
        p.`precio1`,
        p.`precio2`,
        p.`precio3`,
        p.cantidad,
        p.descripcion,
        c.nombre AS categoria,
        m.nombre AS marca,
        u.nombre AS unidadmedida,
        ub.nombre AS ubicacion,
        pr.nombre AS proveedor
    FROM 
        producto p
    LEFT JOIN 
        categoria c ON p.Categoria_codigo = c.codigo
    LEFT JOIN 
        marca m ON p.Marca_codigo = m.codigo
    LEFT JOIN 
        unidadmedida u ON p.UnidadMedida_codigo = u.codigo
    LEFT JOIN 
        ubicacion ub ON p.Ubicacion_codigo = ub.codigo
    LEFT JOIN 
        proveedor pr ON p.proveedor_nit = pr.nit
";

if ($busqueda != '') {
    $consulta .= " WHERE p.nombre LIKE '%$busqueda%'";
}


$resultado = mysqli_query($conexion, $consulta);

if (!$resultado) {
    die("No se pudo ejecutar la consulta: " . mysqli_error($conexion));
}


while ($fila = mysqli_fetch_assoc($resultado)) {
    echo "<tr>";
    echo "<td>" . (isset($fila["codigo"]) ? $fila["codigo"] : 'N/A') . "</td>";
    echo "<td>" . (isset($fila["nombre"]) ? $fila["nombre"] : 'N/A') . "</td>";
    echo "<td>" . (isset($fila["iva"]) ? $fila["iva"] : 'N/A') . "</td>";
    echo "<td>" . (isset($fila["precio1"]) ? $fila["precio1"] : 'N/A') . "</td>";
    echo "<td>" . (isset($fila["precio2"]) ? $fila["precio2"] : 'N/A') . "</td>";
    echo "<td>" . (isset($fila["precio3"]) ? $fila["precio3"] : 'N/A') . "</td>";
    echo "<td>" . (isset($fila["cantidad"]) ? $fila["cantidad"] : 'N/A') . "</td>";
    echo "<td>" . (isset($fila["descripcion"]) ? $fila["descripcion"] : 'N/A') . "</td>";
    echo "<td>" . (isset($fila["categoria"]) ? $fila["categoria"] : 'N/A') . "</td>";
    echo "<td>" . (isset($fila["marca"]) ? $fila["marca"] : 'N/A') . "</td>";
    echo "<td>" . (isset($fila["unidadmedida"]) ? $fila["unidadmedida"] : 'N/A') . "</td>";
    echo "<td>" . (isset($fila["ubicacion"]) ? $fila["ubicacion"] : 'N/A') . "</td>";
    echo "<td>" . (isset($fila["proveedor"]) ? $fila["proveedor"] : 'N/A') . "</td>";
    echo "<td class='text-center'>";
    echo "<i class='fa-regular fa-pen-to-square'></i>";
    echo "<i class='fa-solid fa-trash'></i>";
    echo "</td>";
    echo "</tr>";
}

echo "</table>";

mysqli_close($conexion);

?>