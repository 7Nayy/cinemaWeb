<?php
session_start();
?>
<header>
    <div class="container">
        <h1><a href="index.php">Cinéma</a></h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="espacePersonnel.php">Espace Personnel</a></li>
                    <li><a href="deconnexion.php">Déconnexion</a></li>
                    <li style="float: right;">Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?></li>
                <?php else: ?>
                    <li><a href="inscription.php">Inscription</a></li>
                    <li><a href="connexion.php">Connexion</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
