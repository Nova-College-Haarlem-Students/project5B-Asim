<?php
require 'beheer_check.php';
require 'db.php';

$stmt = $conn->prepare("SELECT * FROM species ORDER BY name");
$stmt->execute();
$soorten = $stmt->fetchAll(PDO::FETCH_ASSOC);

$paginatitel = "Nieuw dier";
include 'header.php';
?>

<h1>Nieuw dier toevoegen</h1>

<form action="dier_create_process.php" method="post" class="formulier">
    <div class="veld">
        <label for="name">Naam *</label>
        <input type="text" name="name" id="name">
    </div>
    <div class="veld">
        <label for="species_id">Soort *</label>
        <select name="species_id" id="species_id">
            <option value="">Kies een soort</option>
            <?php foreach ($soorten as $soort): ?>
                <option value="<?php echo $soort['id']; ?>"><?php echo htmlspecialchars($soort['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="veld">
        <label for="breed">Ras *</label>
        <input type="text" name="breed" id="breed">
    </div>
    <div class="veld">
        <label for="gender">Geslacht *</label>
        <select name="gender" id="gender">
            <option value="">Kies een geslacht</option>
            <option value="man">Man</option>
            <option value="vrouw">Vrouw</option>
        </select>
    </div>
    <div class="veld">
        <label for="birth_date">Geboortedatum</label>
        <input type="date" name="birth_date" id="birth_date">
    </div>
    <div class="veld">
        <label for="chip_number">Chipnummer</label>
        <input type="text" name="chip_number" id="chip_number">
    </div>
    <div class="veld">
        <label for="photo">Foto (URL)*</label>
        <input type="text" name="photo" id="photo">
    </div>
    <div class="veld">
        <label for="description">Beschrijving *</label>
        <input type="text" name="description" id="description">
    </div>
    <div class="veld">
        <label for="price">Adoptieprijs *</label>
        <input type="text" name="price" id="price">
    </div>
    <button type="submit">Dier toevoegen</button>
</form>

<?php include 'footer.php'; ?>
