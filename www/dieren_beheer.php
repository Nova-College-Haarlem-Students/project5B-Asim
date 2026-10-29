<?php
require 'beheer_check.php';
require 'db.php';

$stmt = $conn->prepare("SELECT animals.*, species.name AS species_name FROM animals LEFT JOIN species ON species.id = animals.species_id ORDER BY animals.name");
$stmt->execute();
$dieren = $stmt->fetchAll(PDO::FETCH_ASSOC);

$paginatitel = "Dieren beheren";
include 'header.php';
?>

<h1>Dieren beheren</h1>
<p><a href="dier_create.php" class="knop">Nieuw dier</a></p>

<div class="tabel-wrap">
    <table class="tabel">
        <thead>
            <tr>
                <th>Naam</th>
                <th>Soort</th>
                <th>Prijs</th>
                <th>Status</th>
                <th>Actie</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dieren as $dier): ?>
            <tr>
                <td><?php echo htmlspecialchars($dier['name']); ?></td>
                <td><?php echo htmlspecialchars($dier['species_name']); ?></td>
                <td>&euro; <?php echo htmlspecialchars($dier['price']); ?></td>
                <td>
                    <?php if ($dier['deleted_at']): ?>
                        verwijderd
                    <?php else: ?>
                        actief
                    <?php endif; ?>
                </td>
                <td>
                    <a href="dier_update.php?id=<?php echo $dier['id']; ?>">Wijzig</a>
                    <?php if ($dier['deleted_at']): ?>
                        <a href="dier_herstellen.php?id=<?php echo $dier['id']; ?>">Herstel</a>
                    <?php else: ?>
                        <a href="dier_verwijderen.php?id=<?php echo $dier['id']; ?>" onclick="return confirm('Weet je zeker dat je dit dier wilt verwijderen?')">Verwijder</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
