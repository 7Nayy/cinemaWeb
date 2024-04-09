<?php
include 'config.php';

$filmId = $_GET['filmId']; // Id du film passé en paramètre

$sql = "SELECT Seance.Id, DateTimeSeance, Salle.Numero FROM Seance JOIN Salle ON Seance.SalleId = Salle.Id WHERE FilmId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $filmId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Séance le " . $row["DateTimeSeance"]. " dans la salle " . $row["Numero"]. " - <a href='reserver.php?seanceId=" . $row["Id"] . "'>Réserver</a><br>";
    }
} else {
    echo "Aucune séance trouvée pour ce film.";
}
$conn->close();
?>
