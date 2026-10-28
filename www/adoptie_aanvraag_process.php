<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($_SESSION['user_id']) || !isset($data['animal_id']) || !is_numeric($data['animal_id'])) {
    echo json_encode(['success' => false, 'message' => 'Je moet ingelogd zijn om een aanvraag te doen.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$animal_id = $data['animal_id'];

$stmt = $conn->prepare("SELECT id FROM adoption_requests WHERE user_id = :user_id AND animal_id = :animal_id");
$stmt->execute(['user_id' => $user_id, 'animal_id' => $animal_id]);

if ($stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'Je hebt al een aanvraag voor dit dier ingediend.']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO adoption_requests (user_id, animal_id, request_date, motivation, status) VALUES (:user_id, :animal_id, CURDATE(), '', 'nieuw')");
$stmt->execute(['user_id' => $user_id, 'animal_id' => $animal_id]);

echo json_encode(['success' => true, 'message' => 'Je aanvraag is verstuurd!']);
