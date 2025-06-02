<?php
header('Content-Type: application/json');

// 1. Recibir el JSON
$input = json_decode(file_get_contents('php://input'), true);
$correo = trim($input['correo'] ?? '');

if (empty($correo)) {
    echo json_encode(['success' => false, 'message' => 'Correo vacío.']);
    exit;
}

// 2. Generar código de 6 dígitos
$codigo = rand(100000, 999999);

// 3. Guardar en base de datos
$host = 'localhost';
$dbname = 'inventariomotoracer';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Borrar cualquier código anterior para ese correo
    $pdo->prepare("DELETE FROM verificaciones WHERE correo = ?")->execute([$correo]);

    // Insertar nuevo código
    $stmt = $pdo->prepare("INSERT INTO verificaciones (correo, codigo, fecha_envio) VALUES (?, ?, NOW())");
    $stmt->execute([$correo, $codigo]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error en base de datos: ' . $e->getMessage()]);
    exit;
}

// 4. Enviar correo con Mailjet
$apikey_publica = '19b507d4bdbe078a0e51fcebb12a6d10';
$apikey_privada = 'e32a613c3d93c5f2c172ba7ee726ba05';

$mensaje = [
    'Messages' => [[
        'From' => [
            'Email' => "almacenmotoracer@gmail.com",
            'Name' => "Soporte Moto Racer"
        ],
        'To' => [[ 'Email' => $correo ]],
        'Subject' => "Verificación de correo - Moto Racer",
        'TextPart' => "Hola,\n\nGracias por registrarte en Moto Racer. Tu código de verificación es: $codigo\n\nIngresa este código en la página de registro para completar tu cuenta.\n\nSi no solicitaste este registro, puedes ignorar este mensaje.",
        'HTMLPart' => "
            <html>
            <body style='font-family: Arial, sans-serif;'>
                <h2>Verifica tu correo en Moto Racer</h2>
                <p>Gracias por registrarte en nuestro sistema.</p>
                <p>Tu código de verificación es:</p>
                <h3 style='color: #e74c3c;'>$codigo</h3>
                <p>Por favor, ingresa este código en la página de registro para activar tu cuenta.</p>
                <p>Si tú no solicitaste este registro, simplemente ignora este mensaje.</p>
                <br>
                <p>Atentamente,<br><strong>Soporte Moto Racer</strong></p>
            </body>
            </html>
        "
    ]]
];


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.mailjet.com/v3.1/send");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$apikey_publica:$apikey_privada");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($mensaje));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// 5. Verificar resultado del envío
if ($http_code == 200) {
    echo json_encode(['success' => true, 'message' => 'Código enviado correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al enviar el correo']);
}