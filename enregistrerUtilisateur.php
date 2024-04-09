<?php
include 'config.php'; // Votre script de connexion à la base de données

$nom = $_POST['nom'];
$email = $_POST['email'];
$motDePasse = password_hash($_POST['motDePasse'], PASSWORD_DEFAULT); // Hashage du mot de passe

$stmt = $conn->prepare("INSERT INTO Utilisateur (Nom, Email, MotDePasse) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nom, $email, $motDePasse);

if ($stmt->execute()) {
    echo "Inscription réussie. <a href='connexion.php'>Connectez-vous ici</a>.";
} else {
    echo "Erreur lors de l'inscription: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
