<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago</title>
    <link rel="icon" type="image/x-icon" href="/imagenes/LOGO.png">
    <link rel="stylesheet" href="../componentes/header.css">
    <link rel="stylesheet" href="../css/pago.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="/js/index.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Metal+Mania&display=swap');
    </style>
</head>
<body>
    <div class="container">
        <div class="user-info">
            <h2>Información del Usuario</h2>
            <label for="tipo_doc">Tipo de Documento:</label>
            <select id="tipo_doc" name="tipo_doc">
                <option value="CC">Cédula de Ciudadanía</option>
                <option value="TI">Tarjeta de Identidad</option>
                <option value="NIT">NIT</option>
            </select>
            <input type="text" id="cedula" name="cedula" placeholder="Número de Documento">
            <input type="text" id="nombre" name="nombre" placeholder="Nombre">
            <input type="text" id="apellido" name="apellido" placeholder="Apellido">
            <input type="text" id="telefono" name="telefono" placeholder="Teléfono">
            <input type="email" id="correo" name="correo" placeholder="Correo Electrónico">
            <button type="button" onclick="llenarDatosUsuarioFinal()">Usuario Final</button>
        </div>
        <div class="payment-section">
            <h2>Registrar Pago</h2>
            <div class="payment-methods">
                <div class="payment-box">
                    <h3>Pagos en efectivo</h3>
                    <button>$30,000</button>
                    <button>$50,000</button>
                    <button>$100,000</button>
                    <input type="text" name="valor_efectivo" placeholder="Valor">
                </div>
                <div class="payment-box">
                    <h3>Pagos con tarjeta</h3>
                    <select name="tipo_tarjeta"><option>Tipo</option></select>
                    <input type="text" name="voucher" placeholder="Nro. voucher">
                    <input type="text" name="valor_tarjeta" placeholder="$0.00">
                </div>
                <div class="payment-box">
                    <h3>Otros pagos</h3>
                    <select name="tipo_otro"><option>Tipo</option></select>
                    <input type="text" name="valor_otro" placeholder="$0.00">
                </div>
            </div>
            <div class="notes">
                <h3>Observaciones</h3>
                <textarea name="observaciones" placeholder="Ingrese observaciones..."></textarea>
            </div>
        </div>
        <div class="summary-section">
            <h3>Información de pago</h3>
            <p>Total bruto: <span>$25,210.08</span></p>
            <p>Descuento aplicado: <span>$0.00</span></p>
            <p>Subtotal: <span>$25,210.08</span></p>
            <p>Total IVA: <span>$4,789.92</span></p>
            <h3>Total a pagar</h3>
            <p class="total">$30,000.00</p>
            <button class="save-btn">Guardar y enviar</button>
        </div>
    </div>
    <script>
        function llenarDatosUsuarioFinal() {
            document.getElementById("tipo_doc").value = "CC";
            document.getElementById("cedula").value = "0000000000";
            document.getElementById("nombre").value = "Usuario";
            document.getElementById("apellido").value = "Final";
            document.getElementById("telefono").value = "0000000000";
            document.getElementById("correo").value = "usuariofinal@email.com";
        }
    </script>
</body>
</html>
