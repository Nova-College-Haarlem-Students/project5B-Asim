<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: login.php");
    exit;
}

$email    = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($email) || empty($password)) {
    echo "Vul e-mailadres en wachtwoord in";
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
