<?php
require 'admin_check.php';
require 'db.php';

$stmt = $conn->prepare("SELECT species.name, COUNT(*) AS aantal FROM animals LEFT JOIN species ON species.id = animals.species_id WHERE animals.deleted_at IS NULL GROUP BY species.id, species.name");
$stmt->execute();
$aantal_per_soort = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT AVG(price) AS gemiddelde, MIN(price) AS laagste, MAX(price) AS hoogste FROM animals WHERE deleted_at IS NULL");
$stmt->execute();
$prijzen = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT SUM(animals.price) AS opbrengst FROM adoption_requests LEFT JOIN animals ON animals.id = adoption_requests.animal_id WHERE adoption_requests.status = 'goedgekeurd'");
$stmt->execute();
$opbrengst = $stmt->fetch(PDO::FETCH_ASSOC)['opbrengst'];

$stmt = $conn->prepare("SELECT species.name, COUNT(*) AS aantal_aanvragen FROM adoption_requests LEFT JOIN animals ON animals.id = adoption_requests.animal_id LEFT JOIN species ON species.id = animals.species_id GROUP BY species.id, species.name HAVING COUNT(*) > 3");
$stmt->execute();
$populaire_soorten = $stmt->fetchAll(PDO::FETCH_ASSOC);

$paginatitel = "Statistieken";
include 'header.php';
?>

<h1>Statistieken</h1>

<h2>Aantal dieren per soort</h2>
<div class="tabel-wrap">
    <table class="tabel">
        <thead>
            <tr>
                <th>Soort</th>
                <th>Aantal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($aantal_per_soort as $rij): ?>
            <tr>
                <td><?php echo htmlspecialchars($rij['name']); ?></td>
                <td><?php echo $rij['aantal']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<h2>Adoptieprijzen</h2>
<p>Gemiddelde prijs: &euro; <?php echo round($prijzen['gemiddelde'], 2); ?></p>
<p>Laagste prijs: &euro; <?php echo $prijzen['laagste']; ?></p>
<p>Hoogste prijs: &euro; <?php echo $prijzen['hoogste']; ?></p>

<h2>Opbrengst</h2>
<p>Opbrengst van goedgekeurde adopties: &euro; <?php echo $opbrengst ? $opbrengst : '0.00'; ?></p>

<h2>Populaire soorten (meer dan 3 aanvragen)</h2>
<div class="tabel-wrap">
    <table class="tabel">
        <thead>
            <tr>
                <th>Soort</th>
                <th>Aantal aanvragen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($populaire_soorten as $rij): ?>
            <tr>
                <td><?php echo htmlspecialchars($rij['name']); ?></td>
                <td><?php echo $rij['aantal_aanvragen']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (count($populaire_soorten) == 0): ?>
    <p class="melding">Nog geen enkele soort heeft meer dan 3 aanvragen.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
