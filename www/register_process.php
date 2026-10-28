<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: register.php");
    exit;
}

$terug = "<br/><a href='register.php'>Terug</a>";

$name     = isset($_POST['name']) ? trim($_POST['name']) : '';
$email    = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$phone    = isset($_POST['phone']) ? trim($_POST['phone']) : '';

if (strlen($name) < 2) {
    echo "Naam is verplicht (minimaal 2 tekens)" . $terug;
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Vul een geldig e-mailadres in" . $terug;
    exit;
}

if (strlen($password) < 8) {
    echo "Wachtwoord moet minimaal 8 tekens zijn" . $terug;
    exit;
}

$stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
if ($stmt->fetch()) {
    echo "Dit e-mailadres is al in gebruik" . $terug;
    exit;
}

$stmt = $conn->prepare("SELECT id FROM roles WHERE name = 'klant'");
$stmt->execute();
$rol = $stmt->fetch(PDO::FETCH_ASSOC);

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (role_id, name, email, password, phone) VALUES (:role_id, :name, :email, :password, :phone)");
$stmt->execute([
    'role_id'  => $rol['id'],
    'name'     => $name,
    'email'    => $email,
    'password' => $password_hash,
    'phone'    => $phone
]);

header("Location: login.php");
exit;
