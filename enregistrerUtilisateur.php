<?php
include 'config.php';

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$stmt = $pdo->prepare('INSERT INTO Utilisateurs (username, password) VALUES (:username, :password)');
$stmt->execute(['username' => $username, 'password' => $password]);

header('Location: connexion.php');
?>
