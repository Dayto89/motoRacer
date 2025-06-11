<?php
session_start();
// (mismo control de sesión)
$data = json_decode(file_get_contents('php://input'), true);
$id = (int)$data['id'];
$mysqli = new mysqli('localhost','root','','inventariomotoracer');
$stmt = $mysqli->prepare("DELETE FROM notificaciones WHERE id = ?");
$stmt->bind_param('i', $id);
$success = $stmt->execute();
echo json_encode(['success' => $success]);
