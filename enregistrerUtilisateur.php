<?php
session_start();

include 'config.php';

try {
    // Récup les data du forms
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dob = $_POST['date_naissance'];

    // Calcule age de l'utilisateur
    $dobDate = new DateTime($dob);
    $today = new DateTime();
    $age = $today->diff($dobDate)->y;

    // Vérifie si l'utilisateur a moins de 12 ans
    if ($age < 12) {
        // Stocke un message d'erreur dans la session et redirige vers la page d'inscription
        $_SESSION['error'] = "Vous devez avoir au moins 12 ans pour vous inscrire.";
        header('Location: inscription.php');
        exit;
    }

    // Hache le mot de passe pour le sécuriser
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Prépare la requête SQL pour insérer les données de l'utilisateur dans la base de données
    $stmt = $pdo->prepare('INSERT INTO Utilisateur (Nom, Email, MotDePasse, DateNaissance) VALUES (:username, :email, :password, :dob)');
    // Exécute la requête avec les données du formulaire
    $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashedPassword, 'dob' => $dob]);

    // Redirige l'utilisateur vers la page de connexion après une inscription réussie
    header('Location: connexion.php');
} catch (PDOException $e) {
    // Affiche un message d'erreur si une exception est levée
    echo "Erreur : " . $e->getMessage();
}
?>
