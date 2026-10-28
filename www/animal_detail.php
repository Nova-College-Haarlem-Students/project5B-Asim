<?php
require 'db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: 404.php');
    exit;
}

try {
    $stmt = $conn->prepare("SELECT animals.*, species.name AS species_name FROM animals LEFT JOIN species ON species.id = animals.species_id WHERE animals.id = :id AND animals.deleted_at IS NULL");
    $stmt->execute(['id' => $_GET['id']]);
    $animal = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    header('Location: 500.php');
    exit;
}

if (!$animal) {
    header('Location: 404.php');
    exit;
}

$paginatitel = $animal['name'];
include 'header.php';
?>

<a href="index.php" class="terug">&larr; Terug naar overzicht</a>

<div class="detail">
    <img src="<?php echo htmlspecialchars($animal['photo']); ?>" alt="<?php echo htmlspecialchars($animal['name']); ?>">

    <div class="detail-info">
        <h1><?php echo htmlspecialchars($animal['name']); ?></h1>
        <p><strong>Soort:</strong> <?php echo htmlspecialchars($animal['species_name']); ?></p>
        <p><strong>Ras:</strong> <?php echo htmlspecialchars($animal['breed']); ?></p>
        <p><strong>Geslacht:</strong> <?php echo htmlspecialchars($animal['gender']); ?></p>
        <p><strong>Geboortedatum:</strong> <?php echo $animal['birth_date'] ? htmlspecialchars($animal['birth_date']) : 'Onbekend'; ?></p>
        <p><strong>Chipnummer:</strong> <?php echo $animal['chip_number'] ? htmlspecialchars($animal['chip_number']) : 'Geen chip'; ?></p>
        <p><strong>Beschrijving:</strong> <?php echo htmlspecialchars($animal['description']); ?></p>
        <p class="prijs">&euro; <?php echo htmlspecialchars($animal['price']); ?></p>
    </div>
</div>

<?php include 'footer.php'; ?>
