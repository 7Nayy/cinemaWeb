<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['userId'])) {
    // Si non connecté, redirection vers la page de connexion
    header('Location: connexion.php');
    exit();
}

include 'config.php'; // Connexion à la base de données pour récupérer les infos des films, etc.

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Personnel</title>
</head>
<body>
<h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['userNom']); ?></h1>
<h2>Réservez vos places de cinéma</h2>

<!-- Ici, vous pourriez lister les films disponibles pour la réservation -->
<?php
$sql = "SELECT Id, Titre, Description FROM Film";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<p>";
        echo "<strong>" . htmlspecialchars($row["Titre"]) . "</strong><br>";
        echo htmlspecialchars($row["Description"]) . "<br>";
        // Lien pour réserver une place pour ce film
        echo "<a href='reserver.php?filmId=" . $row["Id"] . "'>Réserver</a>";
        echo "</p>";
    }
} else {
    echo "Aucun film trouvé.";
}
?>

<a href="deconnexion.php">Déconnexion</a>
</body>
</html>
