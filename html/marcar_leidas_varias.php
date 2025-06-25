<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
$mysqli = new mysqli('localhost', 'root', '', 'inventariomotoracer');
if ($mysqli->connect_errno) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la BD']);
    exit;
}

// 1) Traigo las últimas $limit notificaciones, con su flag `leida`
$stmt = $mysqli->prepare("SELECT id, leida FROM notificaciones ORDER BY fecha DESC LIMIT ?");
$stmt->bind_param("i", $limit);
$stmt->execute();
$res = $stmt->get_result();

$ids        = [];
$unread_cnt = 0;
while ($row = $res->fetch_assoc()) {
    $ids[] = $row['id'];
    if ($row['leida'] == 0) {
        $unread_cnt++;
    }
}
$stmt->close();

// 2) Si no hay ninguna sin leer, aviso y salgo
if ($unread_cnt === 0) {
    echo json_encode([
        'success'      => false,
        'already_read' => true,
        'message'      => "Las últimas {$limit} notificaciones ya estaban marcadas como leídas."
    ]);
    exit;
}

// 3) Actualizo sólo esos IDs
// Nota: construyo placeholders dinámicos para IN(...)
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$types        = str_repeat('i', count($ids));
$sqlUpd       = "UPDATE notificaciones SET leida = 1 WHERE id IN ({$placeholders})";
$stmt2        = $mysqli->prepare($sqlUpd);

// bind dinámico
$stmt2->bind_param($types, ...$ids);
if ($stmt2->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar notificaciones.']);
}

$stmt2->close();
$mysqli->close();
