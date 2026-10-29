<?php
require 'beheer_check.php';
require 'db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: dieren_beheer.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM animals WHERE id = :id");
$stmt->execute(['id' => $_GET['id']]);
$dier = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dier) {
    header('Location: dieren_beheer.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM species ORDER BY name");
$stmt->execute();
$soorten = $stmt->fetchAll(PDO::FETCH_ASSOC);

$paginatitel = "Dier wijzigen";
include 'header.php';
?>

<h1>Dier wijzigen</h1>

<form action="dier_update_process.php" method="post" class="formulier">
    <input type="hidden" name="id" value="<?php echo $dier['id']; ?>">
    <div class="veld">
        <label for="name">Naam *</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($dier['name']); ?>">
    </div>
    <div class="veld">
        <label for="species_id">Soort *</label>
        <select name="species_id" id="species_id">
            <?php foreach ($soorten as $soort): ?>
                <option value="<?php echo $soort['id']; ?>" <?php if ($dier['species_id'] == $soort['id']) echo 'selected'; ?>><?php echo htmlspecialchars($soort['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="veld">
        <label for="breed">Ras *</label>
        <input type="text" name="breed" id="breed" value="<?php echo htmlspecialchars($dier['breed']); ?>">
    </div>
    <div class="veld">
        <label for="gender">Geslacht *</label>
        <select name="gender" id="gender">
            <option value="man" <?php if ($dier['gender'] == 'man') echo 'selected'; ?>>Man</option>
            <option value="vrouw" <?php if ($dier['gender'] == 'vrouw') echo 'selected'; ?>>Vrouw</option>
        </select>
    </div>
    <div class="veld">
        <label for="birth_date">Geboortedatum</label>
        <input type="date" name="birth_date" id="birth_date" value="<?php echo htmlspecialchars($dier['birth_date'] ? $dier['birth_date'] : ''); ?>">
    </div>
    <div class="veld">
        <label for="chip_number">Chipnummer</label>
        <input type="text" name="chip_number" id="chip_number" value="<?php echo htmlspecialchars($dier['chip_number'] ? $dier['chip_number'] : ''); ?>">
    </div>
    <div class="veld">
        <label for="photo">Foto (URL) *</label>
        <input type="text" name="photo" id="photo" value="<?php echo htmlspecialchars($dier['photo']); ?>">
    </div>
    <div class="veld">
        <label for="description">Beschrijving *</label>
        <input type="text" name="description" id="description" value="<?php echo htmlspecialchars($dier['description']); ?>">
    </div>
    <div class="veld">
        <label for="price">Adoptieprijs *</label>
        <input type="text" name="price" id="price" value="<?php echo htmlspecialchars($dier['price']); ?>">
    </div>
    <button type="submit">Opslaan</button>
</form>

<?php include 'footer.php'; ?>
