<?php
include 'config.php';

$sql = "SELECT Id, Titre, Description, Duree, DateSortie FROM Film";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Titre: " . $row["Titre"]. " - Durée: " . $row["Duree"]. " minutes - Date de sortie: " . $row["DateSortie"]. "<br>Description: " . $row["Description"]. "<br><br>";
    }
} else {
    echo "Aucun film trouvé";
}
$conn->close();
?>
