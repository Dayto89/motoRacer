<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prueba de Límite de 3 Dígitos</title>
</head>
<body>

    <h2>Prueba de Input</h2>
    <p>Intenta escribir más de 3 números aquí. No debería ser posible.</p>

    <div class="campo">
      <label class="required" for="cantidad">Cantidad:</label>
      <input type="number"
             id="cantidad"
             name="cantidad"
             required
             min="0"
             max="999"
             oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)" /><br>
    </div>

</body>
</html>