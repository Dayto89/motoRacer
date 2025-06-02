
<?php
require __DIR__ . '/../vendor/autoload.php';

use \Mailjet\Resources;
use Mailjet\Client;
use Mailjet\Exception\ConnectionTimeoutException;
use Mailjet\Exception\ServerException;

function enviarCodigo(string $correo, string $codigo): array {
    // Carga credenciales desde variables de entorno
    $apiKey    = '19b507d4bdbe078a0e51fcebb12a6d10';
    $apiSecret = 'e32a613c3d93c5f2c172ba7ee726ba05';

    // Validación básica de credenciales
    if (!$apiKey || !$apiSecret) {
        error_log("[Mailjet] Faltan credenciales de API (MJ_APIKEY_PUBLIC o MJ_APIKEY_PRIVATE).");
        return [
            'success' => false,
            'error'   => 'Credenciales no configuradas'
        ];
    }

    // Inicializa el cliente Mailjet
    $mj = new Client(
        $apiKey,
        $apiSecret,
        true,
        ['version' => 'v3.1']
    );

    // Prepara el cuerpo del mensaje
   $body = [
    'Messages' => [[
        'From' => [
            'Email' => 'almacenmotoracer@gmail.com',
            'Name'  => 'Soporte Almacén Moto Racer'
        ],
        'To' => [[
            'Email' => $correo,
            'Name'  => 'Usuario'
        ]],
        'Subject' => 'Código de recuperación de contraseña',
        'TextPart' => "Hola,\n\nHemos recibido una solicitud para restablecer tu contraseña en Moto Racer.\n\nTu código de recuperación es: $codigo\n\nIngresa este código en la página de recuperación para continuar.\n\nSi no realizaste esta solicitud, puedes ignorar este mensaje.",
        'HTMLPart' => "
            <html>
            <body style='font-family: Arial, sans-serif;'>
                <h2>Recuperación de contraseña - Moto Racer</h2>
                <p>Hola,</p>
                <p>Hemos recibido una solicitud para restablecer tu contraseña.</p>
                <p>Tu código de recuperación es:</p>
                <h3 style='color:rgb(12, 51, 77);'>$codigo</h3>
                <p>Ingresa este código en la página correspondiente para continuar con el proceso.</p>
                <p>Si no solicitaste este cambio, puedes ignorar este mensaje.</p>
                <br>
                <p>Atentamente,<br><strong>Soporte Almacén Moto Racer</strong></p>
            </body>
            </html>
        ",
        'CustomID' => 'RecuperacionSIMR'
    ]]
];

    try {
        // Envía la petición a Mailjet
        $response = $mj->post(Resources::$Email, ['body' => $body]);

        // Registra estado y datos de la respuesta
        error_log(sprintf(
            "[Mailjet] Status: %d, Data: %s",
            $response->getStatus(),
            json_encode($response->getData())
        ));

        if ($response->success()) {
            return [
                'success' => true,
                'error'   => null
            ];
        }

        // Respuesta no exitosa, pero sin excepción
        return [
            'success' => false,
            'error'   => 'Respuesta HTTP ' . $response->getStatus()
        ];

    } catch (ConnectionTimeoutException $e) {
        error_log("[Mailjet] Timeout de conexión: " . $e->getMessage());
        return [
            'success' => false,
            'error'   => 'Timeout de conexión'
        ];

    } catch (ServerException $e) {
        error_log("[Mailjet] Error en servidor Mailjet: " . $e->getMessage());
        return [
            'success' => false,
            'error'   => 'Error de servidor'
        ];

    } catch (\Exception $e) {
        // Cualquier otro error
        error_log("[Mailjet] Excepción general: " . $e->getMessage());
        return [
            'success' => false,
            'error'   => 'Error interno: ' . $e->getMessage()
        ];
    }
}

// Ejemplo de uso
$result = enviarCodigo('destino@mail.com', '123456');
if ($result['success']) {
    echo "Correo enviado correctamente.";
} else {
    echo "Fallo al enviar correo: " . $result['error'];
}

