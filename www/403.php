<?php
session_start();
http_response_code(403);
$paginatitel = "Geen toegang";
include 'header.php';
?>

<div class="melding fout">
    <h1>403 - Geen toegang</h1>
    <p>Je hebt geen toestemming om deze pagina te bekijken.</p>
    <a href="index.php" class="knop">Terug naar overzicht</a>
</div>

<?php include 'footer.php'; ?>
