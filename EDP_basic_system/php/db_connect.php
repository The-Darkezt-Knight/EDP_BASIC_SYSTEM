<?php
$host = "localhost";
$db = "auth";
$user = "root";
$pw = "";
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false
];

//pota ka lee wala gn try pa run ay
try {
    $conn = new PDO($dsn, $user, $pw, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}