<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header('Location: connexion.php');
    exit();
}

include 'config.php';

$seanceId = isset($_POST['seanceId']) ? (int)$_POST['seanceId'] : 0;
$userId = $_SESSION['userId']; // Assumé sécurisé car provenant de la session
$nbPlaces = isset($_POST['nbPlaces']) ? (int)$_POST['nbPlaces'] : 1;

// Insertion de la réservation dans la base de données
$stmt = $conn->prepare("INSERT INTO Reservation (UtilisateurId, SeanceId, NbPlaces) VALUES (?, ?, ?)");
$stmt->bind_param("iii", $userId, $seanceId, $nbPlaces);

if ($stmt->execute()) {
    echo "Réservation effectuée avec succès.";
} else {
    echo "Erreur lors de la réservation : " . $conn->error;
}

$stmt->close();
$conn->close();
?>
