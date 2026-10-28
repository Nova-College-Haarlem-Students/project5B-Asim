<?php
require 'klant_check.php';
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: profiel.php");
    exit;
}

$terug = "<br/><a href='profiel.php'>Terug</a>";

$name  = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

if (strlen($name) < 2) {
    echo "Naam is verplicht (minimaal 2 tekens)" . $terug;
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Vul een geldig e-mailadres in" . $terug;
    exit;
}

$stmt = $conn->prepare("SELECT id FROM users WHERE email = :email AND id != :id");
$stmt->execute(['email' => $email, 'id' => $_SESSION['user_id']]);
if ($stmt->fetch()) {
    echo "Dit e-mailadres is al in gebruik door een ander account" . $terug;
    exit;
}

$stmt = $conn->prepare("UPDATE users SET name = :name, email = :email, phone = :phone WHERE id = :id");
$stmt->execute([
    'name'  => $name,
    'email' => $email,
    'phone' => $phone,
    'id'    => $_SESSION['user_id']
]);

$_SESSION['name']  = $name;
$_SESSION['email'] = $email;

header("Location: profiel.php");
exit;
