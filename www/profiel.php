<?php
require 'klant_check.php';
require 'db.php';

$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$paginatitel = "Mijn profiel";
include 'header.php';
?>

<h1>Mijn profiel</h1>

<form action="profiel_process.php" method="post" class="formulier">
    <div class="veld">
        <label for="name">Naam</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>">
    </div>
    <div class="veld">
        <label for="email">E-mailadres</label>
        <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>">
    </div>
    <div class="veld">
        <label for="phone">Telefoonnummer</label>
        <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
    </div>
    <button type="submit">Opslaan</button>
</form>

<?php include 'footer.php'; ?>
