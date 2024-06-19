<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="index.php">Cinéma</a></h1>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="inscription.php">Inscription</a></li>
                    <li><a href="connexion.php">Connexion</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <h2>Inscription</h2>
            <?php
            session_start();
            if (isset($_SESSION['error'])) {
                echo "<span style='color:red;'>".$_SESSION['error']."</span>";
                unset($_SESSION['error']);
            }
            ?>
            <form action="enregistrerUtilisateur.php" method="post">
                <label for="username">Nom :</label>
                <input type="text" id="username" name="username" required>
                
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
                
                <label for="date_naissance">Date de Naissance :</label>
                <input type="date" id="date_naissance" name="date_naissance" required>
                
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">S'inscrire</button>
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
