<?php
session_start();
require 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];

if (empty($email)) {
    echo "E-mailadres is verplicht";
    echo "<br/><a href='login.php'>Terug</a>";
    exit;
}

if (empty($password)) {
    echo "Wachtwoord is verplicht";
    echo "<br/><a href='login.php'>Terug</a>";
    exit;
}

$stmt = $conn->prepare("SELECT users.*, roles.name AS role
                         FROM users
                         LEFT JOIN roles ON users.role_id = roles.id
                         WHERE users.email = :email");
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name']    = $user['name'];
    $_SESSION['email']   = $user['email'];
    $_SESSION['role']    = $user['role'];

    header("Location: index.php");
    exit;
}

echo "E-mailadres of wachtwoord is onjuist";
echo "<br/><a href='login.php'>Terug naar inloggen</a>";
