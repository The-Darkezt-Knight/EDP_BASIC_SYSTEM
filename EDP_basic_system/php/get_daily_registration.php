<?php
header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=localhost;dbname=auth;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $stmt = $pdo->query("
        SELECT DATE(created_at) as reg_date, COUNT(*) as count
        FROM users
        WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
        GROUP BY DATE(created_at)
        ORDER BY reg_date ASC
    ");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $days = [];
    for ($i=6; $i>=0; $i--) {
        $day = date('Y-m-d', strtotime("-$i day"));
        $days[$day] = 0;
    }

    foreach ($data as $row) {
        $days[$row['reg_date']] = (int)$row['count'];
    }

    $result = [];
    foreach ($days as $date => $count) {
        $result[] = ['reg_date' => $date, 'count' => $count];
    }

    echo json_encode($result);

} catch (Exception $e) {
    echo json_encode([]);
}
