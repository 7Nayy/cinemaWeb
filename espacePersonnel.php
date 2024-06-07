<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Personnel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="index.php">Cinéma</a></h1>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="deconnexion.php">Déconnexion</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <h2>Réservez vos billets</h2>
            <form action="reserver.php" method="post">
                <label for="film">Choisissez un film :</label>
                <select name="film" id="film">
                    <?php
                    $stmt = $pdo->query('SELECT * FROM Films');
                    while ($film = $stmt->fetch()) {
                        echo '<option value="' . $film['Id'] . '">' . $film['Titre'] . '</option>';
                    }
                    ?>
                </select>
                <label for="date">Date :</label>
                <input type="date" name="date" id="date">
                <label for="time">Heure :</label>
                <select name="time" id="time">
                    <?php
                    $stmt = $pdo->query('SELECT * FROM Seances');
                    while ($seance = $stmt->fetch()) {
                        echo '<option value="' . $seance['Heure'] . '">' . $seance['Heure'] . '</option>';
                    }
                    ?>
                </select>
                <button type="submit">Réserver</button>
            </form>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Cinéma. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
