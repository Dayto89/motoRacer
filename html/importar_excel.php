<?php
session_start();
date_default_timezone_set('America/Bogota');
header('Content-Type: text/html; charset=UTF-8');

require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Muestra una alerta SweetAlert2 y redirige de vuelta.
 */
function mostrarAlertaJS($type, $title, $text) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
      document.addEventListener('DOMContentLoaded', function(){
        Swal.fire({
          icon:   '{$type}',
          title:  '{$title}',
          html:   `{$text}`,
          confirmButtonText: 'Aceptar'
        }).then(()=>{ window.location.href = '../html/crearproducto.php'; });
      });
    </script>";
    exit;
}

// 1) Autorización
if (!isset($_SESSION['usuario_id'])) {
    mostrarAlertaJS('error','No autorizado','Por favor inicie sesión.');
}

// 2) Llega la acción de importar
if (!isset($_POST['importar'])) {
    mostrarAlertaJS('warning','Atención','No se recibió la señal de importación.');
}

// 3) Archivo subido
if (empty($_FILES['archivoExcel']['tmp_name']) || !is_uploaded_file($_FILES['archivoExcel']['tmp_name'])) {
    mostrarAlertaJS('error','Atención','No se subió ningún archivo.');
}

// 4) Validar extensión, MIME y tamaño
$ext  = strtolower(pathinfo($_FILES['archivoExcel']['name'], PATHINFO_EXTENSION));
$finfo= new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($_FILES['archivoExcel']['tmp_name']);
$maxSize = 3 * 1024 * 1024; // 3 MiB
if (
    !in_array($ext, ['xlsx','xls']) ||
    !in_array($mime, [
      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
      'application/vnd.ms-excel'
    ])
) {
    mostrarAlertaJS('error','Formato inválido','Solo se permiten archivos .xlsx o .xls');
}
if ($_FILES['archivoExcel']['size'] > $maxSize) {
    mostrarAlertaJS('error','Archivo muy grande',"El Excel no puede exceder ".($maxSize/1024/1024)." MiB.");
}

// 5) Conexión DB
$conexion = new mysqli('localhost','root','','inventariomotoracer');
if ($conexion->connect_error) {
    mostrarAlertaJS('error','Error BD',$conexion->connect_error);
}
$conexion->set_charset('utf8mb4');

/**
 * Busca o crea en la tabla dada, retornando el código (PK).
 */
function obtenerOCrearCodigo(mysqli $c, $tabla, $colNombre, $valor, $colCodigo) {
    $sql = "SELECT `$colCodigo` FROM `$tabla` WHERE `$colNombre` = ? LIMIT 1";
    $st  = $c->prepare($sql);
    $st->bind_param('s',$valor);
    $st->execute();
    $st->bind_result($codigo);
    if ($st->fetch()) {
        $st->close();
        return $codigo;
    }
    $st->close();
    // insertar nuevo
    $ins = $c->prepare("INSERT INTO `$tabla` (`$colNombre`) VALUES (?)");
    $ins->bind_param('s',$valor);
    if (!$ins->execute()) {
        throw new Exception("Error creando en $tabla: ".$ins->error);
    }
    $nuevo = $ins->insert_id;
    $ins->close();
    return $nuevo;
}

try {
    // 6) Cargar Excel
    $spreadsheet = IOFactory::load($_FILES['archivoExcel']['tmp_name']);
    $hoja        = $spreadsheet->getActiveSheet();
    $datos       = $hoja->toArray(null,true,true,true);

    // 7) Validar encabezados (13 cols)
    $encEsperados = [
      'codigo1','codigo2','nombre','iva',
      'precio1','precio2','precio3','cantidad',
      'categoria','marca','clase',
      'ubicacion','proveedor'
    ];
    $encExcel = array_map('strtolower', array_values($datos[1]));
    if ($encExcel !== $encEsperados) {
        mostrarAlertaJS(
          'error','Encabezados inválidos',
          'Se esperaban: '.implode(', ',$encEsperados)
        );
    }

    // 8) Preparar statements
    $sqlI = "INSERT INTO producto
      (codigo1,codigo2,nombre,iva,precio1,precio2,precio3,cantidad,
       Categoria_codigo,Marca_codigo,UnidadMedida_codigo,Ubicacion_codigo,proveedor_nit)
     VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $sqlU = "UPDATE producto SET
       nombre=?, iva=?, precio1=?, precio2=?, precio3=?, cantidad=?,
       Categoria_codigo=?, Marca_codigo=?, UnidadMedida_codigo=?,
       Ubicacion_codigo=?, proveedor_nit=?
     WHERE codigo1=? AND codigo2=?";
    $stI = $conexion->prepare($sqlI);
    $stU = $conexion->prepare($sqlU);

    $omitidas = [];
    $total    = count($datos);
    for ($i=2; $i<=$total; $i++) {
        $fila = array_map('trim', array_values($datos[$i]));
        if (count($fila) < 13) {
            $omitidas[] = $i; continue;
        }
        list($c1,$c2,$nom,$iva,$p1,$p2,$p3,$cant,$cat,$mar,$uni,$ubi,$prov) = $fila;

        // Validar obligatorios y tipos
        if (
            !$c1 || !$nom ||
            !is_numeric($iva) ||
            !is_numeric($p1) ||
            !filter_var($cant, FILTER_VALIDATE_INT, ["options"=>["min_range"=>0,"max_range"=>99]])
        ) {
            $omitidas[] = $i; continue;
        }

        // FK: obtener o crear
        try {
            $catCod  = obtenerOCrearCodigo($conexion,'categoria','nombre',$cat,'codigo');
            $marCod  = obtenerOCrearCodigo($conexion,'marca','nombre',$mar,'codigo');
            $uniCod  = obtenerOCrearCodigo($conexion,'unidadmedida','nombre',$uni,'codigo');
            $ubiCod  = obtenerOCrearCodigo($conexion,'ubicacion','nombre',$ubi,'codigo');
            $provNit = obtenerOCrearCodigo($conexion,'proveedor','nombre',$prov,'nit');
        } catch (Exception $e) {
            $omitidas[] = $i; continue;
        }

        // UPDATE vs INSERT
        $chk = $conexion->prepare("SELECT 1 FROM producto WHERE codigo1=? AND codigo2=? LIMIT 1");
        $chk->bind_param('ss',$c1,$c2);
        $chk->execute();
        $chk->store_result();

        if ($chk->num_rows>0) {
            // UPDATE: 11 campos + 2 en WHERE
            $stU->bind_param(
                'diiiii iiiisss',
                $nom,$iva,$p1,$p2,$p3,$cant,
                $catCod,$marCod,$uniCod,$ubiCod,$provNit,
                $c1,$c2
            );
            $stU->execute();
        } else {
            // INSERT: 13 parámetros
            $stI->bind_param(
                'sssdiiissiiis',
                $c1,$c2,$nom,$iva,$p1,$p2,$p3,$cant,
                $catCod,$marCod,$uniCod,$ubiCod,$provNit
            );
            $stI->execute();
        }
        $chk->close();
    }

    $stI->close();
    $stU->close();
    $conexion->close();

    // 9) Resultado
    if (empty($omitidas)) {
        mostrarAlertaJS('success','Éxito',"Importación completa ({$total}-1 filas).");
    } else {
        mostrarAlertaJS(
          'warning','Importación parcial',
          'Omitidas filas: '.implode(', ',$omitidas)
        );
    }

} catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
    mostrarAlertaJS('error','Error Excel',$e->getMessage());
}
