<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

if (!isset($_GET['reservation_id'])) {
    die('ID de réservation manquant.');
}

$reservation_id = $_GET['reservation_id'];

// Affichage des erreurs SQL
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Récupérer les informations de la réservation
$stmt = $pdo->prepare('SELECT Reservation.NbPlaces, Reservation.ReservationNumber, Seance.DateTimeSeance, Film.Titre, Salle.Numero, Cinema.Nom AS cinema
                       FROM Reservation
                       JOIN Seance ON Reservation.SeanceId = Seance.Id
                       JOIN Film ON Seance.FilmId = Film.Id
                       JOIN Salle ON Seance.SalleId = Salle.Id
                       JOIN Cinema ON Salle.CinemaId = Cinema.Id
                       WHERE Reservation.Id = :reservation_id');
$stmt->execute(['reservation_id' => $reservation_id]);
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reservation) {
    die('Réservation non trouvée.');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket d'entrée</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .ticket {
            width: 300px;
            border: 1px solid #333;
            padding: 20px;
            margin: 0 auto;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <h2>Ticket d'entrée</h2>
        <p><strong>Numéro de réservation:</strong> <?php echo htmlspecialchars($reservation['ReservationNumber']); ?></p>
        <p><strong>Cinéma:</strong> <?php echo htmlspecialchars($reservation['cinema']); ?></p>
        <p><strong>Film:</strong> <?php echo htmlspecialchars($reservation['Titre']); ?></p>
        <p><strong>Séance:</strong> <?php echo htmlspecialchars($reservation['DateTimeSeance']); ?></p>
        <p><strong>Salle:</strong> <?php echo htmlspecialchars($reservation['Numero']); ?></p>
        <p><strong>Nombre de places:</strong> <?php echo htmlspecialchars($reservation['NbPlaces']); ?></p>
    </div>
</body>
</html>
