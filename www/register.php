<?php
session_start();
$paginatitel = "Account aanmaken";
include 'header.php';
?>

<h1>Account aanmaken</h1>

<form action="register_process.php" method="post" class="formulier">
    <div class="veld">
        <label for="name">Naam</label>
        <input type="text" name="name" id="name">
    </div>
    <div class="veld">
        <label for="email">E-mailadres</label>
        <input type="text" name="email" id="email">
    </div>
    <div class="veld">
        <label for="password">Wachtwoord</label>
        <input type="password" name="password" id="password">
    </div>
    <div class="veld">
        <label for="phone">Telefoonnummer</label>
        <input type="text" name="phone" id="phone">
    </div>
    <button type="submit">Account aanmaken</button>
</form>

<p>Heb je al een account? <a href="login.php">Log hier in</a></p>

<?php include 'footer.php'; ?>
