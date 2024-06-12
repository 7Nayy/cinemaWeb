<?php
include 'config.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

$stmt = $pdo->prepare('INSERT INTO Utilisateur (Nom, MotDePasse) VALUES (:username, :password)');
$stmt->execute(['username' => $username, 'password' => $password]);

header('Location: connexion.php');
?>
