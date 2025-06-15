<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
if ($conexion->connect_error) {
    die("Error al conectar con la base de datos: " . $conexion->connect_error);
}

/**
 * Obtiene el código de la clave foránea a partir de su nombre.
 */
function obtenerCodigo(mysqli $conexion, string $tabla, string $columnaNombre, string $valor, string $columnaCodigo)
{
    $sql = "SELECT `$columnaCodigo` FROM `$tabla` WHERE `$columnaNombre` = ? LIMIT 1";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $stmt->bind_result($codigo);
    $stmt->fetch();
    $stmt->close();
    return $codigo ?: null;
}

if (isset($_POST['importar'])) {
    $archivo      = $_FILES['archivoExcel']['tmp_name'];
    $nombreArchivo = $_FILES['archivoExcel']['name'];

    // Verificar que se haya subido un archivo
    if (empty($archivo)) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: `<span class='titulo-alerta advertencia'>Advertencia</span>`,
                html: `
                    <div class='alerta'>
                        <div class=\"contenedor-imagen\">
                            <img src=\"../imagenes/tornillo.png\" alt=\"advertencia\" class=\"tornillo\">
                        </div>
                        <p>No se ha seleccionado ningún archivo.</p>
                    </div>
                `,
                background: '#ffffffdb',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#007bff',
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    container: 'fondo-oscuro'
                }
            });
        </script>";
        exit;
    }

    // Verifica la extensión del archivo
    $ext = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
    if (!in_array($ext, ['xlsx', 'xls'])) {
        die("❌ Formato de archivo no válido. Solo se permiten .xlsx o .xls");
    }

    try {
        // Cargar el archivo Excel
        $spreadsheet = IOFactory::load($archivo);
        $hoja        = $spreadsheet->getActiveSheet();
        $datos       = $hoja->toArray(null, true, true, true);

        // Encabezados esperados (solo 'clase' para unidad de medida)
        $encEsperados = [
            'codigo1', 'codigo2', 'nombre', 'iva',
            'precio1', 'precio2', 'precio3', 'cantidad',
            'descripcion', 'categoria', 'marca', 'clase',
            'ubicacion', 'proveedor'
        ];
        $encExcel = array_map('strtolower', array_values($datos[1]));
        if ($encExcel !== $encEsperados) {
            die("❌ Los encabezados del archivo no coinciden con los esperados.");
        }

        // Preparar sentencias para INSERT y UPDATE
        $sqlInsert = "INSERT INTO producto
            (codigo1, codigo2, nombre, iva, precio1, precio2, precio3, cantidad,
            descripcion, Categoria_codigo, Marca_codigo, UnidadMedida_codigo,
            Ubicacion_codigo, proveedor_nit)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $sqlUpdate = "UPDATE producto SET
            nombre = ?, iva = ?, precio1 = ?, precio2 = ?, precio3 = ?, cantidad = ?,
            descripcion = ?, Categoria_codigo = ?, Marca_codigo = ?,
            UnidadMedida_codigo = ?, Ubicacion_codigo = ?, proveedor_nit = ?
            WHERE codigo1 = ? AND codigo2 = ?";

        $stmtInsert = $conexion->prepare($sqlInsert);
        $stmtUpdate = $conexion->prepare($sqlUpdate);

        // Recorrer filas de datos
        for ($i = 2; $i <= count($datos); $i++) {
            $fila = array_map('trim', array_values($datos[$i]));
            list(
                $codigo1, $codigo2, $nombre, $iva,
                $precio1, $precio2, $precio3, $cantidad,
                $descripcion, $categoria, $marca, $clase,
                $ubicacion, $proveedor
            ) = $fila;

            // Obtener códigos foráneos
            $catCod   = obtenerCodigo($conexion, 'categoria', 'nombre', $categoria, 'codigo');
            $marCod   = obtenerCodigo($conexion, 'marca', 'nombre', $marca, 'codigo');
            $uniCod   = obtenerCodigo($conexion, 'unidadmedida', 'nombre', $clase, 'codigo');
            $ubiCod   = obtenerCodigo($conexion, 'ubicacion', 'nombre', $ubicacion, 'codigo');
            $provNit  = obtenerCodigo($conexion, 'proveedor', 'nombre', $proveedor, 'nit');

            if (!$catCod || !$marCod || !$uniCod || !$ubiCod || !$provNit) {
                error_log("Fila $i: clave foránea no encontrad.");
                echo "⚠️ Fila $i omitida: clave foránea inexistente.<br>";
                continue;
            }

            // Decide INSERT o UPDATE
            $check = $conexion->prepare(
                "SELECT 1 FROM producto WHERE codigo1 = ? AND codigo2 = ? LIMIT 1"
            );
            $check->bind_param('ss', $codigo1, $codigo2);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                // UPDATE
                $stmtUpdate->bind_param(
                    'diiisiiiiiisss',
                    $nombre, $iva, $precio1, $precio2, $precio3,
                    $cantidad, $descripcion,
                    $catCod, $marCod, $uniCod,
                    $ubiCod, $provNit,
                    $codigo1, $codigo2
                );
                if (!$stmtUpdate->execute()) {
                    error_log("Error UPDATE fila $i: " . $stmtUpdate->error);
                }
            } else {
                // INSERT
                $stmtInsert->bind_param(
                    'sssdiiissiiiis',
                    $codigo1, $codigo2, $nombre, $iva,
                    $precio1, $precio2, $precio3, $cantidad,
                    $descripcion, $catCod, $marCod, $uniCod,
                    $ubiCod, $provNit
                );
                if (!$stmtInsert->execute()) {
                    error_log("Error INSERT fila $i: " . $stmtInsert->error);
                }
            }
            $check->close();
        }

        // Cerrar sentencias
        $stmtInsert->close();
        $stmtUpdate->close();

        // Feedback al usuario
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: `<span class='titulo-alerta confirmacion'>Éxito</span>`,
                html: `
                    <div class='alerta'>
                        <div class=\"contenedor-imagen\">
                            <img src=\"../imagenes/moto.png\" alt=\"Confirmación\" class=\"moto\">
                        </div>
                        <p>Archivo importado y datos actualizados correctamente.</p>
                    </div>
                `,
                background: '#ffffffdb',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#007bff',
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-aceptar',
                    container: 'fondo-oscuro'
                }
            }).then(() => {
                window.location.href = '../html/crearproducto.php';
            });
        </script>";
        exit;

    } catch (Exception $e) {
        die("❌ Error al procesar Excel: " . $e->getMessage());
    }
}
