<?php
include 'config.php';  // Inclusion du fichier de configuration pour la connexion à la base de données

// Vérifier si l'ID du film est passé en paramètre
if (isset($_POST['film_id'])) {
    $film_id = $_POST['film_id'];

    try {
        // Requête pour récupérer les séances pour le film sélectionné
        $stmt = $pdo->prepare('SELECT Id, DateTimeSeance FROM Seance WHERE FilmId = :film_id');
        $stmt->execute(['film_id' => $film_id]);
        $seances = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($seances as $seance) {
            // Formater la date et l'heure de la séance
            $dateTime = new DateTime($seance['DateTimeSeance']);
            // Ajouter les options des séances au menu déroulant
            echo '<option value="' . $seance['Id'] . '">' . $dateTime->format('Y-m-d H:i') . '</option>';
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();  // Affichage d'une erreur en cas de problème avec la base de données
    }
}
?>
