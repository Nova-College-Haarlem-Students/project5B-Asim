<?php
require 'beheer_check.php';
require 'db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: dieren_beheer.php');
    exit;
}

$stmt = $conn->prepare("UPDATE animals SET deleted_at = NULL WHERE id = :id");
$stmt->execute(['id' => $_GET['id']]);

$stmt = $conn->prepare("INSERT INTO logs (user_id, animal_id, action, description) VALUES (:user_id, :animal_id, :action, :description)");
$stmt->execute([
    'user_id'     => $_SESSION['user_id'],
    'animal_id'   => $_GET['id'],
    'action'      => 'dier hersteld',
    'description' => $_SESSION['name'] . ' heeft dier #' . $_GET['id'] . ' hersteld'
]);

header('Location: dieren_beheer.php');
exit;
