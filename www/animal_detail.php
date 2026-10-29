<?php
session_start();
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

        <?php if (isset($_SESSION['user_id'])): ?>
            <button id="aanvraagBtn" class="knop" data-animal-id="<?php echo $animal['id']; ?>">Aanvraag indienen</button>
            <p id="aanvraagMelding"></p>
        <?php else: ?>
            <p><a href="login.php">Log in</a> om een adoptie-aanvraag in te dienen.</p>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let btn = document.querySelector('#aanvraagBtn');
    let melding = document.querySelector('#aanvraagMelding');

    if (btn) {
        btn.addEventListener('click', function() {
            fetch('adoptie_aanvraag_process.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ animal_id: btn.dataset.animalId })
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                melding.textContent = data.message;
                if (data.success) {
                    btn.disabled = true;
                }
            });
        });
    }
});
</script>

<?php include 'footer.php'; ?>
