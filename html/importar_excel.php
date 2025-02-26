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
        // Cargar el archivo Excel
        $spreadsheet = IOFactory::load($archivo);
        $hoja = $spreadsheet->getActiveSheet();
        $datos = $hoja->toArray(null, true, true, true);

        // Encabezados esperados
        $encabezadosEsperados = ['codigo1', 'codigo2', 'nombre', 'iva', 'precio1', 'precio2', 'precio3', 'cantidad', 'descripcion', 'categoria', 'marca', 'unidadmedida', 'ubicacion', 'proveedor'];

        $encabezadosExcel = array_map('strtolower', array_values($datos[1])); // Ajuste de índice
        if ($encabezadosExcel !== $encabezadosEsperados) {
            echo "❌ Los encabezados del archivo no coinciden con los esperados.";
            exit;
        }

        // Función para obtener códigos correctos de claves foráneas
        function obtenerCodigo($conexion, $tabla, $columnaNombre, $valor, $columnaCodigo) {
            $valor = mysqli_real_escape_string($conexion, $valor);
            $query = "SELECT $columnaCodigo FROM $tabla WHERE $columnaNombre = '$valor' LIMIT 1";
            $resultado = mysqli_query($conexion, $query);
            if ($fila = mysqli_fetch_assoc($resultado)) {
                return $fila[$columnaCodigo];
            }
            return null;
        }

        // Procesar filas
        for ($i = 2; $i <= count($datos); $i++) {
            $fila = array_map('trim', array_values($datos[$i]));

            list($codigo1, $codigo2, $nombre, $iva, $precio1, $precio2, $precio3, $cantidad, $descripcion, $categoria, $marca, $unidadmedida, $ubicacion, $proveedor) = $fila;

            // Obtener códigos correctos
            $categoriaCodigo = obtenerCodigo($conexion, 'categoria', 'nombre', $categoria, 'codigo');
            $marcaCodigo = obtenerCodigo($conexion, 'marca', 'nombre', $marca, 'codigo');
            $unidadMedidaCodigo = obtenerCodigo($conexion, 'unidadmedida', 'nombre', $unidadmedida, 'codigo');
            $ubicacionCodigo = obtenerCodigo($conexion, 'ubicacion', 'nombre', $ubicacion, 'codigo');
            $proveedorNit = obtenerCodigo($conexion, 'proveedor', 'nombre', $proveedor, 'nit'); // Parece correcto

            // Verificar si todas las claves foráneas existen antes de continuar
            if (!$categoriaCodigo || !$marcaCodigo || !$unidadMedidaCodigo || !$ubicacionCodigo || !$proveedorNit) {
                echo "⚠️ Advertencia: Alguna clave foránea no existe en la base de datos en la fila $i. Registro omitido.<br>";
                continue;
            }

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
                        Categoria_codigo = '$categoriaCodigo',
                        Marca_codigo = '$marcaCodigo',
                        UnidadMedida_codigo = '$unidadMedidaCodigo',
                        Ubicacion_codigo = '$ubicacionCodigo',
                        proveedor_nit = '$proveedorNit'
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
                         '$categoriaCodigo', '$marcaCodigo', '$unidadMedidaCodigo', '$ubicacionCodigo', '$proveedorNit')
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
