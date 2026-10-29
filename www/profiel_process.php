<?php
require 'klant_check.php';
require 'db.php';

$terug = "<br/><a href='profiel.php'>Terug</a>";

if (empty($_POST['name']) || strlen($_POST['name']) < 2) {
    echo "Naam is verplicht (minimaal 2 tekens)" . $terug;
    exit;
}

if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo "Vul een geldig e-mailadres in" . $terug;
    exit;
}

$stmt = $conn->prepare("SELECT id FROM users WHERE email = :email AND id != :id");
$stmt->execute(['email' => $_POST['email'], 'id' => $_SESSION['user_id']]);
if ($stmt->fetch()) {
    echo "Dit e-mailadres is al in gebruik door een ander account" . $terug;
    exit;
}

$stmt = $conn->prepare("UPDATE users SET name = :name, email = :email, phone = :phone WHERE id = :id");
$stmt->execute([
    'name'  => $_POST['name'],
    'email' => $_POST['email'],
    'phone' => $_POST['phone'],
    'id'    => $_SESSION['user_id']
]);

$_SESSION['name']  = $_POST['name'];
$_SESSION['email'] = $_POST['email'];

header("Location: profiel.php");
exit;
