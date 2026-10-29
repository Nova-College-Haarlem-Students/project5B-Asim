<?php
require 'beheer_check.php';
require 'db.php';

$terug = "<br/><a href='aanvragen_beheer.php'>Terug</a>";

if (empty($_POST['id']) || !is_numeric($_POST['id'])) {
    header('Location: aanvragen_beheer.php');
    exit;
}

if ($_POST['status'] != 'nieuw' && $_POST['status'] != 'goedgekeurd' && $_POST['status'] != 'afgewezen') {
    echo "Ongeldige status" . $terug;
    exit;
}

$stmt = $conn->prepare("UPDATE adoption_requests SET status = :status WHERE id = :id");
$stmt->execute(['status' => $_POST['status'], 'id' => $_POST['id']]);

$stmt = $conn->prepare("INSERT INTO logs (user_id, animal_id, action, description) VALUES (:user_id, :animal_id, :action, :description)");
$stmt->execute([
    'user_id'     => $_SESSION['user_id'],
    'animal_id'   => null,
    'action'      => 'aanvraag status gewijzigd',
    'description' => $_SESSION['name'] . ' heeft aanvraag #' . $_POST['id'] . ' op status "' . $_POST['status'] . '" gezet'
]);

header('Location: aanvragen_beheer.php');
exit;
