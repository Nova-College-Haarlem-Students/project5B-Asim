<?php
require 'beheer_check.php';
require 'db.php';

$stmt = $conn->prepare("SELECT adoption_requests.*, animals.name AS animal_name, users.name AS user_name FROM adoption_requests LEFT JOIN animals ON animals.id = adoption_requests.animal_id LEFT JOIN users ON users.id = adoption_requests.user_id ORDER BY adoption_requests.request_date DESC");
$stmt->execute();
$aanvragen = $stmt->fetchAll(PDO::FETCH_ASSOC);

$paginatitel = "Aanvragen beheren";
include 'header.php';
?>

<h1>Aanvragen beheren</h1>

<div class="tabel-wrap">
    <table class="tabel">
        <thead>
            <tr>
                <th>Dier</th>
                <th>Aanvrager</th>
                <th>Datum</th>
                <th>Status</th>
                <th>Actie</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($aanvragen as $aanvraag): ?>
            <tr>
                <td><?php echo htmlspecialchars($aanvraag['animal_name']); ?></td>
                <td><?php echo htmlspecialchars($aanvraag['user_name']); ?></td>
                <td><?php echo htmlspecialchars($aanvraag['request_date']); ?></td>
                <td><?php echo htmlspecialchars($aanvraag['status']); ?></td>
                <td>
                    <form action="aanvraag_status_process.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $aanvraag['id']; ?>">
                        <select name="status">
                            <option value="nieuw" <?php if ($aanvraag['status'] == 'nieuw') echo 'selected'; ?>>Nieuw</option>
                            <option value="goedgekeurd" <?php if ($aanvraag['status'] == 'goedgekeurd') echo 'selected'; ?>>Goedgekeurd</option>
                            <option value="afgewezen" <?php if ($aanvraag['status'] == 'afgewezen') echo 'selected'; ?>>Afgewezen</option>
                        </select>
                        <button type="submit">Opslaan</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (count($aanvragen) == 0): ?>
    <p class="melding">Er zijn nog geen aanvragen.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
