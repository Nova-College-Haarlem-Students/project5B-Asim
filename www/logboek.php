<?php
require 'admin_check.php';
require 'db.php';

$stmt = $conn->prepare("SELECT logs.*, users.name AS user_name, animals.name AS animal_name FROM logs LEFT JOIN users ON users.id = logs.user_id LEFT JOIN animals ON animals.id = logs.animal_id ORDER BY logs.created_at DESC");
$stmt->execute();
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$paginatitel = "Logboek";
include 'header.php';
?>

<h1>Logboek</h1>

<div class="tabel-wrap">
    <table class="tabel">
        <thead>
            <tr>
                <th>Datum</th>
                <th>Gebruiker</th>
                <th>Actie</th>
                <th>Dier</th>
                <th>Omschrijving</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
                <td><?php echo htmlspecialchars($log['created_at']); ?></td>
                <td><?php echo htmlspecialchars($log['user_name']); ?></td>
                <td><?php echo htmlspecialchars($log['action']); ?></td>
                <td><?php echo $log['animal_name'] ? htmlspecialchars($log['animal_name']) : '-'; ?></td>
                <td><?php echo htmlspecialchars($log['description']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (count($logs) == 0): ?>
    <p class="melding">Er zijn nog geen acties gelogd.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
