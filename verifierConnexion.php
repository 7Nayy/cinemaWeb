<?php
include 'config.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $pdo->prepare('SELECT * FROM Utilisateur WHERE Nom = :username');
$stmt->execute(['username' => $username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['MotDePasse'])) {
    $_SESSION['user_id'] = $user['Id'];
    header('Location: espacePersonnel.php');
} else {
    echo 'Nom d\'utilisateur ou mot de passe incorrect';
}
?>
