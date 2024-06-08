<?php
include 'config.php';  // Inclusion du fichier de configuration pour la connexion à la base de données
session_start();  // Démarrage de la session

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');  // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
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
    <!-- Inclusion de jQuery depuis un CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Lorsque l'utilisateur change de film, déclencher la fonction pour charger les séances correspondantes
            $('#film').change(function() {
                var filmId = $(this).val();  // Récupération de l'ID du film sélectionné
                $.ajax({
                    type: 'POST',  // Méthode d'envoi
                    url: 'get_seances.php',  // URL du script pour récupérer les séances
                    data: {film_id: filmId},  // Données envoyées (ID du film)
                    success: function(response) {
                        $('#seance').html(response);  // Mise à jour du menu déroulant des séances avec la réponse du serveur
                    }
                });
            });
        });
    </script>
</head>
<body>
    <?php include 'header.php'; ?>  <!-- Inclusion du fichier header.php -->
    <main>
        <div class="container">
            <h2>Réservez vos billets</h2>
            <form action="reserver.php" method="post">
                <label for="film">Choisissez un film :</label>
                <select name="film" id="film">
                    <option value="">Sélectionnez un film</option>  <!-- Option par défaut -->
                    <?php
                    try {
                        // Requête pour récupérer tous les films
                        $stmt = $pdo->query('SELECT * FROM Film');
                        while ($film = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            // Ajout des films au menu déroulant
                            echo '<option value="' . $film['Id'] . '">' . htmlspecialchars($film['Titre']) . '</option>';
                        }
                    } catch (PDOException $e) {
                        echo "Erreur : " . $e->getMessage();  // Affichage d'une erreur en cas de problème avec la base de données
                    }
                    ?>
                </select>
                <label for="seance">Séance :</label>
                <select name="seance" id="seance">
                    <option value="">Sélectionnez un film d'abord</option>  <!-- Option par défaut -->
                </select>
                <label for="places">Nombre de places :</label>
                <input type="number" name="places" id="places" min="1" max="10" value="1">
                <button type="submit">Réserver</button>
            </form>

            <h2>Rechercher vos réservations</h2>
            <form action="espacePersonnel.php" method="get">
                <label for="search">Rechercher par nom du film :</label>
                <input type="text" name="search" id="search" placeholder="Nom du film">
                <button type="submit">Rechercher</button>
            </form>

            <?php
            if (isset($_GET['search'])) {  // Si une recherche est effectuée
                $search = $_GET['search'];
                try {
                    // Requête pour rechercher les réservations par nom de film et trier par date de séance
                    $stmt = $pdo->prepare('SELECT Reservation.Id, Film.Titre, Seance.DateTimeSeance 
                                           FROM Reservation 
                                           JOIN Seance ON Reservation.SeanceId = Seance.Id 
                                           JOIN Film ON Seance.FilmId = Film.Id 
                                           WHERE Reservation.UtilisateurId = :user_id 
                                           AND Film.Titre LIKE :search
                                           ORDER BY Seance.DateTimeSeance ASC');
                    $stmt->execute([
                        'user_id' => $_SESSION['user_id'],
                        'search' => '%' . $search . '%'
                    ]);
                    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($reservations) {
                        echo '<h3>Résultats de la recherche :</h3>';
                        echo '<ul>';
                        foreach ($reservations as $reservation) {
                            echo '<li>' . htmlspecialchars($reservation['Titre']) . ' - ' . htmlspecialchars($reservation['DateTimeSeance']) . ' - <a href="ticket.php?reservation_id=' . $reservation['Id'] . '">Générer le ticket</a></li>';
                        }
                        echo '</ul>';
                    } else {
                        echo '<p>Aucune réservation trouvée pour ce film.</p>';
                    }
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();  // Affichage d'une erreur en cas de problème avec la base de données
                }
            } else {
                try {
                    // Requête pour récupérer toutes les réservations de l'utilisateur et trier par date de séance
                    $stmt = $pdo->prepare('SELECT Reservation.Id, Film.Titre, Seance.DateTimeSeance 
                                           FROM Reservation 
                                           JOIN Seance ON Reservation.SeanceId = Seance.Id 
                                           JOIN Film ON Seance.FilmId = Film.Id 
                                           WHERE Reservation.UtilisateurId = :user_id
                                           ORDER BY Seance.DateTimeSeance ASC');
                    $stmt->execute(['user_id' => $_SESSION['user_id']]);
                    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($reservations) {
                        echo '<h3>Vos réservations :</h3>';
                        echo '<ul>';
                        foreach ($reservations as $reservation) {
                            echo '<li>' . htmlspecialchars($reservation['Titre']) . ' - ' . htmlspecialchars($reservation['DateTimeSeance']) . ' - <a href="ticket.php?reservation_id=' . $reservation['Id'] . '">Générer le ticket</a></li>';
                        }
                        echo '</ul>';
                    } else {
                        echo '<p>Vous n\'avez aucune réservation.</p>';
                    }
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();  // Affichage d'une erreur en cas de problème avec la base de données
                }
            }
            ?>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Cinéma. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
