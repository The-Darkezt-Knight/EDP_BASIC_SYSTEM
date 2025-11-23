<?php
header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=localhost;dbname=auth;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $stmt = $pdo->query("SELECT COUNT(*) as total_users FROM users");
    $total = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];

    echo json_encode(['total' => $total]);

} catch (Exception $e) {
    echo json_encode(['total' => 0, 'error' => $e->getMessage()]);
}
//This file retrieves the total number of registered users from the database and returns it in JSON format.