<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

$id = $_SESSION['usuario_id'];

$conexion = mysqli_connect('localhost', 'root', '', 'inventariomotoracer');

if (!$conexion) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}
//Info de usuario ( vendedor )
$consulta = "SELECT * FROM usuario WHERE identificacion = $id";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
    $usuario = $resultado->fetch_assoc();
    $nombre = $usuario['nombre'];
    $apellido = $usuario['apellido'];
}

// Traer codigo del cliente seleccionado en factura.php
// $codigo = $_POST['codigo'];
$codigo = 123;
$consulta = "SELECT * FROM cliente WHERE codigo = '$codigo'";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
    $cliente = $resultado->fetch_assoc();
    $nombreCliente = $cliente['nombre'];
    $apellidoCliente = $cliente['apellido'];
    $telefono = $cliente['telefono'];
}

date_default_timezone_set('America/Bogota');

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <link rel="stylesheet" href="../componentes/header.css">
    <link rel="stylesheet" href="../css/recibo.css">
    <script src="../js/index.js"></script>
    <style>

    </style>
</head>
<body>
    <div id="menu"></div>
    <div class="factura">
        <div class="factura-header">
            <img src="../imagenes/LOGO.png" alt="">
            <h2>HECTOR LEONARDO LÓPEZ CIPRIAN   </h2>
            <p>NIT: 74182332-1</p>
            <P>Dir.: CALLE 40 BIS 6 50</P>
            <p>Yopal - Tel: +57 800 200 000</p>
        </div>
        <hr>
        <div>
        <p>Fecha generación: <?php echo date('d/m/Y H:i'); ?></p>
        </div>

        <div class="factura-datos-cliente">
            <strong>Cliente:</strong> 
            <?php echo $nombreCliente . ' ' . $apellidoCliente; ?><br>
            <strong>Teléfono:</strong> <?php echo $telefono; ?><br>
        </div>

        <div class="factura-datos-vendedor">
            <strong>Vendedor:</strong> 
            <?php echo $nombre. ' ' . $apellido; ?><br>
        </div>

        <hr>

        <div class="factura-productos">
            <table>
                <thead>
                    <tr>
                        <th>Cant</th>
                        <th>Vr.Unit</th>
                        <th>Producto</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($productos as $prod) {
                        $subtotal = $prod['cantidad'] * $prod['precio'];
                        $total += $subtotal;
                        echo "<tr>
                                <td>{$prod['nombre']}</td>
                                <td>{$prod['cantidad']}</td>
                                <td>$" . number_format($prod['precio'], 0) . "</td>
                                <td>$" . number_format($subtotal, 0) . "</td>
                            </tr>";
                    }
                    ?>
                </tbody>
                <hr>
                <thead>
                    <h4>Impuestos</h4>
                    <tr>
                        <th>ID</th>
                        <th>%</th>
                        <th>Base</th>
                        <th>Impuestos</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="factura-total">
            <strong>Total: $<?php echo number_format($total, 0); ?></strong>
        </div>

        <div class="factura-footer">
            <p>¡Gracias por su compra!</p>
        </div>
    </div>
</body>
</html>
