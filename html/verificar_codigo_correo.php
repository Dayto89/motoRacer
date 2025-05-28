<?php
header('Content-Type: application/json');

// 1. Recibir el JSON
$input = json_decode(file_get_contents('php://input'), true);
$correo = trim($input['correo'] ?? '');
$codigo = trim($input['codigo'] ?? '');

if (empty($correo) || empty($codigo)) {
    echo json_encode(['success' => false, 'message' => 'Correo o código vacío.']);
    exit;
}

// 2. Conectar a la base de datos
$host = 'localhost';
$dbname = 'inventariomotoracer';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 3. Buscar el código para ese correo
    $stmt = $pdo->prepare("SELECT * FROM verificaciones WHERE correo = ? ORDER BY fecha_envio DESC LIMIT 1");
    $stmt->execute([$correo]);
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($registro && $registro['codigo'] === $codigo) {
        // 4. Opcional: eliminar el código para que no pueda usarse otra vez
        $pdo->prepare("DELETE FROM verificaciones WHERE correo = ?")->execute([$correo]);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Código incorrecto.']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error en base de datos: ' . $e->getMessage()]);
}