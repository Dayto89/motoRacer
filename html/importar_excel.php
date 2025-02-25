<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

if (isset($_POST['importar'])) {
    $archivo = $_FILES['archivoExcel']['tmp_name'];
    $nombreArchivo = $_FILES['archivoExcel']['name'];

    if (empty($archivo)) {
        echo "⚠️ No se ha seleccionado ningún archivo.";
        exit;
    }

    // Verifica la extensión del archivo
    $ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
    if (!in_array(strtolower($ext), ['xlsx', 'xls'])) {
        echo "❌ Formato de archivo no válido. Solo se permiten .xlsx o .xls";
        exit;
    }

    try {
        // Carga el archivo Excel
        $spreadsheet = IOFactory::load($archivo);
        $hoja = $spreadsheet->getActiveSheet();
        $datos = $hoja->toArray();

        // Encabezados esperados
        $encabezadosEsperados = ['codigo1', 'codigo2', 'nombre', 'iva', 'precio1', 'precio2', 'precio3', 'cantidad', 'descripcion', 'categoria', 'marca', 'unidadmedida', 'ubicacion', 'proveedor'];

        $encabezadosExcel = array_map('strtolower', $datos[0]);
        if ($encabezadosExcel !== $encabezadosEsperados) {
            echo "❌ Los encabezados del archivo no coinciden con los esperados.";
            exit;
        }

        // Procesar filas
        for ($i = 1; $i < count($datos); $i++) {
            $fila = array_map('trim', $datos[$i]);

            list($codigo1, $codigo2, $nombre, $iva, $precio1, $precio2, $precio3, $cantidad, $descripcion, $categoria, $marca, $unidadmedida, $ubicacion, $proveedor) = $fila;

            // Verifica si el producto ya existe
            $query = "SELECT * FROM producto WHERE codigo1 = '$codigo1' AND codigo2 = '$codigo2'";
            $resultado = mysqli_query($conexion, $query);

            if (mysqli_num_rows($resultado) > 0) {
                // Actualizar si existe
                $update = "
                    UPDATE producto SET
                        nombre = '$nombre',
                        iva = '$iva',
                        precio1 = '$precio1',
                        precio2 = '$precio2',
                        precio3 = '$precio3',
                        cantidad = '$cantidad',
                        descripcion = '$descripcion',
                        Categoria_codigo = (SELECT codigo FROM categoria WHERE nombre = '$categoria' LIMIT 1),
                        Marca_codigo = (SELECT codigo FROM marca WHERE nombre = '$marca' LIMIT 1),
                        UnidadMedida_codigo = (SELECT codigo FROM unidadmedida WHERE nombre = '$unidadmedida' LIMIT 1),
                        Ubicacion_codigo = (SELECT codigo FROM ubicacion WHERE nombre = '$ubicacion' LIMIT 1),
                        proveedor_nit = (SELECT nit FROM proveedor WHERE nombre = '$proveedor' LIMIT 1)
                    WHERE codigo1 = '$codigo1' AND codigo2 = '$codigo2'
                ";
                mysqli_query($conexion, $update);
            } else {
                // Insertar si no existe
                $insert = "
                    INSERT INTO producto 
                        (codigo1, codigo2, nombre, iva, precio1, precio2, precio3, cantidad, descripcion, Categoria_codigo, Marca_codigo, UnidadMedida_codigo, Ubicacion_codigo, proveedor_nit)
                    VALUES 
                        ('$codigo1', '$codigo2', '$nombre', '$iva', '$precio1', '$precio2', '$precio3', '$cantidad', '$descripcion',
                         (SELECT codigo FROM categoria WHERE nombre = '$categoria' LIMIT 1),
                         (SELECT codigo FROM marca WHERE nombre = '$marca' LIMIT 1),
                         (SELECT codigo FROM unidadmedida WHERE nombre = '$unidadmedida' LIMIT 1),
                         (SELECT codigo FROM ubicacion WHERE nombre = '$ubicacion' LIMIT 1),
                         (SELECT nit FROM proveedor WHERE nombre = '$proveedor' LIMIT 1)
                        )
                ";
                mysqli_query($conexion, $insert);
            }
        }

        echo "<script>alert('✅ Archivo importado y datos actualizados correctamente.');</script>";
        echo "<script>location.href='../html/crearproducto.php';</script>";
        exit();
    } catch (Exception $e) {
        echo "❌ Error al leer el archivo Excel: " . $e->getMessage();
    }
}
?>
