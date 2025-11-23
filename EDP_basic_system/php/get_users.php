<?php
header('Content-Type: application/json');

$pdo = new PDO("mysql:host=localhost;dbname=auth;charset=utf8mb4", "root", "");
$search = isset($_GET['search']) ? $_GET['search'] : '';

if ($search) {
    $stmt = $pdo->prepare("SELECT fullname, email, gender, city, password 
                           FROM users 
                           WHERE fullname LIKE :search 
                              OR email LIKE :search
                              OR city LIKE :search");
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT fullname, email, gender, city, password FROM users");
}

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($users);
