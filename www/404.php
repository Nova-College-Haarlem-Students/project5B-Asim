<?php
http_response_code(404);
$paginatitel = "Niet gevonden";
include 'header.php';
?>

<div class="melding fout">
    <h1>404 - Pagina niet gevonden</h1>
    <p>Dit dier of deze pagina bestaat niet (meer).</p>
    <a href="index.php" class="knop">Terug naar overzicht</a>
</div>

<?php include 'footer.php'; ?>
