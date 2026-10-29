<?php
require 'beheer_check.php';
require 'db.php';

$stmt = $conn->prepare("SELECT animals.*, species.name AS species_name FROM animals LEFT JOIN species ON species.id = animals.species_id LEFT JOIN adoption_requests ON adoption_requests.animal_id = animals.id WHERE adoption_requests.id IS NULL AND animals.deleted_at IS NULL ORDER BY animals.name");
$stmt->execute();
$dieren = $stmt->fetchAll(PDO::FETCH_ASSOC);

$paginatitel = "Dieren zonder aanvragen";
include 'header.php';
?>

<h1>Dieren zonder aanvragen</h1>
<p>Deze dieren hebben nog geen enkele aanvraag gekregen.</p>

<div class="tabel-wrap">
    <table class="tabel">
        <thead>
            <tr>
                <th>Naam</th>
                <th>Soort</th>
                <th>Prijs</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dieren as $dier): ?>
            <tr>
                <td><?php echo htmlspecialchars($dier['name']); ?></td>
                <td><?php echo htmlspecialchars($dier['species_name']); ?></td>
                <td>&euro; <?php echo htmlspecialchars($dier['price']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (count($dieren) == 0): ?>
    <p class="melding">Alle dieren hebben al minstens één aanvraag.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
