<?php
function enviarCodigo($correo_destino, $codigo) {
    $apiKey = '19b507d4bdbe078a0e51fcebb12a6d10';
    $apiSecret = 'e32a613c3d93c5f2c172ba7ee726ba05';

    $mensaje = [
        'Messages' => [[
            'From' => [
                'Email' => "almacenmotoracer@gmail.com",
                'Name' => "Soporte Inventario MotoRacer"
            ],
            'To' => [[
                'Email' => $correo_destino,
                'Name' => "Usuario"
            ]],
            'Subject' => "Código de recuperación de contraseña",
            'TextPart' => "Tu código de recuperación es: $codigo",
            'HTMLPart' => "<h3>Tu código de recuperación es: <strong>$codigo</strong></h3><p>No compartas este código con nadie.</p>"
        ]]
    ];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.mailjet.com/v3.1/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($mensaje),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json"
        ],
        CURLOPT_USERPWD => "$apiKey:$apiSecret"
    ]);

    $respuesta = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);

    if ($error) {
        error_log("Error al enviar el correo: $error");
    }
}