<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil Cinéma</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .film { margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid #ccc; }
        .titre { font-weight: bold; }
        .description { margin-top: 5px; }
    </style>
</head>
<body>
<h1>Films Disponibles</h1>

<?php
include 'config.php'; // Votre fichier de connexion à la base de données

$sql = "SELECT Id, Titre, Description FROM Film";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='film'>";
        echo "<div class='titre'>" . htmlspecialchars($row["Titre"]) . "</div>";
        echo "<div class='description'>" . substr(htmlspecialchars($row["Description"]), 0, 100) . "...</div>"; // Affiche les 100 premiers caractères de la description
        echo "</div>";
    }
} else {
    echo "Aucun film trouvé.";
}
$conn->close();
?>

<div>
    <a href="inscription.php">Inscription</a> | <a href="connexion.php">Connexion</a>
</div>
</body>
</html>
