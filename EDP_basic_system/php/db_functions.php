<?php
require_once "db_connect.php";

function connect()
{   
    global $dsn, $user, $pw, $options;
    try {
        return new PDO($dsn, $user, $pw, $options);
    } catch(PDOException $e) {
        die("Unable to connect to the database " . $e->getMessage());
    }
}

function check_email(PDO $pdo, string $email)
{
    $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":email" => $email]);
    return $stmt->fetchColumn() > 0;
}

function insert_input(PDO $pdo, string $fullname, string $city, string $gender, string $hashed_password, string $email)
{
    $sql = "INSERT INTO users(fullname, city, gender, password, email)
            VALUES(:fullname, :city, :gender, :password, :email)";

    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ":fullname" => $fullname,
            ":city"     => $city,
            ":gender"   => $gender,
            ":password" => $hashed_password,
            ":email"    => $email
        ]);
    } catch(PDOException $e) {
        die("Failed to sign up. Please try again later " . $e->getMessage());
    }
}
?>
