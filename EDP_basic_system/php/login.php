<?php
session_start();
require_once 'db_connect.php';

if ($conn === null) {
    die("Database connection failed!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $errors = [];

    if (empty($email)) $errors[] = "Email is required";
    if (empty($password)) $errors[] = "Password is required";

    if (empty($errors)) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => $email]);

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['fullname'] = $user['fullname'];
                
                // Set success message for Toastr
                header("Location: dashboard.php");
                exit();
            } else {
                $errors[] = "Invalid email or password";
            }
        } else {
            $errors[] = "Invalid email or password";
        }
    }

    if (!empty($errors)) {
        $_SESSION['login_status'] = ['type' => 'error', 'message' => implode(', ', $errors)];
        $_SESSION['old_email'] = $email;
        header("Location: index.php");
        exit();
    }
}
?>
