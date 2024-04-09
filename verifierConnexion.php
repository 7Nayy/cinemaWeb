<?php
session_start();
include 'config.php';

$email = $_POST['email'];
$motDePasse = $_POST['motDePasse'];

$stmt = $conn->prepare("SELECT Id, MotDePasse FROM Utilisateur WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($motDePasse, $row['MotDePasse'])) {
        $_SESSION['userId'] = $row['Id'];
        echo "Connexion réussie.";
        // Redirection vers une page après connexion réussie
        // header('Location: pageApresConnexion.php');
    } else {
        echo "Mot de passe incorrect.";
    }
} else {
    echo "Aucun utilisateur trouvé avec cet email.";
}

$_SESSION['userId'] = $row['Id']; // L'ID de l'utilisateur depuis la base de données
$_SESSION['userNom'] = $row['Nom']; // Le nom de l'utilisateur pour un usage ultérieur

// Redirigez l'utilisateur vers son espace personnel
header('Location: espacePersonnel.php');
exit();
?>
