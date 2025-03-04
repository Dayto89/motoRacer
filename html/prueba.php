<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz de Pagos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="user-info">
            <h2>Información del Usuario</h2>
            <label>Tipo de Documento:</label>
            <select>
                <option>Cédula</option>
                <option>Pasaporte</option>
                <option>NIT</option>
            </select>
            <input type="text" placeholder="Número de Documento">
            <input type="text" placeholder="Nombre">
            <input type="text" placeholder="Apellido">
            <input type="text" placeholder="Teléfono">
            <input type="email" placeholder="Correo Electrónico">
            <button onclick="fillDefaultUser()">Usuario Final</button>
        </div>
        <div class="payment-section">
            <h2>Registrar Pago</h2>
            <div class="payment-methods">
                <div class="payment-box">
                    <h3>Pagos en efectivo</h3>
                    <button>$30,000</button>
                    <button>$50,000</button>
                    <button>$100,000</button>
                    <input type="text" placeholder="Valor">
                </div>
                <div class="payment-box">
                    <h3>Pagos con tarjeta</h3>
                    <select><option>Tipo</option></select>
                    <input type="text" placeholder="Nro. voucher">
                    <input type="text" placeholder="$0.00">
                </div>
                <div class="payment-box">
                    <h3>Otros pagos</h3>
                    <select><option>Tipo</option></select>
                    <input type="text" placeholder="$0.00">
                </div>
            </div>
            <div class="notes">
                <h3>Observaciones</h3>
                <textarea placeholder="Ingrese observaciones..."></textarea>
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
        function fillDefaultUser() {
            document.querySelector('select').value = 'Cédula';
            document.querySelectorAll('.user-info input')[0].value = '0000000000';
            document.querySelectorAll('.user-info input')[1].value = 'Usuario';
            document.querySelectorAll('.user-info input')[2].value = 'Final';
            document.querySelectorAll('.user-info input')[3].value = '0000000000';
            document.querySelectorAll('.user-info input')[4].value = 'usuariofinal@email.com';
        }
    </script>
</body>
</html>