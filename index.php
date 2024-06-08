<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Cinéma</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="container">
            <section class="featured-movies">
                <h2>Films à l'affiche</h2>
                <div class="movies">
                    <?php
                    include 'config.php';
                    $stmt = $pdo->query('SELECT * FROM Film');
                    while ($film = $stmt->fetch()) {
                        echo '<div class="movie">';
                        echo '<h3>' . $film['Titre'] . '</h3>';
                        echo '<p>' . $film['Description'] . '</p>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </section>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Cinéma. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
