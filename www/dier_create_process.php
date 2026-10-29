<?php
require 'beheer_check.php';
require 'db.php';

$terug = "<br/><a href='dier_create.php'>Terug</a>";

if (empty($_POST['name']) || strlen($_POST['name']) < 2) {
    echo "Naam is verplicht (minimaal 2 tekens)" . $terug;
    exit;
}

if (empty($_POST['species_id']) || !is_numeric($_POST['species_id'])) {
    echo "Kies een soort" . $terug;
    exit;
}

$stmt = $conn->prepare("SELECT id FROM species WHERE id = :id");
$stmt->execute(['id' => $_POST['species_id']]);
if (!$stmt->fetch()) {
    echo "Deze soort bestaat niet" . $terug;
    exit;
}

if (empty($_POST['breed'])) {
    echo "Ras is verplicht" . $terug;
    exit;
}

if ($_POST['gender'] != 'man' && $_POST['gender'] != 'vrouw') {
    echo "Kies een geslacht" . $terug;
    exit;
}

if (empty($_POST['photo'])) {
    echo "Foto is verplicht" . $terug;
    exit;
}

if (empty($_POST['description'])) {
    echo "Beschrijving is verplicht" . $terug;
    exit;
}

if (empty($_POST['price']) || !is_numeric($_POST['price']) || $_POST['price'] <= 0) {
    echo "Adoptieprijs moet een getal groter dan 0 zijn" . $terug;
    exit;
}

$birth_date = empty($_POST['birth_date']) ? null : $_POST['birth_date'];
$chip_number = empty($_POST['chip_number']) ? null : $_POST['chip_number'];

if ($chip_number !== null) {
    $stmt = $conn->prepare("SELECT id FROM animals WHERE chip_number = :chip_number");
    $stmt->execute(['chip_number' => $chip_number]);
    if ($stmt->fetch()) {
        echo "Dit chipnummer is al in gebruik" . $terug;
        exit;
    }
}

$stmt = $conn->prepare("INSERT INTO animals (species_id, name, breed, gender, birth_date, chip_number, photo, description, price) VALUES (:species_id, :name, :breed, :gender, :birth_date, :chip_number, :photo, :description, :price)");
$stmt->execute([
    'species_id'   => $_POST['species_id'],
    'name'         => $_POST['name'],
    'breed'        => $_POST['breed'],
    'gender'       => $_POST['gender'],
    'birth_date'   => $birth_date,
    'chip_number'  => $chip_number,
    'photo'        => $_POST['photo'],
    'description'  => $_POST['description'],
    'price'        => $_POST['price']
]);

$animal_id = $conn->lastInsertId();

$stmt = $conn->prepare("INSERT INTO logs (user_id, animal_id, action, description) VALUES (:user_id, :animal_id, :action, :description)");
$stmt->execute([
    'user_id'     => $_SESSION['user_id'],
    'animal_id'   => $animal_id,
    'action'      => 'dier toegevoegd',
    'description' => $_SESSION['name'] . ' heeft ' . $_POST['name'] . ' toegevoegd'
]);

header("Location: dieren_beheer.php");
exit;
