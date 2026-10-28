<?php
session_start();
http_response_code(500);
$paginatitel = "Serverfout";
include 'header.php';
?>

<div class="melding fout">
    <h1>500 - Er ging iets mis</h1>
    <p>Er is een fout opgetreden. Probeer het later opnieuw.</p>
    <a href="index.php" class="knop">Terug naar overzicht</a>
</div>

<?php include 'footer.php'; ?>
