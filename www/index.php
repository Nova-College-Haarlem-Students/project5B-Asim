<?php
require 'db.php';

// Keuzelijst soorten, zonder dubbele waardes
$stmt = $conn->prepare("SELECT DISTINCT s.id, s.name FROM species s ORDER BY s.name");
$stmt->execute();
$soorten = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Filters en sortering uit de URL
$species_id = $_GET['species_id'] ?? '';
$gender     = $_GET['gender'] ?? '';
$sort       = $_GET['sort'] ?? '';

$sql = "SELECT a.*, s.name AS species_name
        FROM animals a
        LEFT JOIN species s ON s.id = a.species_id
        WHERE a.deleted_at IS NULL";
$params = [];

if (is_numeric($species_id)) {
    $sql .= " AND a.species_id = :species_id";
    $params['species_id'] = $species_id;
}

if ($gender === 'man' || $gender === 'vrouw') {
    $sql .= " AND a.gender = :gender";
    $params['gender'] = $gender;
}

if ($sort === 'price_asc') {
    $sql .= " ORDER BY a.price ASC";
} elseif ($sort === 'price_desc') {
    $sql .= " ORDER BY a.price DESC";
} else {
    $sql .= " ORDER BY a.name ASC";
}

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    header('Location: 500.php');
    exit;
}

require 'header.php';
?>

<h2>Onze dieren</h2>

<form method="GET" action="index.php">
    <select name="species_id">
        <option value="">Alle soorten</option>
        <?php foreach ($soorten as $soort): ?>
            <option value="<?= $soort['id'] ?>" <?= ((string) $species_id === (string) $soort['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($soort['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <select name="gender">
        <option value="">Alle geslachten</option>
        <option value="man" <?= $gender === 'man' ? 'selected' : '' ?>>Man</option>
        <option value="vrouw" <?= $gender === 'vrouw' ? 'selected' : '' ?>>Vrouw</option>
    </select>

    <select name="sort">
        <option value="name" <?= $sort === 'name' ? 'selected' : '' ?>>Naam</option>
        <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Prijs laag - hoog</option>
        <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Prijs hoog - laag</option>
    </select>

    <button type="submit">Filteren</button>
</form>

<div class="dieren-grid">
    <?php foreach ($animals as $animal): ?>
        <div class="dier-kaart">
            <img src="<?= htmlspecialchars($animal['photo']) ?>" alt="<?= htmlspecialchars($animal['name']) ?>">
            <h3><?= htmlspecialchars($animal['name']) ?></h3>
            <p><?= htmlspecialchars($animal['species_name']) ?> - <?= htmlspecialchars($animal['breed']) ?></p>
            <p>&euro; <?= htmlspecialchars($animal['price']) ?></p>
            <a href="animal_detail.php?id=<?= $animal['id'] ?>">Bekijk</a>
        </div>
    <?php endforeach; ?>

    <?php if (empty($animals)): ?>
        <p>Geen dieren gevonden.</p>
    <?php endif; ?>
</div>

<?php require 'footer.php'; ?>
