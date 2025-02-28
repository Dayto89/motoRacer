<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../componentes/header.css">
    <link rel="stylesheet" href="../css/pago.css">
    <script src="../js/index.js"></script>
</head>
<body>
    <div id="menu"></div>
    <div class="container">
        <form action="pago.php" method="POST">
            <div class="left-side">
                <i class="bx bx-cart-alt"></i>
                <h1>Total</h1>
                <p id="total">$0.00</p>
            </div>
            <div class="right-side">
                <h1>Selecciona un método de pago</h1>
                <p>Selecciona un método de pago</p>
                <div class="payment-options">
                    <label>
                        <input type="radio" name="metodo_pago" value="Efectivo" checked>
                        Efectivo
                    </label>
                    <label>
                        <input type="radio" name="metodo_pago" value="Tarjeta de crédito">
                        Tarjeta de crédito
                    </label>
                </div>
                <div class="button-container">
                    <div class="boton">
                        <button type="submit" class="guardar">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>