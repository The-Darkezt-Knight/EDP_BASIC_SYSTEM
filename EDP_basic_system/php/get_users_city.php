<?php
header('Content-Type: application/json');
try {
    $pdo = new PDO("mysql:host=localhost;dbname=auth;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $stmt = $pdo->query("
        SELECT city, COUNT(*) as count
        FROM users
        GROUP BY city
        ORDER BY count DESC
        LIMIT 10
    ");

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);

} catch (Exception $e) {
    echo json_encode([]);
}
