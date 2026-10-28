<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $paginatitel; ?> - Pootjes & Co</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&family=Nunito:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <a href="index.php" class="nav-logo">&#128062; Pootjes & Co</a>
        <nav class="nav-links">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="mijn_aanvragen.php">Mijn aanvragen</a>
                <a href="profiel.php">Mijn profiel</a>
                <a href="logout.php">Uitloggen</a>
            <?php else: ?>
                <a href="login.php">Inloggen</a>
                <a href="register.php">Registreren</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
