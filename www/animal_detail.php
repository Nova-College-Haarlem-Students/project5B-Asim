<?php
require 'db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: 404.php');
    exit;
}

$id = (int) $_GET['id'];

try {
    $stmt = $conn->prepare("SELECT a.*, s.name AS species_name FROM animals a LEFT JOIN species s
     ON s.id = a.species_id WHERE a.id = :id AND a.deleted_at IS NULL");
    $stmt->execute(['id' => $id]);
    $animal = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    header('Location: 500.php');
    exit;
}

if (!$animal) {
    header('Location: 404.php');
    exit;
}

require 'header.php';
?>

<h2><?= htmlspecialchars($animal['name']) ?></h2>
<img src="<?= htmlspecialchars($animal['photo']) ?>" alt="<?= htmlspecialchars($animal['name']) ?>">
<p>Soort: <?= htmlspecialchars($animal['species_name']) ?></p>
<p>Ras: <?= htmlspecialchars($animal['breed']) ?></p>
<p>Geslacht: <?= htmlspecialchars($animal['gender']) ?></p>
<p>Geboortedatum: <?= htmlspecialchars($animal['birth_date'] ?? 'Onbekend') ?></p>
<p>Chipnummer: <?= htmlspecialchars($animal['chip_number'] ?? 'Geen chip') ?></p>
<p>Beschrijving: <?= htmlspecialchars($animal['description']) ?></p>
<p>Adoptieprijs: &euro; <?= htmlspecialchars($animal['price']) ?></p>

<a href="index.php">Terug naar overzicht</a>

<?php require 'footer.php'; ?>
