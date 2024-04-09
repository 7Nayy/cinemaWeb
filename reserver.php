<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header('Location: connexion.php');
    exit();
}

include 'config.php'; // Connexion à la base de données

$seanceId = isset($_GET['seanceId']) ? (int)$_GET['seanceId'] : 0;
$userId = $_SESSION['userId'];

// Récupération des détails de la séance pour afficher
$stmt = $conn->prepare("SELECT Film.Titre, Seance.DateTimeSeance FROM Seance JOIN Film ON Seance.FilmId = Film.Id WHERE Seance.Id = ?");
$stmt->bind_param("i", $seanceId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $seance = $result->fetch_assoc();
    echo "<h2>Réservation pour : " . htmlspecialchars($seance['Titre']) . "</h2>";
    echo "<p>Date et heure de la séance : " . $seance['DateTimeSeance'] . "</p>";
} else {
    echo "Séance non trouvée.";
    exit;
}

$conn->close();
?>

<form action="traiterReservation.php" method="post">
    <input type="hidden" name="seanceId" value="<?php echo $seanceId; ?>">
    <input type="hidden" name="userId" value="<?php echo $userId; ?>">
    Nombre de places : <input type="number" name="nbPlaces" min="1" max="10" required>
    <button type="submit">Réserver</button>
</form>
