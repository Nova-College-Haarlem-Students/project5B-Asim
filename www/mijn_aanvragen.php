<?php
require 'klant_check.php';
require 'db.php';

$stmt = $conn->prepare("SELECT adoption_requests.*, animals.name AS animal_name, species.name AS species_name
                         FROM adoption_requests
                         LEFT JOIN animals ON animals.id = adoption_requests.animal_id
                         LEFT JOIN species ON species.id = animals.species_id
                         WHERE adoption_requests.user_id = :user_id
                         ORDER BY adoption_requests.request_date DESC");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$aanvragen = $stmt->fetchAll(PDO::FETCH_ASSOC);

$paginatitel = "Mijn aanvragen";
include 'header.php';
?>

<h1>Mijn aanvragen</h1>

<?php if (count($aanvragen) == 0): ?>
    <p class="melding">Je hebt nog geen aanvragen ingediend.</p>
<?php endif; ?>

<?php foreach ($aanvragen as $aanvraag): ?>
    <div class="aanvraag">
        <p class="titel"><?php echo htmlspecialchars($aanvraag['animal_name']); ?> (<?php echo htmlspecialchars($aanvraag['species_name']); ?>)</p>
        <p>Status: <?php echo htmlspecialchars($aanvraag['status']); ?></p>
        <p>Datum: <?php echo htmlspecialchars($aanvraag['request_date']); ?></p>
    </div>
<?php endforeach; ?>

<?php include 'footer.php'; ?>
