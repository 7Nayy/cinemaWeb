<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Cinéma</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="index.php">Cinéma</a></h1>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="films.php">Films</a></li>
                    <li><a href="seances.php">Séances</a></li>
                    <li><a href="inscription.php">Inscription</a></li>
                    <li><a href="connexion.php">Connexion</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <section class="featured-movies">
                <h2>Films à l'affiche</h2>
                <div class="movies">
                    <?php
                    include 'config.php';
                    $stmt = $pdo->query('SELECT * FROM Films');
                    while ($film = $stmt->fetch()) {
                        echo '<div class="movie">';
                        echo '<img src="' . $film['Affiche'] . '" alt="' . $film['Titre'] . '">';
                        echo '<h3>' . $film['Titre'] . '</h3>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </section>
            <section class="reservation">
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
