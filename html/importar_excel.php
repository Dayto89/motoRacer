<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// ------------ Conexión a la base de datos ------------
$conexion = new mysqli('localhost', 'root', '', 'inventariomotoracer');
if ($conexion->connect_error) {
    mostrarAlertaJS('error', 'Error BD', 'No se pudo conectar con la base de datos.<br><small>' . $conexion->connect_error . '</small>');
    exit;
}

/**
 * Ejecuta SweetAlert2 vía JavaScript
 */
function mostrarAlertaJS($tipo, $titulo, $mensaje) {
    // $tipo: 'confirmacion', 'advertencia' o 'error'
    $iconos = [
        'confirmacion' => 'moto.png',
        'advertencia'  => 'tornillo.png',
        'error'        => 'llave.png'
    ];
    $icono = $iconos[$tipo] ?? 'llave.png';
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: `<span class='titulo-alerta {$tipo}'>${titulo}</span>`,
                html: `
                    <div class='custom-alert'>
                        <div class='contenedor-imagen'>
                            <img src='../imagenes/{$icono}' alt='${titulo}' class='{$tipo}'>
                        </div>
                        <p>${mensaje}</p>
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
        });
    </script>";
}

/**
 * Obtiene o crea el registro en $tabla buscando por $columnaNombre = $valor.
 * Retorna el código generado en $columnaCodigo.
 */
function obtenerOCrearCodigo(mysqli $conexion, string $tabla, string $columnaNombre, string $valor, string $columnaCodigo) {
    // 1. Buscar
    $sql = "SELECT `$columnaCodigo` FROM `$tabla` WHERE `$columnaNombre` = ? LIMIT 1";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $stmt->bind_result($codigo);
    if ($stmt->fetch()) {
        $stmt->close();
        return $codigo;
    }
    $stmt->close();

    // 2. Si no existe, insertar
    $sqlIns = "INSERT INTO `$tabla` (`$columnaNombre`) VALUES (?)";
    $ins = $conexion->prepare($sqlIns);
    $ins->bind_param('s', $valor);
    if (!$ins->execute()) {
        throw new Exception("Error al crear en $tabla: " . $ins->error);
    }
    $nuevoCodigo = $ins->insert_id;
    $ins->close();
    return $nuevoCodigo;
}

if (!isset($_POST['importar'])) {
    // No se envió el formulario
    mostrarAlertaJS('advertencia', 'Atención', 'No se recibió la señal de importación.');
    exit;
}

// ------------ Validación de archivo subido ------------
if (empty($_FILES['archivoExcel']['tmp_name'])) {
    mostrarAlertaJS('advertencia', 'Atención', 'No se ha seleccionado ningún archivo.');
    exit;
}
$nombreArchivo = $_FILES['archivoExcel']['name'];
$ext = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
if (!in_array($ext, ['xlsx','xls'])) {
    mostrarAlertaJS('error', 'Formato inválido', 'Solo se permiten archivos .xlsx o .xls');
    exit;
}

try {
    // ------------ Carga de Excel ------------
    $spreadsheet = IOFactory::load($_FILES['archivoExcel']['tmp_name']);
    $hoja = $spreadsheet->getActiveSheet();
    $datos = $hoja->toArray(null, true, true, true);

    // ------------ Validación de encabezados ------------
    $encEsperados = [
        'codigo1','codigo2','nombre','iva',
        'precio1','precio2','precio3','cantidad',
        'descripcion','categoria','marca','clase',
        'ubicacion','proveedor'
    ];
    $encExcel = array_map('strtolower', array_values($datos[1]));
    if ($encExcel !== $encEsperados) {
        mostrarAlertaJS('error','Encabezados inválidos','Los encabezados no coinciden con los esperados: ' . implode(', ',$encEsperados));
        exit;
    }

    // ------------ Preparación de INSERT y UPDATE ------------
    $sqlInsert = "INSERT INTO producto
        (codigo1,codigo2,nombre,iva,precio1,precio2,precio3,cantidad,descripcion,
         Categoria_codigo,Marca_codigo,UnidadMedida_codigo,Ubicacion_codigo,proveedor_nit)
     VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $sqlUpdate = "UPDATE producto SET
        nombre=?, iva=?, precio1=?, precio2=?, precio3=?, cantidad=?,
        descripcion=?, Categoria_codigo=?, Marca_codigo=?, UnidadMedida_codigo=?,
        Ubicacion_codigo=?, proveedor_nit=?
     WHERE codigo1=? AND codigo2=?";

    $stmtI = $conexion->prepare($sqlInsert);
    $stmtU = $conexion->prepare($sqlUpdate);

    $filasOmitidas = [];
    // ------------ Procesamiento de filas --------
    for ($i=2; $i<=count($datos); $i++) {
        $fila = array_map('trim', array_values($datos[$i]));
        if (count($fila) < 14) {
            $filasOmitidas[] = $i;
            continue;
        }
        list(
            $c1,$c2,$nom,$iva,$p1,$p2,$p3,$cant,
            $desc,$cat,$mar,$uni,$ubi,$prov
        ) = $fila;

        // Validar campos obligatorios
        if (!$c1||!$c2||!$nom||!$cat||!$mar||!$uni||!$ubi||!$prov) {
            $filasOmitidas[] = $i;
            continue;
        }

        // Obtener o crear FK
        try {
            $catCod  = obtenerOCrearCodigo($conexion,'categoria','nombre',$cat,'codigo');
            $marCod  = obtenerOCrearCodigo($conexion,'marca','nombre',$mar,'codigo');
            $uniCod  = obtenerOCrearCodigo($conexion,'unidadmedida','nombre',$uni,'codigo');
            $ubiCod  = obtenerOCrearCodigo($conexion,'ubicacion','nombre',$ubi,'codigo');
            $provNit = obtenerOCrearCodigo($conexion,'proveedor','nombre',$prov,'nit');
        } catch (Exception $e) {
            error_log("Fila $i: " . $e->getMessage());
            $filasOmitidas[] = $i;
            continue;
        }

        // Decidir INSERT o UPDATE
        $chk = $conexion->prepare("SELECT 1 FROM producto WHERE codigo1=? AND codigo2=? LIMIT 1");
        $chk->bind_param('ss',$c1,$c2);
        $chk->execute();
        $chk->store_result();

        if ($chk->num_rows>0) {
            // UPDATE
            $stmtU->bind_param(
                'diiisiiiiiisss',
                $nom,$iva,$p1,$p2,$p3,$cant,$desc,
                $catCod,$marCod,$uniCod,$ubiCod,$provNit,
                $c1,$c2
            );
            if (!$stmtU->execute()) {
                error_log("Error UPDATE fila $i: " . $stmtU->error);
            }
        } else {
            // INSERT
            $stmtI->bind_param(
                'sssdiiissiiiis',
                $c1,$c2,$nom,$iva,$p1,$p2,$p3,$cant,
                $desc,$catCod,$marCod,$uniCod,$ubiCod,$provNit
            );
            if (!$stmtI->execute()) {
                error_log("Error INSERT fila $i: " . $stmtI->error);
            }
        }
        $chk->close();
    }

    $stmtI->close();
    $stmtU->close();

    // ------------ Mostrar resultado ------------
    if (empty($filasOmitidas)) {
        mostrarAlertaJS('confirmacion','Éxito','Archivo importado y datos actualizados correctamente.');
    } else {
        $omit = implode(', ',$filasOmitidas);
        mostrarAlertaJS('advertencia','Importación parcial',"Se omitieron las filas: $omit");
    }
    exit;

} catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
    mostrarAlertaJS('error','Error Excel','No se pudo procesar el archivo.<br><small>'.$e->getMessage().'</small>');
    exit;
}
