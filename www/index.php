<?php
require 'db.php';

$species_id = isset($_GET['species_id']) ? $_GET['species_id'] : '';
$gender     = isset($_GET['gender']) ? $_GET['gender'] : '';
$sort       = isset($_GET['sort']) ? $_GET['sort'] : '';

$query = "SELECT animals.*, species.name AS species_name FROM animals LEFT JOIN species ON species.id = animals.species_id WHERE animals.deleted_at IS NULL";
$params = [];

if (is_numeric($species_id)) {
    $query .= " AND animals.species_id = :species_id";
    $params['species_id'] = $species_id;
}

if ($gender == 'man' || $gender == 'vrouw') {
    $query .= " AND animals.gender = :gender";
    $params['gender'] = $gender;
}

if ($sort == 'prijs_laag') {
    $query .= " ORDER BY animals.price ASC";
} elseif ($sort == 'prijs_hoog') {
    $query .= " ORDER BY animals.price DESC";
} else {
    $query .= " ORDER BY animals.name";
}

try {
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    header('Location: 500.php');
    exit;
}

$stmt = $conn->prepare("SELECT DISTINCT species.id, species.name FROM species ORDER BY species.name");
$stmt->execute();
$soorten = $stmt->fetchAll(PDO::FETCH_ASSOC);

$paginatitel = "Dieren";
include 'header.php';
?>

<div class="intro">
    <h1>Onze dieren</h1>
    <p>Bekijk alle dieren die nog een nieuw thuis zoeken.</p>
</div>

<form action="index.php" method="get" class="zoekbalk">
    <select name="species_id">
        <option value="">Alle soorten</option>
        <?php foreach ($soorten as $soort): ?>
            <option value="<?php echo $soort['id']; ?>" <?php if ($species_id == $soort['id']) echo 'selected'; ?>><?php echo htmlspecialchars($soort['name']); ?></option>
        <?php endforeach; ?>
    </select>
    <select name="gender">
        <option value="">Alle geslachten</option>
        <option value="man" <?php if ($gender == 'man') echo 'selected'; ?>>Man</option>
        <option value="vrouw" <?php if ($gender == 'vrouw') echo 'selected'; ?>>Vrouw</option>
    </select>
    <select name="sort">
        <option value="">Naam</option>
        <option value="prijs_laag" <?php if ($sort == 'prijs_laag') echo 'selected'; ?>>Prijs laag - hoog</option>
        <option value="prijs_hoog" <?php if ($sort == 'prijs_hoog') echo 'selected'; ?>>Prijs hoog - laag</option>
    </select>
    <button type="submit">Filteren</button>
</form>

<?php if (count($animals) == 0): ?>
    <p class="melding">Geen dieren gevonden.</p>
<?php endif; ?>

<div class="grid">
    <?php foreach ($animals as $animal): ?>
        <div class="card">
            <img src="<?php echo htmlspecialchars($animal['photo']); ?>" alt="<?php echo htmlspecialchars($animal['name']); ?>">
            <div class="card-info">
                <p class="titel"><?php echo htmlspecialchars($animal['name']); ?></p>
                <p><?php echo htmlspecialchars($animal['species_name']); ?> &middot; <?php echo htmlspecialchars($animal['breed']); ?></p>
                <p>&euro; <?php echo htmlspecialchars($animal['price']); ?></p>
                <a href="animal_detail.php?id=<?php echo $animal['id']; ?>" class="knop">Bekijk details</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'footer.php'; ?>
