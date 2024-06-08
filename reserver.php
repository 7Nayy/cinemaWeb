<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

// Récupérer les données du formulaire
$seance_id = $_POST['seance'];
$places = $_POST['places'];
$user_id = $_SESSION['user_id'];

// Vérifier que toutes les données nécessaires sont présentes
if (empty($seance_id) || empty($places)) {
    die('Veuillez remplir tous les champs.');
}

// Générer un numéro de réservation unique
$reservation_number = uniqid('RES-', true);

// Préparer et exécuter la requête d'insertion
try {
    $stmt = $pdo->prepare('INSERT INTO Reservation (UtilisateurId, SeanceId, NbPlaces, ReservationNumber) VALUES (:user_id, :seance_id, :places, :reservation_number)');
    $stmt->execute([
        'user_id' => $user_id,
        'seance_id' => $seance_id,
        'places' => $places,
        'reservation_number' => $reservation_number
    ]);
    $reservation_id = $pdo->lastInsertId();
    // Redirection vers la page du ticket après réservation
    header("Location: ticket.php?reservation_id=$reservation_id");
    exit();
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
