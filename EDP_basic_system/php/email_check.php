<?php
require_once "db_functions.php";
header('Content-Type: application/json');
// Get and sanitize the email
$email = $_POST['email'] ?? '';
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['exists' => false, 'error' => 'Invalid email format']);
    exit;
}
// Connect and check
$pdo = connect();
$exists = check_email($pdo, $email);
echo json_encode(['exists' => $exists]);
?>