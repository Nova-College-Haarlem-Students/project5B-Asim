<?php
session_start();
require 'db.php';

$terug = "<br/><a href='register.php'>Terug</a>";

if (empty($_POST['name']) || strlen($_POST['name']) < 2) {
    echo "Naam is verplicht (minimaal 2 tekens)" . $terug;
    exit;
}

if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo "Vul een geldig e-mailadres in" . $terug;
    exit;
}

if (empty($_POST['password']) || strlen($_POST['password']) < 8) {
    echo "Wachtwoord moet minimaal 8 tekens zijn" . $terug;
    exit;
}

$stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
$stmt->execute(['email' => $_POST['email']]);
if ($stmt->fetch()) {
    echo "Dit e-mailadres is al in gebruik" . $terug;
    exit;
}

$stmt = $conn->prepare("SELECT id FROM roles WHERE name = 'klant'");
$stmt->execute();
$rol = $stmt->fetch(PDO::FETCH_ASSOC);

$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (role_id, name, email, password, phone) VALUES (:role_id, :name, :email, :password, :phone)");
$stmt->execute([
    'role_id'  => $rol['id'],
    'name'     => $_POST['name'],
    'email'    => $_POST['email'],
    'password' => $password_hash,
    'phone'    => $_POST['phone']
]);

header("Location: login.php");
exit;
