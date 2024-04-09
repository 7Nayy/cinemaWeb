<?php
$servername = "212.132.116.22"; // L'adresse du serveur de base de données, généralement "localhost" pour une base de données locale
$username = "root"; // Le nom d'utilisateur pour accéder à votre base de données
$password = "admin719"; // Le mot de passe pour accéder à votre base de données
$dbname = "cinema"; // Le nom de votre base de données

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>
