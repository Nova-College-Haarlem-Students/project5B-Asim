<?php
require 'klant_check.php';
require 'db.php';

$stmt = $conn->prepare("SELECT adoption_requests.*, animals.name AS animal_name, species.name AS species_name FROM adoption_requests LEFT JOIN animals ON animals.id = adoption_requests.animal_id LEFT JOIN species ON species.id = animals.species_id WHERE adoption_requests.user_id = :user_id ORDER BY adoption_requests.request_date DESC");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$aanvragen = $stmt->fetchAll(PDO::FETCH_ASSOC);

$paginatitel = "Mijn aanvragen";
include 'header.php';
?>

<h1>Mijn aanvragen</h1>

<div class="tabel-wrap">
    <table class="tabel">
        <thead>
            <tr>
                <th>Dier</th>
                <th>Soort</th>
                <th>Status</th>
                <th>Datum</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($aanvragen as $aanvraag): ?>
            <tr>
                <td><?php echo htmlspecialchars($aanvraag['animal_name']); ?></td>
                <td><?php echo htmlspecialchars($aanvraag['species_name']); ?></td>
                <td><?php echo htmlspecialchars($aanvraag['status']); ?></td>
                <td><?php echo htmlspecialchars($aanvraag['request_date']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (count($aanvragen) == 0): ?>
    <p class="melding">Je hebt nog geen aanvragen ingediend.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
