<?php
include 'config.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $pdo->prepare('SELECT * FROM Utilisateurs WHERE username = :username');
$stmt->execute(['username' => $username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    header('Location: espacePersonnel.php');
} else {
    echo 'Nom d\'utilisateur ou mot de passe incorrect';
}
?>
